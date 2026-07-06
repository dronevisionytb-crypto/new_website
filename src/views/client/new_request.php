<div class="page-header">
  <h1>✈️ Nouvelle demande d'inspection</h1>
  <p>Créez une nouvelle demande de mission aérienne</p>
</div>

<div class="card form-card">
  <form method="post" action="/index.php?page=new_request_submit">
    
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
          <input type="text" id="site_gps" name="site_gps" placeholder="48.8566, 2.3522">
        </div>
        <div class="form-group">
          <label for="cadastral">Plan cadastral (URL)</label>
          <input type="text" id="cadastral" name="cadastral_plan_url" placeholder="https://...">
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