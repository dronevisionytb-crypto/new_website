<section class="page-header">
  <h1>Demandes reçues</h1>
</section>

<table>
  <thead>
    <tr>
      <th>Entreprise</th>
      <th>Site</th>
      <th>Type</th>
      <th>Statut</th>
      <th>Résumé</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($requests as $r): ?>
      <?php
        $summary = "Site: {$r['site_name']} - {$r['installed_power_mwc']} MWc - {$r['mission_type']} - Période: {$r['desired_period']}";
      ?>
      <tr>
        <td><?= htmlspecialchars($r['company_name']) ?></td>
        <td><?= htmlspecialchars($r['site_name']) ?></td>
        <td><?= htmlspecialchars($r['mission_type']) ?></td>
        <td><?= htmlspecialchars($r['status']) ?></td>
        <td>
          <button type="button"
                  onclick="copySummary('<?= addslashes($summary) ?>')">
            Copier
          </button>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
