<div class="page-header">
  <h1>📊 Tableau de bord Administrateur</h1>
  <p>Vue d'ensemble de votre plateforme Drone Vision</p>
</div>

<div class="card-grid">
  <div class="stat-card">
    <div class="stat-label">Demandes totales</div>
    <div class="stat-number">24</div>
    <div class="stat-change positive">↑ 12% ce mois</div>
  </div>

  <div class="stat-card">
    <div class="stat-label">Entreprises</div>
    <div class="stat-number">8</div>
    <div class="stat-change positive">↑ 2 nouvelles</div>
  </div>

  <div class="stat-card">
    <div class="stat-label">Utilisateurs actifs</div>
    <div class="stat-number">15</div>
    <div class="stat-change">→ Stable</div>
  </div>

  <div class="stat-card">
    <div class="stat-label">Revenus</div>
    <div class="stat-number">€12.5K</div>
    <div class="stat-change positive">↑ 8% ce mois</div>
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
          <th>Date</th>
          <th>Statut</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>#DR-001</td>
          <td>Acme Corp</td>
          <td>12 déc 2025</td>
          <td><span class="badge badge-success">Approuvée</span></td>
          <td>
            <button class="btn btn-sm btn-secondary">Voir</button>
          </td>
        </tr>
        <tr>
          <td>#DR-002</td>
          <td>Tech Solutions</td>
          <td>11 déc 2025</td>
          <td><span class="badge badge-warning">En attente</span></td>
          <td>
            <button class="btn btn-sm btn-secondary">Voir</button>
          </td>
        </tr>
        <tr>
          <td>#DR-003</td>
          <td>Green Industries</td>
          <td>10 déc 2025</td>
          <td><span class="badge badge-success">Approuvée</span></td>
          <td>
            <button class="btn btn-sm btn-secondary">Voir</button>
          </td>
        </tr>
        <tr>
          <td>#DR-004</td>
          <td>BuildCo</td>
          <td>9 déc 2025</td>
          <td><span class="badge badge-danger">Rejetée</span></td>
          <td>
            <button class="btn btn-sm btn-secondary">Voir</button>
          </td>
        </tr>
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
      <a href="/index.php?page=users_create" class="btn btn-primary btn-block">
        + Ajouter un utilisateur
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
      📈 Performance
    </h3>
    <div style="display: flex; flex-direction: column; gap: 12px; font-size: 14px;">
      <div style="display: flex; justify-content: space-between;">
        <span>Taux de complétion</span>
        <strong style="color: var(--blue-primary);">92%</strong>
      </div>
      <div style="display: flex; justify-content: space-between;">
        <span>Temps moyen</span>
        <strong style="color: var(--blue-primary);">2.3 jours</strong>
      </div>
      <div style="display: flex; justify-content: space-between;">
        <span>Satisfaction client</span>
        <strong style="color: var(--success);">4.8/5.0 ⭐</strong>
      </div>
    </div>
  </div>
</div>