<?php
  $lat = isset($request['site_latitude']) && $request['site_latitude'] !== null ? (float)$request['site_latitude'] : null;
  $lng = isset($request['site_longitude']) && $request['site_longitude'] !== null ? (float)$request['site_longitude'] : null;
  $hasCoordinates = $lat !== null && $lng !== null;
  $fullAddress = trim((string)($request['site_address'] ?? '') . ' ' . ($request['site_postal_code'] ?? '') . ' ' . ($request['site_city'] ?? ''));
?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">

<div class="page-header">
  <h1>📍 Détail de la demande #<?= (int)$request['id'] ?></h1>
  <p>Visualisez l'intégralité du questionnaire et la localisation client</p>
</div>

<div style="margin-bottom: 16px;">
  <a href="/index.php?page=requests" class="btn btn-secondary">← Retour aux demandes</a>
</div>

<div class="card" style="margin-bottom: 20px;">
  <h2 style="margin: 0 0 14px 0; font-size: 18px; color: var(--gray-900);">Informations client</h2>
  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 10px; font-size: 14px;">
    <div><strong>Entreprise :</strong> <?= htmlspecialchars($request['company_name'] ?? '—') ?></div>
    <div><strong>Client :</strong> <?= htmlspecialchars($request['client_name'] ?? '—') ?></div>
    <div><strong>Email :</strong> <?= htmlspecialchars($request['client_email'] ?? '—') ?></div>
    <div><strong>Contact :</strong> <?= htmlspecialchars($request['client_contact'] ?? '—') ?></div>
    <div><strong>Statut :</strong> <?= htmlspecialchars($request['status'] ?? '—') ?></div>
    <div><strong>Date :</strong> <?= !empty($request['created_at']) ? htmlspecialchars(date('d/m/Y H:i', strtotime($request['created_at']))) : '—' ?></div>
  </div>
</div>

<div class="card" style="margin-bottom: 20px;">
  <h2 style="margin: 0 0 14px 0; font-size: 18px; color: var(--gray-900);">Localisation</h2>
  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 10px; margin-bottom: 14px;">
    <div><strong>Adresse :</strong> <?= htmlspecialchars($fullAddress !== '' ? $fullAddress : '—') ?></div>
    <div><strong>GPS (texte) :</strong> <?= htmlspecialchars($request['site_gps'] ?? '—') ?></div>
    <div><strong>Latitude :</strong> <span id="gps-lat"><?= $hasCoordinates ? htmlspecialchars((string)$lat) : 'Coordonnées indisponibles' ?></span></div>
    <div><strong>Longitude :</strong> <span id="gps-lng"><?= $hasCoordinates ? htmlspecialchars((string)$lng) : 'Coordonnées indisponibles' ?></span></div>
  </div>

  <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 14px;">
    <button type="button" class="btn btn-secondary btn-sm" id="copy-gps-btn" <?= $hasCoordinates ? '' : 'disabled' ?>>
      Copier coordonnées GPS
    </button>
    <span id="copy-gps-feedback" style="font-size: 13px; color: var(--gray-600);"></span>
  </div>

  <?php if ($hasCoordinates): ?>
    <div id="admin-request-map" style="height: 320px; border-radius: var(--radius-md); border: 1px solid var(--gray-200);"></div>
  <?php else: ?>
    <div class="alert alert-info" style="margin: 0;">Coordonnées GPS indisponibles pour cette demande.</div>
  <?php endif; ?>
</div>

<div class="card">
  <h2 style="margin: 0 0 14px 0; font-size: 18px; color: var(--gray-900);">Réponses complètes du questionnaire</h2>
  <?php
    $sections = [
      'Informations du site' => [
        'Nom du site' => $request['site_name'] ?? null,
        'Adresse' => $request['site_address'] ?? null,
        'Code postal' => $request['site_postal_code'] ?? null,
        'Ville' => $request['site_city'] ?? null,
        'Département' => $request['site_department'] ?? null,
        'Puissance installée (MWc)' => $request['installed_power_mwc'] ?? null,
        'Type de centrale' => $request['plant_type'] ?? null,
        'Plan cadastral (URL)' => $request['cadastral_plan_url'] ?? null,
      ],
      'Mission' => [
        'Type de mission' => $request['mission_type'] ?? null,
        'Objectif' => $request['mission_objective'] ?? null,
        'Contexte / Problématique' => $request['mission_context'] ?? null,
      ],
      'Planification' => [
        'Période souhaitée' => $request['desired_period'] ?? null,
        'Durée estimée' => $request['desired_duration'] ?? null,
        'Accès au site' => $request['site_access'] ?? null,
        'Contraintes particulières' => $request['constraints'] ?? null,
      ],
    ];
  ?>

  <?php foreach ($sections as $sectionTitle => $fields): ?>
    <div style="margin-bottom: 18px;">
      <h3 style="margin: 0 0 8px 0; font-size: 16px; color: var(--gray-800);"><?= htmlspecialchars($sectionTitle) ?></h3>
      <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 10px;">
        <?php foreach ($fields as $label => $value): ?>
          <div style="background: var(--gray-50); border: 1px solid var(--gray-200); border-radius: var(--radius-sm); padding: 10px 12px;">
            <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.4px; color: var(--gray-500); margin-bottom: 4px; font-weight: 600;">
              <?= htmlspecialchars($label) ?>
            </div>
            <div style="font-size: 14px; color: var(--gray-900); white-space: pre-wrap; word-break: break-word;">
              <?= htmlspecialchars($value !== null && $value !== '' ? (string)$value : '—') ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
  (function () {
    var hasCoordinates = <?= $hasCoordinates ? 'true' : 'false' ?>;
    var lat = <?= $hasCoordinates ? json_encode($lat) : 'null' ?>;
    var lng = <?= $hasCoordinates ? json_encode($lng) : 'null' ?>;
    var copyBtn = document.getElementById('copy-gps-btn');
    var feedback = document.getElementById('copy-gps-feedback');

    if (hasCoordinates) {
      var map = L.map('admin-request-map').setView([lat, lng], 16);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
      }).addTo(map);
      L.marker([lat, lng]).addTo(map);
    }

    function setFeedback(message, isSuccess) {
      feedback.textContent = message;
      feedback.style.color = isSuccess ? 'var(--success)' : 'var(--danger)';
    }

    if (copyBtn) {
      copyBtn.addEventListener('click', function () {
        var text = lat + ', ' + lng;
        if (!hasCoordinates) {
          setFeedback('Coordonnées indisponibles.', false);
          return;
        }
        if (navigator.clipboard && navigator.clipboard.writeText) {
          navigator.clipboard.writeText(text).then(function () {
            setFeedback('Coordonnées copiées ✅', true);
          }).catch(function () {
            setFeedback('Impossible de copier les coordonnées.', false);
          });
          return;
        }

        var ta = document.createElement('textarea');
        ta.value = text;
        ta.style.cssText = 'position:fixed;left:-9999px;top:-9999px';
        document.body.appendChild(ta);
        ta.focus();
        ta.select();
        try {
          document.execCommand('copy');
          setFeedback('Coordonnées copiées ✅', true);
        } catch (e) {
          setFeedback('Impossible de copier les coordonnées.', false);
        }
        document.body.removeChild(ta);
      });
    }
  })();
</script>
