<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../app/config/bootstrap.php';
require_once __DIR__ . '/../app/helpers/flash.php';


use App\Models\Product;
use FastRoute\Dispatcher;


// Après l'initialisation d'Eloquent
if (Product::count() === 0) {
    $seeder = new \App\Database\Seeders\DatabaseSeeder();
    $seeder->run();
    
    error_log("Données pharmaceutiques par défaut chargées avec succès");
}

// Gestion de la requête
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        
      
        $controller = new $handler[0]();
        $method = $handler[1];
        $controller->$method($vars);
        break;
        
    case Dispatcher::NOT_FOUND:
        http_response_code(404);
        view('errors/404');
        break;
        
    case Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        view('errors/405');
        break;
}
