<?php
$statusMessages = [
  'company_created' => ['success', "Entreprise créée avec succès."],
  'user_created' => ['success', "Compte créé avec succès."],
  'user_deleted' => ['success', "Compte supprimé avec succès."],
];

$errorMessages = [
  'company_name_required' => "Le nom de l'entreprise est obligatoire.",
  'company_create_failed' => "Impossible de créer l'entreprise.",
  'company_required' => "Veuillez sélectionner une entreprise.",
  'user_fields_required' => "Nom, email et mot de passe sont obligatoires.",
  'invalid_email' => "L'adresse email du compte est invalide.",
  'password_too_short' => "Le mot de passe doit contenir au moins 8 caractères.",
  'csrf_invalid' => "Votre session a expiré. Rechargez la page puis réessayez.",
  'user_create_failed' => "Impossible de créer le compte (email déjà utilisé ou données invalides).",
  'invalid_user_delete' => "Suppression impossible : données invalides.",
];
?>

<div class="page-header">
  <h1>🏢 Gestion des entreprises</h1>
  <p>Créez une entreprise puis gérez ses comptes depuis cette même page</p>
</div>

<?php if (!empty($status) && isset($statusMessages[$status])): ?>
  <div class="alert alert-<?= $statusMessages[$status][0] ?>" style="margin-bottom: 20px;">
    <strong>Succès :</strong> <?= htmlspecialchars($statusMessages[$status][1]) ?>
  </div>
<?php endif; ?>

<?php if (!empty($error) && isset($errorMessages[$error])): ?>
  <div class="alert alert-error" style="margin-bottom: 20px;">
    <strong>Erreur :</strong> <?= htmlspecialchars($errorMessages[$error]) ?>
  </div>
<?php endif; ?>

<div class="card form-card" style="margin-bottom: 24px;">
  <h2 style="margin: 0 0 24px 0; color: var(--blue-primary); font-size: 20px; font-weight: 600; padding-bottom: 12px; border-bottom: 2px solid var(--blue-light);">
    ➕ Créer une nouvelle entreprise
  </h2>

  <form method="post" action="/index.php?page=companies_create">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken ?? '') ?>">
    <div class="form-row">
      <div class="form-group">
        <label for="name">Nom de l'entreprise *</label>
        <input type="text" id="name" name="name" placeholder="ACME Corporation" required>
      </div>
      <div class="form-group">
        <label for="siret">SIRET</label>
        <input type="text" id="siret" name="siret" placeholder="123 456 789 00123">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label for="address">Adresse</label>
        <input type="text" id="address" name="address" placeholder="123 Rue de la Paix">
      </div>
      <div class="form-group">
        <label for="postal">Code postal</label>
        <input type="text" id="postal" name="postal_code" placeholder="75000">
      </div>
      <div class="form-group">
        <label for="city">Ville</label>
        <input type="text" id="city" name="city" placeholder="Paris">
      </div>
    </div>

    <div class="form-group">
      <label for="dept">Département</label>
      <input type="text" id="dept" name="department" placeholder="75">
    </div>

    <div style="border-top: 2px solid var(--blue-light); padding-top: 20px; margin: 20px 0;">
      <h3 style="margin: 0 0 16px 0; color: var(--gray-900); font-size: 16px; font-weight: 600;">
        Contact principal
      </h3>

      <div class="form-row">
        <div class="form-group">
          <label for="contact_name">Nom du contact</label>
          <input type="text" id="contact_name" name="contact_name" placeholder="Jean Dupont">
        </div>
        <div class="form-group">
          <label for="contact_email">Email</label>
          <input type="email" id="contact_email" name="contact_email" placeholder="contact@acme.fr">
        </div>
        <div class="form-group">
          <label for="contact_phone">Téléphone</label>
          <input type="text" id="contact_phone" name="contact_phone" placeholder="+33 1 23 45 67 89">
        </div>
      </div>
    </div>

    <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 24px;">
      <button type="reset" class="btn btn-secondary">Réinitialiser</button>
      <button type="submit" class="btn btn-primary btn-lg">✓ Créer l'entreprise</button>
    </div>
  </form>
</div>

