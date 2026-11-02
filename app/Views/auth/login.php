<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($title ?? 'Login Petugas - Smart Clinic ERP') ?></title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
  <style>
    body {
      background: radial-gradient(circle at top left, #E0F2FE, transparent 40%),
                  radial-gradient(circle at bottom right, #D1FAE5, transparent 40%),
                  #F8FAFC;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 24px;
    }
    .login-container {
      width: 100%;
      max-width: 440px;
    }
    .login-card {
      background: #FFFFFF;
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 38px 34px;
      box-shadow: 0 15px 35px rgba(15, 23, 42, 0.08);
      position: relative;
    }
    .back-home {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 13px;
      font-weight: 600;
      color: var(--primary);
      text-decoration: none;
      margin-bottom: 20px;
      transition: gap 0.2s;
    }
    .back-home:hover {
      gap: 10px;
    }
    .login-brand {
      text-align: center;
      margin-bottom: 28px;
    }
    .login-brand-icon {
      width: 60px;
      height: 60px;
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      color: #fff;
      font-size: 30px;
      border-radius: 16px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 12px;
      box-shadow: 0 10px 20px rgba(14, 165, 233, 0.25);
    }
    .password-wrapper {
      position: relative;
      display: flex;
      align-items: center;
    }
    .password-wrapper input {
      padding-right: 44px;
    }
    .toggle-password-btn {
      position: absolute;
      right: 12px;
      background: none;
      border: none;
      color: var(--text-muted);
      cursor: pointer;
      font-size: 18px;
      padding: 4px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: color 0.2s;
    }
    .toggle-password-btn:hover {
      color: var(--text-main);
    }
    .demo-box {
      margin-top: 24px;
      padding: 16px;
      background: #F8FAFC;
      border: 1px dashed var(--border);
      border-radius: 12px;
      font-size: 12px;
      color: var(--text-muted);
      line-height: 1.6;
    }
  </style>
</head>
<body>

<div class="login-container">
  <div class="login-card">
    <a href="<?= BASE_URL ?>/index.php" class="back-home">&larr; Kembali ke Beranda Utama</a>
    
    <div class="login-brand">
      <div class="login-brand-icon">🏥</div>
      <h2 style="font-size: 22px; font-weight: 800; color: var(--text-main);">SmartClinic ERP</h2>
      <p style="font-size: 13px; color: var(--text-muted); margin-top: 4px;">Sistem Informasi Manajemen Klinik & Farmasi</p>
    </div>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger" style="margin-bottom: 20px;">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>/index.php?c=auth&m=login" method="POST" data-validate="true">
      <div class="form-group">
        <label class="form-label">Username Petugas</label>
        <input type="text" name="username" class="form-control" placeholder="Contoh: admin" required autofocus>
      </div>

      <div class="form-group">
        <label class="form-label">Kata Sandi (Password)</label>
        <div class="password-wrapper">
          <input type="password" id="inputPassword" name="password" class="form-control" placeholder="••••••••" required>
          <button type="button" class="toggle-password-btn" id="btnTogglePassword" aria-label="Toggle Password Visibility" title="Tampilkan/Sembunyikan Password">
            <span id="eyeIcon">👁️</span>
          </button>
        </div>
      </div>

      <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 14px; margin-top: 8px;">
        Masuk ke Dashboard Sistem
      </button>
    </form>

    <div class="demo-box">
      <strong style="color: var(--text-main);">🔑 Kredensial Login Demo (Password: <code>admin123</code>):</strong><br>
      • <strong>Super Admin</strong>: <code>admin</code> (Hak Akses Lengkap)<br>
      • <strong>Dokter Poli</strong>: <code>dokter1</code> (Pemeriksaan & Resep EMR)<br>
      • <strong>Kasir Billing</strong>: <code>kasir1</code> (Kas Masuk & Faktur)<br>
      • <strong>Apoteker</strong>: <code>apoteker1</code> (Stok Obat & SPK Belanja)
    </div>
  </div>
</div>

<script src="<?= BASE_URL ?>/assets/js/form-validator.js"></script>
<script>
  // Fitur Eye Visible / Invisible Toggle Password
  const btnToggle = document.getElementById('btnTogglePassword');
  const pwdInput = document.getElementById('inputPassword');
  const eyeIcon = document.getElementById('eyeIcon');

  if (btnToggle && pwdInput && eyeIcon) {
    btnToggle.addEventListener('click', () => {
      if (pwdInput.type === 'password') {
        pwdInput.type = 'text';
        eyeIcon.textContent = '🙈';
        btnToggle.setAttribute('title', 'Sembunyikan Kata Sandi');
      } else {
        pwdInput.type = 'password';
        eyeIcon.textContent = '👁️';
        btnToggle.setAttribute('title', 'Tampilkan Kata Sandi');
      }
    });
  }
</script>
</body>
</html>
