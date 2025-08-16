<?php
namespace App\Controllers;

use App\Models\Supplier;
use App\Core\ViewRenderer;
use Jump\JumpDataTable\DataAction;
use Jump\JumpDataTable\DataColumn;
use Jump\JumpDataTable\DataTable;

class SupplierController
{
    use ViewRenderer;
    protected $basePath;

    public function __construct()
    {
        $this->basePath = '/Projets/autres/gestion_pharmacie/public';
    }

    public function index()
{
    $perPage = 10;
    $currentPage = $_GET['page'] ?? 1;
    $sort = $_GET['sort'] ?? 'id';
    $direction = $_GET['direction'] ?? 'asc';
    $search = $_GET['search'] ?? '';

    $allowedSorts = ['id', 'name', 'phone'];
    $allowedDirections = ['asc', 'desc'];

    if (!in_array($sort, $allowedSorts))
        $sort = 'id';
    if (!in_array($direction, $allowedDirections))
        $direction = 'asc';

    $query = Supplier::query();

    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('phone', 'LIKE', "%{$search}%");
        });
    }

    $totalItems = $query->count();
    $offset = ($currentPage - 1) * $perPage;
    $suppliers = $query->orderBy($sort, $direction)
        ->offset($offset)
        ->limit($perPage)
        ->get()
        ->toArray();

    $table = DataTable::make()
        ->title('Liste des Fournisseurs')
        ->modelName('supplier')
        ->createUrl($this->basePath . '/supplier/create')
        ->publicUrl($this->basePath)
        ->addColumn((new DataColumn('id', 'ID'))->sortable())
        ->addColumn((new DataColumn('name', 'Nom'))->searchable())
        ->addColumn((new DataColumn('phone', 'Téléphone'))->searchable())
        ->addAction(DataAction::edit('Modifier', fn($item) => $this->basePath . '/supplier/' . 'edit/' . $item['id']))
        ->addAction(DataAction::delete('Supprimer', fn($item) => $this->basePath . '/supplier/' . 'delete/' . $item['id']))
        ->data($suppliers)
        ->enableRowSelection(true)
        ->setBulkActions([
            DataAction::delete('Supprimer', fn($item) => "/delete/{$item}"),
        ])
        ->paginate($totalItems, $perPage, $currentPage, $this->basePath . '/supplier', [
            'sort' => $sort,
            'direction' => $direction,
            'search' => $search
        ]);

    $this->render('app', 'suppliers/index', [
        'datatable' => $table->render(),
        'title' => 'Liste des Fournisseurs'
    ]);
}
    public function create()
    {
        $this->render('app', 'suppliers/create', [
            'title' => 'Ajouter un fournisseur'
        ]);
    }

    public function store()
    {
        $data = [
            'name' => trim($_POST['name']),
            'phone' => trim($_POST['phone'])
            
        ];

        if (empty($data['name'])) {
            http_response_code(400);
            echo "Le nom est obligatoire";
            return;
        }
        if (empty($data['phone'])) {
            http_response_code(400);
            echo "Le nom est obligatoire";
            return;
        }


        Supplier::create($data);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'fournisseur créé avec succès'
        ];
        header('Location: ' . $this->basePath . '/supplier');
    }

    public function edit($id)
    {
        
        $supplier = Supplier::where('id', $id)->first();
        if (!$supplier) {
            http_response_code(404);
            echo "fournisseur non trouvé";
            return;
        }



        $this->render('app', 'suppliers/edit', [
            'supplier' => $supplier,
            'title' => 'Modifier le fournisseur'
        ]);
    }

    public function update($id)
    {
      
        $supplier = Supplier::where('id', $id)->first();

        if (!$supplier) {
            http_response_code(404);
            echo "fournisseur non trouvé";
            return;
        }

        $data = [
            'name' => trim($_POST['name']),
            'phone' => trim($_POST['phone'])
        ];

        if (empty($data['name'])) {
            http_response_code(400);
            echo "Le nom est obligatoire";
            return;
        }
        if (empty($data['phone'])) {
            http_response_code(400);
            echo "Le numero de telephone est obligatoire";
            return;
        }


        $supplier->update($data);
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'fournisseur modifié avec succès'
        ];
        header('Location: ' . $this->basePath . '/supplier');
    }

    public function delete($id)
    {
        //$supplier = Supplier::find($id);
        $supplier = Supplier::where('id', $id)->first();
        
        if (!$supplier) {
            http_response_code(404);
            echo "fournisseur non trouvé";
            return;
        }

        $supplier->delete();
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'fournisseur supprimé avec succès'
        ];
        header('Location: ' . $this->basePath . '/supplier');
    }

    public function export()
{
    $suppliers = Supplier::all();

    // En-têtes du fichier CSV
    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="suppliers.csv"',
    ];

    // Ouvrir un flux de sortie pour le fichier CSV
    $output = fopen('php://output', 'w');

    // Écrire les en-têtes du CSV
    fputcsv($output, ['ID', 'Nom', 'Téléphone']);

    // Écrire les données des fournisseurs
    foreach ($suppliers as $supplier) {
        fputcsv($output, [$supplier->id, $supplier->name, $supplier->phone]);
    }

    // Fermer le flux de sortie
    fclose($output);

    // Envoyer les en-têtes et le fichier CSV
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="suppliers.csv"');
    exit();
}
   
}
