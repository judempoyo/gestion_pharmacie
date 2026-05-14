<?php 
namespace App\Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\PurchaseLine;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use Carbon\Carbon;

class DatabaseSeeder
{
    // Taux de conversion approximatif (à ajuster selon le cours actuel)
    private const EUR_TO_CDF = 2500;

    public function run()
    {
        // 1. Fournisseurs
        $suppliers = [
            ['name' => 'Laboratoire PharmaPlus', 'phone' => '+243812345678'],
            ['name' => 'PharmaCentrale Kinshasa', 'phone' => '+243823456789'],
            ['name' => 'SantéDistribution Lubumbashi', 'phone' => '+243834567890'],
            ['name' => 'MediGrossiste Goma', 'phone' => '+243845678901'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::firstOrCreate($supplier);
        }

        // 2. Clients
        $customers = [
            ['name' => 'Clinique Ngaliema', 'phone' => '+243897654321'],
            ['name' => 'Cabinet Dr. Mukwege', 'phone' => '+243807654321'],
            ['name' => 'Pharmacie Bon Marché', 'phone' => '+243817654321'],
            ['name' => 'Hôpital Général de Kinshasa', 'phone' => '+243827654321'],
        ];

        foreach ($customers as $customer) {
            Customer::firstOrCreate($customer);
        }

        // 3. Produits pharmaceutiques (prix en CDF)
        $products = [
            // Antibiotiques
            ['designation' => 'Amoxicilline 500mg - Boite de 12', 'quantity' => 0, 'unit_price' => 20000 * self::EUR_TO_CDF / 2500],
            ['designation' => 'Ciprofloxacine 500mg - Boite de 10', 'quantity' => 0, 'unit_price' => 30000 * self::EUR_TO_CDF / 2500],
            // Antalgiques
            ['designation' => 'Paracétamol 500mg - Boite de 16', 'quantity' => 0, 'unit_price' => 5000 * self::EUR_TO_CDF / 2500],
            ['designation' => 'Ibuprofène 200mg - Boite de 20', 'quantity' => 0, 'unit_price' => 8000 * self::EUR_TO_CDF / 2500],
            // Anti-inflammatoires
            ['designation' => 'Diclofénac 50mg - Boite de 30', 'quantity' => 0, 'unit_price' => 15000 * self::EUR_TO_CDF / 2500],
            // Vitamines
            ['designation' => 'Vitamine C 500mg - Boite de 20 comprimés', 'quantity' => 0, 'unit_price' => 12000 * self::EUR_TO_CDF / 2500],
            ['designation' => 'Vitamine D3 1000UI - Flacon 30ml', 'quantity' => 0, 'unit_price' => 25000 * self::EUR_TO_CDF / 2500],
            // Dermatologie
            ['designation' => 'Crème hydratante Dexeryl - Tube 250g', 'quantity' => 0, 'unit_price' => 18000 * self::EUR_TO_CDF / 2500],
            ['designation' => 'Bétadine 10% - Solution 125ml', 'quantity' => 0, 'unit_price' => 10000 * self::EUR_TO_CDF / 2500],
            // Hygiène
            ['designation' => 'Masque chirurgical - Boite de 50', 'quantity' => 0, 'unit_price' => 25000 * self::EUR_TO_CDF / 2500],
            ['designation' => 'Gel hydroalcoolique 500ml', 'quantity' => 0, 'unit_price' => 15000 * self::EUR_TO_CDF / 2500],
            // Premiers soins
            ['designation' => 'Pansement stérile 10x10cm - Boite de 10', 'quantity' => 0, 'unit_price' => 8000 * self::EUR_TO_CDF / 2500],
            ['designation' => 'Compresse stérile 5x5cm - Paquet de 20', 'quantity' => 0, 'unit_price' => 5000 * self::EUR_TO_CDF / 2500],
            // Maternité
            ['designation' => 'Tétine physiologique - Lot de 2', 'quantity' => 0, 'unit_price' => 10000 * self::EUR_TO_CDF / 2500],
            ['designation' => 'Lait 1er âge 400g', 'quantity' => 0, 'unit_price' => 35000 * self::EUR_TO_CDF / 2500],
        ];

        $createdProducts = [];
        foreach ($products as $product) {
            $createdProducts[] = Product::firstOrCreate($product);
        }

        // 4. Commandes fournisseurs (Purchases) - Sur 6 mois
        $this->createPurchases($createdProducts);

        // 5. Factures clients (Invoices) - Sur 6 mois
        $this->createInvoices($createdProducts);
    }

    private function createPurchases($products)
    {
        $suppliers = Supplier::all();
        
        // Fonction pour générer des achats aléatoires
        $generatePurchase = function($date, $supplierIndex, $products, $maxLines = 5) {
            $supplier = Supplier::skip($supplierIndex % count(Supplier::all()))->first();
            $purchase = Purchase::create([
                'supplier_id' => $supplier->id,
                'total_amount' => 0,
                'created_at' => $date
            ]);

            $lines = [];
            $nbLines = rand(2, $maxLines);
            $total = 0;
            
            for ($i = 0; $i < $nbLines; $i++) {
                $product = $products[array_rand($products)];
                $quantity = rand(5, 50);
                $unitPrice = $product->unit_price * (1 - rand(5, 15)/100); // Remise fournisseur
                
                $line = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice
                ];
                
                PurchaseLine::create(array_merge($line, ['purchase_id' => $purchase->id]));
                $total += $quantity * $unitPrice;
                
                // Mise à jour du stock
                $product->quantity += $quantity;
                $product->save();
            }
            
            $purchase->update(['total_amount' => $total]);
        };

        // Générer 2-3 achats par mois sur les 6 derniers mois
        $months = 6;
        for ($m = 0; $m < $months; $m++) {
            $purchasesThisMonth = rand(2, 3);
            for ($p = 0; $p < $purchasesThisMonth; $p++) {
                $date = Carbon::now()->subMonths($months - $m - 1)->addDays(rand(0, 30));
                $generatePurchase($date, $m + $p, $products);
            }
        }
    }

