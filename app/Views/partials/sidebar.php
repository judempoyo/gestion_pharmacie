
<div id="wrapper" class="mb-0">
    <button id="mobileSidebarTrigger" class="fixed z-40 p-2 m-2 text-gray-600 bg-white rounded-lg shadow-md md:hidden dark:bg-gray-700 dark:text-gray-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

 
    <div id="sidebar" class="fixed inset-y-0 left-0 z-50 flex flex-col w-64 h-screen p-4 transition-all duration-300 transform -translate-x-full bg-white shadow-2xl md:relative md:translate-x-0 dark:bg-gray-800">
        <button id="closeSidebar" class="absolute p-2 text-gray-500 rounded-lg md:hidden -right-3 top-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-red-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>


        <button onclick="toggleSidebar()"
            class="absolute p-2 transition-colors duration-200 bg-gray-200 rounded-full shadow-xl -right-3 top-4 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 hidden md:block"
            id="toggleSidebarBtn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>

     
           <div class="flex items-center justify-center w-full mx-auto text-center p-auto place-content-center">
            <div class="p-2 rounded-lg bg-teal-50 dark:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                </svg>
            </div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white sidebar-text">
                    <span class="text-gray-700  dark:text-gray-300">Gestion Pharmacie</span>
                </h1>

            </div>

            <hr class="my-2 border-t border-gray-300 dark:border-gray-600">

            <!-- Menu principal -->
            <ul class="space-y-2">
                <!-- Tableau de bord -->
                <li class="mt-6">
                    <a href="<?= url('/dashboard') ?>"
                        class="flex items-center p-2 transition-colors duration-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 group <?= (strpos($_SERVER['REQUEST_URI'], '/dashboard') !== false || $_SERVER['REQUEST_URI'] === $basePath . '/') ? 'bg-teal-50 text-teal-700 dark:bg-gray-700 dark:text-teal-400' : 'text-gray-700 dark:text-gray-300' ?>">
                        <svg class="w-6 h-6 <?= (strpos($_SERVER['REQUEST_URI'], '/dashboard') !== false || $_SERVER['REQUEST_URI'] === $basePath . '/') ? 'text-teal-500' : 'text-gray-500 group-hover:text-teal-500 dark:text-gray-400' ?>"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span class="ml-3 sidebar-text">Tableau de bord</span>
                    </a>
                </li>

        
                <li>
                    <a href="<?= url('/product') ?>"
                        class="flex items-center p-2 transition-colors duration-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 group <?= (strpos($_SERVER['REQUEST_URI'], 'product') !== false) ? 'bg-teal-50 text-teal-700 dark:bg-gray-700 dark:text-teal-400' : 'text-gray-700 dark:text-gray-300' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600 dark:text-green-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <span class="ml-3 sidebar-text">Produits</span>
                    </a>
                </li>

                <!-- Ventes -->
                <li>
                    <a href="<?= url('/invoice') ?>"
                        class="flex items-center p-2 transition-colors duration-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 group <?= (strpos($_SERVER['REQUEST_URI'], 'invoice') !== false) ? 'bg-teal-50 text-teal-700 dark:bg-gray-700 dark:text-teal-400' : 'text-gray-700 dark:text-gray-300' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-600 dark:text-purple-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                        </svg>
                        <span class="ml-3 sidebar-text">Ventes</span>
                    </a>
                </li>

                <!-- Bons de commande -->
                <li>
                    <a href="<?= url('/purchase') ?>"
                        class="flex items-center p-2 transition-colors duration-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 group <?= (strpos($_SERVER['REQUEST_URI'], 'purchase') !== false) ? 'bg-teal-50 text-teal-700 dark:bg-gray-700 dark:text-teal-400' : 'text-gray-700 dark:text-gray-300' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-600 dark:text-yellow-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span class="ml-3 sidebar-text">Achats</span>
                    </a>
                </li>

                <!-- Clients -->
                <li>
                    <a href="<?= url('/customer') ?>"
                        class="flex items-center p-2 transition-colors duration-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 group <?= (strpos($_SERVER['REQUEST_URI'], 'customer') !== false) ? 'bg-teal-50 text-teal-700 dark:bg-gray-700 dark:text-teal-400' : 'text-gray-700 dark:text-gray-300' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-pink-600 dark:text-pink-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="ml-3 sidebar-text">Clients</span>
                    </a>
                </li>

                <!-- Fournisseurs -->
                <li>
                    <a href="<?= url('/supplier') ?>"
                        class="flex items-center p-2 transition-colors duration-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 group <?= (strpos($_SERVER['REQUEST_URI'], 'supplier') !== false) ? 'bg-teal-50 text-teal-700 dark:bg-gray-700 dark:text-teal-400' : 'text-gray-700 dark:text-gray-300' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-600 dark:text-indigo-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="ml-3 sidebar-text">Fournisseurs</span>
                    </a>
                </li>

                <!-- Rapports -->
                <li>
                    <a href="<?= url('/reports') ?>"
                        class="flex items-center p-2 transition-colors duration-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 group <?= (strpos($_SERVER['REQUEST_URI'], 'reports') !== false) ? 'bg-teal-50 text-teal-700 dark:bg-gray-700 dark:text-teal-400' : 'text-gray-700 dark:text-gray-300' ?>">
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600 dark:text-blue-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <?php 
                            $expiredCount = \App\Models\Product::whereNotNull('expiry_date')->where('expiry_date', '<', date('Y-m-d'))->count();
                            if ($expiredCount > 0): 
                            ?>
                            <span class="absolute -top-2 -right-2 flex h-4 w-4">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-4 w-4 bg-red-600 text-[10px] text-white items-center justify-center font-bold"><?= $expiredCount ?></span>
                            </span>
                            <?php endif; ?>
                        </div>
                        <span class="ml-3 sidebar-text">Rapports & Alertes</span>
                    </a>
                </li>

            </ul>

            <!-- Menu utilisateur (bas de sidebar) -->
            <div class="pt-4 mt-auto space-y-2 border-t border-gray-200 dark:border-gray-700 bottom">
                <ul>


                    <!-- Profil -->
                    <li>
                        <a href="<?= url('/profile') ?>"
                            class="flex items-center p-2 transition-colors duration-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 group <?= (strpos($_SERVER['REQUEST_URI'], 'profile') !== false) ? 'bg-teal-50 text-teal-700 dark:bg-gray-700 dark:text-teal-400' : 'text-gray-700 dark:text-gray-300' ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-teal-600 dark:text-teal-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="ml-3 sidebar-text">Profil</span>
                        </a>
                    </li>

                    <!-- Déconnexion -->
                    <li>
                        <a href="<?= url('/logout') ?>"
                            class="flex items-center p-2 transition-colors duration-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 group <?= (strpos($_SERVER['REQUEST_URI'], 'logout') !== false) ? 'bg-teal-50 text-teal-700 dark:bg-gray-700 dark:text-teal-400' : 'text-gray-700 dark:text-gray-300' ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-600 dark:text-red-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="ml-3 sidebar-text">Déconnexion</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Effet de flou pour le contenu principal -->
        <div id="contentBlur" class="fixed inset-0 z-40 hidden backdrop-blur-sm md:hidden"></div>
    </div>