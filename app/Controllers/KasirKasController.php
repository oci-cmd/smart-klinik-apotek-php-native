<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\TransaksiKas;
use App\Models\BillingPasien;
use App\Models\BaganAkun;
use App\Models\RekamMedis;
use App\Models\AuditLog;

class KasirKasController extends Controller {
    public function index(): void {
        $this->checkAuth(['admin', 'kasir']);

        $kasModel     = new TransaksiKas();
        $billingModel = new BillingPasien();
        $akunModel    = new BaganAkun();
        $rmModel      = new RekamMedis();

        $transaksiKas = $kasModel->getAllWithAccount();
        $summaryKas   = $kasModel->getSummaryKas();
        $billings     = $billingModel->getAllWithDetails();
        $akuns        = $akunModel->getAll();
        
        // Ambil pasien yang statusnya Menuju Kasir
        $antreanKasir = array_filter($rmModel->getAllWithDetails(), fn($r) => $r['status_periksa'] === 'Menuju Kasir');

        $this->render('kasir/index', [
            'title'        => 'Kasir Billing Pasien & Kas Masuk/Keluar (Modul 4 - KA)',
            'transaksiKas' => $transaksiKas,
            'summaryKas'   => $summaryKas,
            'billings'     => $billings,
            'akuns'        => $akuns,
            'antreanKasir' => $antreanKasir
        ]);
    }

    public function bayarPasien(): void {
        $this->checkAuth(['admin', 'kasir']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rmId       = (int)($_POST['rekam_medis_id'] ?? 0);
            $totalLay   = (float)($_POST['total_layanan'] ?? 0);
            $totalObat  = (float)($_POST['total_obat'] ?? 0);
            $diskon     = (float)($_POST['diskon'] ?? 0);
            $grandTotal = ($totalLay + $totalObat) - $diskon;
            $bayar      = (float)($_POST['nominal_bayar'] ?? 0);
            $kembali    = max(0, $bayar - $grandTotal);

            if ($bayar < $grandTotal) {
                $this->setFlash('danger', 'Nominal bayar kurang dari total tagihan faktur!');
                $this->redirect('/index.php?c=kasirKas&m=index');
            }

            $data = [
                'no_faktur'      => 'INV-' . date('Ym') . '-' . sprintf('%03d', rand(1, 999)),
                'rekam_medis_id' => $rmId,
                'total_layanan'  => $totalLay,
                'total_obat'     => $totalObat,
                'diskon'         => $diskon,
                'grand_total'    => $grandTotal,
                'nominal_bayar'  => $bayar,
                'kembalian'      => $kembali,
                'metode_bayar'   => $_POST['metode_bayar'] ?? 'Tunai',
                'kasir_user'     => $_SESSION['username'] ?? 'kasir1'
            ];

            $billingModel = new BillingPasien();
            if ($billingModel->create($data)) {
                (new AuditLog())->log('BILLING', 'Kasir Pembayaran', "Menerbitkan faktur {$data['no_faktur']} senilai Rp " . number_format($grandTotal));
                $this->setFlash('success', "Pembayaran faktur {$data['no_faktur']} berhasil diselesaikan dan dicatat ke Kas Masuk!");
            } else {
                $this->setFlash('danger', 'Gagal memproses pembayaran kasir.');
            }
            $this->redirect('/index.php?c=kasirKas&m=index');
        }
    }

    public function createKas(): void {
        $this->checkAuth(['admin', 'kasir']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'no_transaksi'    => 'KAS-' . (($_POST['jenis_transaksi'] === 'Kas Masuk') ? 'IN-' : 'OUT-') . time(),
                'tgl_kunjungan'   => trim($_POST['tgl_transaksi'] ?? date('Y-m-d')),
                'akun_id'         => (int)($_POST['akun_id'] ?? 0),
                'jenis_transaksi' => trim($_POST['jenis_transaksi'] ?? 'Kas Masuk'),
                'nominal'         => (float)($_POST['nominal'] ?? 0),
                'kategori'        => trim($_POST['kategori'] ?? 'Operasional'),
                'keterangan'      => trim($_POST['keterangan'] ?? ''),
                'operator'        => $_SESSION['username'] ?? 'kasir1'
            ];

            $kasModel = new TransaksiKas();
            if ($kasModel->create($data)) {
                (new AuditLog())->log('TRANSAKSI_KAS', 'Buku Kas', "Mencatat {$data['jenis_transaksi']} sebesar Rp " . number_format($data['nominal']));
                $this->setFlash('success', "Transaksi {$data['jenis_transaksi']} berhasil dibukukan!");
            } else {
                $this->setFlash('danger', 'Gagal menyimpan transaksi kas. Saldo kas tidak mencukupi untuk transaksi pengeluaran (Validasi Anti-Saldo Minus)!');
            }
            $this->redirect('/index.php?c=kasirKas&m=index');
        }
    }
}

