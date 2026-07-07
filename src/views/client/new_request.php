<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">

<div class="page-header">
  <h1>✈️ Nouvelle demande d'inspection</h1>
  <p>Créez une nouvelle demande de mission aérienne</p>
</div>

<?php if (($error ?? null) === 'csrf_invalid'): ?>
  <div class="alert alert-error">Session expirée. Merci de recharger la page puis de réessayer.</div>
<?php elseif (($error ?? null) === 'missing_required_fields'): ?>
  <div class="alert alert-error">Veuillez remplir tous les champs obligatoires du formulaire.</div>
<?php endif; ?>

<div class="card form-card">
  <form method="post" action="/index.php?page=new_request_submit">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken ?? '') ?>">
    
    <!-- Section 1: Informations du site -->
    <div style="margin-bottom: 32px;">
      <h2 style="margin: 0 0 20px 0; color: var(--gray-900); font-size: 20px; font-weight: 600; padding-bottom: 12px; border-bottom: 2px solid var(--blue-light);">
        📍 Informations du site
      </h2>
      
      <div class="form-row">
        <div class="form-group">
          <label for="site_name">Nom du site *</label>
          <input type="text" id="site_name" name="site_name" placeholder="Ex: Centrale Solaire XYZ" required>
        </div>
        <div class="form-group">
          <label for="installed_power">Puissance installée (MWc)</label>
          <input type="number" id="installed_power" name="installed_power_mwc" placeholder="10.5" step="0.01">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="site_address">Adresse *</label>
          <input type="text" id="site_address" name="site_address" placeholder="Rue, avenue..." required>
        </div>
        <div class="form-group">
          <label for="plant_type">Type de centrale</label>
          <select id="plant_type" name="plant_type">
            <option value="">-- Sélectionner --</option>
            <option value="ombrière">Ombrière</option>
            <option value="toiture">Toiture</option>
            <option value="sol">Sol</option>
            <option value="autre">Autre</option>
          </select>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="site_postal">Code postal *</label>
          <input type="text" id="site_postal" name="site_postal_code" placeholder="75000" required>
        </div>
        <div class="form-group">
          <label for="site_city">Ville *</label>
          <input type="text" id="site_city" name="site_city" placeholder="Paris" required>
        </div>
        <div class="form-group">
          <label for="site_dept">Département *</label>
          <input type="text" id="site_dept" name="site_department" placeholder="75" required>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="site_gps">Coordonnées GPS</label>
          <input type="text" id="site_gps" name="site_gps" placeholder="48.8566, 2.3522" readonly>
        </div>
        <div class="form-group">
          <label for="cadastral">Plan cadastral (URL)</label>
          <input type="text" id="cadastral" name="cadastral_plan_url" placeholder="https://...">
        </div>
      </div>

      <div style="margin-bottom: 16px;">
        <button type="button" class="btn btn-secondary btn-sm" id="geocode-address-btn">Géocoder l'adresse</button>
        <span id="geocode-feedback" style="margin-left: 10px; font-size: 13px; color: var(--gray-600);"></span>
      </div>

      <div id="request-map" style="height: 320px; border-radius: var(--radius-md); border: 1px solid var(--gray-200); margin-bottom: 14px;"></div>

      <div class="form-row">
        <div class="form-group">
          <label for="site_latitude">Latitude</label>
          <input type="text" id="site_latitude" name="site_latitude" placeholder="48.8566" readonly>
        </div>
        <div class="form-group">
          <label for="site_longitude">Longitude</label>
          <input type="text" id="site_longitude" name="site_longitude" placeholder="2.3522" readonly>
        </div>
      </div>
    </div>

    <!-- Section 2: Détails de la mission -->
    <div style="margin-bottom: 32px;">
      <h2 style="margin: 0 0 20px 0; color: var(--gray-900); font-size: 20px; font-weight: 600; padding-bottom: 12px; border-bottom: 2px solid var(--blue-light);">
        🎯 Détails de la mission
      </h2>
      
      <div class="form-group">
        <label for="mission_type">Type de mission *</label>
        <input type="text" id="mission_type" name="mission_type" placeholder="Ex: Inspection thermique, Relevé 3D..." required>
      </div>

      <div class="form-group">
        <label for="mission_obj">Objectif</label>
        <textarea id="mission_obj" name="mission_objective" placeholder="Décrivez l'objectif principal de cette mission..."></textarea>
      </div>

      <div class="form-group">
        <label for="mission_ctx">Contexte / Problématique</label>
        <textarea id="mission_ctx" name="mission_context" placeholder="Décrivez le contexte, les enjeux..."></textarea>
      </div>
    </div>

    <!-- Section 3: Planification -->
    <div style="margin-bottom: 32px;">
      <h2 style="margin: 0 0 20px 0; color: var(--gray-900); font-size: 20px; font-weight: 600; padding-bottom: 12px; border-bottom: 2px solid var(--blue-light);">
        📅 Planification
      </h2>
      
      <div class="form-row">
        <div class="form-group">
          <label for="period">Période souhaitée *</label>
          <input type="text" id="period" name="desired_period" placeholder="Ex: Janvier 2026" required>
        </div>
        <div class="form-group">
          <label for="duration">Durée estimée</label>
          <input type="text" id="duration" name="desired_duration" placeholder="Ex: 2-3 jours">
        </div>
      </div>

      <div class="form-group">
        <label for="access">Accès au site</label>
        <textarea id="access" name="site_access" placeholder="Décrivez les conditions d'accès au site..."></textarea>
      </div>

      <div class="form-group">
        <label for="constraints">Contraintes particulières</label>
        <textarea id="constraints" name="constraints" placeholder="Restrictions, horaires, conditions météo..."></textarea>
      </div>
    </div>

    <!-- Section 4: Contact -->
    <div style="margin-bottom: 32px;">
      <h2 style="margin: 0 0 20px 0; color: var(--gray-900); font-size: 20px; font-weight: 600; padding-bottom: 12px; border-bottom: 2px solid var(--blue-light);">
        📞 Contact
      </h2>
      
      <div class="form-group">
        <label for="contact">Contact client</label>
        <input type="text" id="contact" name="client_contact" placeholder="Nom et numéro de téléphone">
      </div>
    </div>

    <!-- Actions -->
    <div style="display: flex; gap: 12px; justify-content: flex-end;">
      <a href="/index.php?page=dashboard" class="btn btn-secondary">
        Annuler
      </a>
      <button type="submit" class="btn btn-primary btn-lg">
        ✓ Envoyer la demande
      </button>
    </div>

  </form>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
  (function () {
    var addressInput = document.getElementById('site_address');
    var postalInput = document.getElementById('site_postal');
    var cityInput = document.getElementById('site_city');
    var departmentInput = document.getElementById('site_dept');
    var gpsInput = document.getElementById('site_gps');
    var latInput = document.getElementById('site_latitude');
    var lngInput = document.getElementById('site_longitude');
    var geocodeButton = document.getElementById('geocode-address-btn');
    var geocodeFeedback = document.getElementById('geocode-feedback');
    var geocodeTimeoutId = null;
    var GEOCODE_TIMEOUT_MS = 8000;

    var map = L.map('request-map').setView([46.603354, 1.888334], 6);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var marker = L.marker([46.603354, 1.888334], {draggable: true}).addTo(map);

    function updatePositionFields(lat, lng) {
      var latValue = Number(lat).toFixed(7);
      var lngValue = Number(lng).toFixed(7);
      latInput.value = latValue;
      lngInput.value = lngValue;
      gpsInput.value = Number(lat).toFixed(6) + ', ' + Number(lng).toFixed(6);
    }

    function setFeedback(message, success) {
      geocodeFeedback.textContent = message;
      geocodeFeedback.style.color = success ? 'var(--success)' : 'var(--danger)';
    }

    function setMarker(lat, lng, centerMap) {
      marker.setLatLng([lat, lng]);
      if (centerMap) {
        map.setView([lat, lng], 16);
      }
      updatePositionFields(lat, lng);
      setFeedback('Position sélectionnée mise à jour.', true);
    }

    function buildAddress() {
      return [
        addressInput.value.trim(),
        postalInput.value.trim(),
        cityInput.value.trim(),
        departmentInput.value.trim()
      ].filter(Boolean).join(', ');
    }

    function canAutoGeocode() {
      return addressInput.value.trim() !== '' && postalInput.value.trim() !== '' && cityInput.value.trim() !== '';
    }

    async function geocodeAddress() {
      var query = buildAddress();
      if (!query) {
        setFeedback('Veuillez saisir une adresse avant de géocoder.', false);
        return;
      }

      geocodeButton.disabled = true;
      geocodeButton.textContent = 'Géocodage...';
      setFeedback('Recherche de la position...', true);

      var controller = new AbortController();
      var abortTimeoutId = setTimeout(function () { controller.abort(); }, GEOCODE_TIMEOUT_MS);

      try {
        var response = await fetch('https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' + encodeURIComponent(query), {
          signal: controller.signal,
          headers: { 'Accept': 'application/json' }
        });
        if (!response.ok) {
          throw new Error('HTTP ' + response.status);
        }
        var results = await response.json();
        if (!results || !results.length) {
          setFeedback('Aucun résultat trouvé pour cette adresse.', false);
          return;
        }
        var resultLat = parseFloat(results[0].lat);
        var resultLng = parseFloat(results[0].lon);
        setMarker(resultLat, resultLng, true);
      } catch (error) {
        setFeedback('Échec du géocodage (réseau, délai dépassé ou service indisponible).', false);
      } finally {
        clearTimeout(abortTimeoutId);
        geocodeButton.disabled = false;
        geocodeButton.textContent = 'Géocoder l\'adresse';
      }
    }

    marker.on('dragend', function (event) {
      var pos = event.target.getLatLng();
      setMarker(pos.lat, pos.lng, false);
    });

    map.on('click', function (event) {
      setMarker(event.latlng.lat, event.latlng.lng, false);
    });

    geocodeButton.addEventListener('click', function () {
      geocodeAddress();
    });

    [addressInput, postalInput, cityInput, departmentInput].forEach(function (input) {
      input.addEventListener('change', function () {
        clearTimeout(geocodeTimeoutId);
        geocodeTimeoutId = setTimeout(function () {
          if (canAutoGeocode()) {
            geocodeAddress();
          }
        }, 600);
      });
    });
  })();
</script>