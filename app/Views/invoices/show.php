<div class="max-w-4xl p-6 mx-auto mt-8 bg-white rounded-lg shadow dark:bg-gray-800">
    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Facture #<?= $invoice->id ?></h1>
            <p class="text-gray-600 dark:text-gray-300">Date: <?= date('d/m/Y', strtotime($invoice->created_at)) ?></p>
        </div>
        <div class="flex space-x-2">
            <a href="<?= PUBLIC_URL ?>invoice/print/<?= $invoice->id ?>" target="_blank" 
               class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700">
                Imprimer
            </a>
            <a href="<?= PUBLIC_URL ?>invoice/edit/<?= $invoice->id ?>" 
               class="px-4 py-2 text-white bg-teal-500 rounded hover:bg-teal-600 dark:bg-teal-600 dark:hover:bg-teal-700">
                Modifier
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2">
        <div class="p-4 border rounded dark:border-gray-600">
            <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Client</h3>
            <p class="text-gray-700 dark:text-gray-300"><?= htmlspecialchars($invoice->customer->name) ?></p>
            <p class="text-gray-700 dark:text-gray-300"><?= htmlspecialchars($invoice->customer->phone) ?></p>
        </div>
        <div class="p-4 border rounded dark:border-gray-600">
            <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Facture</h3>
            <p class="text-gray-700 dark:text-gray-300">Numéro: <?= $invoice->id ?></p>
            <p class="text-gray-700 dark:text-gray-300">Total: <?= number_format($invoice->total_amount, 2) ?> FC</p>
        </div>
    </div>

    <div class="mb-8">
        <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Produits</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <th class="p-3 text-left">Produit</th>
                        <th class="p-3 text-right">Prix unitaire</th>
                        <th class="p-3 text-right">Quantité</th>
                        <th class="p-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($invoice->invoiceLines as $line): ?>
                    <tr class="border-b dark:border-gray-600">
                        <td class="p-3"><?= htmlspecialchars($line->product->designation) ?></td>
                        <td class="p-3 text-right"><?= number_format($line->unit_price, 2) ?> FC</td>
                        <td class="p-3 text-right"><?= $line->quantity ?></td>
                        <td class="p-3 text-right"><?= number_format($line->unit_price * $line->quantity, 2) ?> FC</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="font-bold bg-gray-100 dark:bg-gray-700">
                        <td class="p-3" colspan="3">Total</td>
                        <td class="p-3 text-right"><?= number_format($invoice->total_amount, 2) ?> FC</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>