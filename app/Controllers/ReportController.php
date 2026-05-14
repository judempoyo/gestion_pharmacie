<?php
namespace App\Controllers;

use App\Core\ViewRenderer;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Purchase;
use Carbon\Carbon;

class ReportController
{
    use ViewRenderer;

    public function index()
    {
        $startDate = $_GET['start_date'] ?? Carbon::now()->startOfMonth()->toDateString();
        $endDate = $_GET['end_date'] ?? Carbon::now()->endOfMonth()->toDateString();

        $salesSummary = Invoice::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->selectRaw('COUNT(*) as count, SUM(total_amount) as total')
            ->first();

        $purchasesSummary = Purchase::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->selectRaw('COUNT(*) as count, SUM(total_amount) as total')
            ->first();

        $stockSummary = [
            'total_value' => Product::selectRaw('SUM(quantity * unit_price) as total')->value('total'),
            'total_items' => Product::sum('quantity'),
            'out_of_stock' => Product::where('quantity', '<=', 0)->count(),
            'expired' => Product::whereNotNull('expiry_date')->where('expiry_date', '<', Carbon::now()->toDateString())->count(),
            'expiring_soon' => Product::whereNotNull('expiry_date')->whereBetween('expiry_date', [
                Carbon::now()->toDateString(),
                Carbon::now()->addMonths(3)->toDateString()
            ])->count(),
        ];

        $topProducts = Product::query()
            ->select('products.id', 'products.designation', 'products.unit_price')
            ->selectSub(function($query) use ($startDate, $endDate) {
                $query->from('invoice_lines')
                    ->join('invoices', 'invoice_lines.invoice_id', '=', 'invoices.id')
                    ->whereColumn('invoice_lines.product_id', 'products.id')
                    ->whereBetween('invoices.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                    ->selectRaw('SUM(invoice_lines.quantity)');
            }, 'total_sold')
            ->selectSub(function($query) use ($startDate, $endDate) {
                $query->from('invoice_lines')
                    ->join('invoices', 'invoice_lines.invoice_id', '=', 'invoices.id')
                    ->whereColumn('invoice_lines.product_id', 'products.id')
                    ->whereBetween('invoices.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                    ->selectRaw('SUM(invoice_lines.quantity * invoice_lines.unit_price)');
            }, 'total_revenue')
            ->orderBy('total_revenue', 'desc')
            ->limit(10)
            ->get();

        $dailySales = Invoice::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $this->render('app', 'reports/index', [
            'title' => 'Rapports détaillés',
            'startDate' => $startDate,
            'endDate' => $endDate,
            'salesSummary' => $salesSummary,
            'purchasesSummary' => $purchasesSummary,
            'stockSummary' => $stockSummary,
            'dailySales' => $dailySales,
            'topProducts' => $topProducts
        ]);
    }

    public function exportCsv()
    {
        $startDate = $_GET['start_date'] ?? Carbon::now()->startOfMonth()->toDateString();
        $endDate = $_GET['end_date'] ?? Carbon::now()->endOfMonth()->toDateString();

        $invoices = Invoice::with('customer')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->get();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="rapport_ventes_' . $startDate . '_au_' . $endDate . '.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID Facture', 'Client', 'Montant Total', 'Date']);

        foreach ($invoices as $invoice) {
            fputcsv($output, [
                $invoice->id,
                $invoice->customer->name,
                $invoice->total_amount,
                $invoice->created_at->format('d/m/Y H:i')
            ]);
        }

        fclose($output);
        exit();
    }
}
