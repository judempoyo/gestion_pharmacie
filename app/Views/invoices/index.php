<?php
$tableParams = [
    'title' => 'Liste des Factures',
    'createUrl' => PUBLIC_URL . 'invoice/create',
    'columns' => [
        ['key' => 'id', 'label' => 'Numéro'],
        ['key' => 'customer.name', 'label' => 'Client'],
        ['key' => 'total_amount', 'label' => 'Montant', 'format' => 'price'],
        ['key' => 'created_at', 'label' => 'Date', 'format' => 'date'],
    ],
    'data' => $invoices, 
    'actions' => [
        [
            'label' => 'Voir',
            'url' => function($item) {
                return PUBLIC_URL . 'invoice/show/' . $item['id'];
            },
        ],
        [
            'label' => 'Modifier',
            'url' => function($item) {
                return PUBLIC_URL . 'invoice/edit/' . $item['id'];
            },
        ],
        [
            'label' => 'Imprimer',
            'url' => function($item) {
                return PUBLIC_URL . 'invoice/print/' . $item['id'];
            },
            'target' => '_blank'
        ],
        [
            'label' => 'Supprimer',
            'type' => 'delete', 
            'url' => function($item) {
                return PUBLIC_URL . 'invoice/delete/' . $item['id'];
            },
        ],
    ],
    'filters' => [
        ['placeholder' => 'Rechercher par client...'],
    ],
    'modelName' => 'invoice',
];

include __DIR__ . '/../partials/reusable_table.php';
?>