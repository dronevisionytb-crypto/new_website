<div class="page-header">
  <h1>📥 Demandes reçues</h1>
  <p>Gestion des demandes d'inspection de vos clients</p>
</div>

<?php if (($status ?? null) === 'updated'): ?>
  <div class="alert alert-success" style="background: var(--success); color: #fff; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px;">
    ✅ Statut mis à jour avec succès.
  </div>
<?php elseif (!empty($error)): ?>
  <div class="alert alert-danger" style="background: var(--danger); color: #fff; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px;">
    ⚠️ Erreur : <?= htmlspecialchars($error) ?>
  </div>
<?php endif; ?>

<div class="card">
  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 32px;">
    <div class="stat-card">
      <div class="stat-label">Demandes totales</div>
      <div class="stat-number"><?= count($requests) ?></div>
    </div>

    <div class="stat-card">
      <div class="stat-label">Envoyées</div>
      <div class="stat-number" style="color: var(--warning);">
        <?= count(array_filter($requests, fn($r) => $r['status'] === 'envoyée')) ?>
      </div>
    </div>

    <div class="stat-card">
      <div class="stat-label">En étude</div>
      <div class="stat-number" style="color: var(--info);">
        <?= count(array_filter($requests, fn($r) => $r['status'] === 'en_etude')) ?>
      </div>
    </div>

    <div class="stat-card">
      <div class="stat-label">Terminées</div>
      <div class="stat-number" style="color: var(--success);">
        <?= count(array_filter($requests, fn($r) => $r['status'] === 'terminée')) ?>
      </div>
    </div>
  </div>

  <?php if (!empty($requests)): ?>
    <?php
      $status_map = [
        'envoyée'         => ['badge-warning', '📨 Envoyée'],
        'en_etude'        => ['badge-info',    '🔎 En étude'],
        'facture_envoyée' => ['badge-primary',  '🧾 Facture envoyée'],
        'terminée'        => ['badge-success',  '✅ Terminée'],
      ];
    ?>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Entreprise</th>
            <th>Site</th>
            <th>Type de mission</th>
            <th>Période</th>
            <th>Date</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($requests as $r): ?>
            <?php
              $sc = $status_map[$r['status']][0] ?? 'badge-info';
              $st = $status_map[$r['status']][1] ?? htmlspecialchars($r['status']);
            ?>
            <tr>
              <td style="color: var(--gray-500); font-size: 13px;"><?= (int)$r['id'] ?></td>
              <td style="font-weight: 500; color: var(--blue-primary);">
                <?= htmlspecialchars($r['company_name'] ?? '—') ?>
              </td>
              <td><?= htmlspecialchars($r['site_name']) ?></td>
              <td><?= htmlspecialchars($r['mission_type']) ?></td>
              <td><?= htmlspecialchars($r['desired_period'] ?? '—') ?></td>
              <td style="white-space: nowrap; font-size: 13px;"><?= date('d/m/Y', strtotime($r['created_at'])) ?></td>
              <td>
                <span class="badge <?= $sc ?>"><?= $st ?></span>
              </td>
              <td style="white-space: nowrap;">
                <form method="POST" action="/index.php?page=update_request_status"
                      style="display: inline-flex; gap: 6px; align-items: center;">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                  <input type="hidden" name="request_id" value="<?= (int)$r['id'] ?>">
                  <select name="status" style="font-size: 13px; padding: 4px 6px; border: 1px solid var(--gray-300); border-radius: 4px;">
                    <option value="envoyée"         <?= $r['status'] === 'envoyée'         ? 'selected' : '' ?>>📨 Envoyée</option>
                    <option value="en_etude"        <?= $r['status'] === 'en_etude'        ? 'selected' : '' ?>>🔎 En étude</option>
                    <option value="facture_envoyée" <?= $r['status'] === 'facture_envoyée' ? 'selected' : '' ?>>🧾 Facture envoyée</option>
                    <option value="terminée"        <?= $r['status'] === 'terminée'        ? 'selected' : '' ?>>✅ Terminée</option>
                  </select>
                  <button type="submit" class="btn btn-sm btn-primary" style="padding: 4px 10px; font-size: 12px;">
                    Valider
                  </button>
                </form>
                <a class="btn btn-sm btn-secondary"
                   style="margin-left: 6px; font-size: 12px;"
                   href="/index.php?page=request_detail&id=<?= (int)$r['id'] ?>">
                  Détails
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
        📭 Aucune demande pour le moment
      </p>
    </div>
  <?php endif; ?>
</div>