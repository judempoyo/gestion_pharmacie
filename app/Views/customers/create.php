<?php //ob_start() ?>
<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 max-w-2xl mx-auto mt-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">Ajouter un Client</h1>
    
    <form action="<?= PUBLIC_URL ?>customer/store" method="POST">
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 mb-2">Nom</label>
            <input type="text" name="name" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 mb-2">Telephone</label>
            <input type="text" name="phone" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
        </div>
        
        <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600 dark:bg-teal-600 dark:hover:bg-teal-700">
            Enregistrer
        </button>
    </form>
</div>
<?php //$content = ob_get_clean(); ?>
<?php //include __DIR__ . '/../layouts/app.php'; ?>