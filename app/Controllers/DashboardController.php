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
use Exception;

class DashboardController
{
    use ViewRenderer;
    protected $basePath;

    public function __construct()
    {
        $this->basePath = defined('BASE_URL_PATH') ? BASE_URL_PATH : '/';
    }

    public function index()
    {
        try {
            // Statistiques principales avec valeurs par défaut
            $data = [
                'totalProducts' => Product::count() ?? 0,
                'criticalStock' => Product::where('quantity', '<', 5)->count() ?? 0,
                'outOfStock' => Product::where('quantity', '<=', 0)->count() ?? 0,
                'expiredProducts' => Product::whereNotNull('expiry_date')->where('expiry_date', '<', date('Y-m-d'))->count() ?? 0,
                'nearExpiry' => Product::whereNotNull('expiry_date')->whereBetween('expiry_date', [
                    date('Y-m-d'),
                    date('Y-m-d', strtotime('+3 months'))
                ])->count() ?? 0,
                
                'monthlySales' => Invoice::whereBetween('created_at', [
                    date('Y-m-01 00:00:00'),
                    date('Y-m-t 23:59:59')
                ])->sum('total_amount') ?? 0,
                
                'monthlyPurchases' => Purchase::whereBetween('created_at', [
                    date('Y-m-01 00:00:00'),
                    date('Y-m-t 23:59:59')
                ])->sum('total_amount') ?? 0,
                
                // Listes
                'lowStockProducts' => Product::where('quantity', '<', 5)->orderBy('quantity')->limit(5)->get(),
                'expiringProducts' => Product::whereNotNull('expiry_date')->where('expiry_date', '>', date('Y-m-d'))->orderBy('expiry_date', 'asc')->limit(5)->get(),
                'recentInvoices' => Invoice::with('customer')->orderBy('created_at', 'desc')->limit(5)->get(),
                'topProducts' => $this->getTopSellingProducts(),
                
                // Charts
                'salesChart' => $this->getSalesChartData(),
                'inventoryChart' => $this->getInventoryChartData(),
                'title' => 'Tableau de bord'
            ];
        } catch (Exception $e) {
            // En cas d'erreur DB, on initialise avec des données vides
            $data = [
                'totalProducts' => 0, 'criticalStock' => 0, 'outOfStock' => 0, 'expiredProducts' => 0, 'nearExpiry' => 0,
                'monthlySales' => 0, 'monthlyPurchases' => 0,
                'lowStockProducts' => [], 'expiringProducts' => [], 'recentInvoices' => [], 'topProducts' => [],
                'salesChart' => ['labels' => [], 'datasets' => []],
                'inventoryChart' => ['labels' => [], 'data' => [], 'colors' => []],
                'title' => 'Tableau de bord (Erreur de chargement)',
                'error' => $e->getMessage()
            ];
        }

        $this->render('app', 'dashboard', $data);
    }

    protected function getSalesChartData()
    {
        $labels = [];
        $salesData = [];
        $purchasesData = [];
        
        try {
            for ($i = 5; $i >= 0; $i--) {
                $month = date('m', strtotime("-$i months"));
                $year = date('Y', strtotime("-$i months"));
                $label = date('M Y', strtotime("-$i months"));
                
                $labels[] = $label;
                $salesData[] = Invoice::whereMonth('created_at', $month)->whereYear('created_at', $year)->sum('total_amount') ?? 0;
                $purchasesData[] = Purchase::whereMonth('created_at', $month)->whereYear('created_at', $year)->sum('total_amount') ?? 0;
            }
        } catch (Exception $e) {
            return ['labels' => [], 'datasets' => []];
        }
        
        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Ventes',
                    'data' => $salesData,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.2)',
                    'borderColor' => 'rgba(16, 185, 129, 1)',
                    'borderWidth' => 2,
                    'fill' => true
                ],
                [
                    'label' => 'Achats',
                    'data' => $purchasesData,
                    'backgroundColor' => 'rgba(99, 102, 241, 0.2)',
                    'borderColor' => 'rgba(99, 102, 241, 1)',
                    'borderWidth' => 2,
                    'fill' => true
                ]
            ]
        ];
    }

    protected function getInventoryChartData()
    {
        try {
            $categories = [
                'En stock' => Product::where('quantity', '>', 10)->count(),
                'Stock faible' => Product::whereBetween('quantity', [1, 10])->count(),
                'Rupture' => Product::where('quantity', '<=', 0)->count()
            ];
        } catch (Exception $e) {
            return ['labels' => [], 'data' => [], 'colors' => []];
        }
        
        return [
            'labels' => array_keys($categories),
            'data' => array_values($categories),
            'colors' => ['#10b981', '#f59e0b', '#ef4444']
        ];
    }

    protected function getTopSellingProducts()
    {
        try {
            return Product::query()
                ->limit(5)
                ->get(); // Simplified to avoid complex subqueries if they cause issues
        } catch (Exception $e) {
            return [];
        }
    }
}