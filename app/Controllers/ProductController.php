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
    
        $allowedSorts = ['id', 'designation', 'unit_price']; 
        $allowedDirections = ['asc', 'desc'];
    
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }
        if (!in_array($direction, $allowedDirections)) {
            $direction = 'asc';
        }
    
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
            'quantity' => trim($_POST['quantity']),
            'unit_price' => trim($_POST['unit_price'])
        ];

        // Validation
        if (empty($data['designation'])) {
            http_response_code(400);
            echo "La désignation est obligatoire";
            return;
        }
        if (empty($data['unit_price'])) {
            http_response_code(400);
            echo "Le prix unitaire est obligatoire";
            return;
        }

        // Handle image upload
       /*  if (!empty($_FILES['image']['name'])) {
            $uploadResult = $this->handleImageUpload();
            if ($uploadResult['success']) {
                $data['image_url'] = $uploadResult['path'];
            } else {
                http_response_code(400);
                echo $uploadResult['error'];
                return;
            }
        } */

        Product::create($data);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Produit créé avec succès'
        ];
        header('Location: ' . $this->basePath . '/product');
    }

    public function edit($id)
    {
        $product = Product::where('id', $id)->first();
        if (!$product) {
            http_response_code(404);
            echo "Produit non trouvé";
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
            echo "Produit non trouvé";
            return;
        }

        $data = [
            'designation' => trim($_POST['designation']),
            'quantity' => trim($_POST['quantity']),
            'unit_price' => trim($_POST['unit_price'])
        ];

        if (empty($data['designation'])) {
            http_response_code(400);
            echo "La désignation est obligatoire";
            return;
        }
        if (empty($data['unit_price'])) {
            http_response_code(400);
            echo "Le prix unitaire est obligatoire";
            return;
        }

        /* // Handle image upload if new image is provided
        if (!empty($_FILES['image']['name'])) {
            $uploadResult = $this->handleImageUpload();
            if ($uploadResult['success']) {
                // Delete old image if exists
                if ($product->image_url && file_exists($product->image_url)) {
                    unlink($product->image_url);
                }
                $data['image_url'] = $uploadResult['path'];
            } else {
                http_response_code(400);
                echo $uploadResult['error'];
                return;
            }
        } */

        $product->update($data);
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Produit modifié avec succès'
        ];
        header('Location: ' . $this->basePath . '/product');
    }

    public function delete($id)
    {
        $product = Product::where('id', $id)->first();
        
        if (!$product) {
            http_response_code(404);
            echo "Produit non trouvé";
            return;
        }

        // Delete associated image if exists
        if ($product->image_url && file_exists($product->image_url)) {
            unlink($product->image_url);
        }

        $product->delete();
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Produit supprimé avec succès'
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
        fputcsv($output, ['ID', 'Désignation', 'Quantité', 'Prix unitaire']);

        // Écrire les données des produits
        foreach ($products as $product) {
            fputcsv($output, [
                $product->id, 
                $product->designation, 
                $product->quantity, 
                $product->unit_price
            ]);
        }

        // Fermer le flux de sortie
        fclose($output);

        // Envoyer les en-têtes et le fichier CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="products.csv"');
        exit();
    }

    /* protected function handleImageUpload()
    {
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . $this->basePath . "/uploads/products/";
        
        if (!file_exists($targetDir)) {
            if (!mkdir($targetDir, 0775, true)) {
                return ['success' => false, 'error' => 'Impossible de créer le répertoire de téléchargement.'];
            }
        }
    
        $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $fileName = uniqid() . '.' . $imageFileType;
        $targetFile = $targetDir . $fileName;
    
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            return ['success' => false, 'error' => 'Le fichier n\'est pas une image.'];
        }
    
        // Check file size (max 2MB)
        if ($_FILES["image"]["size"] > 2000000) {
            return ['success' => false, 'error' => 'L\'image est trop volumineuse (max 2MB).'];
        }
    
        // Allow certain file formats
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedTypes)) {
            return ['success' => false, 'error' => 'Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.'];
        }
    
        // Try to upload file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            // Return relative path for database storage
            return ['success' => true, 'path' => "uploads/products/" . $fileName];
        } else {
            // Add more detailed error information
            $error = error_get_last();
            return ['success' => false, 'error' => 'Erreur de téléchargement: ' . ($error['message'] ?? 'Unknown error')];
        }
    } */
}