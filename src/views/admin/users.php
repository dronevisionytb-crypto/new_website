<section class="page-header">
  <h1>Comptes employés</h1>
</section>

<form class="form-card" method="post" action="/index.php?page=users_create">
  <div class="form-section">
    <h2>Créer un compte</h2>

    <label>Nom *</label>
    <input type="text" name="name" required>

    <label>Email *</label>
    <input type="email" name="email" required>

    <label>Mot de passe *</label>
    <input type="password" name="password" required>

    <label>Rôle *</label>
    <select name="role" required>
      <option value="client">Client</option>
      <option value="admin">Admin</option>
    </select>

    <label>Entreprise (optionnel pour admin)</label>
    <select name="company_id">
      <option value="">Aucune</option>
      <?php if (!empty($companies)): ?>
        <?php foreach ($companies as $c): ?>
          <option value="<?= (int)$c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
        <?php endforeach; ?>
      <?php endif; ?>
    </select>
  </div>

  <button type="submit" class="btn-primary">Créer le compte</button>
</form>

<table>
  <thead>
    <tr>
      <th>Nom</th>
      <th>Email</th>
      <th>Rôle</th>
      <th>Entreprise</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($users)): ?>
      <?php foreach ($users as $u): ?>
        <tr>
          <td><?= htmlspecialchars($u['name']) ?></td>
          <td><?= htmlspecialchars($u['email']) ?></td>
          <td><?= htmlspecialchars($u['role']) ?></td>
          <td><?= htmlspecialchars($u['company_name'] ?? '') ?></td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>
