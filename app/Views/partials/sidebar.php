<div id="wrapper" class="bg-yellow-500 ">
    <div class="relative w-64 h-screen p-4 transition-all duration-300 bg-white shadow-lg dark:bg-gray-800"
        id="sidebar">
        <button onclick="toggleSidebar()"
            class="absolute p-2 mb-8 transition-colors duration-200 bg-gray-200 rounded-full -right-1/7 top-4 toggle-button dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600" id="toggleSidebarBtn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 size-6 sidebar-icon">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 size-6 sidebar-mini-icon">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
            </svg>
        </button>

        <!-- Titre du sidebar -->
        <h1 class="mb-6 text-xl font-bold dark:text-white">
      
                    <span class="ml-3 text-gray-500 sidebar-text dark:text-gray-300">Gestion Pharmacie</span>
                    </h1>

        <!-- Liste des liens -->
        <ul class="space-y-2">
            <!-- Accueil -->
            <li class="mt-12">
                <a href="<?= PUBLIC_URL ?>"
                    class="flex items-center p-2 transition-colors duration-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                    <svg class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="ml-3 text-gray-500 sidebar-text dark:text-gray-300">Accueil</span>
                </a>
            </li>

            <!-- Produits -->
            <li>
                <a href="<?= PUBLIC_URL ?>product"
                    class="flex items-center p-2 transition-colors duration-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>

                    <span class="ml-3 text-gray-500 sidebar-text dark:text-gray-300">Produits</span>
                </a>
            </li>

            <!-- Ventes -->
            <li>
                <a href=" <?= PUBLIC_URL ?>invoice"
                    class="flex items-center p-2 transition-colors duration-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                    </svg>

                    <span class="ml-3 text-gray-500 sidebar-text dark:text-gray-300">Ventes</span>
                </a>
            </li>

            <!-- Clients -->
            <li>
                <a href="<?= PUBLIC_URL ?>customer"
                    class="flex items-center p-2 transition-colors duration-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>

                    <span class="ml-3 text-gray-500 sidebar-text dark:text-gray-300">Clients</span>
                </a>
            </li>
            
            <li>
                <a href="<?= PUBLIC_URL ?>supplier"
                    class="flex items-center p-2 transition-colors duration-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>

                    <span class="ml-3 text-gray-500 sidebar-text dark:text-gray-300">Fournisseurs</span>
                </a>
            </li>
            <!-- Rapport -->
            <li>
                <a href="{{ route('reports.index') }}"
                    class="flex items-center p-2 transition-colors duration-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                    </svg>

                    <span class="ml-3 text-gray-500 sidebar-text dark:text-gray-300">Rapport</span>
                </a>
            </li>
        </ul>

        <!-- Divider -->
        <hr class="my-4 border-t border-gray-300 shadow-lg dark:border-gray-600"></hr>

        <div class="mt-auto">
            <a href=" <?= PUBLIC_URL ?>profile"
                class="flex items-center p-2 transition-colors duration-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">

              
                <svg class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.31 0-10 1.67-10 5v1h20v-1c0-3.33-6.69-5-10-5z" /></svg>

                <span class="ml-3 text-gray-500 sidebar-text dark:text-gray-300">Profil</span>
            </a>
        </div>
        <div class="mt-auto">
            <a href="<?= PUBLIC_URL ?>logout"
                class="flex items-center p-2 transition-colors duration-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                </svg>

                <span class="ml-3 text-gray-500 sidebar-text dark:text-gray-300">Déconnexion</span>
            </a>
        </div>
    </div>
</div>