<section class="page-header">
  <h1>Documents</h1>
  <p>Documents mis à disposition pour votre entreprise.</p>
</section>

<table>
  <thead>
    <tr>
      <th>Titre</th>
      <th>Signé</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($documents as $doc): ?>
      <tr>
        <td><?= htmlspecialchars($doc['title']) ?></td>
        <td><?= $doc['is_signed'] ? 'Oui' : 'Non' ?></td>
        <td>
          <a href="<?= htmlspecialchars($doc['file_path']) ?>" target="_blank" class="btn-icon">👁️</a>
          <a href="<?= htmlspecialchars($doc['file_path']) ?>" download class="btn-icon">⬇️</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
