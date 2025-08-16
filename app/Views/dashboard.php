<div class="min-h-screen p-4 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto">
        <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-white animate-fade-in-down">
            Tableau de bord pharmacie
            <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                <?= date('d/m/Y') ?>
            </span>
        </h1>

        <!-- Cartes de statistiques -->
        <div class="grid grid-cols-1 gap-6 mb-10 sm:grid-cols-2 lg:grid-cols-4 animate-fade-in">
            <!-- Total produits -->
            <div class="p-6 transition-all bg-white rounded-lg shadow dark:bg-gray-800 hover:shadow-lg hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 mr-4 rounded-full bg-emerald-50 dark:bg-emerald-900/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-300">Produits en stock</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white"><?= $totalProducts ?></p>
                    </div>
                </div>
            </div>

            <!-- Stock critique -->
            <div class="p-6 transition-all bg-white rounded-lg shadow dark:bg-gray-800 hover:shadow-lg hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 mr-4 rounded-full bg-amber-50 dark:bg-amber-900/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-300">Stock faible</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white"><?= $criticalStock ?></p>
                        <p class="text-xs text-amber-600 dark:text-amber-400">+ <?= $outOfStock ?> en rupture</p>
                    </div>
                </div>
            </div>

            <!-- Ventes du mois -->
            <div class="p-6 transition-all bg-white rounded-lg shadow dark:bg-gray-800 hover:shadow-lg hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 mr-4 rounded-full bg-blue-50 dark:bg-blue-900/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-300">Ventes ce mois</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white"><?= number_format($monthlySales, 0, ',', ' ') ?> FC</p>
                        <p class="text-xs text-blue-600 dark:text-blue-400">
                            <?= number_format($monthlyPurchases, 0, ',', ' ') ?> FC d'achats
                        </p>
                    </div>
                </div>
            </div>

            <!-- Commandes fournisseurs -->
            <div class="p-6 transition-all bg-white rounded-lg shadow dark:bg-gray-800 hover:shadow-lg hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 mr-4 rounded-full bg-purple-50 dark:bg-purple-900/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-300">Commandes ce mois </p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                            <?= number_format($monthlyPurchases, 0, ',', ' ') ?> FC 
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphiques et tableaux -->
        <div class="grid grid-cols-1 gap-8 mb-8 lg:grid-cols-2">
            <!-- Graphique des ventes/achats -->
            <div class="p-6 transition-all bg-white rounded-lg shadow dark:bg-gray-800 hover:shadow-lg animate-fade-in-left">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Ventes et achats</h2>
                    <span class="text-sm text-gray-500 dark:text-gray-400">6 derniers mois</span>
                </div>
                <canvas id="salesChart" height="300"></canvas>
            </div>

            <!-- État du stock -->
            <div class="p-6 transition-all bg-white rounded-lg shadow dark:bg-gray-800 hover:shadow-lg animate-fade-in-right">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">État du stock</h2>
                </div>
                <canvas id="inventoryChart" height="300"></canvas>
            </div>
        </div>

        <!-- Tableaux -->
        <div class="grid grid-cols-1 gap-8 mb-8 lg:grid-cols-2">
            <!-- Produits en rupture -->
            <div class="p-6 transition-all bg-white rounded-lg shadow dark:bg-gray-800 hover:shadow-lg animate-fade-in-left">
                <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Produits à réapprovisionner</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Produit</th>
                                <th class="px-4 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-300">Stock</th>
                                <th class="px-4 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-300">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            <?php foreach ($lowStockProducts as $product): ?>
                            <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($product->designation) ?></td>
                                <td class="px-4 py-3 text-sm text-right <?= $product->quantity == 0 ? 'text-red-600 font-semibold' : 'text-amber-600' ?>">
                                    <?= $product->quantity ?>
                                </td>
                                <td class="px-4 py-3 text-sm text-right">
                                    <a href="<?= $this->basePath ?>/purchase/create?product_id=<?= $product->id ?>" 
                                       class="px-3 py-1 text-sm text-white transition-colors bg-blue-600 rounded-md hover:bg-blue-700">
                                        Commander
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Dernières ventes -->
            <div class="p-6 transition-all bg-white rounded-lg shadow dark:bg-gray-800 hover:shadow-lg animate-fade-in-right">
                <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Dernières ventes</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Facture</th>
                                <th class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Client</th>
                                <th class="px-4 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-300">Montant</th>
                                <th class="px-4 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-300">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            <?php foreach ($recentInvoices as $invoice): ?>
                            <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-3 text-sm font-medium text-blue-600 dark:text-blue-400">
                                    <a href="<?= $this->basePath ?>/invoice/show/<?= $invoice->id ?>" class="hover:underline">
                                        #<?= str_pad($invoice->id, 6, '0', STR_PAD_LEFT) ?>
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white"><?= htmlspecialchars($invoice->customer->name) ?></td>
                                <td class="px-4 py-3 text-sm text-right text-gray-900 dark:text-white"><?= number_format($invoice->total_amount, 0, ',', ' ') ?> FC</td>
                                <td class="px-4 py-3 text-sm text-right text-gray-500 dark:text-gray-400"><?= $invoice->created_at->format('d/m H:i') ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Meilleurs produits -->
        <div class="p-6 mb-8 transition-all bg-white rounded-lg shadow dark:bg-gray-800 hover:shadow-lg animate-fade-in-up">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Meilleurs produits</h2>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
                <?php foreach ($topProducts as $product): ?>
                <div class="p-4 transition-all border rounded-lg hover:shadow-md dark:border-gray-700">
                    <div class="text-lg font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($product->designation) ?></div>
                    <div class="flex items-center justify-between mt-2">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Ventes: <?= $product->sales_count ?? 0 ?></span>
                        <span class="text-sm font-semibold text-blue-600 dark:text-blue-400"><?= number_format($product->unit_price, 0, ',', ' ') ?> FC</span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Scripts pour les graphiques -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Graphique des ventes et achats
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($salesChart['labels']) ?>,
                datasets: <?= json_encode($salesChart['datasets']) ?>
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#fff' : '#374151'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.raw.toLocaleString() + ' FC';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#fff' : '#374151',
                            callback: function(value) {
                                return value.toLocaleString() + ' FC';
                            }
                        },
                        grid: {
                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        ticks: {
                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#fff' : '#374151'
                        },
                        grid: {
                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                        }
                    }
                }
            }
        });

        // Graphique de l'état du stock
        const inventoryCtx = document.getElementById('inventoryChart').getContext('2d');
        new Chart(inventoryCtx, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode($inventoryChart['labels']) ?>,
                datasets: [{
                    data: <?= json_encode($inventoryChart['data']) ?>,
                    backgroundColor: <?= json_encode($inventoryChart['colors']) ?>,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#fff' : '#374151'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.raw + ' produits';
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        });
    });
</script>

<!-- Styles pour les animations -->
<style>
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out;
    }
    .animate-fade-in-down {
        animation: fadeInDown 0.5s ease-out;
    }
    .animate-fade-in-left {
        animation: fadeInLeft 0.5s ease-out;
    }
    .animate-fade-in-right {
        animation: fadeInRight 0.5s ease-out;
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes fadeInDown {
        from { 
            opacity: 0;
            transform: translateY(-20px);
        }
        to { 
            opacity: 1;
            transform: translateY(0);
        }
    }
    @keyframes fadeInLeft {
        from { 
            opacity: 0;
            transform: translateX(-20px);
        }
        to { 
            opacity: 1;
            transform: translateX(0);
        }
    }
    @keyframes fadeInRight {
        from { 
            opacity: 0;
            transform: translateX(20px);
        }
        to { 
            opacity: 1;
            transform: translateX(0);
        }
    }
    @keyframes fadeInUp {
        from { 
            opacity: 0;
            transform: translateY(20px);
        }
        to { 
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>