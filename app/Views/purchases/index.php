<?php


$tableParams = [
    'title' => 'Liste des Factures',
    'createUrl' => PUBLIC_URL . 'purchase/create',
    'columns' => [
        ['key' => 'id', 'label' => 'Numéro'],
        ['key' => 'suppliers.name', 'label' => 'Client'],
        ['key' => 'total_amount', 'label' => 'Montant', 'format' => 'price'],
        ['key' => 'created_at', 'label' => 'Date', 'format' => 'date'],
    ],
    'data' => $purchases, 
    'actions' => [
        [
            'label' => 'Voir',
            'url' => function($item) {
                return PUBLIC_URL . 'purchase/show/' . $item['id'];
            },
        ],
        [
            'label' => 'Modifier',
            'url' => function($item) {
                return PUBLIC_URL . 'purchase/edit/' . $item['id'];
            },
        ],
        [
            'label' => 'Imprimer',
            'url' => function($item) {
                return PUBLIC_URL . 'purchase/print/' . $item['id'];
            },
            'target' => '_blank'
        ],
        [
            'label' => 'Supprimer',
            'type' => 'delete', 
            'url' => function($item) {
                return PUBLIC_URL . 'purchase/delete/' . $item['id'];
            },
        ],
    ],
    'filters' => [
        ['placeholder' => 'Rechercher par fournisseur...'],
    ],
    'modelName' => 'purchase',
];

include __DIR__ . '/../partials/reusable_table.php';
?>