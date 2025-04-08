<?php
namespace App\Controllers;

use App\Models\Product;
use App\Core\ViewRenderer;

class ProductController
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
    
        
        $allowedSorts = ['id', 'name']; 
        $allowedDirections = ['asc', 'desc']; // Directions autorisées
    
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }
        if (!in_array($direction, $allowedDirections)) {
            $direction = 'asc';
        }
    
        // Pagination avec tri
        $products = Product::orderBy($sort, $direction)->paginate($perPage);
    
        $this->render('app', 'products/index', [
            'products' => $products,
            'title' => 'Liste des Produits',
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }
    public function create()
    {
        $this->render('app', 'products/create', [
            'title' => 'Ajouter un produit'
        ]);
    }

    public function store()
    {
        $data = [
            'designation' => trim($_POST['designation']),
            'unit_price' => trim($_POST['unit_price'])
            
        ];

        if (empty($data['designation'])) {
            http_response_code(400);
            echo "Le nom est obligatoire";
            return;
        }
        if (empty($data['unit_price'])) {
            http_response_code(400);
            echo "Le prix unitaire est obligatoire";
            return;
        }


        Product::create($data);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'produit créé avec succès'
        ];
        header('Location: ' . $this->basePath . '/product');
    }

    public function edit($id)
    {
        
        $product = Product::where('id', $id)->first();
        if (!$product) {
            http_response_code(404);
            echo "produit non trouvé";
            return;
        }



        $this->render('app', 'products/edit', [
            'product' => $product,
            'title' => 'Modifier le produit'
        ]);
    }

    public function update($id)
    {
      
        $product = Product::where('id', $id)->first();

        if (!$product) {
            http_response_code(404);
            echo "produit non trouvé";
            return;
        }

        $data = [
            'designation' => trim($_POST['designation']),
            'unit_price' => trim($_POST['unit_price'])
        ];

        if (empty($data['designation'])) {
            http_response_code(400);
            echo "Le nom est obligatoire";
            return;
        }
        if (empty($data['unit_price'])) {
            http_response_code(400);
            echo "Le numero de telephone est obligatoire";
            return;
        }


        $product->update($data);
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'produit modifié avec succès'
        ];
        header('Location: ' . $this->basePath . '/product');
    }

    public function delete($id)
    {
        //$product = Product::find($id);
        $product = Product::where('id', $id)->first();
        
        if (!$product) {
            http_response_code(404);
            echo "produit non trouvé";
            return;
        }

        $product->delete();
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'produit supprimé avec succès'
        ];
        header('Location: ' . $this->basePath . '/product');
    }

    public function export()
{
    $products = Product::all();

    // En-têtes du fichier CSV
    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="products.csv"',
    ];

    // Ouvrir un flux de sortie pour le fichier CSV
    $output = fopen('php://output', 'w');

    // Écrire les en-têtes du CSV
    fputcsv($output, ['ID', 'Nom', 'Téléphone']);

    // Écrire les données des produits
    foreach ($products as $product) {
        fputcsv($output, [$product->id, $product->name, $product->phone]);
    }

    // Fermer le flux de sortie
    fclose($output);

    // Envoyer les en-têtes et le fichier CSV
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="products.csv"');
    exit();
}
   
}
