<div class="page-header">
  <h1>📥 Demandes reçues</h1>
  <p>Gestion des demandes d'inspection de vos clients</p>
</div>

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
  </div>

  <?php if (!empty($requests)): ?>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Entreprise</th>
            <th>Site</th>
            <th>Type de mission</th>
            <th>Puissance (MWc)</th>
            <th>Période</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($requests as $r): ?>
            <tr>
              <td style="font-weight: 500; color: var(--blue-primary);">
                <?= htmlspecialchars($r['company_name']) ?>
              </td>
              <td><?= htmlspecialchars($r['site_name']) ?></td>
              <td><?= htmlspecialchars($r['mission_type']) ?></td>
              <td style="text-align: center;">
                <?= $r['installed_power_mwc'] !== null ? number_format($r['installed_power_mwc'], 2, ',', ' ') : '-' ?>
              </td>
              <td><?= htmlspecialchars($r['desired_period']) ?></td>
              <td>
                <?php
                  $status_map = [
                    'envoyée' => ['badge-warning', '📨 Envoyée'],
                    'en_etude' => ['badge-info', '🔎 En étude'],
                    'facture_envoyée' => ['badge-primary', '🧾 Facture envoyée'],
                    'terminée' => ['badge-success', '✅ Terminée'],
                  ];
                  $status_class = $status_map[$r['status']][0] ?? 'badge-info';
                  $status_text = $status_map[$r['status']][1] ?? htmlspecialchars($r['status']);
                ?>
                <span class="badge <?= $status_class ?>"><?= $status_text ?></span>
              </td>
              <td>
                <button class="btn btn-sm btn-secondary" onclick="alert('Détails: ' + '<?= addslashes($r['site_name']) ?>')">
                  Voir
                </button>
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