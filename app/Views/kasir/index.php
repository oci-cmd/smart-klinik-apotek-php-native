<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div style="margin-bottom: 24px;">
  <h2 style="font-size: 18px; font-weight: 700;">Kasir Billing Pasien & Pencatatan Buku Kas</h2>
  <p style="font-size: 13px; color: var(--text-muted);">Modul 4 (D3/D4 Komputerisasi Akuntansi): Penerimaan Kas Pasien, Bukti Kuitansi & Pengeluaran Operasional Anti-Minus</p>
</div>

<!-- KARTU RINGKASAN SALDO KAS -->
<div class="grid-stats">
  <div class="card-stat">
    <div>
      <div class="stat-label">Total Kas Masuk</div>
      <div class="stat-value" style="color: var(--success);">Rp <?= number_format($summaryKas['total_masuk'], 0, ',', '.') ?></div>
      <div class="stat-desc">Pendapatan klinik & farmasi</div>
    </div>
    <div class="stat-icon icon-green">📥</div>
  </div>

  <div class="card-stat">
    <div>
      <div class="stat-label">Total Kas Keluar</div>
      <div class="stat-value" style="color: var(--danger);">Rp <?= number_format($summaryKas['total_keluar'], 0, ',', '.') ?></div>
      <div class="stat-desc">Beban operasional & obat</div>
    </div>
    <div class="stat-icon icon-red">📤</div>
  </div>

  <div class="card-stat">
    <div>
      <div class="stat-label">Posisi Saldo Kas Riil</div>
      <div class="stat-value" style="color: var(--primary);">Rp <?= number_format($summaryKas['saldo_akhir'], 0, ',', '.') ?></div>
      <div class="stat-desc">Ketersediaan kas operasional</div>
    </div>
    <div class="stat-icon icon-blue">🏦</div>
  </div>
</div>

<!-- ANTREAN KASIR UNTUK PEMBAYARAN PASIEN -->
<?php if (!empty($antreanKasir)): ?>
<div class="card" style="border: 2px solid var(--primary); background: #F0F9FF;">
  <div class="card-header" style="background: transparent;">
    <div class="card-title" style="color: var(--primary);">🔔 Pasien Menunggu Pembayaran Kasir (<?= count($antreanKasir) ?> Pasien)</div>
  </div>
  <div class="card-body">
    <div class="grid-stats">
      <?php foreach ($antreanKasir as $ak): ?>
        <div class="card" style="margin: 0; background: #fff;">
          <div class="card-body">
            <h4 style="font-size: 15px; font-weight: 700;"><?= htmlspecialchars($ak['nama_pasien']) ?></h4>
            <p style="font-size: 12.5px; color: var(--text-muted); margin: 4px 0 12px;">
              No. Kunjungan: <strong><?= htmlspecialchars($ak['no_kunjungan']) ?></strong><br>
              Layanan: <?= htmlspecialchars($ak['nama_layanan']) ?> (Rp <?= number_format($ak['tarif'], 0, ',', '.') ?>)<br>
              Resep: <em><?= htmlspecialchars($ak['resep_obat']) ?></em>
            </p>

            <!-- FORM PROSES KASIR CEPAT -->
            <form action="<?= BASE_URL ?>/index.php?c=kasirKas&m=bayarPasien" method="POST">
              <input type="hidden" name="rekam_medis_id" value="<?= $ak['id'] ?>">
              <input type="hidden" name="total_layanan" value="<?= $ak['tarif'] ?>">
              
              <div class="form-group">
                <label class="form-label" style="font-size: 11px;">Biaya Obat Resep (Rp)</label>
                <input type="number" step="1000" name="total_obat" value="25000" class="form-control" style="font-size: 12px; padding: 6px;" required>
              </div>

              <div class="form-group">
                <label class="form-label" style="font-size: 11px;">Diskon / Potongan (Rp)</label>
                <input type="number" step="1000" name="diskon" value="0" class="form-control" style="font-size: 12px; padding: 6px;">
              </div>

              <div class="form-group">
                <label class="form-label" style="font-size: 11px;">Nominal Bayar Pasien (Rp)</label>
                <input type="number" step="1000" name="nominal_bayar" placeholder="Contoh: 100000" class="form-control" style="font-size: 12px; padding: 6px;" required>
              </div>

              <button type="submit" class="btn btn-primary btn-sm" style="width: 100%;">Proses Bayar & Kuitansi &rarr;</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- FORM PENCATATAN TRANSAKSI KAS KELUAR / MASUK LAINNYA -->
