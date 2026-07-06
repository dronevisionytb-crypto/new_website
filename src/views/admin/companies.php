<section class="page-header">
  <h1>Entreprises</h1>
</section>

<form class="form-card" method="post" action="/index.php?page=companies_create">
  <div class="form-section">
    <h2>Créer une entreprise</h2>

    <label>Nom *</label>
    <input type="text" name="name" required>

    <label>Adresse</label>
    <input type="text" name="address">

    <label>Code postal</label>
    <input type="text" name="postal_code">

    <label>Ville</label>
    <input type="text" name="city">

    <label>Département</label>
    <input type="text" name="department">

    <label>SIRET</label>
    <input type="text" name="siret">

    <label>Contact (nom)</label>
    <input type="text" name="contact_name">

    <label>Contact (email)</label>
    <input type="email" name="contact_email">

    <label>Contact (téléphone)</label>
    <input type="text" name="contact_phone">
  </div>

  <button type="submit" class="btn-primary">Créer l’entreprise</button>
</form>

<table>
  <thead>
    <tr>
      <th>Nom</th>
      <th>Ville</th>
      <th>SIRET</th>
      <th>Contact</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($companies)): ?>
      <?php foreach ($companies as $c): ?>
        <tr>
          <td><?= htmlspecialchars($c['name']) ?></td>
          <td><?= htmlspecialchars($c['city']) ?></td>
          <td><?= htmlspecialchars($c['siret']) ?></td>
          <td><?= htmlspecialchars($c['contact_name']) ?></td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>
