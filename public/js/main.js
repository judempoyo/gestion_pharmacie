function toggleTheme() {
  const html = document.documentElement;
  html.classList.toggle('dark');
  
  // Sauvegarde du thème
  const isDark = html.classList.contains('dark');
  localStorage.setItem('theme', isDark ? 'dark' : 'light');
  
  // Mise à jour de l'icône
  const themeIcon = document.getElementById('theme-icon');
  if (themeIcon) {
    themeIcon.setAttribute('d', isDark ? 
      'M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z' : 
      'M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z'
    );
  }
}

function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  if (!sidebar) return;

  sidebar.classList.toggle('sidebar-mini');
  localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('sidebar-mini'));
}

function closeMobileSidebar() {
  const sidebar = document.getElementById('sidebar');
  const contentBlur = document.getElementById('contentBlur');
  if (sidebar) sidebar.classList.add('-translate-x-full');
  if (contentBlur) contentBlur.classList.add('hidden');
  document.body.classList.remove('overflow-hidden');
}

// Chargement initial
window.addEventListener('DOMContentLoaded', () => {
  // Theme
  const savedTheme = localStorage.getItem('theme') || 'light';
  document.documentElement.classList.toggle('dark', savedTheme === 'dark');
  
  // Sidebar State (Desktop)
  const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
  const sidebar = document.getElementById('sidebar');
  if (isCollapsed && sidebar && window.innerWidth >= 768) {
    sidebar.classList.add('sidebar-mini');
  }

  // Mobile Sidebar Logic
  const sidebarTrigger = document.getElementById('mobileSidebarTrigger');
  const closeSidebarBtn = document.getElementById('closeSidebar');
  const contentBlur = document.getElementById('contentBlur');

  if (sidebarTrigger) {
    sidebarTrigger.addEventListener('click', () => {
      if (sidebar) sidebar.classList.remove('-translate-x-full');
      if (contentBlur) contentBlur.classList.remove('hidden');
      document.body.classList.add('overflow-hidden');
    });
  }

  if (closeSidebarBtn) closeSidebarBtn.addEventListener('click', closeMobileSidebar);
  if (contentBlur) contentBlur.addEventListener('click', closeMobileSidebar);

  // Close sidebar on link click (mobile)
  document.querySelectorAll('#sidebar a').forEach(link => {
    link.addEventListener('click', () => {
      if (window.innerWidth < 768) {
        closeMobileSidebar();
      }
    });
  });
});

// Fonction pour revenir à la page précédente
function goBack() {
  window.history.back();
}
