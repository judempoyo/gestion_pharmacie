<?php
namespace App\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Models\Product;
use App\Models\Customer;
use App\Core\ViewRenderer;

class InvoiceController
{
    use ViewRenderer;
    protected $basePath;

    public function __construct()
    {
        $this->basePath = '/Projets/gestion_pharmacie/public';
    }

    public function index()
    {
        $perPage = 10; 
        $sort = $_GET['sort'] ?? 'id'; 
        $direction = $_GET['direction'] ?? 'asc'; 
    
        
        $allowedSorts = ['id', 'customers.name', 'total_amount']; // Champs autorisés pour le tri
        $allowedDirections = ['asc', 'desc']; // Directions autorisées
    
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }
        if (!in_array($direction, $allowedDirections)) {
            $direction = 'asc';
        }
    
        // Pagination avec tri
        $invoices = Invoice::with('customer')->orderBy('id', 'desc')->paginate($perPage);
    
        $this->render('app', 'invoices/index', [
            'invoices' => $invoices,
            'title' => 'Liste des Factures',
            'sort' => $sort,
            'direction' => $direction,
        ]);
        /* $perPage = 10;
        $invoices = Invoice::with('customer')->orderBy('id', 'desc')->paginate($perPage);

        $this->render('app', 'invoices/index', [
            'invoices' => $invoices,
            'title' => 'Liste des Factures'
        ]); */
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();

        $this->render('app', 'invoices/create', [
            'title' => 'Créer une facture',
            'customers' => $customers,
            'products' => $products
        ]);
    }

    public function store()
    {
        // Validation de base
        if (empty($_POST['customer_id'])) {
            http_response_code(400);
            echo "Le client est obligatoire";
            return;
        }

        // Création de la facture
        $invoice = Invoice::create([
            'customer_id' => $_POST['customer_id'],
            'total_amount' => 0 // Initialisé à 0, sera calculé après
        ]);

        // Ajout des lignes de facture
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
                        'unit_price' => $product->unit_price
                    ]);
                    
                    $totalAmount += $lineTotal;
                }
            }
        }

        // Mise à jour du montant total
        $invoice->update(['total_amount' => $totalAmount]);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Facture créée avec succès'
        ];
        
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
        $invoice = Invoice::with(['invoiceLines.product'])->find($id);
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