<div class="card">
  <div class="card-header">
    <div class="card-title">Pencatatan Transaksi Kas Masuk / Kas Keluar Operasional</div>
  </div>
  <div class="card-body">
    <form action="<?= BASE_URL ?>/index.php?c=kasirKas&m=createKas" method="POST" data-validate="true">
      <div class="grid-form">
        <div class="form-group">
          <label class="form-label">Jenis Transaksi *</label>
          <select name="jenis_transaksi" class="form-control" required>
            <option value="Kas Masuk">Kas Masuk (Penerimaan)</option>
            <option value="Kas Keluar">Kas Keluar (Pengeluaran)</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Rekening Akun Terkait (COA) *</label>
          <select name="akun_id" class="form-control" required>
            <?php foreach ($akuns as $a): ?>
              <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['kode_akun']) ?> - <?= htmlspecialchars($a['nama_akun']) ?> (<?= $a['kelompok'] ?>)</option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Nominal Transaksi (Rp) *</label>
          <input type="number" step="1000" name="nominal" class="form-control" placeholder="Contoh: 150000" required>
        </div>
        <div class="form-group">
          <label class="form-label">Kategori Transaksi *</label>
          <input type="text" name="kategori" class="form-control" placeholder="Contoh: Pembelian Obat / Operasional" required>
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Keterangan Lengkap Bukti Transaksi *</label>
        <textarea name="keterangan" class="form-control" rows="2" placeholder="Tuliskan keterangan detail transaksi kas" required></textarea>
      </div>
      <button type="submit" class="btn btn-success">+ Bukukan Transaksi Kas</button>
    </form>
  </div>
</div>

<!-- TABEL BUKU KAS HARIAN -->
<div class="card">
  <div class="card-header">
    <div class="card-title">Buku Kas Harian & Mutasi Jurnal Keuangan</div>
  </div>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>No. Transaksi</th>
          <th>Tanggal</th>
          <th>Akun COA</th>
          <th>Jenis</th>
          <th>Kategori</th>
          <th>Nominal (Rp)</th>
          <th>Keterangan</th>
          <th>Operator</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($transaksiKas as $t): ?>
          <tr>
            <td><code><?= htmlspecialchars($t['no_transaksi']) ?></code></td>
            <td><?= htmlspecialchars($t['tgl_transaksi']) ?></td>
            <td><?= htmlspecialchars($t['kode_akun']) ?> - <?= htmlspecialchars($t['nama_akun']) ?></td>
            <td>
              <?php if ($t['jenis_transaksi'] === 'Kas Masuk'): ?>
                <span class="badge badge-success">Kas Masuk</span>
              <?php else: ?>
                <span class="badge badge-danger">Kas Keluar</span>
              <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($t['kategori']) ?></td>
            <td>
              <strong style="color: <?= ($t['jenis_transaksi'] === 'Kas Masuk') ? 'var(--success)' : 'var(--danger)' ?>;">
                Rp <?= number_format($t['nominal'], 0, ',', '.') ?>
              </strong>
            </td>
            <td><?= htmlspecialchars($t['keterangan']) ?></td>
            <td><small><?= htmlspecialchars($t['operator']) ?></small></td>
            <td>
              <span style="color: var(--text-muted); font-size: 11px;">Tervalidasi</span>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

