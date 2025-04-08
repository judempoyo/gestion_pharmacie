<?php
$tableParams = [
    'title' => 'Liste des Produits',
    'createUrl' => PUBLIC_URL . 'product/create',
    'columns' => [
        ['key' => 'id', 'label' => 'ID'],
        ['key' => 'designation', 'label' => 'Désignation'],
        ['key' => 'quantity', 'label' => 'Quantité'],
        ['key' => 'unit_price', 'label' => 'Prix unitaire'],
        [
            'key' => 'image_url', 
            'label' => 'Image', 
            'format' => 'image',
            'basePath' => PUBLIC_URL
        ],
    ],
    'data' => $products, 
    'actions' => [
        [
            'label' => 'Modifier',
            'url' => function($item) {
                return PUBLIC_URL . 'product/edit/' . $item['id'];
            },
        ],
        [
            'label' => 'Supprimer',
            'type' => 'delete', 
            'url' => function($item) {
                return PUBLIC_URL . 'product/delete/' . $item['id'];
            },
        ],
    ],
    'filters' => [
        ['placeholder' => 'Rechercher par désignation...'],
    ],
    'modelName' => 'product',
];

include __DIR__ . '/../partials/reusable_table.php';
?>