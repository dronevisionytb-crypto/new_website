<div class="page-header">
  <h1>📊 Tableau de bord Administrateur</h1>
  <p>Vue d'ensemble de votre plateforme Drone Vision</p>
</div>

<div class="card-grid">
  <div class="stat-card">
    <div class="stat-label">Demandes totales</div>
    <div class="stat-number"><?= (int)$countRequests ?></div>
  </div>

  <div class="stat-card">
    <div class="stat-label">Entreprises</div>
    <div class="stat-number"><?= (int)$countCompanies ?></div>
  </div>

  <div class="stat-card">
    <div class="stat-label">Utilisateurs clients</div>
    <div class="stat-number"><?= (int)$countUsers ?></div>
  </div>

  <div class="stat-card">
    <div class="stat-label">En étude</div>
    <div class="stat-number" style="color: var(--info);"><?= (int)$countStudy ?></div>
  </div>
</div>

<div class="card">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h2 style="margin: 0; color: var(--gray-900); font-size: 18px; font-weight: 600;">
      Demandes récentes
    </h2>
    <a href="/index.php?page=requests" class="btn btn-sm btn-primary">
      Voir tous
    </a>
  </div>

  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Entreprise</th>
          <th>Site</th>
          <th>Date</th>
          <th>Statut</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($requests)): ?>
          <?php
            $status_map = [
              'envoyée'         => ['badge-warning', '📨 Envoyée'],
              'en_etude'        => ['badge-info',    '🔎 En étude'],
              'facture_envoyée' => ['badge-primary',  '🧾 Facture envoyée'],
              'terminée'        => ['badge-success',  '✅ Terminée'],
            ];
          ?>
          <?php foreach ($requests as $r): ?>
            <?php
              $sc = $status_map[$r['status']][0] ?? 'badge-info';
              $st = $status_map[$r['status']][1] ?? htmlspecialchars($r['status']);
            ?>
            <tr>
              <td>#<?= (int)$r['id'] ?></td>
              <td><?= htmlspecialchars($r['company_name'] ?? '—') ?></td>
              <td><?= htmlspecialchars($r['site_name']) ?></td>
              <td><?= date('d/m/Y', strtotime($r['created_at'])) ?></td>
              <td><span class="badge <?= $sc ?>"><?= $st ?></span></td>
              <td>
                <a href="/index.php?page=requests" class="btn btn-sm btn-secondary">Voir</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" style="text-align: center; color: var(--gray-500); padding: 24px;">
              📭 Aucune demande pour le moment
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; margin-top: 32px;">
  <div class="card">
    <h3 style="margin: 0 0 16px 0; color: var(--gray-900); font-size: 16px; font-weight: 600;">
      Gestion rapide
    </h3>
    <div style="display: flex; flex-direction: column; gap: 12px;">
      <a href="/index.php?page=companies" class="btn btn-primary btn-block">
        + Ajouter une entreprise / un compte
      </a>
      <a href="/index.php?page=companies" class="btn btn-secondary btn-block">
        Gérer les entreprises
      </a>
      <a href="/index.php?page=requests" class="btn btn-secondary btn-block">
        Voir toutes les demandes
      </a>
    </div>
  </div>

  <div class="card">
    <h3 style="margin: 0 0 16px 0; color: var(--gray-900); font-size: 16px; font-weight: 600;">
      📈 Suivi des statuts
    </h3>
    <div style="display: flex; flex-direction: column; gap: 12px; font-size: 14px;">
      <div style="display: flex; justify-content: space-between;">
        <span>📨 Envoyées</span>
        <strong style="color: var(--warning);"><?= (int)$countNew ?></strong>
      </div>
      <div style="display: flex; justify-content: space-between;">
        <span>🔎 En étude</span>
        <strong style="color: var(--info);"><?= (int)$countStudy ?></strong>
      </div>
    </div>
  </div>
</div>