    private function createInvoices($products)
    {
        $customers = Customer::all();
        
        // Fonction pour générer des ventes aléatoires
        $generateInvoice = function($date, $customerIndex, $products, $maxLines = 4) {
            $customer = Customer::skip($customerIndex % count(Customer::all()))->first();
            $invoice = Invoice::create([
                'customer_id' => $customer->id,
                'total_amount' => 0,
                'created_at' => $date
            ]);

            $lines = [];
            $nbLines = rand(1, $maxLines);
            $total = 0;
            
            for ($i = 0; $i < $nbLines; $i++) {
                $product = $products[array_rand($products)];
                $maxQuantity = min($product->quantity, 20); // Ne pas vendre plus que le stock
                if ($maxQuantity <= 0) continue;
                
                $quantity = rand(1, $maxQuantity);
                $unitPrice = $product->unit_price;
                
                $line = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice
                ];
                
                InvoiceLine::create(array_merge($line, ['invoice_id' => $invoice->id]));
                $total += $quantity * $unitPrice;
                
                // Mise à jour du stock
                $product->quantity -= $quantity;
                $product->save();
            }
            
            if ($total > 0) {
                $invoice->update(['total_amount' => $total]);
            } else {
                $invoice->delete(); // Supprime les factures vides
            }
        };

        // Générer 8-12 ventes par mois sur les 6 derniers mois
        $months = 6;
        for ($m = 0; $m < $months; $m++) {
            $invoicesThisMonth = rand(8, 12);
            for ($i = 0; $i < $invoicesThisMonth; $i++) {
                $date = Carbon::now()->subMonths($months - $m - 1)->addDays(rand(0, 30));
                $generateInvoice($date, $m + $i, $products);
            }
        }
    }
}