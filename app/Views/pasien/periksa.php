<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="card" style="max-width: 800px; margin: 0 auto;">
  <div class="card-header">
    <div class="card-title">Pemeriksaan Dokter & Entri Rekam Medis (EMR)</div>
    <a href="<?= BASE_URL ?>/index.php?c=pasien&m=index" class="btn btn-outline btn-sm">&larr; Kembali</a>
  </div>
  <div class="card-body">
    <!-- INFO PASIEN -->
    <div style="background: #F8FAFC; border: 1px solid var(--border); border-radius: var(--radius-md); padding: 16px; margin-bottom: 20px;">
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; font-size: 13.5px;">
        <div><strong>No. RM:</strong> <?= htmlspecialchars($kunjungan['no_rm']) ?></div>
        <div><strong>Nama Pasien:</strong> <?= htmlspecialchars($kunjungan['nama_pasien']) ?> (<?= $kunjungan['jenis_kelamin'] ?>)</div>
        <div><strong>Layanan Poli:</strong> <?= htmlspecialchars($kunjungan['nama_layanan']) ?></div>
        <div><strong>Keluhan Pasien:</strong> <?= htmlspecialchars($kunjungan['keluhan']) ?></div>
      </div>
    </div>

    <form action="<?= BASE_URL ?>/index.php?c=pasien&m=periksa&id=<?= $kunjungan['id'] ?>" method="POST" data-validate="true">
      <div class="grid-form">
        <div class="form-group">
          <label class="form-label">Tekanan Darah (Tensi) *</label>
          <input type="text" name="tensi" class="form-control" value="<?= htmlspecialchars($kunjungan['tensi'] ?? '120/80') ?>" placeholder="Contoh: 120/80 mmHg" required>
        </div>
        <div class="form-group">
          <label class="form-label">Suhu Tubuh (°C) *</label>
          <input type="text" name="suhu" class="form-control" value="<?= htmlspecialchars($kunjungan['suhu'] ?? '36.5 C') ?>" placeholder="Contoh: 36.8 C" required>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Diagnosa Medis Dokter *</label>
        <input type="text" name="diagnosis" class="form-control" value="<?= htmlspecialchars($kunjungan['diagnosis'] ?? '') ?>" placeholder="Contoh: Faringitis Akut / ISPA" required>
      </div>

      <div class="form-group">
        <label class="form-label">Resep Obat / Instruksi Apotek *</label>
        <textarea name="resep_obat" class="form-control" rows="3" placeholder="Contoh: Amoxicillin 500mg 3x1, Paracetamol 500mg 3x1 prn" required><?= htmlspecialchars($kunjungan['resep_obat'] ?? '') ?></textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Status Tindak Lanjut *</label>
        <select name="status_periksa" class="form-control" required>
          <option value="Menuju Kasir">Menuju Kasir & Apotek (Selesai Diperiksa)</option>
          <option value="Diperiksa">Sedang Dalam Observasi / Pemeriksaan</option>
          <option value="Selesai">Tutup Pemeriksaan (Selesai)</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary" style="width: 100%; padding: 11px;">Simpan Rekam Medis & Arahkan ke Kasir &rarr;</button>
    </form>
  </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

