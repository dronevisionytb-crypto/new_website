<div class="page-header">
  <h1>📄 Documents</h1>
  <p>Documents mis à disposition pour votre entreprise</p>
</div>

<div class="card">
  <?php if (!empty($documents)): ?>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px; margin-top: 12px;">
      <?php foreach ($documents as $doc): ?>
        <div class="card" style="display: flex; flex-direction: column; justify-content: space-between;">
          <div>
            <div style="font-size: 32px; margin-bottom: 12px;">📑</div>
            <h3 style="margin: 0 0 8px 0; color: var(--gray-900); font-size: 16px; font-weight: 600;">
              <?= htmlspecialchars($doc['title']) ?>
            </h3>
            <div style="display: flex; gap: 8px; margin-top: 12px;">
              <?php if ($doc['is_signed']): ?>
                <span class="badge badge-success">✓ Signé</span>
              <?php else: ?>
                <span class="badge badge-warning">À signer</span>
              <?php endif; ?>
            </div>
          </div>

          <div style="display: flex; gap: 8px; margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--gray-100);">
            <a href="<?= htmlspecialchars($doc['file_path']) ?>" target="_blank" class="btn btn-sm btn-secondary flex-1" style="text-align: center;">
              👁️ Voir
            </a>
            <a href="<?= htmlspecialchars($doc['file_path']) ?>" download class="btn btn-sm btn-primary flex-1" style="text-align: center;">
              ⬇️ Télécharger
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div style="padding: 40px; text-align: center;">
      <p style="color: var(--gray-500); font-size: 16px;">
        📭 Aucun document disponible pour le moment
      </p>
    </div>
  <?php endif; ?>
</div>