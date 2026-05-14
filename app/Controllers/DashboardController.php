<?php
namespace App\Controllers;

use App\Core\ViewRenderer;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;

class DashboardController
{
    use ViewRenderer;
    protected $basePath;

    public function __construct()
    {
        $this->basePath = BASE_URL_PATH;
    }

    public function index()
    {
        // Statistiques principales
        $data = [
            'totalProducts' => Product::count(),
            'criticalStock' => Product::where('quantity', '<', 5)->count(),
            'outOfStock' => Product::where('quantity', '<=', 0)->count(),
            'expiredProducts' => Product::where('expiry_date', '<', Carbon::now()->toDateString())->count(),
            'nearExpiry' => Product::whereBetween('expiry_date', [
                Carbon::now()->toDateString(),
                Carbon::now()->addMonths(3)->toDateString()
            ])->count(),
            
            'monthlySales' => Invoice::whereBetween('created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])->sum('total_amount'),
            'monthlyPurchases' => Purchase::whereBetween('created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])->sum('total_amount'),
            
            // Produits en rupture de stock
            'lowStockProducts' => Product::where('quantity', '<', 5)
                ->orderBy('quantity')
                ->limit(10)
                ->get(),

            // Produits proches de la péremption
            'expiringProducts' => Product::whereNotNull('expiry_date')
                ->where('expiry_date', '<', Carbon::now()->addMonths(6)->toDateString())
                ->orderBy('expiry_date', 'asc')
                ->limit(5)
                ->get(),
                
            // Dernières ventes
            'recentInvoices' => Invoice::with('customer')
                ->orderBy('created_at', 'desc')
                ->limit(8)
                ->get(),
                
            // Derniers achats
            'recentPurchases' => Purchase::with('supplier')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
                
            // Meilleurs produits
            'topProducts' => $this->getTopSellingProducts(),
                
            // Données pour les graphiques
            'salesChart' => $this->getSalesChartData(),
            'inventoryChart' => $this->getInventoryChartData(),
            'title' => 'Tableau de bord'
        ];

        $this->render('app', 'dashboard', $data);

    
    }

    protected function getSalesChartData()
    {
        $labels = [];
        $salesData = [];
        $purchasesData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $month = $date->format('m');
            $year = $date->format('Y');
            
            $labels[] = $date->format('M Y');
            $salesData[] = Invoice::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->sum('total_amount');
                
            $purchasesData[] = Purchase::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->sum('total_amount');
        }
        
        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Ventes',
                    'data' => $salesData,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.7)',
                    'borderColor' => 'rgba(16, 185, 129, 1)',
                ],
                [
                    'label' => 'Achats',
                    'data' => $purchasesData,
                    'backgroundColor' => 'rgba(99, 102, 241, 0.7)',
                    'borderColor' => 'rgba(99, 102, 241, 1)',
                ]
            ]
        ];
    }

    protected function getInventoryChartData()
    {
        $categories = [
            'En stock' => Product::where('quantity', '>', 10)->count(),
            'Stock faible' => Product::whereBetween('quantity', [1, 10])->count(),
            'Rupture' => Product::where('quantity', '<=', 0)->count()
        ];
        
        return [
            'labels' => array_keys($categories),
            'data' => array_values($categories),
            'colors' => [
                'rgba(16, 185, 129, 0.7)',
                'rgba(234, 179, 8, 0.7)',
                'rgba(239, 68, 68, 0.7)'
            ]
        ];
    }

    protected function getTopSellingProducts()
{
    return Product::query()
        ->select('products.*')
        ->selectSub(function($query) {
            $query->from('invoice_lines')
                ->whereColumn('invoice_lines.product_id', 'products.id')
                ->selectRaw('SUM(quantity)');
        }, 'sales_count')
        ->orderBy('sales_count', 'desc')
        ->limit(5)
        ->get();
}
}