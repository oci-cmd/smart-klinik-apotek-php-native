<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\BaganAkun;
use App\Models\AuditLog;

class BaganAkunController extends Controller {
    public function index(): void {
        $this->checkAuth(['admin', 'kasir']);

        $akunModel = new BaganAkun();
        $akuns     = $akunModel->getAll();

        $this->render('akun/index', [
            'title' => 'Bagan Akun Standar (COA) Finansial Klinik (Modul 3 - KA)',
            'akuns' => $akuns
        ]);
    }

    public function create(): void {
        $this->checkAuth(['admin']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'kode_akun'    => trim($_POST['kode_akun'] ?? ''),
                'nama_akun'    => trim($_POST['nama_akun'] ?? ''),
                'kelompok'     => trim($_POST['kelompok'] ?? 'Aset'),
                'saldo_normal' => trim($_POST['saldo_normal'] ?? 'Debet'),
                'saldo_awal'   => (float)($_POST['saldo_awal'] ?? 0),
                'status'       => trim($_POST['status'] ?? 'aktif')
            ];

            $akunModel = new BaganAkun();
            if ($akunModel->create($data)) {
                (new AuditLog())->log('CREATE', 'Bagan Akun COA', "Menambah akun {$data['kode_akun']} - {$data['nama_akun']}");
                $this->setFlash('success', 'Rekening akun baru berhasil ditambahkan ke COA!');
            } else {
                $this->setFlash('danger', 'Gagal menambahkan akun. Kode akun mungkin telah terdaftar.');
            }
            $this->redirect('/index.php?c=baganAkun&m=index');
        }
    }

    public function delete(): void {
        $this->checkAuth(['admin']);
        $id = (int)($_GET['id'] ?? 0);
        $akunModel = new BaganAkun();

        if ($akunModel->delete($id)) {
            (new AuditLog())->log('DELETE', 'Bagan Akun COA', "Menghapus akun ID {$id}");
            $this->setFlash('success', 'Akun berhasil dihapus dari bagan akun.');
        } else {
            $this->setFlash('danger', 'Akun tidak dapat dihapus karena sudah memiliki riwayat mutasi transaksi kas!');
        }
        $this->redirect('/index.php?c=baganAkun&m=index');
    }
}

