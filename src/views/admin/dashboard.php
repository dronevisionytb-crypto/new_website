<section class="page-header">
  <h1>Accueil admin</h1>
  <p>Vue globale des demandes.</p>
</section>

<section class="cards">
  <div class="card">
    <h2>Demandes non traitées</h2>
    <p class="big-number"><?= (int)$countNew ?></p>
  </div>
  <div class="card">
    <h2>Demandes en étude</h2>
    <p class="big-number"><?= (int)$countStudy ?></p>
  </div>
</section>

<section>
  <h2>Dernières demandes</h2>
  <table>
    <thead>
      <tr>
        <th>Entreprise</th>
        <th>Site</th>
        <th>Type</th>
        <th>Statut</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($requests as $r): ?>
        <tr>
          <td><?= htmlspecialchars($r['company_id']) ?></td>
          <td><?= htmlspecialchars($r['site_name']) ?></td>
          <td><?= htmlspecialchars($r['mission_type']) ?></td>
          <td><?= htmlspecialchars($r['status']) ?></td>
          <td><?= htmlspecialchars($r['created_at']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</section>
