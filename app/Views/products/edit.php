<div class="max-w-2xl p-6 mx-auto mt-8 bg-white rounded-lg shadow dark:bg-gray-800">
    <h1 class="mb-6 text-3xl font-bold text-gray-900 dark:text-white">Modifier le Produit</h1>
    
    <form action="<?= url('/product/update/' . $product->id) ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-4">
            <label class="block mb-2 text-gray-700 dark:text-gray-300 font-medium">Désignation</label>
            <input type="text" name="designation" value="<?= htmlspecialchars($product->designation) ?>" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-teal-500 outline-none" required>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
                <label class="block mb-2 text-gray-700 dark:text-gray-300 font-medium">Quantité</label>
                <input type="number" name="quantity" min="0" value="<?= htmlspecialchars($product->quantity) ?>" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-teal-500 outline-none" required>
            </div>
            <div class="mb-4">
                <label class="block mb-2 text-gray-700 dark:text-gray-300 font-medium">Prix unitaire</label>
                <input type="number" step="0.01" name="unit_price" min="0" value="<?= htmlspecialchars($product->unit_price) ?>" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-teal-500 outline-none" required>
            </div>
        </div>
        <div class="mb-6">
            <label class="block mb-2 text-gray-700 dark:text-gray-300 font-medium">Date de péremption</label>
            <input type="date" name="expiry_date" value="<?= $product->expiry_date ?>" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-teal-500 outline-none">
        </div>
        
        <div class="flex items-center justify-end space-x-3">
            <a href="<?= url('/product') ?>" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">Annuler</a>
            <button type="submit" class="px-6 py-2 text-white bg-teal-600 rounded-lg hover:bg-teal-700 transition-colors shadow-lg">
                Mettre à jour
            </button>
        </div>
    </form>
</div>