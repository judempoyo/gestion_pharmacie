<?php
// Extraire les variables du tableau $tableParams
extract($tableParams);

// Paramètres par défaut
$title = $title ?? 'Liste des éléments';
$createUrl = $createUrl ?? '#';
$columns = $columns ?? [];
$data = $data ?? NULL;
$actions = $actions ?? [];
$filters = $filters ?? [];
$modelName = $modelName ?? 'default';
?>

<div
    class="max-w-full p-6 mx-auto mt-8 bg-white rounded-lg shadow-lg dark:bg-gray-800 animate__animated animate__fadeIn">
    <!-- Titre et bouton d'ajout -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white animate__animated animate__fadeInLeft"><?= $title ?>
        </h1>
        <a href="<?= $createUrl ?>"
            class="px-4 py-2 text-white transition duration-500 ease-in-out transform bg-teal-500 rounded hover:bg-teal-600 dark:bg-teal-600 dark:hover:bg-teal-700 hover:scale-105 animate__animated animate__fadeInRight">
            Ajouter
        </a>
    </div>

    <!-- Filtres (optionnels) -->
    <?php if (!empty($filters)): ?>
        <div class="mb-6 animate__animated animate__fadeInUp">
            <!-- Bouton pour afficher/masquer les filtres -->
            <button onclick="toggleFilters()"
                class="px-4 py-2 text-white transition duration-500 ease-in-out transform bg-teal-500 rounded-lg hover:bg-teal-600 dark:bg-teal-600 dark:hover:bg-teal-700 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                </svg>

            </button>

            <!-- Conteneur des filtres (masqué initialement) -->
            <div id="filtersContainer" class="hidden mt-4">
                <div class="flex flex-wrap gap-4">
                    <?php foreach ($filters as $filter): ?>
                        <div class="flex-1 min-w-[200px]">
                            <input type="text" placeholder="<?= $filter['placeholder'] ?? 'Filtrer...' ?>"
                                class="w-full px-4 py-2 transition duration-300 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400" />
                        </div>
                    <?php endforeach; ?>
                    <button
                        class="px-6 py-2 text-white transition duration-500 ease-in-out transform bg-teal-500 rounded-lg hover:bg-teal-600 dark:bg-teal-600 dark:hover:bg-teal-700 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                        Appliquer
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Tableau -->
    <div class="mt-6 animate__animated animate__fadeInUp">
        <a href="<?= PUBLIC_URL . $modelName ?>/export"
            class="px-4 py-2 text-white transition duration-500 ease-in-out transform bg-teal-500 rounded hover:bg-teal-600 dark:bg-teal-600 dark:hover:bg-teal-700 hover:scale-105">
            Exporter en CSV
        </a>
    </div>
    <div class="overflow-x-auto animate__animated animate__fadeInUp">
        <table class="w-full min-w-full bg-white rounded-lg shadow-lg dark:bg-gray-700">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-800">
                    <?php foreach ($columns as $column): ?>
                        <th
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase transition duration-300 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                            <a
                                href="?sort=<?= $column['key'] ?>&direction=<?= $sort === $column['key'] && $direction === 'asc' ? 'desc' : 'asc' ?>">
                                <?= $column['label'] ?>
                                <?php if ($sort === $column['key']): ?>
                                    <span class="ml-1">
                                        <?= $direction === 'asc' ? '▲' : '▼' ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                        </th>
                    <?php endforeach; ?>
                    <?php if (!empty($actions)): ?>
                        <th
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                            Actions
                        </th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                <?php if ($data && $data->count() > 0): ?>
                    <?php foreach ($data as $item): ?>
                        <tr
                            class="z-10 transition duration-500 hover:bg-gray-50 dark:hover:bg-gray-800 animate__animated animate__fadeIn">
                            <?php foreach ($columns as $column): ?>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                    <?= $item[$column['key']] ?>
                                </td>
                            <?php endforeach; ?>

                            <?php if (!empty($actions)): ?>
                                <td class="px-6 py-4 text-sm">
                                    <!-- Dropdown pour les actions -->
                                    <div class="relative inline-block text-left">
                                        <!-- Bouton d'actions -->
                                        <button onclick="toggleDropdown(event, 'actions-<?= $item['id'] ?>')"
                                            class="flex items-center justify-center w-8 h-8 transition duration-500 rounded-full hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-teal-500">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                                </path>
                                            </svg>
                                        </button>

                                        <!-- Menu déroulant -->
                                        <div id="actions-<?= $item['id'] ?>"
                                            class="absolute right-0 z-50 hidden w-48 mt-2 bg-white rounded-lg shadow-lg dark:bg-gray-700 ring-1 ring-black ring-opacity-5 animate__animated animate__fadeIn ">
                                            <div class="py-1">
                                                <?php foreach ($actions as $action): ?>
                                                    <?php if (isset($action['type']) && $action['type'] === 'delete'): ?>
                                                        <!-- Bouton pour ouvrir le modal de suppression -->
                                                        <button onclick="openModal('deleteModal-<?= $item['id'] ?>')"
                                                            class="block w-full px-4 py-2 text-sm text-left text-red-600 transition duration-300 hover:bg-gray-100 dark:text-red-500 dark:hover:bg-gray-600">
                                                            <?= $action['label'] ?>
                                                        </button>
                                                    <?php else: ?>
                                                        <a href="<?= $action['url']($item) ?>"
                                                            class="block px-4 py-2 text-sm text-left text-gray-700 transition duration-300 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600">
                                                            <?= $action['label'] ?>
                                                        </a>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>

                        <!-- Modal de suppression pour chaque élément -->
                        <?php
                        $modalParams = [
                            'modalId' => 'deleteModal-' . $item['id'],
                            'title' => 'Confirmer la suppression',
                            'message' => 'Êtes-vous sûr de vouloir supprimer cet élément ?',
                            'formAction' => $actions[1]['url']($item), // URL de suppression
                            'submitText' => 'Supprimer',
                            'cancelText' => 'Annuler',
                            'includePasswordField' => false,
                        ];
                        include __DIR__ . '/modal.php'; // Inclure le modal réutilisable
                        ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan=" <?= count($columns) + empty($actions) ? 0 : 1 ?> "
                            class="w-full px-6 py-4 text-center text-gray-500 dark:text-gray-400 animate__animated animate__fadeIn">
                            Aucun élément à afficher.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Pagination -->

   <!-- Pagination -->
