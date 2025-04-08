<?php //ob_start()?>
<div class="max-w-2xl p-6 mx-auto mt-8 bg-white rounded-lg shadow dark:bg-gray-800">
    <h1 class="mb-6 text-3xl font-bold text-gray-900 dark:text-white">Modifier le Fournisseur</h1>
    
    <form action="<?= PUBLIC_URL ?>supplier/update/<?= $supplier->id ?>" method="POST">
        <div class="mb-4">
            <label class="block mb-2 text-gray-700 dark:text-gray-300">Nom</label>
            <input type="text" name="name" value="<?= htmlspecialchars($supplier->name) ?>" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
        </div>
        

        <div class="mb-4">
            <label class="block mb-2 text-gray-700 dark:text-gray-300">Telephoe</label>
            <input type="text" name="phone" id="phone" value="<?= htmlspecialchars($supplier->phone) ?>" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
        </div>
        
        <button type="submit" class="px-4 py-2 text-white bg-teal-500 rounded hover:bg-teal-600 dark:bg-teal-600 dark:hover:bg-teal-700">
            Mettre à jour
        </button>
    </form>
</div>
<?php //$content = ob_get_clean(); ?>
<?php //include __DIR__ . '/../layouts/app.php'; ?>