<div class="card" style="margin-bottom: 24px;">
  <h2 style="margin: 0 0 24px 0; color: var(--gray-900); font-size: 18px; font-weight: 600;">
    Liste des entreprises (<?= count($companies ?? []) ?>)
  </h2>

  <?php if (!empty($companies)): ?>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Nom</th>
            <th>Ville</th>
            <th>SIRET</th>
            <th>Contact</th>
            <th>Email</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($companies as $c): ?>
            <?php $isSelected = !empty($selectedCompanyId) && (int)$selectedCompanyId === (int)$c['id']; ?>
            <tr style="<?= $isSelected ? 'background: var(--blue-light);' : '' ?>">
              <td style="font-weight: 600; color: var(--blue-primary);">
                <?= htmlspecialchars($c['name']) ?>
              </td>
              <td><?= htmlspecialchars($c['city'] ?? '-') ?></td>
              <td><?= htmlspecialchars($c['siret'] ?? '-') ?></td>
              <td><?= htmlspecialchars($c['contact_name'] ?? '-') ?></td>
              <td style="font-size: 13px; color: var(--gray-600);">
                <?= htmlspecialchars($c['contact_email'] ?? '-') ?>
              </td>
              <td style="display: flex; gap: 8px; flex-wrap: wrap;">
                <a href="/index.php?page=companies&selected_company_id=<?= (int)$c['id'] ?>" class="btn btn-sm btn-primary">
                  <?= $isSelected ? 'Sélectionnée' : 'Voir comptes' ?>
                </a>
                <a href="/index.php?page=company_view&id=<?= (int)$c['id'] ?>" class="btn btn-sm btn-secondary">
                  Détails
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div style="padding: 40px; text-align: center;">
      <p style="color: var(--gray-500); font-size: 16px;">
        📭 Aucune entreprise pour le moment - Créez la première ci-dessus
      </p>
    </div>
  <?php endif; ?>
</div>

<div class="card">
  <?php if (!empty($selectedCompany)): ?>
    <h2 style="margin: 0 0 16px 0; color: var(--gray-900); font-size: 18px; font-weight: 600;">
      👥 Comptes de <?= htmlspecialchars($selectedCompany['name']) ?>
    </h2>
    <p style="margin-top: 0; color: var(--gray-600);">
      Mini-liste des comptes liés à l’entreprise sélectionnée.
    </p>

    <form method="post" action="/index.php?page=company_user_create" style="margin: 20px 0 28px 0; padding: 16px; border-radius: var(--radius-md); background: var(--gray-50); border: 1px solid var(--gray-200);">
      <input type="hidden" name="company_id" value="<?= (int)$selectedCompany['id'] ?>">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken ?? '') ?>">
      <div class="form-row">
        <div class="form-group">
          <label for="user_name">Nom *</label>
          <input type="text" id="user_name" name="name" required placeholder="Marie Martin">
        </div>
        <div class="form-group">
          <label for="user_email">Email *</label>
          <input type="email" id="user_email" name="email" required placeholder="marie@entreprise.fr">
        </div>
        <div class="form-group">
          <label for="user_password">Mot de passe *</label>
          <input type="password" id="user_password" name="password" minlength="8" required placeholder="••••••••">
        </div>
      </div>
      <div style="display: flex; justify-content: flex-end;">
        <button type="submit" class="btn btn-primary btn-sm">+ Créer un compte</button>
      </div>
    </form>

    <?php if (!empty($companyUsers)): ?>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Nom</th>
              <th>Email</th>
              <th>Rôle</th>
              <th>Créé le</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($companyUsers as $user): ?>
              <tr>
                <td style="font-weight: 600; color: var(--gray-900);"><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td>
                  <?php if ($user['role'] === 'admin'): ?>
                    <span class="badge badge-primary">Admin</span>
                  <?php else: ?>
                    <span class="badge badge-success">Client</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php
                    $createdAt = $user['created_at'] ?? null;
                    $formattedCreatedAt = '-';
                    if (!empty($createdAt)) {
                      $timestamp = strtotime($createdAt);
                      if ($timestamp !== false) {
                        $formattedCreatedAt = date('d/m/Y H:i', $timestamp);
                      }
                    }
                  ?>
                  <?= htmlspecialchars($formattedCreatedAt) ?>
                </td>
                <td>
                  <?php if ($user['role'] === 'admin'): ?>
                    <span style="color: var(--gray-400);">Protégé</span>
                  <?php else: ?>
                    <form method="post" action="/index.php?page=company_user_delete" onsubmit="return confirm('Supprimer ce compte ?');">
                      <input type="hidden" name="company_id" value="<?= (int)$selectedCompany['id'] ?>">
                      <input type="hidden" name="user_id" value="<?= (int)$user['id'] ?>">
                      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken ?? '') ?>">
                      <button type="submit" class="btn btn-sm btn-secondary">Supprimer</button>
                    </form>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div style="padding: 24px; text-align: center; background: var(--gray-50); border-radius: var(--radius-md);">
        <p style="margin: 0; color: var(--gray-500);">
          Aucun compte pour cette entreprise. Utilisez le formulaire ci-dessus pour en créer un.
        </p>
      </div>
    <?php endif; ?>
  <?php else: ?>
    <h2 style="margin: 0 0 12px 0; color: var(--gray-900); font-size: 18px; font-weight: 600;">
      👥 Comptes d’entreprise
    </h2>
    <div style="padding: 24px; text-align: center; background: var(--gray-50); border-radius: var(--radius-md);">
      <p style="margin: 0; color: var(--gray-500);">
        Sélectionnez une entreprise dans la liste ci-dessus pour afficher et gérer ses comptes.
      </p>
    </div>
  <?php endif; ?>
</div>
