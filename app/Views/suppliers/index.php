<?php
// Paramètres pour le tableau des clients
$tableParams = [
    'title' => 'Liste des Clients',
    'createUrl' => PUBLIC_URL . 'supplier/create',
    'columns' => [
        ['key' => 'id', 'label' => 'ID'],
        ['key' => 'name', 'label' => 'Nom'],
    ],
    'data' => $suppliers, 
    'actions' => [
        [
            'label' => 'Modifier',
            'url' => function($item) {
                return PUBLIC_URL . 'supplier/edit/' . $item['id'];
            },
        ],
        [
            'label' => 'Supprimer',
            'type' => 'delete', 
            'url' => function($item) {
                return PUBLIC_URL . 'supplier/delete/' . $item['id'];
            },
        ],
    ],
    'filters' => [
        ['placeholder' => 'Rechercher par nom...'],
    ],
    'modelName' => 'supplier',
];


include __DIR__ . '/../partials/reusable_table.php';
?>