<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($title ?? APP_NAME) ?></title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/responsive.css">
</head>
<body>
<div class="sidebar-backdrop"></div>
<div class="app-container">
  <?php require_once __DIR__ . '/sidebar.php'; ?>
  <div class="main-wrapper">
    <header class="topbar">
      <div class="topbar-left">
        <button type="button" class="btn-toggle-sidebar" aria-label="Toggle Navigation">☰</button>
        <h1 class="page-title"><?= htmlspecialchars($title ?? 'Dashboard') ?></h1>
      </div>
      <div class="topbar-right" style="display:flex;align-items:center;gap:12px;">
        <a href="<?= BASE_URL ?>/" target="_blank" class="btn btn-primary btn-sm" style="display:inline-flex;align-items:center;gap:6px;text-decoration:none;font-weight:600;padding:7px 14px;border-radius:8px;box-shadow:0 2px 6px rgba(14,165,233,0.3);" title="Buka Halaman Depan Website (Landing Page)">
          <span>🌐</span>
          <span>Lihat Website</span>
        </a>
        <span class="badge badge-success">● Server Online (Port 3306)</span>
        <a href="<?= BASE_URL ?>/index.php?c=auth&m=logout" class="btn btn-outline btn-sm">Keluar</a>
      </div>
    </header>
    <main class="content-area">
      <?php if ($flash = \App\Core\Controller::getFlash()): ?>
        <div class="alert alert-<?= htmlspecialchars($flash['type']) ?>">
          <strong>Info:</strong> <?= htmlspecialchars($flash['message']) ?>
        </div>
      <?php endif; ?>
