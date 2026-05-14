<div class="min-h-screen p-4 bg-gray-50 dark:bg-gray-900">
    <div class="mx-auto">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Rapports d'activité</h1>
            
            <form action="<?= url('/reports') ?>" method="GET" class="mt-4 md:mt-0 flex flex-wrap gap-3">
                <div class="flex items-center space-x-2">
                    <label class="text-sm text-gray-600 dark:text-gray-400">Du</label>
                    <input type="date" name="start_date" value="<?= $startDate ?>" class="p-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">
                </div>
                <div class="flex items-center space-x-2">
                    <label class="text-sm text-gray-600 dark:text-gray-400">Au</label>
                    <input type="date" name="end_date" value="<?= $endDate ?>" class="p-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">
                </div>
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors text-sm">
                    Filtrer
                </button>
                <a href="<?= url('/reports/export?start_date=' . $startDate . '&end_date=' . $endDate) ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors text-sm flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Exporter CSV
                </a>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Résumé Ventes -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                <p class="text-sm text-gray-500 dark:text-gray-400 uppercase font-semibold">Chiffre d'affaires</p>
                <h3 class="text-2xl font-bold text-teal-600 mt-1"><?= number_format($salesSummary->total ?? 0, 0, ',', ' ') ?> FC</h3>
                <p class="text-sm text-gray-600 dark:text-gray-500 mt-2"><?= $salesSummary->count ?? 0 ?> ventes effectuées</p>
            </div>

            <!-- Résumé Achats -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                <p class="text-sm text-gray-500 dark:text-gray-400 uppercase font-semibold">Dépenses (Achats)</p>
                <h3 class="text-2xl font-bold text-orange-600 mt-1"><?= number_format($purchasesSummary->total ?? 0, 0, ',', ' ') ?> FC</h3>
                <p class="text-sm text-gray-600 dark:text-gray-500 mt-2"><?= $purchasesSummary->count ?? 0 ?> bons de commande</p>
            </div>

            <!-- Valeur du Stock -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                <p class="text-sm text-gray-500 dark:text-gray-400 uppercase font-semibold">Valeur du Stock Actuel</p>
                <h3 class="text-2xl font-bold text-blue-600 mt-1"><?= number_format($stockSummary['total_value'] ?? 0, 0, ',', ' ') ?> FC</h3>
                <p class="text-sm text-gray-600 dark:text-gray-500 mt-2"><?= $stockSummary['total_items'] ?> articles en stock</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Evolution des ventes -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Évolution quotidienne des ventes</h2>
                <div class="h-80">
                    <canvas id="dailySalesChart"></canvas>
                </div>
            </div>

            <!-- Alertes de stock -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Résumé des alertes</h2>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-red-50 dark:bg-red-900/20 rounded-lg">
                        <div class="flex items-center">
                            <div class="p-2 bg-red-100 dark:bg-red-800 rounded-full mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <span class="font-medium text-gray-900 dark:text-white">Produits périmés</span>
                        </div>
                        <span class="text-xl font-bold text-red-600"><?= $stockSummary['expired'] ?></span>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                        <div class="flex items-center">
                            <div class="p-2 bg-orange-100 dark:bg-orange-800 rounded-full mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="font-medium text-gray-900 dark:text-white">Rupture de stock</span>
                        </div>
                        <span class="text-xl font-bold text-orange-600"><?= $stockSummary['out_of_stock'] ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('dailySalesChart').getContext('2d');
        const labels = <?= json_encode($dailySales->pluck('date')) ?>;
        const data = <?= json_encode($dailySales->pluck('total')) ?>;

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Ventes Journalières',
                    data: data,
                    backgroundColor: 'rgba(20, 184, 166, 0.6)',
                    borderColor: 'rgb(20, 184, 166)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    });
</script>
