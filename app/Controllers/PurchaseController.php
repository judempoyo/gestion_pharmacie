<?php
namespace App\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseLine;
use App\Models\Product;
use App\Models\Supplier;
use App\Core\ViewRenderer;

class PurchaseController
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
    
        
        $allowedSorts = ['id', 'suppliers.name', 'total_amount']; // Champs autorisés pour le tri
        $allowedDirections = ['asc', 'desc']; // Directions autorisées
    
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }
        if (!in_array($direction, $allowedDirections)) {
            $direction = 'asc';
        }
    
        // Pagination avec tri
        $purchases = Purchase::with('supplier')->orderBy('id', 'desc')->paginate($perPage);
    
        $this->render('app', 'purchases/index', [
            'purchases' => $purchases,
            'title' => 'Liste des Factures',
            'sort' => $sort,
            'direction' => $direction,
        ]);
        /* $perPage = 10;
        $purchases = Purchase::with('supplier')->orderBy('id', 'desc')->paginate($perPage);

        $this->render('app', 'purchases/index', [
            'purchases' => $purchases,
            'title' => 'Liste des Factures'
        ]); */
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
            echo "Le client est obligatoire";
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
        $purchase = Purchase::with(['supplier', 'purchaseLines.product'])->find($id);
        
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
        $purchase = Purchase::with(['purchaseLines.product'])->find($id);
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
        $purchase = Purchase::with(['supplier', 'purchaseLines.product'])->find($id);
        
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