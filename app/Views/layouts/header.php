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
      <div class="topbar-right">
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

