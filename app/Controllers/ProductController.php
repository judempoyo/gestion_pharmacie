<?php
namespace App\Controllers;

use App\Models\Product;
use App\Core\ViewRenderer;
use Jump\JumpDataTable\DataAction;
use Jump\JumpDataTable\DataColumn;
use Jump\JumpDataTable\DataTable;
class ProductController
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

        $allowedSorts = ['id', 'designation', 'quantity', 'unit_price', 'expiry_date'];
        $allowedDirections = ['asc', 'desc'];

        if (!in_array($sort, $allowedSorts))
            $sort = 'id';
        if (!in_array($direction, $allowedDirections))
            $direction = 'asc';

        $query = Product::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('designation', 'LIKE', "%{$search}%")
                    ->orWhere('quantity', 'LIKE', "%{$search}%")
                    ->orWhere('unit_price', 'LIKE', "%{$search}%");
            });
        }

        $totalItems = $query->count();
        $offset = ($currentPage - 1) * $perPage;
        $products = $query->orderBy($sort, $direction)
            ->offset($offset)
            ->limit($perPage)
            ->get()
            ->toArray();

        $table = DataTable::make()
            ->title('Liste des Produits')
            ->modelName('product')
            ->createUrl($this->basePath . '/product/create')
            ->publicUrl($this->basePath)
            ->addColumn((new DataColumn('id', 'ID'))->sortable())
            ->addColumn((new DataColumn('designation', 'Désignation'))->searchable())
            ->addColumn((new DataColumn('quantity', 'Quantité'))->sortable())
            ->addColumn((new DataColumn('unit_price', 'Prix Unitaire'))->sortable())
            ->addColumn((new DataColumn('created_at', 'Ajouté le'))
                ->sortable()
                ->withRenderer(fn($item) => date('d/m/Y', strtotime($item['created_at']))))
            ->addColumn((new DataColumn('expiry_date', 'Péremption'))
                ->sortable()
                ->withRenderer(function ($item) {
                    $value = $item['expiry_date'] ?? null;
                    if (!$value) return '-';
                    $date = \Carbon\Carbon::parse($value);
                    $now = \Carbon\Carbon::now();
                    
                    $class = 'expiry-safe';
                    if ($date->isPast()) {
                        $class = 'expiry-expired';
                    } elseif ($date->diffInMonths($now) <= 3) {
                        $class = 'expiry-critical';
                    } elseif ($date->diffInMonths($now) <= 6) {
                        $class = 'expiry-warning';
                    }
                    
                    return "<span class='$class'>" . $date->format('d/m/Y') . "</span>";
                }))
            ->addAction(DataAction::edit('Modifier', fn($item) => $this->basePath . '/product/' . 'edit/' . $item['id']))
            ->addAction(DataAction::delete('Supprimer', fn($item) => $this->basePath . '/product/' . 'delete/' . $item['id']))
            ->data($products)
            ->enableRowSelection(true)
            ->setBulkActions([
                DataAction::delete('Supprimer', fn($item) => "/delete/{$item}"),
            ])
            ->paginate($totalItems, $perPage, $currentPage, $this->basePath . '/product', [
                'sort' => $sort,
                'direction' => $direction,
                'search' => $search
            ]);

        $this->render('app', 'products/index', [
            'datatable' => $table->render(),
            'title' => 'Liste des Produits'
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
            'unit_price' => trim($_POST['unit_price']),
            'expiry_date' => !empty($_POST['expiry_date']) ? $_POST['expiry_date'] : null,
        ];

        // Validation
        if (empty($data['designation'])) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'La désignation est obligatoire'];
            header('Location: ' . $this->basePath . '/product/create');
            return;
        }

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
            'unit_price' => trim($_POST['unit_price']),
            'expiry_date' => !empty($_POST['expiry_date']) ? $_POST['expiry_date'] : null,
        ];

        if (empty($data['designation'])) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'La désignation est obligatoire'];
            header('Location: ' . $this->basePath . '/product/edit/' . $id);
            return;
        }

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