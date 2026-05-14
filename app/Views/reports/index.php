<div class="min-h-screen p-4 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <div class="mx-auto max-w-7xl">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Rapports d'activité</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Analyse détaillée des performances de votre pharmacie</p>
            </div>
            
            <form action="<?= url('/reports') ?>" method="GET" class="flex flex-wrap items-center gap-3 bg-white dark:bg-gray-800 p-3 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center space-x-2">
                    <label class="text-xs font-bold uppercase text-gray-400 dark:text-gray-500">Du</label>
                    <input type="date" name="start_date" value="<?= $startDate ?>" class="p-2 bg-gray-50 dark:bg-gray-700 border-none rounded-xl dark:text-white text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
                <div class="flex items-center space-x-2">
                    <label class="text-xs font-bold uppercase text-gray-400 dark:text-gray-500">Au</label>
                    <input type="date" name="end_date" value="<?= $endDate ?>" class="p-2 bg-gray-50 dark:bg-gray-700 border-none rounded-xl dark:text-white text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
                <button type="submit" class="px-5 py-2 bg-teal-600 text-white font-semibold rounded-xl hover:bg-teal-700 transition-all active:scale-95 shadow-md shadow-teal-200 dark:shadow-none">
                    Filtrer
                </button>
                <a href="<?= url('/reports/export?start_date=' . $startDate . '&end_date=' . $endDate) ?>" class="px-5 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    CSV
                </a>
            </form>
        </div>

        <!-- Cartes de résumé -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 group hover:border-teal-500 transition-colors">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Chiffre d'affaires</p>
                    <div class="p-2 bg-teal-50 dark:bg-teal-900/30 rounded-lg text-teal-600 dark:text-teal-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-gray-900 dark:text-white"><?= number_format($salesSummary->total ?? 0, 0, ',', ' ') ?> <span class="text-sm font-normal text-gray-400">FC</span></h3>
                <p class="text-sm text-gray-500 mt-2 flex items-center">
                    <span class="text-teal-500 font-bold mr-1"><?= $salesSummary->count ?? 0 ?></span> ventes
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 group hover:border-orange-500 transition-colors">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Dépenses (Achats)</p>
                    <div class="p-2 bg-orange-50 dark:bg-orange-900/30 rounded-lg text-orange-600 dark:text-orange-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h12l1 12H4L5 9z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-gray-900 dark:text-white"><?= number_format($purchasesSummary->total ?? 0, 0, ',', ' ') ?> <span class="text-sm font-normal text-gray-400">FC</span></h3>
                <p class="text-sm text-gray-500 mt-2">
                    <span class="text-orange-500 font-bold mr-1"><?= $purchasesSummary->count ?? 0 ?></span> bons
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 group hover:border-blue-500 transition-colors">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Valeur du Stock</p>
                    <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg text-blue-600 dark:text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-gray-900 dark:text-white"><?= number_format($stockSummary['total_value'] ?? 0, 0, ',', ' ') ?> <span class="text-sm font-normal text-gray-400">FC</span></h3>
                <p class="text-sm text-gray-500 mt-2">
                    <span class="text-blue-500 font-bold mr-1"><?= $stockSummary['total_items'] ?></span> articles
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 group hover:border-red-500 transition-colors">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Alertes Péremption</p>
                    <div class="p-2 bg-red-50 dark:bg-red-900/30 rounded-lg text-red-600 dark:text-red-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-red-600 dark:text-red-400"><?= $stockSummary['expired'] ?></h3>
                <p class="text-sm text-gray-500 mt-2 italic">
                    <?= $stockSummary['expiring_soon'] ?> expirent bientôt
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Evolution des ventes -->
            <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-50 dark:border-gray-700">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Évolution des revenus</h2>
                <div class="h-80">
                    <canvas id="dailySalesChart"></canvas>
                </div>
            </div>

            <!-- Meilleurs produits -->
            <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-50 dark:border-gray-700 overflow-hidden">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Top 10 des produits les plus rentables</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="text-left">
                                <th class="pb-4 text-xs font-bold text-gray-400 dark:text-gray-500 uppercase">Désignation</th>
                                <th class="pb-4 text-xs font-bold text-gray-400 dark:text-gray-500 uppercase text-right">Quantité</th>
                                <th class="pb-4 text-xs font-bold text-gray-400 dark:text-gray-500 uppercase text-right">Revenu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            <?php foreach ($topProducts as $product): ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="py-4 text-sm font-semibold text-gray-900 dark:text-white truncate max-w-xs"><?= htmlspecialchars($product->designation) ?></td>
                                <td class="py-4 text-sm text-gray-500 dark:text-gray-400 text-right"><?= $product->total_sold ?? 0 ?></td>
                                <td class="py-4 text-sm font-bold text-teal-600 dark:text-teal-400 text-right"><?= number_format($product->total_revenue ?? 0, 0, ',', ' ') ?> FC</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#9ca3af' : '#6b7280';
        const gridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';

        const ctx = document.getElementById('dailySalesChart').getContext('2d');
        
        // Gradient for bars
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(20, 184, 166, 0.8)');
        gradient.addColorStop(1, 'rgba(20, 184, 166, 0.2)');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($dailySales->pluck('date')) ?>,
                datasets: [{
                    label: 'Ventes journalières',
                    data: <?= json_encode($dailySales->pluck('total')) ?>,
                    backgroundColor: gradient,
                    borderColor: '#14b8a6',
                    borderWidth: 2,
                    borderRadius: 12,
                    borderSkipped: false,
                    barThickness: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: isDark ? '#1f2937' : '#fff',
                        titleColor: isDark ? '#fff' : '#111827',
                        bodyColor: isDark ? '#d1d5db' : '#4b5563',
                        padding: 12,
                        cornerRadius: 12,
                        boxPadding: 6,
                        borderColor: isDark ? '#374151' : '#e5e7eb',
                        borderWidth: 1,
                        callbacks: {
                            label: (context) => `Revenu: ${context.parsed.y.toLocaleString()} FC`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: gridColor, drawBorder: false },
                        ticks: { color: textColor, font: { size: 10 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: textColor, font: { size: 10 } }
                    }
                }
            }
        });
    });
</script>
