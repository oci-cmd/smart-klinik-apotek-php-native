<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div style="margin-bottom: 24px;">
  <h2 style="font-size: 18px; font-weight: 700;">Registrasi Pasien & Antrean Rekam Medis (EMR)</h2>
  <p style="font-size: 13px; color: var(--text-muted);">Modul 2 (S1 Sistem Informasi): Manajemen Data Induk Pasien, Penerbitan Nomor RM & Kunjungan Poli Medis</p>
</div>

<!-- FORM PENDAFTARAN PASIEN BARU -->
<div class="card">
  <div class="card-header">
    <div class="card-title">Pendaftaran Pasien Baru</div>
  </div>
  <div class="card-body">
    <form action="<?= BASE_URL ?>/index.php?c=pasien&m=create" method="POST" data-validate="true">
      <div class="grid-form">
        <div class="form-group">
          <label class="form-label">NIK (16 Digit KTP) *</label>
          <input type="text" name="nik" maxlength="16" class="form-control" placeholder="Contoh: 320912..." required>
        </div>
        <div class="form-group">
          <label class="form-label">Nama Lengkap Pasien *</label>
          <input type="text" name="nama_pasien" class="form-control" placeholder="Nama Pasien" required>
        </div>
        <div class="form-group">
          <label class="form-label">Jenis Kelamin *</label>
          <select name="jenis_kelamin" class="form-control" required>
            <option value="L">Laki-Laki</option>
            <option value="P">Perempuan</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Tanggal Lahir *</label>
          <input type="date" name="tgl_lahir" class="form-control" required>
        </div>
        <div class="form-group">
          <label class="form-label">No. Telepon / WhatsApp *</label>
          <input type="text" name="telepon" class="form-control" placeholder="08..." required>
        </div>
        <div class="form-group">
          <label class="form-label">Jenis Pasien *</label>
          <select name="jenis_pasien" class="form-control" required>
            <option value="Umum">Umum</option>
            <option value="BPJS">BPJS Kesehatan</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Alamat Lengkap *</label>
        <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat domisili pasien" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">+ Daftarkan Pasien</button>
    </form>
  </div>
</div>

<!-- FORM TERBITKAN ANTREAN KUNJUNGAN POLI -->
<div class="card">
  <div class="card-header">
    <div class="card-title">Terbitkan Antrean Kunjungan Poli Medis</div>
  </div>
  <div class="card-body">
    <form action="<?= BASE_URL ?>/index.php?c=pasien&m=createKunjungan" method="POST" data-validate="true">
      <div class="grid-form">
        <div class="form-group">
          <label class="form-label">Pilih Pasien Terdaftar *</label>
          <select name="pasien_id" class="form-control" required>
            <option value="">-- Pilih Pasien --</option>
            <?php foreach ($pasiens as $p): ?>
              <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['no_rm']) ?> - <?= htmlspecialchars($p['nama_pasien']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Poli / Layanan Tujuan *</label>
          <select name="layanan_id" class="form-control" required>
            <option value="">-- Pilih Layanan --</option>
            <?php foreach ($layananList as $l): ?>
              <option value="<?= $l['id'] ?>"><?= htmlspecialchars($l['poli']) ?> (<?= htmlspecialchars($l['nama_layanan']) ?>) - Rp <?= number_format($l['tarif'], 0, ',', '.') ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Tanggal Kunjungan *</label>
          <input type="date" name="tgl_kunjungan" value="<?= date('Y-m-d') ?>" class="form-control" required>
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Keluhan Utama Pasien *</label>
        <input type="text" name="keluhan" class="form-control" placeholder="Contoh: Pusing berputar, mual, demam..." required>
      </div>
      <button type="submit" class="btn btn-success">+ Terbitkan Nomor Antrean</button>
    </form>
  </div>
</div>

<!-- TABEL ANTREAN & REKAM MEDIS -->
<div class="card">
  <div class="card-header">
    <div class="card-title">Daftar Antrean & Rekam Medis Pasien (EMR)</div>
  </div>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>No. Kunjungan</th>
          <th>Data Pasien</th>
          <th>Poli Layanan</th>
          <th>Keluhan</th>
          <th>Tanda Vital & Diagnosa</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($kunjungan as $k): ?>
          <tr>
            <td><code><?= htmlspecialchars($k['no_kunjungan']) ?></code></td>
            <td>
              <strong><?= htmlspecialchars($k['nama_pasien']) ?></strong><br>
              <small style="color: var(--text-muted);"><?= htmlspecialchars($k['no_rm']) ?> (<?= $k['jenis_kelamin'] ?>)</small>
            </td>
            <td><?= htmlspecialchars($k['nama_layanan']) ?></td>
            <td><?= htmlspecialchars($k['keluhan']) ?></td>
            <td>
              <?php if (!empty($k['diagnosis'])): ?>
                <strong><?= htmlspecialchars($k['diagnosis']) ?></strong><br>
                <small style="color: var(--text-muted);">Tensi: <?= htmlspecialchars($k['tensi']) ?> | Temp: <?= htmlspecialchars($k['suhu']) ?></small>
              <?php else: ?>
                <em style="color: var(--text-muted);">(Belum diperiksa dokter)</em>
              <?php endif; ?>
            </td>
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
            <td>
              <?php if ($k['status_periksa'] !== 'Selesai'): ?>
                <a href="<?= BASE_URL ?>/index.php?c=pasien&m=periksa&id=<?= $k['id'] ?>" class="btn btn-primary btn-sm">Periksa Dokter &rarr;</a>
              <?php else: ?>
                <span style="color: var(--success); font-weight: 600; font-size: 12px;">✓ Selesai Dilayani</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

