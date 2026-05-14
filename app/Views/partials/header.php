<header class="flex items-center justify-between px-6 py-4 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 sticky top-0 z-40 backdrop-blur supports-[backdrop-filter]:bg-white/60 supports-[backdrop-filter]:dark:bg-zinc-900/60">
    <!-- Partie gauche avec titre -->
    <div class="col-span-4 items-center">
        <button id="mobileSidebarTrigger" class="md:hidden text-gray-500 dark:text-gray-400 mr-4">
            <i class="fas fa-bars text-xl"></i>
        </button>
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200"><?= $title ?? 'Gestion Pharmacie' ?></h2>
    </div>

    <!-- Partie droite avec bouton theme -->
    <div class="flex items-center">
        <button onclick="toggleTheme()" 
                class="p-2 text-gray-700 dark:text-white bg-white/80 dark:bg-gray-700/80 rounded-full hover:bg-gray-100 dark:hover:bg-gray-600 transition-all hover:scale-110 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path id="theme-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
            </svg>
        </button>
    </div>
</header>