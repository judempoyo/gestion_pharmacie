<?php ob_start() ?>
<div class="max-w-4xl mx-auto mt-10 bg-white dark:bg-gray-800 shadow-lg p-8 rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-6">Bienvenue, <?= htmlspecialchars($user->name) ?> !</h1>
    
    <div class="space-y-4">
        <p>Email : <?= htmlspecialchars($user->email) ?></p>
        <p>Compte créé le : <?= $user->created_at->format('d/m/Y H:i') ?></p>
    </div>

    <div class="mt-6">
        <a href="<?= PUBLIC_URL ?>logout" 
           class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">
            Déconnexion
        </a>
    </div>
</div>
<?php 
//$content = ob_get_clean();
//include __DIR__ . '/../layouts/app.php';