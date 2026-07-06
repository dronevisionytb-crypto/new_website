<section class="page-header">
  <h1>Mes demandes</h1>
</section>

<table>
  <thead>
    <tr>
      <th>Site</th>
      <th>Type de mission</th>
      <th>Période souhaitée</th>
      <th>Statut</th>
      <th>Date</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($requests as $r): ?>
      <tr>
        <td><?= htmlspecialchars($r['site_name']) ?></td>
        <td><?= htmlspecialchars($r['mission_type']) ?></td>
        <td><?= htmlspecialchars($r['desired_period']) ?></td>
        <td><?= htmlspecialchars($r['status']) ?></td>
        <td><?= htmlspecialchars($r['created_at']) ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>