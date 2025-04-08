<div id="wrapper" class="bg-gray-100 dark:bg-gray-900">
    <div class="relative w-64 h-screen p-4 transition-all duration-300 bg-white shadow-lg dark:bg-gray-800" id="sidebar">
        <button onclick="toggleSidebar()" class="absolute p-2 mb-8 transition-colors duration-200 bg-gray-200 rounded-full -right-1/7 top-4 toggle-button dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600" id="toggleSidebarBtn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 sidebar-icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 sidebar-mini-icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
            </svg>
        </button>

        <!-- Titre du sidebar -->
        <div class="flex items-center mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
            </svg>
            <h1 class="ml-2 text-xl font-bold dark:text-white">
                <span class="text-gray-700 sidebar-text dark:text-gray-300">Gestion Pharmacie</span>
            </h1>
        </div>

        <!-- Liste des liens -->
        <ul class="space-y-2">
            <!-- Accueil -->
            <li>
                <a href="<?= PUBLIC_URL ?>" class="flex items-center p-2 transition-colors duration-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="ml-3 sidebar-text">Accueil</span>
                </a>
            </li>

            <!-- Produits -->
            <li>
                <a href="<?= PUBLIC_URL ?>product" class="flex items-center p-2 transition-colors duration-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <span class="ml-3 sidebar-text">Produits</span>
                </a>
            </li>

            <!-- Ventes -->
            <li>
                <a href="<?= PUBLIC_URL ?>invoice" class="flex items-center p-2 transition-colors duration-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                    </svg>
                    <span class="ml-3 sidebar-text">Ventes</span>
                </a>
            </li>

            <!-- Bons de commande -->
            <li>
                <a href="<?= PUBLIC_URL ?>purchase" class="flex items-center p-2 transition-colors duration-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span class="ml-3 sidebar-text">Bons de commande</span>
                </a>
            </li>

            <!-- Clients -->
            <li>
                <a href="<?= PUBLIC_URL ?>customer" class="flex items-center p-2 transition-colors duration-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-pink-600 dark:text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="ml-3 sidebar-text">Clients</span>
                </a>
            </li>
            
            <!-- Fournisseurs -->
            <li>
                <a href="<?= PUBLIC_URL ?>supplier" class="flex items-center p-2 transition-colors duration-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span class="ml-3 sidebar-text">Fournisseurs</span>
                </a>
            </li>

           
        </ul>

        <!-- Divider -->
        <hr class="my-4 border-t border-gray-200 dark:border-gray-700">
        

        <!-- Section inférieure -->
        <div class="mt-auto space-y-2">
        <ul class="space-y-2">
            <!-- Stock critique -->
            <li>
                <a href="<?= PUBLIC_URL ?>stock/alert" class="flex items-center p-2 transition-colors duration-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span class="ml-3 sidebar-text">Stock critique</span>
                </a>
            </li>

            <!-- Profil -->
            <li>
                <a href="<?= PUBLIC_URL ?>profile" class="flex items-center p-2 transition-colors duration-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-teal-600 dark:text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="ml-3 sidebar-text">Profil</span>
                </a>
            </li>

            <!-- Déconnexion -->
            <li>
                <a href="<?= PUBLIC_URL ?>logout" class="flex items-center p-2 transition-colors duration-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span class="ml-3 sidebar-text">Déconnexion</span>
                </a>
            </li>
</ul>
        </div>
    </div>
</div>

<style>
    .sidebar-text {
        color: #4b5563; /* gray-600 */
        transition: all 0.3s ease;
    }
    
    .dark .sidebar-text {
        color: #d1d5db; /* gray-300 */
    }
    
    #sidebar.collapsed {
        width: 5rem;
    }
    
    #sidebar.collapsed .sidebar-text {
        opacity: 0;
        width: 0;
        overflow: hidden;
    }
    
    #sidebar.collapsed .sidebar-icon {
        display: none;
    }
    
    #sidebar:not(.collapsed) .sidebar-mini-icon {
        display: none;
    }
</style>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('collapsed');
        
        // Sauvegarder l'état dans localStorage
        const isCollapsed = sidebar.classList.contains('collapsed');
        localStorage.setItem('sidebarCollapsed', isCollapsed);
    }
    
    // Vérifier l'état au chargement
    document.addEventListener('DOMContentLoaded', function() {
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (isCollapsed) {
            document.getElementById('sidebar').classList.add('collapsed');
        }
    });
</script>