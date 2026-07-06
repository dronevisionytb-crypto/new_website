<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Admin - Inspection drone</title>
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<div class="sidebar">
  <div class="logo">
    <img src="/assets/img/logo.png" alt="Logo">
  </div>
  <nav>
    <a href="/index.php?page=dashboard"><img src="/assets/img/icons/home.svg" alt=""> Accueil</a>
    <a href="/index.php?page=requests"><img src="/assets/img/icons/file.svg" alt=""> Demandes</a>
    <a href="/index.php?page=companies"><img src="/assets/img/icons/company.svg" alt=""> Entreprises</a>
    <a href="/index.php?page=users"><img src="/assets/img/icons/user.svg" alt=""> Comptes</a>
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
