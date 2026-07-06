<div class="page-header">
  <h1>🏢 Gestion des entreprises</h1>
  <p>Créez et gérez les entreprises clientes</p>
</div>

<div class="card form-card" style="margin-bottom: 40px;">
  <h2 style="margin: 0 0 24px 0; color: var(--blue-primary); font-size: 20px; font-weight: 600; padding-bottom: 12px; border-bottom: 2px solid var(--blue-light);">
    ➕ Créer une nouvelle entreprise
  </h2>

  <form method="post" action="/index.php?page=companies_create">
    <div class="form-row">
      <div class="form-group">
        <label for="name">Nom de l'entreprise *</label>
        <input type="text" id="name" name="name" placeholder="ACME Corporation" required>
      </div>
      <div class="form-group">
        <label for="siret">SIRET</label>
        <input type="text" id="siret" name="siret" placeholder="123 456 789 00123">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label for="address">Adresse</label>
        <input type="text" id="address" name="address" placeholder="123 Rue de la Paix">
      </div>
      <div class="form-group">
        <label for="postal">Code postal</label>
        <input type="text" id="postal" name="postal_code" placeholder="75000">
      </div>
      <div class="form-group">
        <label for="city">Ville</label>
        <input type="text" id="city" name="city" placeholder="Paris">
      </div>
    </div>

    <div class="form-group">
      <label for="dept">Département</label>
      <input type="text" id="dept" name="department" placeholder="75">
    </div>

    <div style="border-top: 2px solid var(--blue-light); padding-top: 20px; margin: 20px 0;">
      <h3 style="margin: 0 0 16px 0; color: var(--gray-900); font-size: 16px; font-weight: 600;">
        Contact principal
      </h3>

      <div class="form-row">
        <div class="form-group">
          <label for="contact_name">Nom du contact</label>
          <input type="text" id="contact_name" name="contact_name" placeholder="Jean Dupont">
        </div>
        <div class="form-group">
          <label for="contact_email">Email</label>
          <input type="email" id="contact_email" name="contact_email" placeholder="contact@acme.fr">
        </div>
        <div class="form-group">
          <label for="contact_phone">Téléphone</label>
          <input type="text" id="contact_phone" name="contact_phone" placeholder="+33 1 23 45 67 89">
        </div>
      </div>
    </div>

    <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 24px;">
      <button type="reset" class="btn btn-secondary">Réinitialiser</button>
      <button type="submit" class="btn btn-primary btn-lg">✓ Créer l'entreprise</button>
    </div>
  </form>
</div>

<!-- Liste des entreprises -->
<div class="card">
  <h2 style="margin: 0 0 24px 0; color: var(--gray-900); font-size: 18px; font-weight: 600;">
    Liste des entreprises (<?= count($companies ?? []) ?>)
  </h2>

  <?php if (!empty($companies)): ?>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Nom</th>
            <th>Ville</th>
            <th>SIRET</th>
            <th>Contact</th>
            <th>Email</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($companies as $c): ?>
            <tr>
              <td style="font-weight: 600; color: var(--blue-primary);">
                <?= htmlspecialchars($c['name']) ?>
              </td>
              <td><?= htmlspecialchars($c['city'] ?? '-') ?></td>
              <td><?= htmlspecialchars($c['siret'] ?? '-') ?></td>
              <td><?= htmlspecialchars($c['contact_name'] ?? '-') ?></td>
              <td style="font-size: 13px; color: var(--gray-600);">
                <?= htmlspecialchars($c['contact_email'] ?? '-') ?>
              </td>
              <td>
                <a href="/index.php?page=company_view&id=<?= (int)$c['id'] ?>" class="btn btn-sm btn-secondary">
                  Voir détails
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div style="padding: 40px; text-align: center;">
      <p style="color: var(--gray-500); font-size: 16px;">
        📭 Aucune entreprise pour le moment - Créez la première ci-dessus
      </p>
    </div>
  <?php endif; ?>
</div>