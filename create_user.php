<?php

require 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;

require_once 'app/config/bootstrap.php';
// Configuration de la base de données
$capsule = new DB;

// Création de l'utilisateur
$email = 'admin@gmail.com';
$password = '12345678';

// Vérifie si l'utilisateur existe déjà
$user = DB::table('users')->where('email', $email)->first();

if ($user) {
    echo "Un utilisateur avec cet email existe déjà.\n";
    exit;
}

// Insère l'utilisateur dans la base de données
DB::table('users')->insert([
    'name' => 'Admin',
    'email' => $email,
    'password' => password_hash($password, PASSWORD_BCRYPT),
    'created_at' => date('Y-m-d H:i:s'),
    'updated_at' => date('Y-m-d H:i:s'),
]);

echo "Utilisateur créé avec succès : $email\n";