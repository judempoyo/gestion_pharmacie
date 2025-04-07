<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 max-w-2xl mx-auto mt-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">Supprimer la Réservation</h1>
    
    <p class="text-gray-700 dark:text-gray-300 mb-4">Êtes-vous sûr de vouloir supprimer la réservation de <?= $booking->customer_name ?> ?</p>
    
    <form action="<?= PUBLIC_URL ?>booking/delete/<?= $booking->id ?>" method="POST">
        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700">
            Supprimer
        </button>
        <a href="<?= PUBLIC_URL ?>booking" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 dark:bg-gray-600 dark:text-white dark:hover:bg-gray-700 ml-4">
            Annuler
        </a>
    </form>
</div>