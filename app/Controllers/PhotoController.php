<?php
namespace App\Controllers;

use App\Models\Photo;
use App\Core\ViewRenderer;

class PhotoController
{
    use ViewRenderer;
    
    /* 
    
    public function index()
    {
        $photos = Photo::all(); // Récupérer toutes les photos
        require_once __DIR__ . '/../Views/photo/index.php'; // Charger la vue
        } 
        
        public function create()
        {
            require_once __DIR__ . '/../Views/photo/create.php'; // Charger la vue pour créer une photo
            }
            */
    
    public function index() {
        $photos = Photo::all();
        $this->render('app','photos/index', [
            'photos' => $photos,
            'title' => 'Galerie Photos'
        ]);
    }
    public function create() {
        $this->render('app','photos/create', [
            
    ]);
}

    public function store($data)
    {
        // Validation simple des données
        if (empty($data['title']) || empty($data['description']) || empty($data['path'])) {
            http_response_code(400);
            echo "Tous les champs sont requis.";
            return;
        }

        Photo::create($data); // Créer une nouvelle photo
        header('Location: /'); // Rediriger vers la page d'accueil
    }
}