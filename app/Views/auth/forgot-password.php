<div class="max-w-md mx-auto mt-10 bg-white p-8 rounded-lg shadow-md dark:bg-gray-800 dark:p-8 dark:rounded-lg dark:shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Mot de passe oublié</h1>
    
    <?php if ($error): ?>
        <div class="bg-red-100 p-4 rounded mb-4 dark:bg-red-900 dark:p-4 dark:rounded dark:mb-4">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form action="<?= PUBLIC_URL ?>forgot-password" method="POST">
        <div class="mb-4">
            <label class="block text-gray-700 mb-2 dark:text-gray-300">Email</label>
            <input type="email" name="email" required
                   class="w-full px-3 py-2  rounded  bg-gray-100 border-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
        </div>
        
        <button type="submit" 
                class="w-full bg-teal-500 text-white py-2 px-4 rounded hover:bg-teal-600 dark:bg-teal-700 dark:text-white dark:py-2 dark:px-4 dark:rounded dark:hover:bg-teal-800">
            Envoyer le lien de réinitialisation
        </button>
    </form>
</div>