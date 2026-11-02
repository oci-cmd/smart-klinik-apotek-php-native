<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Pasien;
use App\Models\Obat;
use App\Models\RekamMedis;
use App\Models\TransaksiKas;

class DashboardController extends Controller {
    public function index(): void {
        $this->checkAuth();

        $pasienModel = new Pasien();
        $obatModel   = new Obat();
        $rmModel     = new RekamMedis();
        $kasModel    = new TransaksiKas();

        $totalPasien    = count($pasienModel->getAll());
        $obatMenipis    = count($obatModel->getLowStock());
        $obatExpired    = count($obatModel->getExpiringSoon());
        $kunjunganHariIni = count($rmModel->getAllWithDetails());
        $summaryKas     = $kasModel->getSummaryKas();
        $listKunjungan  = array_slice($rmModel->getAllWithDetails(), 0, 5);

        $this->render('dashboard/index', [
            'title'            => 'Dashboard Analitik Medis & Finansial',
            'totalPasien'      => $totalPasien,
            'obatMenipis'      => $obatMenipis,
            'obatExpired'      => $obatExpired,
            'kunjunganHariIni' => $kunjunganHariIni,
            'summaryKas'       => $summaryKas,
            'listKunjungan'    => $listKunjungan
        ]);
    }
}

