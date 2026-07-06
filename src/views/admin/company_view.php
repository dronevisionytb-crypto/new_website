<section class="page-header">
  <h1><?= htmlspecialchars($company['name']) ?></h1>
  <p>Gestion de l’entreprise</p>
</section>

<div class="card">
  <h2>Informations</h2>
  <p><strong>Adresse :</strong> <?= htmlspecialchars($company['address']) ?></p>
  <p><strong>SIRET :</strong> <?= htmlspecialchars($company['siret']) ?></p>
  <p><strong>Contact :</strong> <?= htmlspecialchars($company['contact_name']) ?></p>
  <p><strong>Email :</strong> <?= htmlspecialchars($company['contact_email']) ?></p>
  <p><strong>Téléphone :</strong> <?= htmlspecialchars($company['contact_phone']) ?></p>
</div>

<div class="card">
  <h2>Employés</h2>

  <table>
    <thead>
      <tr>
        <th>Nom</th>
        <th>Email</th>
        <th>Téléphone</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($employees as $u): ?>
      <tr>
        <td><?= htmlspecialchars($u['name']) ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td><?= htmlspecialchars($u['phone']) ?></td>
        <td>
          <a href="/index.php?page=delete_user&id=<?= $u['id'] ?>" class="btn-primary">Supprimer</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <a href="/index.php?page=users_create&company_id=<?= $company['id'] ?>" class="btn-primary">Ajouter un employé</a>
</div>

<div class="card">
  <h2>Documents</h2>

  <table>
    <thead>
      <tr>
        <th>Titre</th>
        <th>Fichier</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($documents as $d): ?>
      <tr>
        <td><?= htmlspecialchars($d['title']) ?></td>
        <td><a href="<?= htmlspecialchars($d['file_path']) ?>" target="_blank">Voir</a></td>
        <td>
          <a href="/index.php?page=delete_document&id=<?= $d['id'] ?>" class="btn-primary">Supprimer</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <a href="/index.php?page=upload_document&company_id=<?= $company['id'] ?>" class="btn-primary">Ajouter un document</a>
</div>
