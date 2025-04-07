<?php ob_start() ?>
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Liste des Photos</h1>
        <a href="<?= PUBLIC_URL ?>create" class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded transition duration-200">
            Ajouter une Photo
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php foreach ($photos as $photo): ?>
        <div class="border rounded-lg p-4 hover:shadow-lg transition-shadow">
            <h2 class="text-xl font-semibold mb-2"><?= htmlspecialchars($photo->title) ?></h2>
            <p class="text-gray-600 mb-3"><?= htmlspecialchars($photo->description) ?></p>
            <img src="<?= htmlspecialchars($photo->path) ?>" 
                 alt="<?= htmlspecialchars($photo->title) ?>" 
                 class="w-full h-48 object-cover rounded">
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php 
$content = ob_get_clean();
$title = "Gestion des Photos";
$headerTitle = "Galerie Photo";
include __DIR__ . '/../layouts/app.php';
?>