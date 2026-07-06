<div class="page-header">
  <h1>💰 Factures</h1>
  <p>Factures et documents de paiement liés à vos missions</p>
</div>

<div class="card">
  <?php if (!empty($invoices)): ?>
    <div style="overflow-x: auto;">
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Numéro</th>
              <th>Montant HT</th>
              <th>Montant TTC</th>
              <th>Statut</th>
              <th>Date</th>
              <th>Fichier</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($invoices as $inv): ?>
              <tr>
                <td style="font-weight: 600; color: var(--blue-primary);">
                  #<?= str_pad((int)$inv['id'], 4, '0', STR_PAD_LEFT) ?>
                </td>
                <td>
                  <?= $inv['amount_ht'] !== null ? number_format($inv['amount_ht'], 2, ',', ' ') . ' €' : '-' ?>
                </td>
                <td style="font-weight: 600;">
                  <?= $inv['amount_ttc'] !== null ? number_format($inv['amount_ttc'], 2, ',', ' ') . ' €' : '-' ?>
                </td>
                <td>
                  <?php
                    $status_map = [
                      'pending' => ['badge-warning', '⏳ En attente'],
                      'paid' => ['badge-success', '✓ Payée'],
                      'overdue' => ['badge-danger', '⚠️ En retard'],
                      'cancelled' => ['badge-info', '✗ Annulée'],
                    ];
                    $status_class = $status_map[$inv['status']][0] ?? 'badge-info';
                    $status_text = $status_map[$inv['status']][1] ?? htmlspecialchars($inv['status']);
                  ?>
                  <span class="badge <?= $status_class ?>"><?= $status_text ?></span>
                </td>
                <td>
                  <?php echo isset($inv['created_at']) ? date('d/m/Y', strtotime($inv['created_at'])) : '-'; ?>
                </td>
                <td>
                  <?php if (!empty($inv['file_path'])): ?>
                    <div style="display: flex; gap: 8px;">
                      <a href="<?= htmlspecialchars($inv['file_path']) ?>" target="_blank" class="btn btn-sm btn-secondary">
                        👁️
                      </a>
                      <a href="<?= htmlspecialchars($inv['file_path']) ?>" download class="btn btn-sm btn-primary">
                        ⬇️
                      </a>
                    </div>
                  <?php else: ?>
                    <span style="color: var(--gray-400); font-size: 13px;">Aucun fichier</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Résumé financier -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 32px;">
      <div class="stat-card">
        <div class="stat-label">Total facturé (TTC)</div>
        <div class="stat-number" style="color: var(--blue-primary);">
          <?php 
            $total = array_sum(array_map(fn($i) => $i['amount_ttc'] ?? 0, $invoices));
            echo number_format($total, 2, ',', ' ') . ' €';
          ?>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-label">Factures payées</div>
        <div class="stat-number" style="color: var(--success);">
          <?= count(array_filter($invoices, fn($i) => $i['status'] === 'paid')) ?>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-label">En attente de paiement</div>
        <div class="stat-number" style="color: var(--warning);">
          <?= count(array_filter($invoices, fn($i) => $i['status'] === 'pending')) ?>
        </div>
      </div>
    </div>

  <?php else: ?>
    <div style="padding: 40px; text-align: center;">
      <p style="color: var(--gray-500); font-size: 16px;">
        📭 Aucune facture pour le moment
      </p>
    </div>
  <?php endif; ?>
</div>