<div class="flex items-center justify-between mt-6 animate__animated animate__fadeInUp">
    <!-- Texte indiquant la plage d'éléments -->
    <div class="text-sm text-gray-700 dark:text-gray-300">
        Affichage de <?= $data->firstItem() ?> à <?= $data->lastItem() ?> sur <?= $data->total() ?> éléments
    </div>

    <!-- Boutons de pagination -->
    <div class="flex">
        <!-- Bouton Précédent -->
        <?php if ($data->onFirstPage()): ?>
            <div
                class="flex items-center justify-center h-10 px-4 text-base font-medium text-gray-400 bg-gray-100 border border-gray-300 rounded-lg cursor-not-allowed me-3 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-500">
                <svg class="w-3.5 h-3.5 me-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4"/>
                </svg>
                Precedent
            </div>
        <?php else: ?>
            <a href="<?= $data->previousPageUrl() ?>"
                class="flex items-center justify-center h-10 px-4 text-base font-medium text-gray-500 bg-white border border-gray-300 rounded-lg me-3 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                <svg class="w-3.5 h-3.5 me-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4"/>
                </svg>
                Precedent
            </a>
        <?php endif; ?>

        <!-- Bouton Suivant -->
        <?php if ($data->hasMorePages()): ?>
            <a href="<?= $data->nextPageUrl() ?>"
                class="flex items-center justify-center h-10 px-4 text-base font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                Suivant
                <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
            </a>
        <?php else: ?>
            <div
                class="flex items-center justify-center h-10 px-4 text-base font-medium text-gray-400 bg-gray-100 border border-gray-300 rounded-lg cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-500">
                Suivant
                <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- Script pour gérer les dropdowns -->
<script>
    function toggleDropdown(event, dropdownId) {
        event.stopPropagation(); // Empêche la propagation de l'événement
        const dropdown = document.getElementById(dropdownId);
        if (dropdown) {
            dropdown.classList.toggle('hidden');
        } else {
            console.error(`Dropdown with ID ${dropdownId} not found.`);
        }
    }

    // Fermer les dropdowns lorsqu'on clique ailleurs
    document.addEventListener('click', function () {
        const dropdowns = document.querySelectorAll('.relative.inline-block.text-left > div');
        dropdowns.forEach(dropdown => {
            dropdown.classList.add('hidden');
        });
    });

    function toggleFilters() {
        const filtersContainer = document.getElementById('filtersContainer');
        if (filtersContainer) {
            filtersContainer.classList.toggle('hidden');
        }
    }
</script>