<section class="page-header">
  <h1>Accueil</h1>
  <p>Bienvenue, <?= htmlspecialchars(currentUser()['name']) ?></p>
</section>

<section class="cards">
  <div class="card">
    <h2>Missions demandées</h2>
    <p class="big-number"><?= (int)$missions_count ?></p>
  </div>
</section>

<section class="documents-section">
  <h2>Documents importants</h2>
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
</section>
