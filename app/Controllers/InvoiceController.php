<?php
namespace App\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Models\Product;
use App\Models\Customer;
use App\Core\ViewRenderer;
use Jump\JumpDataTable\DataAction;
use Jump\JumpDataTable\DataColumn;
use Jump\JumpDataTable\DataTable;

class InvoiceController
{
    use ViewRenderer;
    protected $basePath;

    public function __construct()
    {
        $this->basePath = BASE_URL_PATH;
    }

  public function index()
{
    $perPage = 10;
    $currentPage = $_GET['page'] ?? 1;
    $sort = $_GET['sort'] ?? 'id';
    $direction = $_GET['direction'] ?? 'asc';
    $search = $_GET['search'] ?? '';

    $allowedSorts = ['id', 'customer_id', 'total_amount'];
    $allowedDirections = ['asc', 'desc'];

    if (!in_array($sort, $allowedSorts))
        $sort = 'id';
    if (!in_array($direction, $allowedDirections))
        $direction = 'asc';

    $query = Invoice::with('customer');

    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('total_amount', 'LIKE', "%{$search}%")
                ->orWhereHas('customer', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
        });
    }

    $totalItems = $query->count();
    $offset = ($currentPage - 1) * $perPage;
    $invoices = $query->orderBy($sort, $direction)
        ->offset($offset)
        ->limit($perPage)
        ->get()
        ->toArray();

    // Format data for DataTable
    $formattedData = array_map(function($invoice) {
        $customerName = $invoice['customer']['name'] ?? $invoice['guest_name'] ?? 'Client Passager';
        return [
            'id' => $invoice['id'],
            'customer_name' => $customerName,
            'total_amount' => $invoice['total_amount'],
            'created_at' => $invoice['created_at']
        ];
    }, $invoices);

    $table = DataTable::make()
        ->title('Liste des Factures')
        ->modelName('invoice')
        ->createUrl($this->basePath . '/invoice/create')
        ->publicUrl($this->basePath)
        ->addColumn((new DataColumn('id', 'ID'))->sortable())
        ->addColumn((new DataColumn('customer_name', 'Client'))->searchable())
        ->addColumn((new DataColumn('total_amount', 'Montant Total'))->sortable())
        ->addColumn((new DataColumn('created_at', 'Date'))
            ->sortable()
            ->withRenderer(fn($item) => date('d/m/Y H:i', strtotime($item['created_at']))))
          ->addAction(DataAction::view('Détails', fn($item) => $this->basePath . '/invoice/' . 'show/' . $item['id']))
          ->addAction(DataAction::fromArray([
    'type' => 'print',
    'label' => 'Imprimer',
    'url' => function($item) {
        return $this->basePath .'/invoice/print/' . $item['id'];
    },
    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
    </svg>'
]))
          
        ->addAction(DataAction::edit('Modifier', fn($item) => $this->basePath . '/invoice/' . 'edit/' . $item['id']))
        ->addAction(DataAction::delete('Supprimer', fn($item) => $this->basePath . '/invoice/' . 'delete/' . $item['id']))
        ->data($formattedData)
        ->enableRowSelection(true)
        ->setBulkActions([
            DataAction::delete('Supprimer', fn($item) => "/delete/{$item}"),
        ])
        ->paginate($totalItems, $perPage, $currentPage, $this->basePath . '/invoice', [
            'sort' => $sort,
            'direction' => $direction,
            'search' => $search
        ]);

    $this->render('app', 'invoices/index', [
        'datatable' => $table->render(),
        'title' => 'Liste des Factures'
    ]);
}
    public function create()
    {
        $customers = Customer::all();
        // Uniquement les produits non périmés
        $products = Product::where(function($q) {
            $q->whereNull('expiry_date')
              ->orWhere('expiry_date', '>=', date('Y-m-d'));
        })->where('quantity', '>', 0)->get();

        $this->render('app', 'invoices/create', [
            'title' => 'Enregistrer une vente',
            'customers' => $customers,
            'products' => $products
        ]);
    }

    public function store()
    {
        // Validation de base
        if (empty($_POST['customer_id']) && empty($_POST['guest_name'])) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Veuillez sélectionner un client ou saisir un nom de client passager'];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            return;
        }

        if (empty($_POST['products'])) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'La vente doit contenir au moins un produit'];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            return;
        }

        // Vérification préalable de tous les produits (expiration et stock)
        foreach ($_POST['products'] as $productData) {
            $product = Product::find($productData['id']);
            if (!$product) continue;

            // 1. Vérifier l'expiration (sécurité supplémentaire)
            if ($product->expiry_date && strtotime($product->expiry_date) < time()) {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => "Vente impossible : le produit '{$product->designation}' est périmé"
                ];
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                return;
            }

            // 2. Vérifier le stock
            if ($product->quantity < $productData['quantity']) {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => "Stock insuffisant pour '{$product->designation}'"
                ];
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                return;
            }
        }

        // Création de la facture
        $invoice = Invoice::create([
            'customer_id' => !empty($_POST['customer_id']) ? $_POST['customer_id'] : null,
            'guest_name' => !empty($_POST['guest_name']) ? $_POST['guest_name'] : null,
            'total_amount' => 0
        ]);

        $totalAmount = 0;
        foreach ($_POST['products'] as $productData) {
            $product = Product::find($productData['id']);
            if ($product) {
                $lineTotal = $product->unit_price * $productData['quantity'];
                
                InvoiceLine::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $product->id,
                    'quantity' => $productData['quantity'],
                    'unit_price' => $product->unit_price
                ]);

                // Déduire du stock
                $product->decrement('quantity', $productData['quantity']);
                
                $totalAmount += $lineTotal;
            }
        }

        $invoice->update(['total_amount' => $totalAmount]);

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Vente enregistrée avec succès'];
        header('Location: ' . $this->basePath . '/invoice');
    }

    public function show($id)
    {
        

        $invoiceId = is_array($id) ? ($id['id'] ?? null) : $id;
    
        $invoice = Invoice::with(['customer', 'invoiceLines.product'])->find($invoiceId);
        
        if (!$invoice) {
            http_response_code(404);
            echo "Facture non trouvée";
            return;
        }

        $this->render('app', 'invoices/show', [
            'invoice' => $invoice,
            'title' => 'Détails de la facture'
        ]);
    }

    public function edit($id)
    {
        $invoiceId = is_array($id) ? ($id['id'] ?? null) : $id;
        $invoice = Invoice::with(['invoiceLines.product'])->find($invoiceId);
        $customers = Customer::all();
        $products = Product::all();

        if (!$invoice) {
            http_response_code(404);
            echo "Facture non trouvée";
            return;
        }

        $this->render('app', 'invoices/edit', [
            'invoice' => $invoice,
            'customers' => $customers,
            'products' => $products,
            'title' => 'Modifier la facture'
        ]);
    }

    public function update($id)
    {
        $invoice = Invoice::find($id);
        
        if (!$invoice) {
            http_response_code(404);
            echo "Facture non trouvée";
            return;
        }

        // Validation
        if (empty($_POST['customer_id'])) {
            http_response_code(400);
            echo "Le client est obligatoire";
            return;
        }

        // Mise à jour de la facture
        $invoice->update(['customer_id' => $_POST['customer_id']]);

        // Suppression des anciennes lignes
        InvoiceLine::where('invoice_id', $invoice->id)->delete();

        // Ajout des nouvelles lignes
        $totalAmount = 0;
        
        if (!empty($_POST['products'])) {
            foreach ($_POST['products'] as $productData) {
                $product = Product::find($productData['id']);
                
                if ($product) {
                    $lineTotal = $product->unit_price * $productData['quantity'];
                    
                    InvoiceLine::create([
                        'invoice_id' => $invoice->id,
                        'product_id' => $product->id,
                        'quantity' => $productData['quantity'],
                        'unit_price' => $product->product->unit_price
                    ]);
                    
                    $totalAmount += $lineTotal;
                }
            }
        }

        // Mise à jour du montant total
        $invoice->update(['total_amount' => $totalAmount]);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Facture mise à jour avec succès'
        ];
        
        header('Location: ' . $this->basePath . '/invoice');
    }

    public function delete($id)
    {
        $invoice = Invoice::find($id);
        
        if (!$invoice) {
            http_response_code(404);
            echo "Facture non trouvée";
            return;
        }

        // Suppression des lignes de facture associées
        InvoiceLine::where('invoice_id', $invoice->id)->delete();
        
        // Suppression de la facture
        $invoice->delete();

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Facture supprimée avec succès'
        ];
        
        header('Location: ' . $this->basePath . '/invoice');
    }

    public function print($id)
{
    
    $invoiceId = is_array($id) ? ($id['id'] ?? null) : $id;
    
    $invoice = Invoice::with(['customer', 'invoiceLines.product'])->find($invoiceId);
    
    if (!$invoice) {
        http_response_code(404);
        echo "Facture non trouvée";
        return;
    }

    $this->render('app', 'invoices/print', [
        'invoice' => $invoice,
        'title' => 'Facture #' . $invoice->id
    ], false); // false pour ne pas utiliser le layout
}

   
}