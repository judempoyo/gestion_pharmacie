<div class="min-h-screen p-4 bg-gray-50 dark:bg-gray-900">
    <div class="mx-auto">
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
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white"><?= $totalProducts ?? 0 ?></p>
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
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-300">Stock faible / Rupture</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white"><?= ($criticalStock ?? 0) + ($outOfStock ?? 0) ?></p>
                        <p class="text-xs text-amber-600 dark:text-amber-400"><?= $outOfStock ?? 0 ?> en rupture totale</p>
                    </div>
                </div>
            </div>

            <!-- Péremption -->
            <div class="p-6 transition-all bg-white rounded-lg shadow dark:bg-gray-800 hover:shadow-lg hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 mr-4 rounded-full bg-red-50 dark:bg-red-900/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-300">Péremption</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white"><?= $expiredProducts ?? 0 ?></p>
                        <p class="text-xs text-red-600 dark:text-red-400"><?= $nearExpiry ?? 0 ?> expirent bientôt</p>
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
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-300">Ventes du mois</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white"><?= number_format($monthlySales ?? 0, 0, ',', ' ') ?> FC</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphiques -->
        <div class="grid grid-cols-1 gap-8 mb-8 lg:grid-cols-2">
            <!-- Graphique des ventes/achats -->
            <div class="p-6 transition-all bg-white rounded-lg shadow dark:bg-gray-800 hover:shadow-lg animate-fade-in">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Ventes et achats</h2>
                    <span class="text-sm text-gray-500 dark:text-gray-400">6 derniers mois</span>
                </div>
                <div class="relative h-64">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <!-- État du stock -->
            <div class="p-6 transition-all bg-white rounded-lg shadow dark:bg-gray-800 hover:shadow-lg animate-fade-in">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">État du stock</h2>
                </div>
                <div class="relative h-64">
                    <canvas id="inventoryChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Tableaux de vigilance -->
        <div class="grid grid-cols-1 gap-8 mb-8 lg:grid-cols-3">
            <!-- Produits en rupture -->
            <div class="p-6 transition-all bg-white rounded-lg shadow dark:bg-gray-800 hover:shadow-lg">
                <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Stock faible
                </h2>
                <div class="overflow-x-auto max-h-60">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            <?php foreach ($lowStockProducts ?? [] as $product): ?>
                            <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-2 py-3 text-sm font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($product->designation) ?></td>
                                <td class="px-2 py-3 text-sm text-right <?= ($product->quantity ?? 0) == 0 ? 'text-red-600 font-semibold' : 'text-amber-600' ?>">
                                    <?= $product->quantity ?? 0 ?>
                                </td>
                                <td class="px-2 py-3 text-sm text-right">
                                    <a href="<?= url('/purchase/create?product_id=' . ($product->id ?? '')) ?>" class="text-blue-600 hover:underline">Commander</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Produits expirant bientôt -->
            <div class="p-6 transition-all bg-white rounded-lg shadow dark:bg-gray-800 hover:shadow-lg">
                <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Péremption proche
                </h2>
                <div class="overflow-x-auto max-h-60">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            <?php foreach ($expiringProducts ?? [] as $product): ?>
                            <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-2 py-3 text-sm font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($product->designation) ?></td>
                                <td class="px-2 py-3 text-sm text-right <?= (isset($product->expiry_date) && strtotime($product->expiry_date) < time()) ? 'text-red-600 font-bold' : 'text-orange-500' ?>">
                                    <?= isset($product->expiry_date) ? date('d/m/Y', strtotime($product->expiry_date)) : '-' ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Dernières ventes -->
            <div class="p-6 transition-all bg-white rounded-lg shadow dark:bg-gray-800 hover:shadow-lg">
                <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                    </svg>
                    Ventes récentes
                </h2>
                <div class="overflow-x-auto max-h-60">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            <?php foreach ($recentInvoices ?? [] as $invoice): ?>
                            <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-2 py-3 text-sm font-medium text-blue-600 dark:text-blue-400">
                                    <a href="<?= url('/invoice/show/' . ($invoice->id ?? '')) ?>" class="hover:underline">#<?= $invoice->id ?? '' ?></a>
                                </td>
                                <td class="px-2 py-3 text-sm text-gray-900 dark:text-white"><?= htmlspecialchars($invoice->customer->name ?? 'Client inconnu') ?></td>
                                <td class="px-2 py-3 text-sm text-right font-medium"><?= number_format($invoice->total_amount ?? 0, 0, ',', ' ') ?></td>
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
        if (typeof Chart === 'undefined') return;

        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#e5e7eb' : '#374151';
        const gridColor = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';

        // Chart 1: Sales
        const salesEl = document.getElementById('salesChart');
        if (salesEl) {
            const salesCtx = salesEl.getContext('2d');
            const salesData = <?= json_encode($salesChart ?? ['labels' => [], 'datasets' => []]) ?>;
            new Chart(salesCtx, {
                type: 'line',
                data: salesData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    tension: 0.3,
                    plugins: {
                        legend: { labels: { color: textColor } }
                    },
                    scales: {
                        y: { grid: { color: gridColor }, ticks: { color: textColor } },
                        x: { grid: { color: gridColor }, ticks: { color: textColor } }
                    }
                }
            });
        }

        // Chart 2: Inventory
        const invEl = document.getElementById('inventoryChart');
        if (invEl) {
            const inventoryCtx = invEl.getContext('2d');
            const inventoryData = <?= json_encode($inventoryChart ?? ['labels' => [], 'data' => [], 'colors' => []]) ?>;
            new Chart(inventoryCtx, {
                type: 'doughnut',
                data: {
                    labels: inventoryData.labels,
                    datasets: [{
                        data: inventoryData.data,
                        backgroundColor: inventoryData.colors,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'right', labels: { color: textColor } }
                    },
                    cutout: '75%'
                }
            });
        }
    });
</script>