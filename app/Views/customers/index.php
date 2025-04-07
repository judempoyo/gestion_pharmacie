<?php
// Paramètres pour le tableau des clients
$tableParams = [
    'title' => 'Liste des Clients',
    'createUrl' => PUBLIC_URL . 'customer/create',
    'columns' => [
        ['key' => 'id', 'label' => 'ID'],
        ['key' => 'name', 'label' => 'Nom'],
    ],
    'data' => $customers, 
    'actions' => [
        [
            'label' => 'Modifier',
            'url' => function($item) {
                return PUBLIC_URL . 'customer/edit/' . $item['id'];
            },
        ],
        [
            'label' => 'Supprimer',
            'type' => 'delete', 
            'url' => function($item) {
                return PUBLIC_URL . 'customer/delete/' . $item['id'];
            },
        ],
    ],
    'filters' => [
        ['placeholder' => 'Rechercher par nom...'],
    ],
    'modelName' => 'customer',
];


include __DIR__ . '/../partials/reusable_table.php';
?>