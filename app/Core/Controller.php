<?php
namespace App\Core;

/**
 * Base Controller
 * Menyediakan method render view, redirect, session auth guard, flash message
 */
class Controller {
    public function __construct() {
        Security::initSession();
    }

    protected function render(string $viewPath, array $data = []): void {
        extract($data);
        $fullPath = __DIR__ . '/../Views/' . $viewPath . '.php';

        if (file_exists($fullPath)) {
            require_once $fullPath;
        } else {
            die("View [{$viewPath}] tidak ditemukan pada: " . htmlspecialchars($fullPath));
        }
    }

    protected function redirect(string $url): void {
        header("Location: " . BASE_URL . $url);
        exit;
    }

    protected function checkAuth(array $allowedRoles = []): void {
        if (empty($_SESSION['user_id'])) {
            $this->setFlash('danger', 'Silakan login terlebih dahulu untuk mengakses sistem.');
            $this->redirect('/index.php?c=auth&m=login');
        }

        if (!empty($allowedRoles) && !in_array($_SESSION['role'] ?? '', $allowedRoles)) {
            $this->setFlash('danger', 'Akses ditolak: Anda tidak memiliki hak akses untuk modul tersebut.');
            $this->redirect('/index.php?c=dashboard&m=index');
        }
    }

    protected function setFlash(string $type, string $message): void {
        Security::initSession();
        $_SESSION['flash'] = [
            'type'    => $type, // success, danger, warning, info
            'message' => $message
        ];
    }

    public static function getFlash(): ?array {
        Security::initSession();
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }
}

