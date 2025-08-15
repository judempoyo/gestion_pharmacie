<div class="max-w-md p-8 mx-auto mt-10 bg-white rounded-lg shadow-md dark:bg-gray-800 dark:p-8 dark:rounded-lg dark:shadow-md">
    <h1 class="mb-6 text-2xl font-bold text-gray-900 dark:text-gray-100">Connexion</h1>
    
    <?php if ($error): ?>
        <div class="p-4 mb-4 bg-red-100 rounded dark:bg-red-900 dark:p-4 dark:rounded dark:mb-4">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form action="<?= PUBLIC_URL ?>login" method="POST">
        <div class="mb-4">
            <label class="block mb-2 text-gray-700 dark:text-gray-300">Email</label>
            <input type="email" name="email" required
                   class="w-full px-3 py-2 bg-gray-100 border-gray-100 rounded dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
        </div>
        
        <div class="mb-4">
            <label class="block mb-2 text-gray-700 dark:text-gray-300">Mot de passe</label>
            <input type="password" name="password" required
                   class="w-full px-3 py-2 bg-gray-100 border-gray-100 rounded dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
        </div>
        
        <button type="submit" 
                class="w-full px-4 py-2 text-white bg-teal-500 rounded hover:bg-teal-600 dark:bg-teal-700 dark:text-white dark:py-2 dark:px-4 dark:rounded dark:hover:bg-teal-800">
            Se connecter
        </button>
    </form>
    
   <!--  <p class="mt-4 text-center text-gray-600 dark:text-gray-400">
        Pas de compte ? 
        <a href="<?= PUBLIC_URL ?>register" class="text-teal-500 hover:underline dark:text-teal-700 dark:hover:underline">S'inscrire</a>
    </p> -->

    <p class="mt-4 text-center text-gray-600 dark:text-gray-400">
        Mot de passe oublié ? 
        <a href="<?= PUBLIC_URL ?>forgot-password" class="text-teal-500 hover:underline dark:text-teal-700 dark:hover:underline">Réinitialiser</a>
    </p>
</div>