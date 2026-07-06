<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Client - Inspection drone</title>
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<div class="sidebar">
  <div class="logo">
    <img src="/assets/img/logo.png" alt="Logo">
  </div>
  <nav>
    <a href="/index.php?page=dashboard"><img src="/assets/img/icons/home.svg" alt=""> Accueil</a>
    <a href="/index.php?page=new_request"><img src="/assets/img/icons/plus.svg" alt=""> Nouvelle demande</a>
    <a href="/index.php?page=my_requests"><img src="/assets/img/icons/file.svg" alt=""> Mes demandes</a>
    <a href="/index.php?page=documents"><img src="/assets/img/icons/company.svg" alt=""> Documents</a>
    <a href="/index.php?page=invoices"><img src="/assets/img/icons/invoice.svg" alt=""> Factures</a>
  </nav>
  <div class="sidebar-bottom">
    <a href="/logout.php" class="logout"><img src="/assets/img/icons/logout.svg" alt=""> Déconnexion</a>
  </div>
</div>
<div class="content">
  <?php include $view; ?>
</div>
</body>
</html>
