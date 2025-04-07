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
    class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 max-w-full mx-auto mt-8 animate__animated animate__fadeIn">
    <!-- Titre et bouton d'ajout -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white animate__animated animate__fadeInLeft"><?= $title ?>
        </h1>
        <a href="<?= $createUrl ?>"
            class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600 dark:bg-teal-600 dark:hover:bg-teal-700 transition duration-500 ease-in-out transform hover:scale-105 animate__animated animate__fadeInRight">
            Ajouter
        </a>
    </div>

    <!-- Filtres (optionnels) -->
    <?php if (!empty($filters)): ?>
        <div class="mb-6 animate__animated animate__fadeInUp">
            <!-- Bouton pour afficher/masquer les filtres -->
            <button onclick="toggleFilters()"
                class="bg-teal-500 text-white px-4 py-2 rounded-lg hover:bg-teal-600 dark:bg-teal-600 dark:hover:bg-teal-700 transition duration-500 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">

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
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 transition duration-300" />
                        </div>
                    <?php endforeach; ?>
                    <button
                        class="bg-teal-500 text-white px-6 py-2 rounded-lg hover:bg-teal-600 dark:bg-teal-600 dark:hover:bg-teal-700 transition duration-500 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                        Appliquer
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Tableau -->
    <div class="mt-6 animate__animated animate__fadeInUp">
        <a href="<?= PUBLIC_URL . $modelName ?>/export"
            class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600 dark:bg-teal-600 dark:hover:bg-teal-700 transition duration-500 ease-in-out transform hover:scale-105">
            Exporter en CSV
        </a>
    </div>
    <div class="overflow-x-auto animate__animated animate__fadeInUp">
        <table class="min-w-full w-full bg-white dark:bg-gray-700 rounded-lg shadow-lg">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-800">
                    <?php foreach ($columns as $column): ?>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hover:bg-gray-100 dark:hover:bg-gray-600 transition duration-300">
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
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Actions
                        </th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                <?php if ($data && $data->count() > 0): ?>
                    <?php foreach ($data as $item): ?>
                        <tr
                            class="hover:bg-gray-50 dark:hover:bg-gray-800 transition duration-500 animate__animated animate__fadeIn">
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
                                            class="flex items-center justify-center w-8 h-8 rounded-full hover:bg-gray-100 dark:hover:bg-gray-600 transition duration-500 focus:outline-none focus:ring-2 focus:ring-teal-500">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                                </path>
                                            </svg>
                                        </button>

                                        <!-- Menu déroulant -->
                                        <div id="actions-<?= $item['id'] ?>"
                                            class="hidden absolute right-0 mt-2 w-48 rounded-lg shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 z-50 animate__animated animate__fadeIn ">
                                            <div class="py-1">
                                                <?php foreach ($actions as $action): ?>
                                                    <?php if (isset($action['type']) && $action['type'] === 'delete'): ?>
                                                        <!-- Bouton pour ouvrir le modal de suppression -->
                                                        <button onclick="openModal('deleteModal-<?= $item['id'] ?>')"
                                                            class="block w-full px-4 py-2 text-sm text-left text-red-600 hover:bg-gray-100 dark:text-red-500 dark:hover:bg-gray-600 transition duration-300">
                                                            <?= $action['label'] ?>
                                                        </button>
                                                    <?php else: ?>
                                                        <a href="<?= $action['url']($item) ?>"
                                                            class="block px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 transition duration-300">
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
                            class="px-6 py-4 text-center text-gray-500 dark:text-gray-400 animate__animated animate__fadeIn">
                            Aucun élément à afficher.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Pagination -->
<div class="mt-6 flex justify-between items-center animate__animated animate__fadeInUp">
    <!-- Texte indiquant la plage d'éléments -->
    <div class="text-sm text-gray-700 dark:text-gray-300">
        Affichage de <?= $data->firstItem() ?> à <?= $data->lastItem() ?> sur <?= $data->total() ?> éléments
    </div>

    <!-- Boutons de pagination -->
    <div class="flex items-center space-x-4">
        <!-- Bouton Précédent -->
        <?php if ($data->onFirstPage()): ?>
            <div
                class="border rounded-md bg-gray-100 dark:bg-gray-700 px-2 py-1 text-3xl leading-6 text-slate-400 dark:text-gray-400 cursor-not-allowed shadow-sm">
                &lt;
            </div>
        <?php else: ?>
            <a href="<?= $data->previousPageUrl() ?>"
                class="border rounded-md bg-teal-500 dark:bg-teal-600 px-2 py-1 text-3xl leading-6 text-white transition hover:bg-teal-600 dark:hover:bg-teal-700 cursor-pointer shadow-sm">
                &lt;
            </a>
        <?php endif; ?>

        <!-- Indicateur de page -->
        <div class="text-slate-500 dark:text-gray-300">
            <?= $data->currentPage() ?> / <?= $data->lastPage() ?>
        </div>

        <!-- Bouton Suivant -->
        <?php if ($data->hasMorePages()): ?>
            <a href="<?= $data->nextPageUrl() ?>"
                class="border rounded-md bg-teal-500 dark:bg-teal-600 px-2 py-1 text-3xl leading-6 text-white transition hover:bg-teal-600 dark:hover:bg-teal-700 cursor-pointer shadow-sm">
                &gt;
            </a>
        <?php else: ?>
            <div
                class="border rounded-md bg-gray-100 dark:bg-gray-700 px-2 py-1 text-3xl leading-6 text-slate-400 dark:text-gray-400 cursor-not-allowed shadow-sm">
                &gt;
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