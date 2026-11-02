<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($title ?? 'SmartClinic Pratama & Farmasi') ?></title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
  <style>
    :root {
      --hero-gradient: linear-gradient(135deg, #0B132B 0%, #1C2541 60%, #0F766E 100%);
    }
    body {
      display: block;
      background-color: #FFFFFF;
      min-height: 100vh;
    }
    /* NAVBAR */
    .landing-navbar {
      background: #FFFFFF;
      border-bottom: 1px solid var(--border);
      padding: 16px 40px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    }
    .nav-brand {
      display: flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
    }
    .nav-brand-icon {
      width: 42px;
      height: 42px;
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      color: #fff;
      font-size: 22px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
    }
    .nav-brand-text {
      font-size: 18px;
      font-weight: 800;
      color: var(--text-main);
      line-height: 1.2;
    }
    .nav-brand-sub {
      font-size: 11.5px;
      color: var(--text-muted);
    }
    .nav-links {
      display: flex;
      align-items: center;
      gap: 24px;
    }
    .nav-item {
      font-size: 14px;
      font-weight: 600;
      color: var(--text-muted);
      text-decoration: none;
      transition: color 0.2s;
    }
    .nav-item:hover {
      color: var(--primary);
    }
    .btn-login-portal {
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      color: #fff;
      padding: 9px 20px;
      border-radius: 9999px;
      font-size: 13.5px;
      font-weight: 700;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
      transition: all 0.2s;
    }
    .btn-login-portal:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(14, 165, 233, 0.4);
    }

    /* HERO SECTION */
    .hero-section {
      background: var(--hero-gradient);
      color: #FFFFFF;
      padding: 80px 40px 90px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(8px);
      padding: 6px 16px;
      border-radius: 9999px;
      font-size: 12.5px;
      font-weight: 600;
      color: #38BDF8;
      margin-bottom: 24px;
    }
    .hero-title {
      font-size: 42px;
      font-weight: 800;
      line-height: 1.25;
      max-width: 860px;
      margin: 0 auto 20px;
      letter-spacing: -0.5px;
    }
    .hero-subtitle {
      font-size: 16px;
      color: #CBD5E1;
      max-width: 680px;
      margin: 0 auto 36px;
      line-height: 1.6;
    }
    .hero-actions {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 16px;
      flex-wrap: wrap;
    }
    .btn-hero-primary {
      background: #0EA5E9;
      color: #fff;
      padding: 13px 28px;
      border-radius: 12px;
      font-size: 15px;
      font-weight: 700;
      text-decoration: none;
      transition: all 0.2s;
    }
    .btn-hero-primary:hover {
      background: #0284C7;
      transform: translateY(-2px);
    }
    .btn-hero-secondary {
      background: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.25);
      color: #fff;
      padding: 13px 28px;
      border-radius: 12px;
      font-size: 15px;
      font-weight: 600;
      text-decoration: none;
      backdrop-filter: blur(6px);
      transition: all 0.2s;
    }
    .btn-hero-secondary:hover {
      background: rgba(255, 255, 255, 0.16);
    }

    /* SECTION CONTAINER */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 70px 24px;
    }
    .section-header {
      text-align: center;
      margin-bottom: 48px;
    }
    .section-tag {
      font-size: 12px;
      text-transform: uppercase;
      font-weight: 800;
      color: var(--primary);
      letter-spacing: 1.5px;
      margin-bottom: 8px;
    }
    .section-title-landing {
      font-size: 30px;
      font-weight: 800;
      color: var(--text-main);
      line-height: 1.3;
    }

    /* CARDS GRID */
    .grid-features {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 24px;
    }
    .feature-card {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 28px 24px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
      transition: all 0.3s;
    }
    .feature-card:hover {
      transform: translateY(-4px);
      box-shadow: var(--shadow-lg);
      border-color: #BAE6FD;
    }
    .feature-icon-box {
      width: 52px;
      height: 52px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      margin-bottom: 18px;
    }

    /* POLI & PRICING GRID */
    .grid-poli {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 20px;
    }
    .poli-item {
      background: #F8FAFC;
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 20px 22px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    /* FOOTER */
    .landing-footer {
      background: #0B132B;
      color: #94A3B8;
      padding: 60px 40px 30px;
      border-top: 1px solid rgba(255, 255, 255, 0.08);
    }
    .footer-content {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 2fr 1fr 1fr;
      gap: 40px;
      margin-bottom: 40px;
    }
    .footer-col h4 {
      color: #fff;
      font-size: 15px;
      font-weight: 700;
      margin-bottom: 16px;
    }
    .footer-col p {
      font-size: 13.5px;
      line-height: 1.6;
    }
    .footer-bottom {
      max-width: 1200px;
      margin: 0 auto;
      padding-top: 24px;
      border-top: 1px solid rgba(255, 255, 255, 0.08);
      font-size: 12.5px;
      text-align: center;
    }

    @media (max-width: 768px) {
      .landing-navbar {
        padding: 14px 20px;
      }
      .nav-links {
        display: none;
      }
      .hero-title {
        font-size: 28px;
      }
      .footer-content {
        grid-template-columns: 1fr;
        gap: 28px;
      }
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="landing-navbar">
  <a href="<?= BASE_URL ?>/index.php" class="nav-brand">
    <div class="nav-brand-icon">🏥</div>
    <div>
      <div class="nav-brand-text">SmartClinic Pratama</div>
      <div class="nav-brand-sub">Klinik & Apotek Modern Cirebon</div>
    </div>
  </a>

  <div class="nav-links">
    <a href="#layanan" class="nav-item">Layanan Poli</a>
    <a href="#farmasi" class="nav-item">Katalog Obat</a>
    <a href="#keunggulan" class="nav-item">Keunggulan ERP</a>
    <a href="#kontak" class="nav-item">Kontak & Lokasi</a>
  </div>

  <div>
    <a href="<?= BASE_URL ?>/index.php?c=auth&m=login" class="btn-login-portal">
      <span>Portal Petugas / CMS</span>
      <span>&rarr;</span>
    </a>
  </div>
</nav>

<!-- HERO SECTION -->
<header class="hero-section">
  <div class="hero-badge">
    <span>🌟 Terakreditasi Paripurna & Berbasis Sistem Terpadu</span>
  </div>
  <h1 class="hero-title">Pelayanan Medis Prima & Pengelolaan Farmasi Digital Terpadu</h1>
  <p class="hero-subtitle">
    Pusat layanan kesehatan rawat jalan modern di Cirebon yang mengintegrasikan pendaftaran pasien cepat, rekam medis elektronik (EMR), ketersediaan obat farmasi, dan transparansi kasir digital.
  </p>
  <div class="hero-actions">
    <a href="<?= BASE_URL ?>/index.php?c=auth&m=login" class="btn-hero-primary">
      Masuk ke Admin Panel CMS &rarr;
    </a>
    <a href="#layanan" class="btn-hero-secondary">
      Lihat Layanan Poli Medis
    </a>
  </div>
</header>

<!-- STATS STRIP -->
<div style="background: #F8FAFC; border-bottom: 1px solid var(--border); padding: 30px 20px;">
  <div style="max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; text-align: center;">
    <div>
      <div style="font-size: 32px; font-weight: 800; color: var(--primary);">5 Poli</div>
      <div style="font-size: 13px; color: var(--text-muted); font-weight: 600;">Layanan Spesialis & Umum</div>
    </div>
    <div>
      <div style="font-size: 32px; font-weight: 800; color: var(--success);">&gt; 120 Obat</div>
      <div style="font-size: 13px; color: var(--text-muted); font-weight: 600;">Farmasi Lengkap & Tersedia</div>
    </div>
    <div>
      <div style="font-size: 32px; font-weight: 800; color: var(--secondary);">100% Digital</div>
      <div style="font-size: 13px; color: var(--text-muted); font-weight: 600;">Rekam Medis Elektronik (EMR)</div>
    </div>
    <div>
      <div style="font-size: 32px; font-weight: 800; color: var(--warning);">Realtime</div>
      <div style="font-size: 13px; color: var(--text-muted); font-weight: 600;">Billing Kasir & SPK Belanja</div>
    </div>
  </div>
</div>

<!-- SECTION 1: LAYANAN POLI MEDIS -->
<section id="layanan" class="container">
  <div class="section-header">
    <div class="section-tag">Poli & Tindakan Medis</div>
    <h2 class="section-title-landing">Layanan Poli Kesehatan Kami</h2>
    <p style="color: var(--text-muted); margin-top: 8px;">Ditangani oleh dokter berpengalaman dan didukung fasilitas medis mutakhir.</p>
  </div>

  <div class="grid-poli">
    <?php foreach ($layananList as $lay): ?>
      <div class="poli-item">
        <div>
          <span class="badge badge-primary" style="margin-bottom: 6px;"><?= htmlspecialchars($lay['poli']) ?></span>
          <h4 style="font-size: 16px; font-weight: 700; color: var(--text-main);"><?= htmlspecialchars($lay['nama_layanan']) ?></h4>
          <span style="font-size: 12px; color: var(--text-muted);">Kode: <?= htmlspecialchars($lay['kode_layanan']) ?></span>
        </div>
        <div style="text-align: right;">
          <div style="font-size: 12px; color: var(--text-muted);">Tarif Dokter</div>
          <div style="font-size: 18px; font-weight: 800; color: var(--success);">Rp <?= number_format($lay['tarif'], 0, ',', '.') ?></div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- SECTION 2: KATALOG OBAT FARMASI -->
<section id="farmasi" style="background: #F8FAFC; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
  <div class="container">
    <div class="section-header">
      <div class="section-tag">Katalog Farmasi Apotek</div>
      <h2 class="section-title-landing">Ketersediaan Obat Berkualitas</h2>
      <p style="color: var(--text-muted); margin-top: 8px;">Penyediaan obat resep dan obat bebas dengan standar mutu dan tanggal kedaluwarsa terpantau ketat.</p>
    </div>

    <div class="grid-features">
      <?php foreach ($obatCatalog as $obt): ?>
        <div class="feature-card">
          <div class="feature-icon-box icon-blue">💊</div>
          <span class="badge badge-success" style="margin-bottom: 8px;"><?= htmlspecialchars($obt['kategori']) ?></span>
          <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 6px;"><?= htmlspecialchars($obt['nama_obat']) ?></h4>
          <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 16px;">
            Satuan: <strong><?= htmlspecialchars($obt['satuan']) ?></strong><br>
            Tersedia: <strong><?= $obt['stok'] ?> unit</strong> di apotek.
          </p>
          <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border-light); padding-top: 12px;">
            <span style="font-size: 12px; color: var(--text-muted);">Harga Apotek</span>
            <strong style="color: var(--primary); font-size: 16px;">Rp <?= number_format($obt['harga_jual'], 0, ',', '.') ?></strong>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- SECTION 3: KEUNGGULAN SISTEM ERP HYBRID (SI & KA) -->
<section id="keunggulan" class="container">
  <div class="section-header">
    <div class="section-tag">Pondasi Akademik Terpadu</div>
    <h2 class="section-title-landing">Keunggulan Integrasi S1 SI & D3/D4 KA</h2>
    <p style="color: var(--text-muted); margin-top: 8px;">Dibangun sebagai model acuan mahasiswa STMIK IKMI Cirebon pada mata kuliah Pemrograman Web Dasar.</p>
  </div>

  <div class="grid-features">
    <div class="feature-card">
      <div class="feature-icon-box icon-blue">🧑‍⚕️</div>
      <h4 style="font-size: 17px; font-weight: 700; margin-bottom: 8px;">Modul 1 & 2 (SI)</h4>
      <p style="font-size: 13.5px; color: var(--text-muted); line-height: 1.6;">
        Registrasi identitas pasien, penerbitan nomor RM, antrean poli, rekam medis dokter (EMR), dan pemantauan obat expired.
      </p>
    </div>

    <div class="feature-card">
      <div class="feature-icon-box icon-green">💳</div>
      <h4 style="font-size: 17px; font-weight: 700; margin-bottom: 8px;">Modul 3 & 4 (KA)</h4>
      <p style="font-size: 13.5px; color: var(--text-muted); line-height: 1.6;">
        Bagan Akun Standar (COA), billing kasir tindakan + obat, kuitansi cetak otomatis, dan validasi buku kas anti-saldo minus.
      </p>
    </div>

    <div class="feature-card">
      <div class="feature-icon-box icon-amber">⚖️</div>
      <h4 style="font-size: 17px; font-weight: 700; margin-bottom: 8px;">Modul 5 (SI + KA)</h4>
      <p style="font-size: 13.5px; color: var(--text-muted); line-height: 1.6;">
        Algoritma SPK Simple Additive Weighting (SAW) untuk penentuan prioritas belanja obat kritis serta Audit Log OWASP.
      </p>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer id="kontak" class="landing-footer">
  <div class="footer-content">
    <div class="footer-col">
      <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 14px;">
        <div style="width: 34px; height: 34px; background: var(--primary); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 18px;">🏥</div>
        <span style="color: #fff; font-weight: 800; font-size: 17px;">SmartClinic & Apotek Farmasi</span>
      </div>
      <p>
        Pusat pelayanan kesehatan rawat jalan terpadu dengan integrasi rekam medis elektronik dan akuntansi kasir modern. Membuka layanan setiap hari kerja dari pukul 08:00 s.d. 21:00 WIB.
      </p>
    </div>

    <div class="footer-col">
      <h4>Navigasi Halaman</h4>
      <p>
        • <a href="#layanan" style="color: #94A3B8; text-decoration: none;">Layanan Poli</a><br>
        • <a href="#farmasi" style="color: #94A3B8; text-decoration: none;">Katalog Obat</a><br>
        • <a href="<?= BASE_URL ?>/index.php?c=auth&m=login" style="color: #38BDF8; text-decoration: none; font-weight: 600;">Portal CMS Petugas</a>
      </p>
    </div>

    <div class="footer-col">
      <h4>Kontak & Lokasi</h4>
      <p>
        📍 Jl. Tuparev No. 45, Cirebon, Jawa Barat<br>
        📞 Telepon/WA: (0231) 889977<br>
        📧 Email: kontak@smartklinik-cirebon.id
      </p>
    </div>
  </div>

  <div class="footer-bottom">
    &copy; 2026 <strong>STMIK IKMI Cirebon</strong> — Pemrograman Web Dasar. Disusun oleh: <strong>Rosidin, S. Kom., M. Kom.</strong>
  </div>
</footer>

</body>
</html>
