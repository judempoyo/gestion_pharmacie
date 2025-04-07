<?php ob_start() ?>
<div class="bg-white rounded-lg shadow p-6 max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Ajouter une Photo</h1>
    
    <form action="<?= PUBLIC_URL ?>store" method="POST" enctype="multipart/form-data">
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Titre</label>
            <input type="text" name="title" class="w-full p-2 border rounded" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Description</label>
            <textarea name="description" class="w-full p-2 border rounded" rows="4"></textarea>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Image</label>
            <input type="file" name="image" accept="image/*" class="w-full" required>
        </div>
        
        <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600">
            Publier la Photo
        </button>
    </form>
</div>
<?php 
$content = ob_get_clean();
$title = "Ajouter une Photo";
include __DIR__ . '/../layouts/app.php';