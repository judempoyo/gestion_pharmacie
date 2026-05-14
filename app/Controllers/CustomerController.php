<?php
namespace App\Controllers;

use App\Core\ViewRenderer;
use App\Models\Customer;
use Jump\JumpDataTable\DataAction;
use Jump\JumpDataTable\DataColumn;
use Jump\JumpDataTable\DataTable;

class CustomerController
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

        $allowedSorts = ['id', 'name', 'phone', 'email'];
        $allowedDirections = ['asc', 'desc'];

        if (!in_array($sort, $allowedSorts))
            $sort = 'id';
        if (!in_array($direction, $allowedDirections))
            $direction = 'asc';

        $query = Customer::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $totalItems = $query->count();
        $offset = ($currentPage - 1) * $perPage;
        $customers = $query->orderBy($sort, $direction)
            ->offset($offset)
            ->limit($perPage)
            ->get()
            ->toArray();

        $table = DataTable::make()
            ->title('Liste des clients')
            ->modelName('customer')
            ->createUrl($this->basePath . '/customer/create')
            ->publicUrl($this->basePath)
            ->addColumn((new DataColumn('id', 'ID'))->sortable())
            ->addColumn((new DataColumn('name', 'Nom'))->searchable())
            ->addColumn((new DataColumn('email', 'Email'))->searchable())
            ->addColumn((new DataColumn('phone', 'Téléphone'))->searchable())
            ->addAction(DataAction::edit('Modifier', fn($item) => $this->basePath . '/customer/' . 'edit/' . $item['id']))
            ->addAction(DataAction::delete('Supprimer', fn($item) => $this->basePath . '/customer/' . 'delete/' . $item['id']))
            ->data($customers)
            ->enableRowSelection(true)
            ->setBulkActions([
                DataAction::delete('Supprimer', fn($item) => "/delete/{$item}"),
            ])
            ->paginate($totalItems, $perPage, $currentPage, $this->basePath . '/customer', [
                'sort' => $sort,
                'direction' => $direction,
                'search' => $search
            ]);

        $this->render('app', 'customers/index', [
            'datatable' => $table->render(),
            'title' => 'Liste des clients'
        ]);
    }

    public function create()
    {
        $this->render('app', 'customers/create', [
            'title' => 'Ajouter un client'
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


        Customer::create($data);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Client créé avec succès'
        ];
        header('Location: ' . $this->basePath . '/customer');
    }

    public function edit($id)
    {
        
        $customer = Customer::where('id', $id)->first();
        if (!$customer) {
            http_response_code(404);
            echo "Client non trouvé";
            return;
        }



        $this->render('app', 'customers/edit', [
            'customer' => $customer,
            'title' => 'Modifier le client'
        ]);
    }

    public function update($id)
    {
      
        $customer = Customer::where('id', $id)->first();

        if (!$customer) {
            http_response_code(404);
            echo "Client non trouvé";
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


        $customer->update($data);
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Client modifié avec succès'
        ];
        header('Location: ' . $this->basePath . '/customer');
    }

    public function delete($id)
    {
        //$customer = Customer::find($id);
        $customer = Customer::where('id', $id)->first();
        
        if (!$customer) {
            http_response_code(404);
            echo "Client non trouvé";
            return;
        }

        $customer->delete();
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Client supprimé avec succès'
        ];
        header('Location: ' . $this->basePath . '/customer');
    }

    public function export()
{
    $customers = Customer::all();

    // En-têtes du fichier CSV
    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="customers.csv"',
    ];

    // Ouvrir un flux de sortie pour le fichier CSV
    $output = fopen('php://output', 'w');

    // Écrire les en-têtes du CSV
    fputcsv($output, ['ID', 'Nom', 'Téléphone']);

    // Écrire les données des clients
    foreach ($customers as $customer) {
        fputcsv($output, [$customer->id, $customer->name, $customer->phone]);
    }

    // Fermer le flux de sortie
    fclose($output);

    // Envoyer les en-têtes et le fichier CSV
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="customers.csv"');
    exit();
}
   
}
