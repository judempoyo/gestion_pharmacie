<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture #<?= $invoice->id ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-3xl p-8 bg-white rounded-lg shadow-lg">
            <!-- En-tête de la facture -->
            <div class="flex items-center justify-between pb-4 mb-6 border-b">
                <div>
                    <h1 class="text-2xl font-bold text-teal-600">Pharmacie XYZ</h1>
                    <p class="text-sm text-gray-600">123 Rue Principale</p>
                    <p class="text-sm text-gray-600">75000 Paris</p>
                    <p class="text-sm text-gray-600">Tél: 01 23 45 67 89</p>
                </div>
                <div class="text-right">
                    <h2 class="text-xl font-semibold text-gray-800">Facture #<?= $invoice->id ?></h2>
                    <p class="text-sm text-gray-600">Date: <?= date('d/m/Y', strtotime($invoice->created_at)) ?></p>
                </div>
            </div>

            <!-- Informations du client -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Client</h3>
                <p class="text-sm text-gray-600"><?= htmlspecialchars($invoice->customer->name) ?></p>
                <p class="text-sm text-gray-600"><?= htmlspecialchars($invoice->customer->phone) ?></p>
            </div>

            <!-- Tableau des produits -->
            <table class="w-full mb-6 border border-collapse border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-sm font-medium text-left text-gray-600 border border-gray-300">Produit</th>
                        <th class="px-4 py-2 text-sm font-medium text-right text-gray-600 border border-gray-300">Prix unitaire</th>
                        <th class="px-4 py-2 text-sm font-medium text-right text-gray-600 border border-gray-300">Quantité</th>
                        <th class="px-4 py-2 text-sm font-medium text-right text-gray-600 border border-gray-300">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($invoice->invoiceLines as $line): ?>
                    <tr>
                        <td class="px-4 py-2 text-sm text-gray-800 border border-gray-300"><?= htmlspecialchars($line->product->designation) ?></td>
                        <td class="px-4 py-2 text-sm text-right text-gray-800 border border-gray-300"><?= number_format($line->unit_price, 2) ?> FC</td>
                        <td class="px-4 py-2 text-sm text-right text-gray-800 border border-gray-300"><?= $line->quantity ?></td>
                        <td class="px-4 py-2 text-sm text-right text-gray-800 border border-gray-300"><?= number_format($line->unit_price * $line->quantity, 2) ?> FC</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="bg-gray-100">
                        <td colspan="3" class="px-4 py-2 text-sm font-semibold text-right text-gray-800 border border-gray-300">Total</td>
                        <td class="px-4 py-2 text-sm font-semibold text-right text-gray-800 border border-gray-300"><?= number_format($invoice->total_amount, 2) ?> FC</td>
                    </tr>
                </tfoot>
            </table>

            <!-- Pied de page -->
            <div class="text-sm text-center text-gray-600">
                <p>Merci pour votre confiance</p>
                <p>Facture générée le <?= date('d/m/Y H:i') ?></p>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>