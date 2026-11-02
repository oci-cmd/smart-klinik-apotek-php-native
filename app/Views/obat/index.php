<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
  <div>
    <h2 style="font-size: 18px; font-weight: 700;">Katalog Obat Farmasi & Layanan Medis</h2>
    <p style="font-size: 13px; color: var(--text-muted);">Modul 1 (S1 Sistem Informasi): Manajemen Data Master Obat, Peringatan Kadaluarsa & Tarif Tindakan Medis</p>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-title">Tambah Obat Baru ke Katalog Farmasi</div>
  </div>
  <div class="card-body">
    <form action="<?= BASE_URL ?>/index.php?c=layananObat&m=createObat" method="POST" data-validate="true">
      <div class="grid-form">
        <div class="form-group">
          <label class="form-label">Kode Obat *</label>
          <input type="text" name="kode_obat" class="form-control" placeholder="Contoh: OBT-007" required>
        </div>
        <div class="form-group">
          <label class="form-label">Nama Obat *</label>
          <input type="text" name="nama_obat" class="form-control" placeholder="Contoh: Ibuprofen 400mg" required>
        </div>
        <div class="form-group">
          <label class="form-label">Kategori *</label>
          <input type="text" name="kategori" class="form-control" placeholder="Contoh: Analgesik / NSAID" required>
        </div>
        <div class="form-group">
          <label class="form-label">Satuan *</label>
          <input type="text" name="satuan" class="form-control" placeholder="Contoh: Strip / Botol / Tablet" required>
        </div>
        <div class="form-group">
          <label class="form-label">Harga Beli Distributor (Rp) *</label>
          <input type="number" step="100" name="harga_beli" class="form-control" placeholder="4000" required>
        </div>
        <div class="form-group">
          <label class="form-label">Harga Jual Apotek (Rp) *</label>
          <input type="number" step="100" name="harga_jual" class="form-control" placeholder="8000" required>
        </div>
        <div class="form-group">
          <label class="form-label">Stok Fisik Awal *</label>
          <input type="number" name="stok" class="form-control" placeholder="50" required>
        </div>
        <div class="form-group">
          <label class="form-label">Batas Minimum Stok (Buffer) *</label>
          <input type="number" name="stok_min" class="form-control" placeholder="15" required>
        </div>
        <div class="form-group">
          <label class="form-label">Tanggal Kedaluwarsa (Exp Date) *</label>
          <input type="date" name="exp_date" class="form-control" required>
        </div>
      </div>
      <button type="submit" class="btn btn-primary" style="margin-top: 8px;">+ Simpan Obat Baru</button>
    </form>
  </div>
</div>

<!-- TABEL KATALOG OBAT -->
<div class="card">
  <div class="card-header">
    <div class="card-title">Daftar Stok Obat Farmasi</div>
  </div>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Kode</th>
          <th>Nama Obat</th>
          <th>Kategori</th>
          <th>Satuan</th>
          <th>Harga Beli</th>
          <th>Harga Jual</th>
          <th>Sisa Stok</th>
          <th>Tgl Kedaluwarsa</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($obats as $o): ?>
          <tr>
            <td><code><?= htmlspecialchars($o['kode_obat']) ?></code></td>
            <td><strong><?= htmlspecialchars($o['nama_obat']) ?></strong></td>
            <td><?= htmlspecialchars($o['kategori']) ?></td>
            <td><?= htmlspecialchars($o['satuan']) ?></td>
            <td>Rp <?= number_format($o['harga_beli'], 0, ',', '.') ?></td>
            <td><strong style="color: var(--primary);">Rp <?= number_format($o['harga_jual'], 0, ',', '.') ?></strong></td>
            <td>
              <?php if ($o['stok'] <= $o['stok_min']): ?>
                <span class="badge badge-danger"><?= $o['stok'] ?> (Kritis)</span>
              <?php else: ?>
                <span class="badge badge-success"><?= $o['stok'] ?></span>
              <?php endif; ?>
            </td>
            <td>
              <?php 
                $exp = strtotime($o['exp_date']);
                $now = time();
                $diffDays = ($exp - $now) / (60 * 60 * 24);
                if ($diffDays <= 60):
              ?>
                <span class="badge badge-warning"><?= htmlspecialchars($o['exp_date']) ?></span>
              <?php else: ?>
                <?= htmlspecialchars($o['exp_date']) ?>
              <?php endif; ?>
            </td>
            <td>
              <a href="<?= BASE_URL ?>/index.php?c=layananObat&m=deleteObat&id=<?= $o['id'] ?>" 
                 class="btn btn-danger btn-sm btn-confirm-delete" 
                 data-msg="Hapus obat <?= htmlspecialchars($o['nama_obat']) ?>?">Hapus</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- TABEL LAYANAN MEDIS -->
<div class="card">
  <div class="card-header">
    <div class="card-title">Daftar Layanan Medis & Tarif Tindakan Dokter</div>
  </div>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Kode</th>
          <th>Nama Tindakan / Layanan</th>
          <th>Poli Klinik</th>
          <th>Tarif Layanan</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($layanan as $l): ?>
          <tr>
            <td><code><?= htmlspecialchars($l['kode_layanan']) ?></code></td>
            <td><strong><?= htmlspecialchars($l['nama_layanan']) ?></strong></td>
            <td><?= htmlspecialchars($l['poli']) ?></td>
            <td><strong style="color: var(--success);">Rp <?= number_format($l['tarif'], 0, ',', '.') ?></strong></td>
            <td><span class="badge badge-success"><?= htmlspecialchars($l['status']) ?></span></td>
            <td>
              <a href="<?= BASE_URL ?>/index.php?c=layananObat&m=deleteLayanan&id=<?= $l['id'] ?>" 
                 class="btn btn-danger btn-sm btn-confirm-delete" 
                 data-msg="Hapus layanan <?= htmlspecialchars($l['nama_layanan']) ?>?">Hapus</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

