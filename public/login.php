<?php
session_start();
require __DIR__ . '/../config/config.php';

$pdo = get_pdo();
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'role' => $user['role'],
            'name' => $user['name'],
            'company_id' => $user['company_id'] ?? null,
        ];
        header('Location: /index.php');
        exit;
    } else {
        $error = 'Identifiants incorrects';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion - Drone Vision</title>
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<div class="login-container">
  <div class="login-card">
    <div class="logo">
      <img src="/assets/img/logo.png" alt="Drone Vision Logo">
    </div>
    
    <h1>Connexion</h1>
    <p>Accédez à votre compte Drone Vision</p>

    <?php if ($error): ?>
      <div class="alert alert-error">
        <strong>Erreur :</strong> <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="post">
      <div class="form-group">
        <label for="email">Adresse Email</label>
        <input 
          type="email" 
          id="email"
          name="email" 
          placeholder="you@example.com" 
          required 
          autofocus
        >
      </div>

      <div class="form-group">
        <label for="password">Mot de passe</label>
        <input 
          type="password" 
          id="password"
          name="password" 
          placeholder="••••••••" 
          required
        >
      </div>

      <button type="submit" class="btn btn-primary btn-block">
        Se connecter
      </button>
    </form>

    <p style="text-align: center; margin-top: 24px; color: var(--gray-600); font-size: 13px;">
      © 2026 Drone Vision - Inspections Aériennes Professionnelles
    </p>
  </div>
</div>
</body>
</html>