<?php
namespace App\Controllers;

use App\Models\Customer;
use App\Core\ViewRenderer;

class CustomerController
{
    use ViewRenderer;
    protected $basePath;

    public function __construct()
    {
        $this->basePath = '/Projets/KongB/public';
    }

    public function index()
    {
        $perPage = 10; // Nombre d'éléments par page
        $sort = $_GET['sort'] ?? 'id'; // Colonne de tri par défaut
        $direction = $_GET['direction'] ?? 'asc'; // Direction de tri par défaut
    
        // Validation des paramètres de tri
        $allowedSorts = ['id', 'name']; // Colonnes autorisées pour le tri
        $allowedDirections = ['asc', 'desc']; // Directions autorisées
    
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }
        if (!in_array($direction, $allowedDirections)) {
            $direction = 'asc';
        }
    
        // Pagination avec tri
        $customers = Customer::orderBy($sort, $direction)->paginate($perPage);
    
        $this->render('app', 'customers/index', [
            'customers' => $customers,
            'title' => 'Liste des clients',
            'sort' => $sort,
            'direction' => $direction,
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
