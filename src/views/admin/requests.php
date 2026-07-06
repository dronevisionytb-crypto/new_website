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
              $detailId = 'detail-' . (int)$r['id'];
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
                <button class="btn btn-sm btn-secondary"
                        style="margin-left: 6px; font-size: 12px;"
                        onclick="toggleDetail('<?= $detailId ?>', this)">
                  Détails ▼
                </button>
              </td>
            </tr>
            <tr id="<?= $detailId ?>" style="display: none; background: var(--gray-50, #f8f9fa);">
              <td colspan="8" style="padding: 16px 20px;">
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 10px; font-size: 13px;">
                  <?php
                    $fields = [
                      'Nom du site'     => $r['site_name'],
                      'Adresse'         => $r['site_address'],
                      'Code postal'     => $r['site_postal_code'],
                      'Ville'           => $r['site_city'],
                      'Département'     => $r['site_department'],
                      'GPS'             => $r['site_gps'] ?? '',
                      'Type de mission' => $r['mission_type'],
                      'Période souhaitée' => $r['desired_period'] ?? '',
                      'Contact client'  => $r['client_contact'] ?? '',
                    ];
                  ?>
                  <?php foreach ($fields as $label => $value): ?>
                    <div style="display: flex; align-items: center; gap: 8px; background: #fff; border: 1px solid var(--gray-200, #e5e7eb); border-radius: 6px; padding: 8px 12px;">
                      <div style="flex: 1; overflow: hidden;">
                        <div style="font-weight: 600; color: var(--gray-600); font-size: 11px; text-transform: uppercase; letter-spacing: .4px; margin-bottom: 2px;"><?= htmlspecialchars($label) ?></div>
                        <div style="color: var(--gray-900); word-break: break-all;"><?= htmlspecialchars($value ?: '—') ?></div>
                      </div>
                      <?php if ($value !== '' && $value !== null): ?>
                        <button class="btn-copy"
                                data-value="<?= htmlspecialchars($value, ENT_QUOTES) ?>"
                                title="Copier"
                                style="flex-shrink: 0; background: none; border: 1px solid var(--gray-300, #d1d5db); border-radius: 4px; padding: 4px 8px; cursor: pointer; font-size: 12px; color: var(--gray-600);">
                          📋
                        </button>
                      <?php endif; ?>
                    </div>
                  <?php endforeach; ?>
                </div>
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

<script>
function toggleDetail(id, btn) {
  var row = document.getElementById(id);
  if (!row) return;
  var open = row.style.display !== 'none';
  row.style.display = open ? 'none' : 'table-row';
  btn.textContent = open ? 'Détails ▼' : 'Détails ▲';
}

function copyToClipboard(text, btn) {
  var prev = btn.textContent;
  if (navigator.clipboard && navigator.clipboard.writeText) {
    navigator.clipboard.writeText(text).then(function () {
      showCopied(btn, prev);
    }).catch(function () {
      fallbackCopy(text, btn, prev);
    });
  } else {
    fallbackCopy(text, btn, prev);
  }
}

function fallbackCopy(text, btn, prev) {
  var ta = document.createElement('textarea');
  ta.value = text;
  ta.style.cssText = 'position:fixed;left:-9999px;top:-9999px';
  document.body.appendChild(ta);
  ta.focus();
  ta.select();
  try { document.execCommand('copy'); showCopied(btn, prev); } catch (e) {}
  document.body.removeChild(ta);
}

function showCopied(btn, prev) {
  btn.textContent = '✓ Copié';
  btn.style.color = 'var(--success, green)';
  btn.style.borderColor = 'var(--success, green)';
  setTimeout(function () {
    btn.textContent = prev;
    btn.style.color = '';
    btn.style.borderColor = '';
  }, 1500);
}

document.addEventListener('click', function (e) {
  if (e.target && e.target.classList.contains('btn-copy')) {
    copyToClipboard(e.target.dataset.value, e.target);
  }
});
</script>