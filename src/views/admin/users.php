<div class="page-header">
  <h1>👥 Gestion des comptes utilisateurs</h1>
  <p>Créez et gérez les comptes des utilisateurs</p>
</div>

<div class="card form-card" style="margin-bottom: 40px;">
  <h2 style="margin: 0 0 24px 0; color: var(--blue-primary); font-size: 20px; font-weight: 600; padding-bottom: 12px; border-bottom: 2px solid var(--blue-light);">
    ➕ Créer un nouveau compte
  </h2>

  <form method="post" action="/index.php?page=users_create">
    <div class="form-row">
      <div class="form-group">
        <label for="name">Nom complet *</label>
        <input type="text" id="name" name="name" placeholder="Jean Dupont" required>
      </div>
      <div class="form-group">
        <label for="email">Email *</label>
        <input type="email" id="email" name="email" placeholder="jean@example.com" required>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label for="password">Mot de passe *</label>
        <input type="password" id="password" name="password" placeholder="••••••••" required>
      </div>
      <div class="form-group">
        <label for="role">Rôle *</label>
        <select id="role" name="role" required>
          <option value="">-- Sélectionner un rôle --</option>
          <option value="client">Client</option>
          <option value="admin">Administrateur</option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="company">Entreprise associée (optionnel pour admin)</label>
      <select id="company" name="company_id">
        <option value="">-- Aucune (Admin uniquement) --</option>
        <?php if (!empty($companies)): ?>
          <?php foreach ($companies as $c): ?>
            <option value="<?= (int)$c['id'] ?>">
              <?= htmlspecialchars($c['name']) ?>
            </option>
          <?php endforeach; ?>
        <?php endif; ?>
      </select>
    </div>

    <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 24px;">
      <button type="reset" class="btn btn-secondary">Réinitialiser</button>
      <button type="submit" class="btn btn-primary btn-lg">✓ Créer le compte</button>
    </div>
  </form>
</div>

<!-- Liste des utilisateurs -->
<div class="card">
  <h2 style="margin: 0 0 24px 0; color: var(--gray-900); font-size: 18px; font-weight: 600;">
    Liste des utilisateurs (<?= count($users ?? []) ?>)
  </h2>

  <?php if (!empty($users)): ?>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Entreprise</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $u): ?>
            <tr>
              <td style="font-weight: 600; color: var(--gray-900);">
                <?= htmlspecialchars($u['name']) ?>
              </td>
              <td style="font-size: 13px; color: var(--gray-600);">
                <?= htmlspecialchars($u['email']) ?>
              </td>
              <td>
                <?php if ($u['role'] === 'admin'): ?>
                  <span class="badge badge-primary">👤 Admin</span>
                <?php else: ?>
                  <span class="badge badge-success">🏢 Client</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if (!empty($u['company_name'])): ?>
                  <span style="color: var(--blue-primary); font-weight: 500;">
                    <?= htmlspecialchars($u['company_name']) ?>
                  </span>
                <?php else: ?>
                  <span style="color: var(--gray-400);">—</span>
                <?php endif; ?>
              </td>
              <td>
                <button class="btn btn-sm btn-secondary" onclick="alert('Détails utilisateur: ' + '<?= addslashes($u['name']) ?>')">
                  Voir
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div style="padding: 40px; text-align: center;">
      <p style="color: var(--gray-500); font-size: 16px;">
        📭 Aucun utilisateur pour le moment - Créez le premier ci-dessus
      </p>
    </div>
  <?php endif; ?>
</div>