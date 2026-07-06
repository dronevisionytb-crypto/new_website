<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Client - Drone Vision</title>
  <link rel="stylesheet" href="/assets/css/style.css">
  <script src="/assets/js/components.js" defer></script>
</head>
<body>
<aside class="sidebar">
  <div class="logo">
    <img src="/assets/img/logo.png" alt="Drone Vision">
  </div>
  
  <nav>
    <a href="/index.php?page=dashboard" class="nav-link" data-page="dashboard">
      <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
        <polyline points="9 22 9 12 15 12 15 22"></polyline>
      </svg>
      <span>Accueil</span>
    </a>
    
    <a href="/index.php?page=new_request" class="nav-link" data-page="new_request">
      <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="12" y1="5" x2="12" y2="19"></line>
        <line x1="5" y1="12" x2="19" y2="12"></line>
      </svg>
      <span>Nouvelle demande</span>
    </a>
    
    <a href="/index.php?page=my_requests" class="nav-link" data-page="my_requests">
      <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
        <polyline points="14 2 14 8 20 8"></polyline>
        <line x1="12" y1="11" x2="12" y2="17"></line>
        <line x1="9" y1="14" x2="15" y2="14"></line>
      </svg>
      <span>Mes demandes</span>
    </a>
    
    <a href="/index.php?page=documents" class="nav-link" data-page="documents">
      <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
      </svg>
      <span>Documents</span>
    </a>
    
    <a href="/index.php?page=invoices" class="nav-link" data-page="invoices">
      <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
      </svg>
      <span>Factures</span>
    </a>
  </nav>

  <div class="sidebar-bottom">
    <a href="/logout.php" class="logout">
      <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
        <polyline points="16 17 21 12 16 7"></polyline>
        <line x1="21" y1="12" x2="9" y2="12"></line>
      </svg>
      <span>Déconnexion</span>
    </a>
  </div>
</aside>

<main class="content">
  <?php include $view; ?>
</main>

<script>
  // Set active nav link
  document.addEventListener('DOMContentLoaded', function() {
    const currentPage = new URLSearchParams(window.location.search).get('page') || 'dashboard';
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
      if (link.dataset.page === currentPage) {
        link.classList.add('active');
      } else {
        link.classList.remove('active');
      }
    });
  });
</script>
</body>
</html>