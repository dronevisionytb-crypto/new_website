<div class="page-header">
  <h1>📋 Mes demandes</h1>
  <p>Suivi de toutes vos demandes d'inspection</p>
</div>

<div class="card">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h2 style="margin: 0; color: var(--gray-900); font-size: 18px; font-weight: 600;">
      Historique des demandes
    </h2>
    <a href="/index.php?page=new_request" class="btn btn-sm btn-primary">
      + Nouvelle demande
    </a>
  </div>

  <?php if (!empty($requests)): ?>
    <div class="table-container">
      <table>
        <thead>
          <tr>
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
            <tr>
              <td style="font-weight: 500; color: var(--blue-primary);"><?= htmlspecialchars($r['site_name']) ?></td>
              <td><?= htmlspecialchars($r['mission_type']) ?></td>
              <td><?= htmlspecialchars($r['desired_period']) ?></td>
              <td><?= date('d/m/Y', strtotime($r['created_at'])) ?></td>
              <td>
                <?php
                  $status_map = [
                    'pending' => ['badge-warning', '⏳ En attente'],
                    'approved' => ['badge-success', '✓ Approuvée'],
                    'rejected' => ['badge-danger', '✗ Rejetée'],
                    'completed' => ['badge-success', '✓ Complétée'],
                  ];
                  $status_class = $status_map[$r['status']][0] ?? 'badge-info';
                  $status_text = $status_map[$r['status']][1] ?? $r['status'];
                ?>
                <span class="badge <?= $status_class ?>"><?= $status_text ?></span>
              </td>
              <td>
                <button class="btn btn-sm btn-secondary" onclick="alert('Détail de: ' + '<?= addslashes($r['site_name']) ?>')">
                  Détails
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div style="padding: 40px; text-align: center;">
      <p style="color: var(--gray-500); font-size: 16px; margin-bottom: 20px;">
        📭 Aucune demande pour le moment
      </p>
      <a href="/index.php?page=new_request" class="btn btn-primary">
        Créer votre première demande
      </a>
    </div>
  <?php endif; ?>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; margin-top: 32px;">
  <div class="card">
    <div style="text-align: center;">
      <div style="font-size: 28px; margin-bottom: 12px;">📊</div>
      <h3 style="margin: 0 0 8px 0; color: var(--gray-900);">Total demandes</h3>
      <p style="margin: 0; font-size: 24px; font-weight: 700; color: var(--blue-primary);">
        <?= count($requests) ?>
      </p>
    </div>
  </div>

  <div class="card">
    <div style="text-align: center;">
      <div style="font-size: 28px; margin-bottom: 12px;">✓</div>
      <h3 style="margin: 0 0 8px 0; color: var(--gray-900);">Approuvées</h3>
      <p style="margin: 0; font-size: 24px; font-weight: 700; color: var(--success);">
        <?= count(array_filter($requests, fn($r) => $r['status'] === 'approved' || $r['status'] === 'completed')) ?>
      </p>
    </div>
  </div>

  <div class="card">
    <div style="text-align: center;">
      <div style="font-size: 28px; margin-bottom: 12px;">⏳</div>
      <h3 style="margin: 0 0 8px 0; color: var(--gray-900);">En attente</h3>
      <p style="margin: 0; font-size: 24px; font-weight: 700; color: var(--warning);">
        <?= count(array_filter($requests, fn($r) => $r['status'] === 'pending')) ?>
      </p>
    </div>
  </div>
</div>