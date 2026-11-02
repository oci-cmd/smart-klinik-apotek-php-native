<?php
/**
 * Database Auto-Migrator: Smart Clinic & Pharmacy ERP
 * Mengimpor database.sql ke MySQL secara otomatis hanya dengan 1 klik!
 */

require_once __DIR__ . '/config/config.php';

$message = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['auto'])) {
    try {
        // Hubungkan ke MySQL Server tanpa memilih db terlebih dahulu
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";charset=utf8mb4", DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $sqlFile = __DIR__ . '/config/database.sql';
        if (!file_exists($sqlFile)) {
            throw new Exception("Berkas skema database.sql tidak ditemukan!");
        }

        $sqlContent = file_get_contents($sqlFile);

        // Eksekusi multi query
        $pdo->exec($sqlContent);
        $message = "Basis data <strong>smart_klinik_db</strong> beserta 10 tabel dan dummy data realistis berhasil diinisialisasi 100%!";
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Setup Basis Data - Smart Clinic ERP</title>
  <style>
    body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #F8FAFC; color: #0F172A; padding: 40px 20px; }
    .box { max-width: 650px; margin: 0 auto; background: #fff; border: 1px solid #E2E8F0; border-radius: 16px; padding: 36px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
    h2 { font-size: 22px; font-weight: 800; margin-bottom: 8px; color: #0F172A; }
    p { font-size: 14px; color: #64748B; line-height: 1.6; margin-bottom: 24px; }
    .btn { background: #0EA5E9; color: #fff; border: none; padding: 12px 24px; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer; text-decoration: none; display: inline-block; }
    .btn:hover { background: #0284C7; }
    .alert { padding: 16px; border-radius: 8px; font-size: 13.5px; margin-bottom: 20px; }
    .alert-success { background: #D1FAE5; color: #065F46; border: 1px solid #A7F3D0; }
    .alert-danger { background: #FEE2E2; color: #991B1B; border: 1px solid #FECACA; }
  </style>
</head>
<body>

<div class="box">
  <div style="font-size: 40px; margin-bottom: 12px;">🏥</div>
  <h2>Database Auto-Migrator & Seeder</h2>
  <p>Inisialisasi otomatis basis data <strong>smart_klinik_db</strong> untuk proyek pegangan dosen Pemrograman Web Dasar STMIK IKMI Cirebon.</p>

  <?php if ($message): ?>
    <div class="alert alert-success">
      <?= $message ?><br><br>
      <a href="index.php" class="btn" style="background: #10B981;">Buka Halaman Login Aplikasi &rarr;</a>
    </div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger">
      <strong>Gagal Migrasi Database:</strong><br>
      <?= htmlspecialchars($error) ?><br><br>
      <small>Pastikan MySQL aktif di port <?= DB_PORT ?> dengan user <?= DB_USER ?>.</small>
    </div>
  <?php else: ?>
    <form method="POST">
      <button type="submit" class="btn">🚀 Eksekusi Migrasi Basis Data Sekarang</button>
    </form>
  <?php endif; ?>
</div>

</body>
</html>

