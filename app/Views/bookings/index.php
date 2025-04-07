<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 max-w-4xl mx-auto mt-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">Liste des Réservations</h1>
    
    <a href="<?= PUBLIC_URL ?>booking/create" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600 dark:bg-teal-600 dark:hover:bg-teal-700 mb-4 inline-block">
        Ajouter une réservation
    </a>

    <div class="overflow-x-auto">
        <table class="min-w-full w-full bg-white dark:bg-gray-700">
            <thead>
                <tr>
                    <th class="px-6 py-3 border-b-2 border-gray-300 dark:border-gray-600 text-left text-sm font-semibold text-gray-700 dark:text-white">ID</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 dark:border-gray-600 text-left text-sm font-semibold text-gray-700 dark:text-white">Nom du client</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 dark:border-gray-600 text-left text-sm font-semibold text-gray-700 dark:text-white">Type de session</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 dark:border-gray-600 text-left text-sm font-semibold text-gray-700 dark:text-white">Heure de début</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 dark:border-gray-600 text-left text-sm font-semibold text-gray-700 dark:text-white">Heure de fin</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 dark:border-gray-600 text-left text-sm font-semibold text-gray-700 dark:text-white">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                <tr class="hover:bg-gray-100 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 border-b border-gray-300 dark:border-gray-600 text-sm text-gray-900 dark:text-white"><?= $booking->id ?></td>
                    <td class="px-6 py-4 border-b border-gray-300 dark:border-gray-600 text-sm text-gray-900 dark:text-white"><?= $booking->customer_name ?></td>
                    <td class="px-6 py-4 border-b border-gray-300 dark:border-gray-600 text-sm text-gray-900 dark:text-white"><?= $booking->session_type ?></td>
                    <td class="px-6 py-4 border-b border-gray-300 dark:border-gray-600 text-sm text-gray-900 dark:text-white"><?= $booking->start_time ?></td>
                    <td class="px-6 py-4 border-b border-gray-300 dark:border-gray-600 text-sm text-gray-900 dark:text-white"><?= $booking->end_time ?></td>
                    <td class="px-6 py-4 border-b border-gray-300 dark:border-gray-600 text-sm">
                        <a href="<?= PUBLIC_URL ?>booking/edit/<?= $booking->id ?>" class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">Modifier</a>
                        <a href="<?= PUBLIC_URL ?>booking/delete/<?= $booking->id ?>" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 ml-4">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>