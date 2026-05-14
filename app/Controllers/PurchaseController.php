<?php
namespace App\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseLine;
use App\Models\Product;
use App\Models\Supplier;
use App\Core\ViewRenderer;
use Jump\JumpDataTable\DataAction;
use Jump\JumpDataTable\DataColumn;
use Jump\JumpDataTable\DataTable;
class PurchaseController
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

    $allowedSorts = ['id', 'supplier_id', 'total_amount'];
    $allowedDirections = ['asc', 'desc'];

    if (!in_array($sort, $allowedSorts))
        $sort = 'id';
    if (!in_array($direction, $allowedDirections))
        $direction = 'asc';

    $query = Purchase::with('supplier');

    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('total_amount', 'LIKE', "%{$search}%")
                ->orWhereHas('supplier', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
        });
    }

    $totalItems = $query->count();
    $offset = ($currentPage - 1) * $perPage;
    $purchases = $query->orderBy($sort, $direction)
        ->offset($offset)
        ->limit($perPage)
        ->get()
        ->toArray();

    // Format data for DataTable
    $formattedData = array_map(function($purchase) {
        return [
            'id' => $purchase['id'],
            'supplier_name' => $purchase['supplier']['name'] ?? 'N/A',
            'total_amount' => $purchase['total_amount'],
            'created_at' => $purchase['created_at']
        ];
    }, $purchases);

    $table = DataTable::make()
        ->title('Liste des Achats')
        ->modelName('purchase')
        ->createUrl($this->basePath . '/purchase/create')
        ->publicUrl($this->basePath)
        ->addColumn((new DataColumn('id', 'ID'))->sortable())
        ->addColumn((new DataColumn('supplier_name', 'Fournisseur'))->searchable())
        ->addColumn((new DataColumn('total_amount', 'Montant Total'))->sortable())
        ->addColumn((new DataColumn('created_at', 'Date')))
          ->addAction(DataAction::view('Détails', fn($item) => $this->basePath . '/purchase/' . 'show/' . $item['id']))
            ->addAction(DataAction::fromArray([
    'type' => 'print',
    'label' => 'Imprimer',
    'url' => function($item) {
        return $this->basePath .'/purchase/print/' . $item['id'];
    },
    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
    </svg>'
]))
          
        ->addAction(DataAction::edit('Modifier', fn($item) => $this->basePath . '/purchase/' . 'edit/' . $item['id']))
        ->addAction(DataAction::delete('Supprimer', fn($item) => $this->basePath . '/purchase/' . 'delete/' . $item['id']))
        ->data($formattedData)
        ->enableRowSelection(true)
        ->setBulkActions([
            DataAction::delete('Supprimer', fn($item) => "/delete/{$item}"),
        ])
        ->paginate($totalItems, $perPage, $currentPage, $this->basePath . '/purchase', [
            'sort' => $sort,
            'direction' => $direction,
            'search' => $search
        ]);

    $this->render('app', 'purchases/index', [
        'datatable' => $table->render(),
        'title' => 'Liste des Achats'
    ]);
}
    public function create()
    {
        $suppliers = supplier::all();
        $products = Product::all();

        $this->render('app', 'purchases/create', [
            'title' => 'Créer une facture',
            'suppliers' => $suppliers,
            'products' => $products
        ]);
    }

    public function store()
    {
        // Validation de base
        if (empty($_POST['supplier_id'])) {
            http_response_code(400);
            echo "Le fournisseur est obligatoire";
            return;
        }

        // Création de la facture
        $purchase = Purchase::create([
            'supplier_id' => $_POST['supplier_id'],
            'total_amount' => 0 // Initialisé à 0, sera calculé après
        ]);

        // Ajout des lignes de facture
        $totalAmount = 0;
        
        if (!empty($_POST['products'])) {
            foreach ($_POST['products'] as $productData) {
                $product = Product::find($productData['id']);
                
                if ($product) {
                    $lineTotal = $product->unit_price * $productData['quantity'];
                    
                    PurchaseLine::create([
                        'purchase_id' => $purchase->id,
                        'product_id' => $product->id,
                        'quantity' => $productData['quantity'],
                        'unit_price' => $product->unit_price
                    ]);
                    
                    $totalAmount += $lineTotal;
                }
            }
        }

        // Mise à jour du montant total
        $purchase->update(['total_amount' => $totalAmount]);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Facture créée avec succès'
        ];
        
        header('Location: ' . $this->basePath . '/purchase');
    }

    public function show($id)
    {
        $purchaseId = is_array($id) ? ($id['id'] ?? null) : $id;
    
        $purchase = Purchase::with(['supplier', 'purchaseLines.product'])->find($purchaseId);
        
        if (!$purchase) {
            http_response_code(404);
            echo "Facture non trouvée";
            return;
        }

        $this->render('app', 'purchases/show', [
            'purchase' => $purchase,
            'title' => 'Détails de la facture'
        ]);
    }

    public function edit($id)
    {
        $purchaseId = is_array($id) ? ($id['id'] ?? null) : $id;

        $purchase = Purchase::with(['purchaseLines.product'])->find($purchaseId);
        $suppliers = Supplier::all();
        $products = Product::all();

        if (!$purchase) {
            http_response_code(404);
            echo "Facture non trouvée";
            return;
        }

        $this->render('app', 'purchases/edit', [
            'purchase' => $purchase,
            'suppliers' => $suppliers,
            'products' => $products,
            'title' => 'Modifier la facture'
        ]);
    }

    public function update($id)
    {
        $purchase = Purchase::find($id);
        
        if (!$purchase) {
            http_response_code(404);
            echo "Facture non trouvée";
            return;
        }

        // Validation
        if (empty($_POST['supplier_id'])) {
            http_response_code(400);
            echo "Le client est obligatoire";
            return;
        }

        // Mise à jour de la facture
        $purchase->update(['supplier_id' => $_POST['supplier_id']]);

        // Suppression des anciennes lignes
        PurchaseLine::where('purchase_id', $purchase->id)->delete();

        // Ajout des nouvelles lignes
        $totalAmount = 0;
        
        if (!empty($_POST['products'])) {
            foreach ($_POST['products'] as $productData) {
                $product = Product::find($productData['id']);
                
                if ($product) {
                    $lineTotal = $product->unit_price * $productData['quantity'];
                    
                    PurchaseLine::create([
                        'purchase_id' => $purchase->id,
                        'product_id' => $product->id,
                        'quantity' => $productData['quantity'],
                        'unit_price' => $product->product->unit_price
                    ]);
                    
                    $totalAmount += $lineTotal;
                }
            }
        }

        // Mise à jour du montant total
        $purchase->update(['total_amount' => $totalAmount]);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Facture mise à jour avec succès'
        ];
        
        header('Location: ' . $this->basePath . '/purchase');
    }

    public function delete($id)
    {
        $purchase = Purchase::find($id);
        
        if (!$purchase) {
            http_response_code(404);
            echo "Facture non trouvée";
            return;
        }

        // Suppression des lignes de facture associées
        PurchaseLine::where('purchase_id', $purchase->id)->delete();
        
        // Suppression de la facture
        $purchase->delete();

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Facture supprimée avec succès'
        ];
        
        header('Location: ' . $this->basePath . '/purchase');
    }

    public function print($id)
    {
        $purchaseId = is_array($id) ? ($id['id'] ?? null) : $id;
    
        $purchase = Purchase::with(['supplier', 'purchaseLines.product'])->find($purchaseId);
        
        if (!$purchase) {
            http_response_code(404);
            echo "Facture non trouvée";
            return;
        }

        $this->render('app', 'purchases/print', [
            'purchase' => $purchase,
            'title' => 'Facture #' . $purchase->id
        ], false); // false pour ne pas utiliser le layout
    }
}