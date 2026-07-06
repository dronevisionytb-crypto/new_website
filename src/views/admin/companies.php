<?php $msg = $_GET['msg'] ?? null; $err = $_GET['error'] ?? null; ?>

<style>
  details > summary { list-style: none; }
  details > summary::-webkit-details-marker { display: none; }
  .company-row[open] > summary .toggle-icon::after { content: '▴'; }
  .company-row > summary .toggle-icon::after { content: '▾'; }
  .add-user-row[open] > summary { border-radius: var(--radius-sm) var(--radius-sm) 0 0; }
</style>

<div class="page-header">
  <h1>🏢 Gestion des entreprises</h1>
  <p>Créez des entreprises et gérez leurs comptes utilisateurs depuis cette page</p>
</div>

<?php if ($msg === 'company_created'): ?>
  <div class="alert" style="background:#d1fae5;color:#065f46;border:1px solid #6ee7b7;padding:12px 16px;border-radius:var(--radius-md);margin-bottom:20px;">
    ✓ Entreprise créée avec succès.
  </div>
<?php elseif ($msg === 'user_added'): ?>
  <div class="alert" style="background:#d1fae5;color:#065f46;border:1px solid #6ee7b7;padding:12px 16px;border-radius:var(--radius-md);margin-bottom:20px;">
    ✓ Compte utilisateur ajouté.
  </div>
<?php elseif ($msg === 'user_deleted'): ?>
  <div class="alert" style="background:#fef3c7;color:#92400e;border:1px solid #fcd34d;padding:12px 16px;border-radius:var(--radius-md);margin-bottom:20px;">
    ✓ Compte supprimé.
  </div>
<?php elseif ($err === 'email_exists'): ?>
  <div class="alert alert-error" style="margin-bottom:20px;">
    ❌ Cette adresse email est déjà utilisée par un autre compte.
  </div>
<?php endif; ?>

<!-- ── Créer une entreprise ───────────────────────────────────── -->
<details class="card" style="margin-bottom:24px;" <?= ($msg === null && $err === null && empty($companies)) ? 'open' : '' ?>>
  <summary style="cursor:pointer;display:flex;justify-content:space-between;align-items:center;padding:4px 0;">
    <h2 style="margin:0;color:var(--blue-primary);font-size:18px;font-weight:600;">
      ➕ Créer une nouvelle entreprise
    </h2>
    <span style="color:var(--gray-400);font-size:12px;white-space:nowrap;">Cliquer pour développer ▾</span>
  </summary>

  <div style="margin-top:20px;padding-top:20px;border-top:2px solid var(--blue-light);">
    <form method="post" action="/index.php?page=companies_create">
      <div class="form-row">
        <div class="form-group">
          <label>Nom de l'entreprise *</label>
          <input type="text" name="name" placeholder="ACME Corporation" required>
        </div>
        <div class="form-group">
          <label>SIRET</label>
          <input type="text" name="siret" placeholder="123 456 789 00123">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Adresse</label>
          <input type="text" name="address" placeholder="123 Rue de la Paix">
        </div>
        <div class="form-group">
          <label>Code postal</label>
          <input type="text" name="postal_code" placeholder="75000">
        </div>
        <div class="form-group">
          <label>Ville</label>
          <input type="text" name="city" placeholder="Paris">
        </div>
        <div class="form-group">
          <label>Département</label>
          <input type="text" name="department" placeholder="75">
        </div>
      </div>
      <div style="border-top:1px solid var(--gray-200);padding-top:16px;margin-top:8px;">
        <p style="margin:0 0 12px 0;color:var(--gray-600);font-size:13px;font-weight:600;">📞 Contact principal</p>
        <div class="form-row">
          <div class="form-group">
            <label>Nom</label>
            <input type="text" name="contact_name" placeholder="Jean Dupont">
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="contact_email" placeholder="contact@acme.fr">
          </div>
          <div class="form-group">
            <label>Téléphone</label>
            <input type="text" name="contact_phone" placeholder="+33 1 23 45 67 89">
          </div>
        </div>
      </div>
      <div style="display:flex;justify-content:flex-end;gap:12px;margin-top:20px;">
        <button type="reset" class="btn btn-secondary">Réinitialiser</button>
        <button type="submit" class="btn btn-primary btn-lg">✓ Créer l'entreprise</button>
      </div>
    </form>
  </div>
</details>

