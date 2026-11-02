<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div style="margin-bottom: 24px;">
  <h2 style="font-size: 18px; font-weight: 700;">Bagan Akun Standar (Chart of Accounts / COA)</h2>
  <p style="font-size: 13px; color: var(--text-muted);">Modul 3 (D3/D4 Komputerisasi Akuntansi): Struktur Rekening Keuangan, Saldo Normal (Debet/Kredit) & Saldo Awal</p>
</div>

<!-- FORM TAMBAH AKUN COA -->
<div class="card">
  <div class="card-header">
    <div class="card-title">Tambah Rekening Akun Baru (COA)</div>
  </div>
  <div class="card-body">
    <form action="<?= BASE_URL ?>/index.php?c=baganAkun&m=create" method="POST" data-validate="true">
      <div class="grid-form">
        <div class="form-group">
          <label class="form-label">Kode Akun *</label>
          <input type="text" name="kode_akun" class="form-control" placeholder="Contoh: 1106 / 5104" required>
        </div>
        <div class="form-group">
          <label class="form-label">Nama Akun Finansial *</label>
          <input type="text" name="nama_akun" class="form-control" placeholder="Contoh: Kas Kasir Pembantu" required>
        </div>
        <div class="form-group">
          <label class="form-label">Kelompok Akun *</label>
          <select name="kelompok" class="form-control" required>
            <option value="Aset">Aset (Harta)</option>
            <option value="Kewajiban">Kewajiban (Utang)</option>
            <option value="Modal">Modal (Ekuitas)</option>
            <option value="Pendapatan">Pendapatan (Revenue)</option>
            <option value="Beban">Beban Operasional (Expense)</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Saldo Normal *</label>
          <select name="saldo_normal" class="form-control" required>
            <option value="Debet">Debet</option>
            <option value="Kredit">Kredit</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Saldo Awal (Rp)</label>
          <input type="number" step="1000" name="saldo_awal" class="form-control" placeholder="0" value="0">
        </div>
      </div>
      <button type="submit" class="btn btn-primary">+ Simpan Akun COA</button>
    </form>
  </div>
</div>

<!-- TABEL BAGAN AKUN -->
<div class="card">
  <div class="card-header">
    <div class="card-title">Daftar Bagan Akun Standar (COA) Klinik Pratama</div>
  </div>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Kode Akun</th>
          <th>Nama Akun Rekening</th>
          <th>Kelompok Akun</th>
          <th>Saldo Normal</th>
          <th>Saldo Awal</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($akuns as $a): ?>
          <tr>
            <td><code><?= htmlspecialchars($a['kode_akun']) ?></code></td>
            <td><strong><?= htmlspecialchars($a['nama_akun']) ?></strong></td>
            <td>
              <?php
                $badgeKel = match($a['kelompok']) {
                  'Aset'       => 'badge-primary',
                  'Pendapatan' => 'badge-success',
                  'Kewajiban'  => 'badge-warning',
                  'Beban'      => 'badge-danger',
                  default      => 'badge-primary'
                };
              ?>
              <span class="badge <?= $badgeKel ?>"><?= htmlspecialchars($a['kelompok']) ?></span>
            </td>
            <td><strong><?= htmlspecialchars($a['saldo_normal']) ?></strong></td>
            <td>Rp <?= number_format($a['saldo_awal'], 0, ',', '.') ?></td>
            <td><span class="badge badge-success"><?= htmlspecialchars($a['status']) ?></span></td>
            <td>
              <a href="<?= BASE_URL ?>/index.php?c=baganAkun&m=delete&id=<?= $a['id'] ?>" 
                 class="btn btn-danger btn-sm btn-confirm-delete" 
                 data-msg="Hapus akun <?= htmlspecialchars($a['nama_akun']) ?>?">Hapus</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

