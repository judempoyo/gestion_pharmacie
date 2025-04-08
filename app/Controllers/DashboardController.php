<?php
namespace App\Controllers;

use App\Models\Product;
use App\Models\Invoice;
use App\Models\Purchase;
use App\Services\SessionManager;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\User;
use App\Core\ViewRenderer;

class DashboardController
{
    use ViewRenderer;
    protected $session;

    protected $basePath;

    public function __construct()
    {
        $this->session = new SessionManager();
        $this->session->start();
        $this->basePath = '/Projets/gestion_pharmacie/public';
    }

    public function index()
    {
        // Récupérer l'utilisateur connecté (à adapter selon votre système d'authentification)
        if ($this->session->has('user')) {
            $user = User::find($this->session->get('user'));
        }
            
        // Statistiques principales
        $data = [
            'user' => $user,
            'totalProducts' => Product::count(),
            'criticalStock' => Product::where('quantity', '<', 5)->count(),
            'monthlySales' => Invoice::whereMonth('created_at', date('m'))->sum('total_amount'),
            'pendingOrders' => Purchase::count(),
            
            // Produits en rupture de stock
            'lowStockProducts' => Product::where('quantity', '<', 5)
                ->orderBy('quantity')
                ->limit(5)
                ->get(),
                
            // Dernières ventes
            'recentInvoices' => Invoice::with('customer')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
                
            // Données pour le graphique des ventes
            'salesChart' => $this->getSalesChartData()
        ];

        $this->render('app', 'dashboard', $data);
    }

    protected function getSalesChartData()
    {
        // Générer des données pour les 6 derniers mois
        $labels = [];
        $data = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = date('m', strtotime("-$i months"));
            $year = date('Y', strtotime("-$i months"));
            
            $labels[] = date('M Y', strtotime("-$i months"));
            $data[] = Invoice::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->sum('total_amount');
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
}