<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 max-w-2xl mx-auto mt-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">Ajouter une Réservation</h1>
    
    <form action="<?= PUBLIC_URL ?>booking/store" method="POST">
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 mb-2">Nom du client</label>
            <input type="text" name="customer_name" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 mb-2">Téléphone du client</ <label class="block text-gray-700 dark:text-gray-300 mb-2">Téléphone du client</label>
            <input type="text" name="customer_phone" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 mb-2">Type de session</label>
            <input type="text" name="session_type" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 mb-2">Heure de début</label>
            <input type="datetime-local" name="start_time" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 mb-2">Heure de fin</label>
            <input type="datetime-local" name="end_time" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
        </div>
        
        <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600 dark:bg-teal-600 dark:hover:bg-teal-700">
            Enregistrer
        </button>
    </form>
</div>