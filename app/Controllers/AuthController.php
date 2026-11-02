<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Security;
use App\Models\User;
use App\Models\AuditLog;

class AuthController extends Controller {
    public function login(): void {
        Security::initSession();
        if (!empty($_SESSION['user_id'])) {
            $this->redirect('/index.php?c=dashboard&m=index');
        }

        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $userModel = new User();
            $user = $userModel->findByUsername($username);

            // Validasi Bcrypt & Status Aktif
            if ($user && Security::verifyPassword($password, $user['password'])) {
                session_regenerate_id(true); // Proteksi Session Fixation
                $_SESSION['user_id']      = $user['id'];
                $_SESSION['username']     = $user['username'];
                $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                $_SESSION['role']         = $user['role'];

                // Audit Log Login
                (new AuditLog())->log('LOGIN', 'Autentikasi', "Login berhasil sebagai {$user['role']}");

                $this->setFlash('success', "Selamat datang kembali, {$user['nama_lengkap']}!");
                $this->redirect('/index.php?c=dashboard&m=index');
            } else {
                $error = "Username atau password yang Anda masukkan salah!";
                (new AuditLog())->log('LOGIN_FAILED', 'Autentikasi', "Percobaan login gagal dengan username: {$username}");
            }
        }

        $this->render('auth/login', [
            'title' => 'Login Petugas - Smart Clinic ERP',
            'error' => $error
        ]);
    }

    public function logout(): void {
        Security::initSession();
        (new AuditLog())->log('LOGOUT', 'Autentikasi', 'User keluar dari sistem');
        $_SESSION = [];
        session_destroy();
        $this->redirect('/index.php?c=auth&m=login');
    }
}

