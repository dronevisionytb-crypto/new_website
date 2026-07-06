<section class="page-header">
  <h1>Nouvelle demande</h1>
  <p>Remplissez les informations pour créer une demande de mission.</p>
</section>

<form class="form-card" method="post" action="/index.php?page=new_request_submit">

  <h2>Informations sur le site</h2>

  <label>Nom du site *</label>
  <input type="text" name="site_name" required>

  <label>Adresse *</label>
  <input type="text" name="site_address" required>

  <label>Code postal *</label>
  <input type="text" name="site_postal_code" required>

  <label>Ville *</label>
  <input type="text" name="site_city" required>

  <label>Département *</label>
  <input type="text" name="site_department" required>

  <label>Coordonnées GPS</label>
  <input type="text" name="site_gps">

  <label>Puissance installée (MWc)</label>
  <input type="number" step="0.01" name="installed_power_mwc">

  <label>Type de centrale</label>
  <select name="plant_type">
    <option value="ombrière">Ombrière</option>
    <option value="toiture">Toiture</option>
    <option value="sol">Sol</option>
    <option value="autre">Autre</option>
  </select>

  <h2>Mission</h2>

  <label>Type de mission *</label>
  <input type="text" name="mission_type" required>

  <label>Objectif</label>
  <textarea name="mission_objective"></textarea>

  <label>Contexte / Problématique</label>
  <textarea name="mission_context"></textarea>

  <h2>Informations complémentaires</h2>

  <label>Période souhaitée *</label>
  <input type="text" name="desired_period" required>

  <label>Durée estimée</label>
  <input type="text" name="desired_duration">

  <label>Accès au site</label>
  <textarea name="site_access"></textarea>

  <label>Contraintes</label>
  <textarea name="constraints"></textarea>

  <label>Plan cadastral (URL)</label>
  <input type="text" name="cadastral_plan_url">

  <label>Contact client</label>
  <input type="text" name="client_contact">

  <button type="submit" class="btn-primary">Envoyer la demande ➤</button>

</form>
