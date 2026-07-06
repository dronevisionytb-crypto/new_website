<div class="page-header">
  <h1>🚁 Mon Tableau de Bord</h1>
  <p>Gestion de vos inspections aériennes</p>
</div>

<div class="card-grid">
  <div class="stat-card">
    <div class="stat-label">Demandes en cours</div>
    <div class="stat-number">3</div>
    <div class="stat-change">→ Suivi actif</div>
  </div>

  <div class="stat-card">
    <div class="stat-label">Inspections complétées</div>
    <div class="stat-number">12</div>
    <div class="stat-change positive">↑ 2 ce mois</div>
  </div>

  <div class="stat-card">
    <div class="stat-label">Documents disponibles</div>
    <div class="stat-number">8</div>
    <div class="stat-change">Dernier : 2 jours</div>
  </div>

  <div class="stat-card">
    <div class="stat-label">Factures impayées</div>
    <div class="stat-number">€2.4K</div>
    <div class="stat-change warning">⚠ À régulariser</div>
  </div>
</div>

<div class="card">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h2 style="margin: 0; color: var(--gray-900); font-size: 18px; font-weight: 600;">
      Mes demandes récentes
    </h2>
    <a href="/index.php?page=new_request" class="btn btn-sm btn-primary">
      + Nouvelle demande
    </a>
  </div>

  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>Référence</th>
          <th>Type d'inspection</th>
          <th>Date</th>
          <th>Statut</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>#REQ-2025-001</td>
          <td>Inspection toiture</td>
          <td>12 déc 2025</td>
          <td><span class="badge badge-success">Complétée</span></td>
          <td>
            <button class="btn btn-sm btn-secondary">Détails</button>
          </td>
        </tr>
        <tr>
          <td>#REQ-2025-002</td>
          <td>Relevé 3D site</td>
          <td>10 déc 2025</td>
          <td><span class="badge badge-warning">En cours</span></td>
          <td>
            <button class="btn btn-sm btn-secondary">Détails</button>
          </td>
        </tr>
        <tr>
          <td>#REQ-2025-003</td>
          <td>Inspection éolienne</td>
          <td>8 déc 2025</td>
          <td><span class="badge badge-info">Programmée</span></td>
          <td>
            <button class="btn btn-sm btn-secondary">Détails</button>
          </td>
        </tr>
        <tr>
          <td>#REQ-2025-004</td>
          <td>Thermographie infra-rouge</td>
          <td>5 déc 2025</td>
          <td><span class="badge badge-success">Complétée</span></td>
          <td>
            <button class="btn btn-sm btn-secondary">Détails</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; margin-top: 32px;">
  <div class="card">
    <h3 style="margin: 0 0 16px 0; color: var(--gray-900); font-size: 16px; font-weight: 600;">
      Accès rapide
    </h3>
    <div style="display: flex; flex-direction: column; gap: 12px;">
      <a href="/index.php?page=new_request" class="btn btn-primary btn-block">
        + Créer une demande
      </a>
      <a href="/index.php?page=my_requests" class="btn btn-secondary btn-block">
        Voir toutes mes demandes
      </a>
      <a href="/index.php?page=documents" class="btn btn-secondary btn-block">
        Télécharger mes documents
      </a>
    </div>
  </div>

  <div class="card">
    <h3 style="margin: 0 0 16px 0; color: var(--gray-900); font-size: 16px; font-weight: 600;">
      📋 Mes factures
    </h3>
    <div style="display: flex; flex-direction: column; gap: 12px; font-size: 14px;">
      <div style="display: flex; justify-content: space-between;">
        <span>Factures payées</span>
        <strong style="color: var(--success);">10</strong>
      </div>
      <div style="display: flex; justify-content: space-between;">
        <span>En attente de paiement</span>
        <strong style="color: var(--warning);">1</strong>
      </div>
      <a href="/index.php?page=invoices" class="btn btn-outline btn-sm" style="text-align: center; margin-top: 8px;">
        Voir les factures
      </a>
    </div>
  </div>
</div>