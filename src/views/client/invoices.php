<section class="page-header">
  <h1>Factures</h1>
  <p>Factures liées à vos missions.</p>
</section>

<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Montant HT</th>
      <th>Montant TTC</th>
      <th>Statut</th>
      <th>Fichier</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($invoices as $inv): ?>
      <tr>
        <td>#<?= (int)$inv['id'] ?></td>
        <td><?= $inv['amount_ht'] !== null ? number_format($inv['amount_ht'], 2, ',', ' ') . ' €' : '-' ?></td>
        <td><?= $inv['amount_ttc'] !== null ? number_format($inv['amount_ttc'], 2, ',', ' ') . ' €' : '-' ?></td>
        <td><?= htmlspecialchars($inv['status']) ?></td>
        <td>
          <?php if (!empty($inv['file_path'])): ?>
            <a href="<?= htmlspecialchars($inv['file_path']) ?>" target="_blank" class="btn-icon">👁️</a>
            <a href="<?= htmlspecialchars($inv['file_path']) ?>" download class="btn-icon">⬇️</a>
          <?php else: ?>
            <span class="muted">Aucun fichier</span>
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
