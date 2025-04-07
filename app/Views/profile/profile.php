<div class="max-w-md mx-auto mt-10 bg-white p-8 rounded-lg shadow-md dark:bg-gray-800 dark:p-8 dark:rounded-lg dark:shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Profil</h1>
    
    <?php if (!empty($errors)): ?>
        <div class="bg-red-100 p-4 rounded mb-4 dark:bg-red-900 dark:p-4 dark:rounded dark:mb-4">
            <?php foreach ($errors as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->has('success')): ?>
        <div class="bg-teal-100 p-4 rounded mb-4 dark:bg-teal-900 dark:p-4 dark:rounded dark:mb-4">
            <?= htmlspecialchars($this->session->get('success')) ?>
        </div>
        <?php $this->session->remove('success'); ?>
    <?php endif; ?>

    <form action="<?= PUBLIC_URL ?>profile/update-info" method="POST">
        <div class="mb-4">
            <label class="block text-gray-700 mb-2 dark:text-gray-300">Nom</label>
            <input type="text" name="name" required
                   value="<?= htmlspecialchars($user->name) ?>"
                   class="w-full px-3 py-2 border rounded dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2 dark:text-gray-300">Email</label>
            <input type="email" name="email" required
                   value="<?= htmlspecialchars($user->email) ?>"
                   class="w-full px-3 py-2 border rounded dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
        </div>
        
        <button type="submit" 
                class="w-full bg-indigo-500 text-white py-2 px-4 rounded hover:bg-indigo-600 dark:bg-indigo-700 dark:text-white dark:py-2 dark:px-4 dark:hover:bg-indigo-800">
            Mettre à jour les informations
        </button>
    </form>

    <hr class="my-6 border-gray-300 dark:border-gray-600">

    <form action="<?= PUBLIC_URL ?>profile/update-password" method="POST">
        <div class="mb-4">
            <label class="block text-gray-700 mb-2 dark:text-gray-300">Mot de passe actuel</label>
            <input type="password" name="current_password" required
                   class="w-full px-3 py-2 border rounded dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2 dark:text-gray-300">Nouveau mot de passe</label>
            <input type="password" name="new_password" required
                   class="w-full px-3 py-2 border rounded dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2 dark:text-gray-300">Confirmer le nouveau mot de passe</label>
            <input type="password" name="new_password_confirmation" required
                   class="w-full px-3 py-2 border rounded dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
        </div>
        
        <button type="submit" 
                class="w-full bg-teal-500 text-white py-2 px-4 rounded hover:bg-teal-600 dark:bg-teal-700 dark:text-white dark:py-2 dark:px-4 dark:hover:bg-teal-800">
            Mettre à jour le mot de passe
        </button>
    </form>

    <hr class="my-6 border-gray-300 dark:border-gray-600">

    <!-- Inclure le modal pour la suppression du compte -->
    <?php
    $modalParams = [
        'modalId' => 'deleteAccountModal',
        'title' => 'Confirmer la suppression',
        'message' => 'Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.',
        'formAction' => PUBLIC_URL . 'profile/delete',
        'submitText' => 'Supprimer',
        'cancelText' => 'Annuler',
        'includePasswordField' => true,
    ];
    include __DIR__ . '/../partials/modal.php';
    ?>

    <!-- Bouton pour ouvrir le modal -->
    <button onclick="openModal('deleteAccountModal')"
            class="w-full bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600 dark:bg-red-700 dark:text-white dark:py-2 dark:px-4 dark:hover:bg-red-800">
        Supprimer mon compte
    </button>
</div>