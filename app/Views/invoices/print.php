<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture #<?= $invoice->id ?></title>
    <style>
        body { font-family: Arial, sans-serif; }
        .invoice-header { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .invoice-info { margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .total-row { font-weight: bold; }
        .footer { margin-top: 50px; text-align: center; font-size: 0.8em; }
    </style>
</head>
<body>
    <div class="invoice-header">
        <div>
            <h1>Pharmacie XYZ</h1>
            <p>123 Rue Principale</p>
            <p>75000 Paris</p>
            <p>Tél: 01 23 45 67 89</p>
        </div>
        <div>
            <h2>Facture #<?= $invoice->id ?></h2>
            <p>Date: <?= date('d/m/Y', strtotime($invoice->created_at)) ?></p>
        </div>
    </div>

    <div class="invoice-info">
        <div>
            <h3>Client</h3>
            <p><?= htmlspecialchars($invoice->customer->name) ?></p>
            <p><?= htmlspecialchars($invoice->customer->phone) ?></p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th class="text-right">Prix unitaire</th>
                <th class="text-right">Quantité</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($invoice->invoiceLines as $line): ?>
            <tr>
                <td><?= htmlspecialchars($line->product->designation) ?></td>
                <td class="text-right"><?= number_format($line->unit_price, 2) ?> €</td>
                <td class="text-right"><?= $line->quantity ?></td>
                <td class="text-right"><?= number_format($line->unit_price * $line->quantity, 2) ?> €</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3">Total</td>
                <td class="text-right"><?= number_format($invoice->total_amount, 2) ?> €</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Merci pour votre confiance</p>
        <p>Facture générée le <?= date('d/m/Y H:i') ?></p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>