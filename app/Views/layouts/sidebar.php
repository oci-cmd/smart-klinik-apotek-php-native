<?php
$currentC = $_GET['c'] ?? 'dashboard';
$role = $_SESSION['role'] ?? 'guest';
$nama = $_SESSION['nama_lengkap'] ?? 'User';
?>
<aside class="sidebar">
  <div class="sidebar-header" style="cursor:pointer;" onclick="window.open('<?= BASE_URL ?>/', '_blank');" title="Klik untuk membuka Landing Page Website">
    <div class="brand-icon">🏥</div>
    <div>
      <div class="brand-title">SmartClinic ERP</div>
      <div class="brand-subtitle">SI & KA Integration</div>
    </div>
  </div>

  <nav class="sidebar-menu">
    <div class="menu-category" style="display:flex;align-items:center;justify-content:space-between;">
      <span>Frontend & Portal</span>
      <span style="font-size:10px;color:var(--text-muted);text-transform:none;">Publik</span>
    </div>
    <a href="<?= BASE_URL ?>/" target="_blank" class="nav-link" style="color:#0284c7;background:rgba(14,165,233,0.08);border:1px dashed rgba(14,165,233,0.35);margin-bottom:8px;font-weight:600;" title="Buka Website Landing Page Publik">
      <span class="nav-icon">🌐</span>
      <span>Website Depan</span>
      <span style="font-size:10px;background:#0284c7;color:#fff;padding:2px 6px;border-radius:4px;margin-left:auto;">Buka ↗</span>
    </a>

    <div class="menu-category">Menu Utama</div>
    <a href="<?= BASE_URL ?>/index.php?c=dashboard&m=index" class="nav-link <?= ($currentC === 'dashboard') ? 'active' : '' ?>">
      <span class="nav-icon">📊</span>
      <span>Dashboard Analitik</span>
    </a>

    <div class="menu-category">Prodi Sistem Informasi (SI)</div>
    <a href="<?= BASE_URL ?>/index.php?c=layananObat&m=index" class="nav-link <?= ($currentC === 'layananObat') ? 'active' : '' ?>">
      <span class="nav-icon">💊</span>
      <span>Layanan & Obat (M1)</span>
    </a>
    <a href="<?= BASE_URL ?>/index.php?c=pasien&m=index" class="nav-link <?= ($currentC === 'pasien') ? 'active' : '' ?>">
      <span class="nav-icon">🧑‍⚕️</span>
      <span>Pasien & Rekam Medis (M2)</span>
    </a>

    <div class="menu-category">Prodi Komputerisasi Akuntansi (KA)</div>
    <a href="<?= BASE_URL ?>/index.php?c=baganAkun&m=index" class="nav-link <?= ($currentC === 'baganAkun') ? 'active' : '' ?>">
      <span class="nav-icon">📑</span>
      <span>Bagan Akun COA (M3)</span>
    </a>
    <a href="<?= BASE_URL ?>/index.php?c=kasirKas&m=index" class="nav-link <?= ($currentC === 'kasirKas') ? 'active' : '' ?>">
      <span class="nav-icon">💳</span>
      <span>Kasir & Buku Kas (M4)</span>
    </a>

    <div class="menu-category">Sinergi SI + KA</div>
    <a href="<?= BASE_URL ?>/index.php?c=spkAudit&m=index" class="nav-link <?= ($currentC === 'spkAudit') ? 'active' : '' ?>">
      <span class="nav-icon">⚖️</span>
      <span>SPK SAW & Audit Log (M5)</span>
    </a>
  </nav>

  <div class="sidebar-footer">
    <div class="user-profile">
      <div class="avatar"><?= strtoupper(substr($nama, 0, 1)) ?></div>
      <div class="user-info">
        <div class="user-name"><?= htmlspecialchars($nama) ?></div>
        <div class="user-role">Role: <?= htmlspecialchars($role) ?></div>
      </div>
    </div>
  </div>
</aside>
