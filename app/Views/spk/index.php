<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div style="margin-bottom: 24px;">
  <h2 style="font-size: 18px; font-weight: 700;">Sistem Pendukung Keputusan (SPK) SAW & Audit Log OWASP</h2>
  <p style="font-size: 13px; color: var(--text-muted);">Modul 5 (Sinergi SI & KA): Algoritma Simple Additive Weighting (Prioritas Belanja Obat Farmasi) & Rekam Jejak Keamanan</p>
</div>

<!-- INFORMASI BOBOT KRITERIA SPK SAW -->
<div class="card">
  <div class="card-header">
    <div class="card-title">Parameter Bobot Kriteria SPK SAW (Pengadaan Obat Farmasi)</div>
  </div>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Kode</th>
          <th>Nama Kriteria Penilaian</th>
          <th>Sifat Kriteria</th>
          <th>Bobot Preferensi (W)</th>
          <th>Penjelasan Logika Komputasi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($kriteria as $kr): ?>
          <tr>
            <td><code><?= htmlspecialchars($kr['kode_kriteria']) ?></code></td>
            <td><strong><?= htmlspecialchars($kr['nama_kriteria']) ?></strong></td>
            <td>
              <span class="badge <?= ($kr['tipe'] === 'benefit') ? 'badge-success' : 'badge-warning' ?>">
                <?= strtoupper($kr['tipe']) ?>
              </span>
            </td>
            <td><strong><?= ($kr['bobot'] * 100) ?>%</strong> (<?= $kr['bobot'] ?>)</td>
            <td>
              <?php if ($kr['tipe'] === 'cost'): ?>
                Makin kecil nilai fisik/harga, makin tinggi skor normalisasinya (Cost = Min / X).
              <?php else: ?>
                Makin besar frekuensi resep/urgensi, makin tinggi skor normalisasinya (Benefit = X / Max).
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- TABEL HASIL PERANGKINGAN SPK SAW -->
<div class="card">
  <div class="card-header">
    <div class="card-title">Hasil Rekomendasi Prioritas Belanja Obat (Metode SAW)</div>
    <span class="badge badge-primary">Algoritma Multi-Attribute Decision Making</span>
  </div>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th style="width: 70px;">Peringkat</th>
          <th>Kode & Nama Obat</th>
          <th>Sisa Stok</th>
          <th>Harga Beli</th>
          <th>R1 (Stok)</th>
          <th>R2 (Laku)</th>
          <th>R3 (Urgensi)</th>
          <th>R4 (Harga)</th>
          <th>Skor Akhir (V)</th>
          <th>Tingkat Prioritas Belanja</th>
        </tr>
      </thead>
      <tbody>
        <?php $rank = 1; foreach ($prioritas as $p): ?>
          <tr style="<?= ($rank <= 2) ? 'background-color: #FEF3C7;' : '' ?>">
            <td style="text-align: center;">
              <?php if ($rank === 1): ?>
                <span class="badge badge-danger" style="font-size: 13px;">🏆 Rank 1</span>
              <?php elseif ($rank === 2): ?>
                <span class="badge badge-warning">Rank 2</span>
              <?php else: ?>
                <strong>#<?= $rank ?></strong>
              <?php endif; ?>
            </td>
            <td>
              <strong><?= htmlspecialchars($p['nama_obat']) ?></strong><br>
              <code><?= htmlspecialchars($p['kode_obat']) ?></code>
            </td>
            <td><strong><?= $p['stok'] ?> unit</strong></td>
            <td>Rp <?= number_format($p['harga_beli'], 0, ',', '.') ?></td>
            <td><?= $p['r1'] ?></td>
            <td><?= $p['r2'] ?></td>
            <td><?= $p['r3'] ?></td>
            <td><?= $p['r4'] ?></td>
            <td><strong style="color: var(--primary); font-size: 15px;"><?= $p['score_v'] ?></strong></td>
            <td>
              <div style="display: flex; align-items: center; gap: 8px;">
                <div style="flex-grow: 1; height: 8px; background: #E2E8F0; border-radius: 4px; overflow: hidden;">
                  <div style="width: <?= $p['persen'] ?>%; height: 100%; background: <?= ($rank <= 2) ? 'var(--danger)' : 'var(--primary)' ?>;"></div>
                </div>
                <span style="font-size: 11px; font-weight: 700;"><?= $p['persen'] ?>%</span>
              </div>
            </td>
          </tr>
        <?php $rank++; endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- AUDIT LOGS OWASP CYBERSECURITY -->
<div class="card">
  <div class="card-header">
    <div class="card-title">Rekam Jejak Audit Keamanan Sistem (OWASP Activity Logs)</div>
    <span class="badge badge-success">Forensik Digital Terverifikasi</span>
  </div>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Waktu Log</th>
          <th>Pengguna</th>
          <th>Aksi</th>
          <th>Modul Terkait</th>
          <th>Keterangan Aktivitas</th>
          <th>IP Address</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($logs as $l): ?>
          <tr>
            <td>#<?= $l['id'] ?></td>
            <td><small><?= htmlspecialchars($l['created_at']) ?></small></td>
            <td><strong><?= htmlspecialchars($l['username']) ?></strong></td>
            <td><code><?= htmlspecialchars($l['aksi']) ?></code></td>
            <td><?= htmlspecialchars($l['modul']) ?></td>
            <td><?= htmlspecialchars($l['keterangan']) ?></td>
            <td><code><?= htmlspecialchars($l['ip_address']) ?></code></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

