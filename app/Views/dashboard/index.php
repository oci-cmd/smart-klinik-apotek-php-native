<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<!-- 4 STAT METRICS CARDS (Gaya CareOps & MedServ Dribbble) -->
<div class="grid-stats">
  <div class="card-stat">
    <div>
      <div class="stat-label">Total Pasien Terdaftar</div>
      <div class="stat-value"><?= number_format($totalPasien) ?></div>
      <div class="stat-desc">Rekam data pasien aktif</div>
    </div>
    <div class="stat-icon icon-blue">👥</div>
  </div>

  <div class="card-stat">
    <div>
      <div class="stat-label">Kunjungan Hari Ini</div>
      <div class="stat-value"><?= number_format($kunjunganHariIni) ?></div>
      <div class="stat-desc">Antrean poli medis</div>
    </div>
    <div class="stat-icon icon-green">🩺</div>
  </div>

  <div class="card-stat">
    <div>
      <div class="stat-label">Saldo Kas Riil Klinik</div>
      <div class="stat-value">Rp <?= number_format($summaryKas['saldo_akhir'], 0, ',', '.') ?></div>
      <div class="stat-desc">Total Kas Masuk - Keluar</div>
    </div>
    <div class="stat-icon icon-green">💰</div>
  </div>

  <div class="card-stat">
    <div>
      <div class="stat-label">Obat Kritis / Expired</div>
      <div class="stat-value" style="color: var(--danger);"><?= $obatMenipis + $obatExpired ?></div>
      <div class="stat-desc"><?= $obatMenipis ?> stok minim, <?= $obatExpired ?> segera exp</div>
    </div>
    <div class="stat-icon icon-red">⚠️</div>
  </div>
</div>

<!-- SECTION MODULAR DOKUMENTASI UNTUK DOSEN & MAHASISWA -->
<div class="card" style="background: linear-gradient(135deg, #0F172A, #1E293B); color: #fff; margin-bottom: 24px;">
  <div class="card-body" style="padding: 24px 28px;">
    <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 8px;">Pondasi Hybrid: S1 Sistem Informasi (SI) & D3/D4 Komputerisasi Akuntansi (KA)</h3>
    <p style="font-size: 13.5px; color: #94A3B8; max-width: 900px; line-height: 1.6;">
      Aplikasi ini mendemonstrasikan integrasi arsitektur bersih <strong>PHP Native MVC</strong> dengan standar industri:
      validasi formulir sisi klien, pencegahan SQL Injection via <strong>PDO Prepared Statements Strict Mode</strong>, otentikasi kata sandi <strong>Bcrypt</strong>, pembatasan hak akses <strong>Role-Based Access Control</strong>, algoritma <strong>SPK SAW</strong> untuk prioritas stok obat, dan validasi akuntansi saldo kas anti-minus.
    </p>
  </div>
</div>

<!-- TABEL REKAP KUNJUNGAN PASIEN TERKINI -->
<div class="card">
  <div class="card-header">
    <div class="card-title">Antrean & Riwayat Kunjungan Pasien Terkini (EMR)</div>
    <a href="<?= BASE_URL ?>/index.php?c=pasien&m=index" class="btn btn-outline btn-sm">Lihat Semua Kunjungan &rarr;</a>
  </div>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>No. Kunjungan</th>
          <th>Nama Pasien</th>
          <th>Poli Layanan</th>
          <th>Keluhan</th>
          <th>Status Pemeriksaan</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($listKunjungan)): ?>
          <tr><td colspan="5" style="text-align:center; padding: 20px;">Belum ada antrean kunjungan hari ini.</td></tr>
        <?php else: ?>
          <?php foreach ($listKunjungan as $k): ?>
            <tr>
              <td><strong><?= htmlspecialchars($k['no_kunjungan']) ?></strong></td>
              <td><?= htmlspecialchars($k['nama_pasien']) ?> (<?= htmlspecialchars($k['no_rm']) ?>)</td>
              <td><?= htmlspecialchars($k['nama_layanan']) ?></td>
              <td><?= htmlspecialchars($k['keluhan']) ?></td>
              <td>
                <?php
                  $badge = match($k['status_periksa']) {
                    'Selesai'      => 'badge-success',
                    'Menuju Kasir' => 'badge-primary',
                    'Diperiksa'    => 'badge-warning',
                    default        => 'badge-danger'
                  };
                ?>
                <span class="badge <?= $badge ?>"><?= htmlspecialchars($k['status_periksa']) ?></span>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

