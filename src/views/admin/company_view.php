<div class="page-header">
  <h1>🏢 <?= htmlspecialchars($company['name']) ?></h1>
  <p>Gestion des informations et ressources de l'entreprise</p>
</div>

<!-- Informations principales -->
<div class="card-grid">
  <div class="card">
    <h3 style="margin: 0 0 16px 0; color: var(--blue-primary); font-size: 16px; font-weight: 600;">
      📍 Adresse
    </h3>
    <p style="margin: 0; line-height: 1.6; color: var(--gray-700);">
      <?= htmlspecialchars($company['address'] ?? '-') ?><br>
      <?= htmlspecialchars(($company['postal_code'] ?? '') . ' ' . ($company['city'] ?? '')) ?>
    </p>
  </div>

  <div class="card">
    <h3 style="margin: 0 0 16px 0; color: var(--blue-primary); font-size: 16px; font-weight: 600;">
      🏛️ SIRET
    </h3>
    <p style="margin: 0; font-size: 18px; font-weight: 600; color: var(--gray-900);">
      <?= htmlspecialchars($company['siret'] ?? '-') ?>
    </p>
  </div>

  <div class="card">
    <h3 style="margin: 0 0 16px 0; color: var(--blue-primary); font-size: 16px; font-weight: 600;">
      📞 Contact principal
    </h3>
    <p style="margin: 8px 0 0 0; color: var(--gray-700);">
      <strong><?= htmlspecialchars($company['contact_name'] ?? '-') ?></strong><br>
      <a href="mailto:<?= htmlspecialchars($company['contact_email'] ?? '') ?>" style="color: var(--blue-primary); text-decoration: none;">
        <?= htmlspecialchars($company['contact_email'] ?? '-') ?>
      </a>
    </p>
  </div>
</div>

<!-- Employés -->
<div class="card">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h2 style="margin: 0; color: var(--gray-900); font-size: 18px; font-weight: 600;">
      👥 Employés (<?= count($employees ?? []) ?>)
    </h2>
    <a href="/index.php?page=users_create&company_id=<?= (int)$company['id'] ?>" class="btn btn-sm btn-primary">
      ➕ Ajouter un employé
    </a>
  </div>

  <?php if (!empty($employees)): ?>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($employees as $u): ?>
            <tr>
              <td style="font-weight: 600; color: var(--gray-900);">
                <?= htmlspecialchars($u['name']) ?>
              </td>
              <td style="color: var(--gray-600);">
                <?= htmlspecialchars($u['email']) ?>
              </td>
              <td>
                <?= htmlspecialchars($u['phone'] ?? '-') ?>
              </td>
              <td>
                <button class="btn btn-sm btn-danger" onclick="if(confirm('Supprimer cet employé ?')) { window.location.href='/index.php?page=delete_user&id=<?= (int)$u['id'] ?>'; }">
                  ✗ Supprimer
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div style="padding: 24px; text-align: center; background: var(--gray-50); border-radius: var(--radius-md);">
      <p style="color: var(--gray-500); margin: 0;">Aucun employé - Cliquez sur le bouton ci-dessus pour en ajouter</p>
    </div>
  <?php endif; ?>
</div>

<!-- Documents -->
<div class="card">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h2 style="margin: 0; color: var(--gray-900); font-size: 18px; font-weight: 600;">
      📄 Documents (<?= count($documents ?? []) ?>)
    </h2>
    <a href="/index.php?page=upload_document&company_id=<?= (int)$company['id'] ?>" class="btn btn-sm btn-primary">
      ➕ Ajouter un document
    </a>
  </div>

  <?php if (!empty($documents)): ?>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 16px;">
      <?php foreach ($documents as $d): ?>
        <div style="padding: 16px; border: 1px solid var(--gray-200); border-radius: var(--radius-md); background: var(--gray-50);">
          <div style="font-size: 24px; margin-bottom: 8px;">📑</div>
          <h4 style="margin: 0 0 12px 0; color: var(--gray-900); font-size: 14px; font-weight: 600; word-break: break-word;">
            <?= htmlspecialchars($d['title']) ?>
          </h4>
          <div style="display: flex; gap: 8px;">
            <a href="<?= htmlspecialchars($d['file_path']) ?>" target="_blank" class="btn btn-sm btn-secondary flex-1" style="text-align: center; font-size: 12px;">
              👁️
            </a>
            <button class="btn btn-sm btn-danger flex-1" onclick="if(confirm('Supprimer ce document ?')) { window.location.href='/index.php?page=delete_document&id=<?= (int)$d['id'] ?>'; }" style="font-size: 12px;">
              ✗
            </button>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div style="padding: 24px; text-align: center; background: var(--gray-50); border-radius: var(--radius-md);">
      <p style="color: var(--gray-500); margin: 0;">Aucun document - Cliquez sur le bouton ci-dessus pour en ajouter</p>
    </div>
  <?php endif; ?>
</div>

<!-- Actions -->
<div style="margin-top: 32px; padding: 20px; background: var(--gray-50); border-radius: var(--radius-lg); border-left: 4px solid var(--blue-primary);">
  <h3 style="margin: 0 0 12px 0; color: var(--gray-900); font-size: 16px;">
    ⚙️ Actions rapides
  </h3>
  <div style="display: flex; gap: 12px; flex-wrap: wrap;">
    <a href="/index.php?page=companies" class="btn btn-secondary">← Retour à la liste</a>
  </div>
</div>