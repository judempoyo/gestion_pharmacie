<div class="container px-4 py-8 mx-auto">
    <h1 class="mb-6 text-3xl font-bold dark:text-white">Tableau de bord pharmacie</h1>
    
    <!-- Cartes de statistiques -->
    <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-4">
        <!-- Total produits -->
        <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center">
                <div class="p-3 mr-4 bg-blue-100 rounded-full dark:bg-blue-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-300">Produits en stock</p>
                    <p class="text-2xl font-bold dark:text-white"><?= $totalProducts ?></p>
                </div>
            </div>
        </div>
        
        <!-- Stock critique -->
        <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center">
                <div class="p-3 mr-4 bg-red-100 rounded-full dark:bg-red-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-300">Stock critique</p>
                    <p class="text-2xl font-bold dark:text-white"><?= $criticalStock ?></p>
                </div>
            </div>
        </div>
        
        <!-- Ventes du mois -->
        <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center">
                <div class="p-3 mr-4 bg-green-100 rounded-full dark:bg-green-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-300">Ventes ce mois</p>
                    <p class="text-2xl font-bold dark:text-white"><?= number_format($monthlySales, 2) ?> €</p>
                </div>
            </div>
        </div>
        
        <!-- Commandes fournisseurs -->
        <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center">
                <div class="p-3 mr-4 bg-purple-100 rounded-full dark:bg-purple-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-300">Commandes en cours</p>
                    <p class="text-2xl font-bold dark:text-white"><?= $pendingOrders ?></p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Graphiques et tableaux -->
    <div class="grid grid-cols-1 gap-8 mb-8 lg:grid-cols-2">
        <!-- Graphique des ventes -->
        <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-700">
            <h2 class="mb-4 text-xl font-bold dark:text-white">Ventes mensuelles</h2>
            <canvas id="salesChart" height="300"></canvas>
        </div>
        
        <!-- Produits en rupture -->
        <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-700">
            <h2 class="mb-4 text-xl font-bold dark:text-white">Produits en rupture</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b dark:border-gray-600">
                            <th class="py-2 text-left dark:text-white">Produit</th>
                            <th class="py-2 text-right dark:text-white">Stock</th>
                            <th class="py-2 text-right dark:text-white">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lowStockProducts as $product): ?>
                        <tr class="border-b dark:border-gray-600">
                            <td class="py-2 dark:text-white"><?= htmlspecialchars($product->designation) ?></td>
                            <td class="text-right py-2 <?= $product->quantity == 0 ? 'text-red-600 font-bold' : 'text-yellow-600' ?>">
                                <?= $product->quantity ?>
                            </td>
                            <td class="py-2 text-right">
                                <a href="<?= PUBLIC_URL ?>product/edit/<?= $product->id ?>" class="text-blue-600 hover:underline dark:text-blue-400">Commander</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Dernières ventes -->
    <div class="p-6 mb-8 bg-white rounded-lg shadow dark:bg-gray-700">
        <h2 class="mb-4 text-xl font-bold dark:text-white">Dernières ventes</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b dark:border-gray-600">
                        <th class="py-2 text-left dark:text-white">N° Facture</th>
                        <th class="py-2 text-left dark:text-white">Client</th>
                        <th class="py-2 text-right dark:text-white">Montant</th>
                        <th class="py-2 text-right dark:text-white">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentInvoices as $invoice): ?>
                    <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600">
                        <td class="py-2">
                            <a href="<?= PUBLIC_URL ?>invoice/show/<?= $invoice->id ?>" class="text-blue-600 hover:underline dark:text-blue-400">
                                #<?= $invoice->id ?>
                            </a>
                        </td>
                        <td class="py-2 dark:text-white"><?= htmlspecialchars($invoice->customer->name) ?></td>
                        <td class="py-2 text-right dark:text-white"><?= number_format($invoice->total_amount, 2) ?> €</td>
                        <td class="py-2 text-right dark:text-white"><?= $invoice->created_at->format('d/m/Y H:i') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Informations utilisateur -->
    <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-700">
        <h2 class="mb-4 text-xl font-bold dark:text-white">Votre compte</h2>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <p class="text-gray-500 dark:text-gray-300">Nom complet</p>
                <p class="text-lg dark:text-white"><?= htmlspecialchars($user->name) ?></p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-gray-300">Email</p>
                <p class="text-lg dark:text-white"><?= htmlspecialchars($user->email) ?></p>
            </div>
           <!--  <div>
                <p class="text-gray-500 dark:text-gray-300">Téléphone</p>
                <p class="text-lg dark:text-white"><?= htmlspecialchars($user->phone) ?></p>
            </div> -->
            <div>
                <p class="text-gray-500 dark:text-gray-300">Compte créé le</p>
                <p class="text-lg dark:text-white"><?= $user->created_at->format('d/m/Y') ?></p>
            </div>
        </div>
        <div class="mt-6">
            <a href="<?= PUBLIC_URL ?>profile" class="px-4 py-2 mr-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                Modifier le profil
            </a>
            <a href="<?= PUBLIC_URL ?>logout" class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700">
                Déconnexion
            </a>
        </div>
    </div>
</div>

<!-- Script pour le graphique -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($salesChart['labels']) ?>,
                datasets: [{
                    label: 'Ventes mensuelles (€)',
                    data: <?= json_encode($salesChart['data']) ?>,
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
<?php 
//$content = ob_get_clean();
//include __DIR__ . '/../layouts/app.php';