<!-- ── Liste des entreprises ─────────────────────────────────── -->
<div class="card">
  <h2 style="margin:0 0 20px 0;color:var(--gray-900);font-size:18px;font-weight:600;">
    Entreprises (<?= count($companies ?? []) ?>)
  </h2>

  <?php if (empty($companies)): ?>
    <div style="padding:40px;text-align:center;">
      <p style="color:var(--gray-500);font-size:16px;">
        📭 Aucune entreprise — créez-en une ci-dessus
      </p>
    </div>
  <?php else: ?>
    <div style="display:flex;flex-direction:column;gap:10px;">
      <?php foreach ($companies as $c): ?>
      <details class="company-row" style="border:1px solid var(--gray-200);border-radius:var(--radius-md);overflow:hidden;">

        <!-- ── Summary / header row ── -->
        <summary style="cursor:pointer;padding:14px 20px;background:var(--gray-50);display:flex;align-items:center;justify-content:space-between;user-select:none;transition:background .15s;">
          <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;">
            <span style="font-weight:700;font-size:15px;color:var(--gray-900);">
              🏢 <?= htmlspecialchars($c['name']) ?>
            </span>
            <span class="badge badge-primary" style="font-size:11px;">
              <?= count($c['users']) ?> compte(s)
            </span>
            <?php if (!empty($c['city'])): ?>
              <span style="color:var(--gray-500);font-size:13px;">📍 <?= htmlspecialchars($c['city']) ?><?= !empty($c['department']) ? ' (' . htmlspecialchars($c['department']) . ')' : '' ?></span>
            <?php endif; ?>
          </div>
          <span class="toggle-icon" style="color:var(--gray-400);font-size:13px;white-space:nowrap;"></span>
        </summary>

        <!-- ── Expanded content ── -->
        <div style="padding:20px;">

          <!-- Company info strip -->
          <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px;margin-bottom:20px;padding:14px 16px;background:var(--gray-50);border-radius:var(--radius-sm);">
            <div>
              <div style="font-size:11px;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px;">Adresse</div>
              <div style="color:var(--gray-800);font-size:13px;line-height:1.5;">
                <?= htmlspecialchars($c['address'] ?? '—') ?><br>
                <?= htmlspecialchars(trim(($c['postal_code'] ?? '') . ' ' . ($c['city'] ?? ''))) ?: '—' ?>
              </div>
            </div>
            <div>
              <div style="font-size:11px;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px;">SIRET</div>
              <div style="color:var(--gray-800);font-size:13px;"><?= htmlspecialchars($c['siret'] ?? '—') ?></div>
            </div>
            <div>
              <div style="font-size:11px;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px;">Contact principal</div>
              <div style="color:var(--gray-800);font-size:13px;line-height:1.5;">
                <?= htmlspecialchars($c['contact_name'] ?? '—') ?><br>
                <?php if (!empty($c['contact_email'])): ?>
                  <a href="mailto:<?= htmlspecialchars($c['contact_email']) ?>" style="color:var(--blue-primary);text-decoration:none;font-size:12px;">
                    <?= htmlspecialchars($c['contact_email']) ?>
                  </a>
                <?php endif; ?>
                <?php if (!empty($c['contact_phone'])): ?>
                  <br><span style="font-size:12px;color:var(--gray-600);"><?= htmlspecialchars($c['contact_phone']) ?></span>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <!-- Users table -->
          <h4 style="margin:0 0 12px 0;font-size:14px;font-weight:600;color:var(--gray-800);">
            👥 Comptes utilisateurs
          </h4>
          <?php if (!empty($c['users'])): ?>
            <div class="table-container" style="margin-bottom:16px;">
              <table>
                <thead>
                  <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th style="width:110px;">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($c['users'] as $u): ?>
                    <tr>
                      <td style="font-weight:600;"><?= htmlspecialchars($u['name']) ?></td>
                      <td style="color:var(--gray-600);font-size:13px;"><?= htmlspecialchars($u['email']) ?></td>
                      <td>
                        <button class="btn btn-sm btn-danger"
                          onclick="if(confirm('Supprimer le compte de <?= addslashes(htmlspecialchars($u['name'])) ?> ?')) window.location.href='/index.php?page=company_delete_user&id=<?= (int)$u['id'] ?>'">
                          ✗ Supprimer
                        </button>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php else: ?>
            <p style="color:var(--gray-500);font-size:13px;margin:0 0 16px 0;">
              Aucun compte — ajoutez-en un ci-dessous.
            </p>
          <?php endif; ?>

          <!-- Add user inline accordion -->
          <details class="add-user-row" style="border:1px solid var(--blue-light);border-radius:var(--radius-sm);">
            <summary style="cursor:pointer;padding:10px 16px;background:#eef4ff;color:var(--blue-primary);font-weight:600;font-size:14px;user-select:none;border-radius:var(--radius-sm);">
              ➕ Ajouter un compte utilisateur
            </summary>
            <div style="padding:16px;border-top:1px solid var(--blue-light);">
              <form method="post" action="/index.php?page=company_add_user">
                <input type="hidden" name="company_id" value="<?= (int)$c['id'] ?>">
                <div class="form-row">
                  <div class="form-group">
                    <label>Nom complet *</label>
                    <input type="text" name="name" placeholder="Jean Dupont" required>
                  </div>
                  <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" placeholder="jean@acme.fr" required>
                  </div>
                  <div class="form-group">
                    <label>Mot de passe *</label>
                    <input type="password" name="password" placeholder="••••••••" required minlength="6">
                  </div>
                </div>
                <div style="display:flex;justify-content:flex-end;margin-top:12px;">
                  <button type="submit" class="btn btn-primary">✓ Ajouter le compte</button>
                </div>
              </form>
            </div>
          </details>

        </div>
      </details>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
