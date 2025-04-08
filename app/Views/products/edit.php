<div class="max-w-2xl p-6 mx-auto mt-8 bg-white rounded-lg shadow dark:bg-gray-800">
    <h1 class="mb-6 text-3xl font-bold text-gray-900 dark:text-white">Modifier le Produit</h1>
    
    <form action="<?= PUBLIC_URL ?>product/update/<?= $product->id ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-4">
            <label class="block mb-2 text-gray-700 dark:text-gray-300">Désignation</label>
            <input type="text" name="designation" value="<?= htmlspecialchars($product->designation) ?>" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
        </div>
        <div class="mb-4">
            <label class="block mb-2 text-gray-700 dark:text-gray-300">Quantité</label>
            <input type="number" name="quantity" value="<?= htmlspecialchars($product->quantity) ?>" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
        </div>
        <div class="mb-4">
            <label class="block mb-2 text-gray-700 dark:text-gray-300">Prix unitaire</label>
            <input type="number" step="0.01" name="unit_price" value="<?= htmlspecialchars($product->unit_price) ?>" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
        </div>
        <div class="mb-4">
            <label class="block mb-2 text-gray-700 dark:text-gray-300">Image actuelle</label>
            <?php if ($product->image_url): ?>
                <img src="<?= PUBLIC_URL  . $product->image_url ?>" alt="Image produit" class="object-cover w-32 h-32 mb-2">
            <?php else: ?>
                <p class="text-gray-500 dark:text-gray-400">Aucune image</p>
            <?php endif; ?>
            <label class="block mb-2 text-gray-700 dark:text-gray-300">Nouvelle image</label>
            <input type="file" name="image" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>
        
        <button type="submit" class="px-4 py-2 text-white bg-teal-500 rounded hover:bg-teal-600 dark:bg-teal-600 dark:hover:bg-teal-700">
            Mettre à jour
        </button>
    </form>
</div>