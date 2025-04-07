<?php

//namespace App\Config;

require_once dirname(__DIR__) . '/../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

// Configuration de base
define('BASE_PATH', realpath(__DIR__ . '/..'));
define('PUBLIC_PATH', BASE_PATH . '/public/');
define('PUBLIC_URL', 'http://jump.localhost/Projets/gestion_pharmacie/public/');



use FastRoute\RouteCollector;
use App\Controllers\CustomerController;
use App\Controllers\SupplierController;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use Illuminate\Pagination\Paginator;

// Initialiser la pagination
Paginator::currentPathResolver(function () {
    return isset($_SERVER['REQUEST_URI']) ? strtok($_SERVER['REQUEST_URI'], '?') : '/';
});

Paginator::currentPageResolver(function ($pageName = 'page') {
    return isset($_GET[$pageName]) ? $_GET[$pageName] : 1;
});

$basePath = '/Projets/gestion_pharmacie/public'; // Chemin de base de votre projet


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

// Ajouter le chemin de base à vos routes
$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) use ($basePath) {
  

  $r->addRoute('GET', $basePath . '/customer', [CustomerController::class, 'index']);
  $r->addRoute('GET', $basePath . '/customer/create', [CustomerController::class, 'create']);
  $r->addRoute('POST', $basePath . '/customer/store', [CustomerController::class, 'store']);
  $r->addRoute('GET', $basePath . '/customer/export', [CustomerController::class, 'export']);
  $r->addRoute('GET', $basePath . '/customer/edit/{id:\d+}', [CustomerController::class, 'edit']);
  $r->addRoute('POST', $basePath . '/customer/update/{id:\d+}', [CustomerController::class, 'update']);
  $r->addRoute('POST', $basePath . '/customer/delete/{id:\d+}', [CustomerController::class, 'delete']);

  $r->addRoute('GET', $basePath . '/supplier', [SupplierController::class, 'index']);
  $r->addRoute('GET', $basePath . '/supplier/create', [SupplierController::class, 'create']);
  $r->addRoute('POST', $basePath . '/supplier/store', [SupplierController::class, 'store']);
  $r->addRoute('GET', $basePath . '/supplier/export', [SupplierController::class, 'export']);
  $r->addRoute('GET', $basePath . '/supplier/edit/{id:\d+}', [SupplierController::class, 'edit']);
  $r->addRoute('POST', $basePath . '/supplier/update/{id:\d+}', [SupplierController::class, 'update']);
  $r->addRoute('POST', $basePath . '/supplier/delete/{id:\d+}', [SupplierController::class, 'delete']);

  $r->addRoute('GET', $basePath . '/', [AuthController::class, 'showLoginForm']);
  $r->addRoute('GET', $basePath . '/login', [AuthController::class, 'showLoginForm']);
  $r->addRoute('POST', $basePath . '/login', [AuthController::class, 'login']);
  $r->addRoute('GET', $basePath . '/register', [AuthController::class, 'showRegisterForm']);
  $r->addRoute('POST', $basePath . '/register', [AuthController::class, 'register']);
  $r->addRoute('GET', $basePath . '/profile', [UserController::class, 'showProfile']);
$r->addRoute('POST', $basePath . '/profile/update-info', [UserController::class, 'updateProfileInfo']);
$r->addRoute('POST', $basePath . '/profile/update-password', [UserController::class, 'updateProfilePassword']);
$r->addRoute('POST', $basePath . '/profile/delete', [UserController::class, 'deleteProfile']);
  $r->addRoute('GET', $basePath . '/logout', [AuthController::class, 'logout']);
  $r->addRoute('GET', $basePath . '/forgot-password', [AuthController::class, 'showForgotPasswordForm']);
  $r->addRoute('POST', $basePath . '/forgot-password', [AuthController::class, 'sendResetLinkEmail']);
  $r->addRoute('GET', $basePath . '/reset-password/{token}', [AuthController::class, 'showResetForm']);
  $r->addRoute('POST', $basePath . '/reset-password', [AuthController::class, 'resetPassword']);

  $r->addRoute('GET', $basePath . '/dashboard', [AuthController::class, 'dashboard']);
});



$dbHost = $_ENV['DB_HOST'];
$dbName = $_ENV['DB_DATABASE'];
$dbUser = $_ENV['DB_USERNAME'];
$dbPassword = $_ENV['DB_PASSWORD'];

$capsule = new Capsule;
$capsule->addConnection([
  'driver' => 'mysql',
  'host' => $dbHost,
  'database' => $dbName,
  'username' => $dbUser,
  'password' => $dbPassword,
  'charset' => 'utf8',
  'collation' => 'utf8_unicode_ci',
  'prefix' => '',
]);



// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();



// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

// Fonction helper pour les vues
function view($path, $data = [])
{
  extract($data);
  require dirname(__DIR__) . "/Views/$path.php";
}