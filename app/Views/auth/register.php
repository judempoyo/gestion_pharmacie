<div class="max-w-md mx-auto mt-10 bg-white p-8 rounded-lg shadow-md dark:bg-gray-800 dark:p-8 dark:rounded-lg dark:shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Inscription</h1>
    
    <?php if (!empty($errors)): ?>
        <div class="bg-red-100 p-4 rounded mb-4 dark:bg-red-900 dark:p-4 dark:rounded dark:mb-4">
            <?php foreach ($errors as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="<?= PUBLIC_URL ?>register" method="POST">
        <div class="mb-4">
            <label class="block text-gray-700 mb-2 dark:text-gray-300">Nom</label>
            <input type="text" name="name" required
                   value="<?= htmlspecialchars($old['name'] ?? '') ?>"
                   class="w-full px-3 py-2 border rounded dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2 dark:text-gray-300">Email</label>
            <input type="email" name="email" required
                   value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                   class="w-full px-3 py-2 border rounded dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2 dark:text-gray-300">Mot de passe</label>
            <input type="password" name="password" required
                   class="w-full px-3 py-2 border rounded dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2 dark:text-gray-300">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" required
                   class="w-full px-3 py-2 border rounded dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
        </div>
        
        <button type="submit" 
                class="w-full bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 dark:bg-green-700 dark:text-white dark:py-2dark:px-4 dark:hover:bg-green-800">
            S' inscrire
        </button>
    </form>
    
    <p class="mt-4 text-center text-gray-600 dark:text-gray-400">
    Déjà inscrit ? 
        <a href="<?= PUBLIC_URL ?>login" class="text-teal-500 hover:underline dark:text-teal-700 dark:hover:underline">Se connecter</a>
    </p>
    
</div>