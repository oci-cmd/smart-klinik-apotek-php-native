<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\LayananMedis;
use App\Models\Obat;

class HomeController extends Controller {
    public function index(): void {
        $layananModel = new LayananMedis();
        $obatModel    = new Obat();

        $layananList = $layananModel->getAll();
        $obatCatalog = array_slice($obatModel->getAll(), 0, 6);

        $this->render('home/index', [
            'title'       => 'SmartClinic Pratama & Farmasi Terpadu - Layanan Medis Modern Cirebon',
            'layananList' => $layananList,
            'obatCatalog' => $obatCatalog
        ]);
    }
}
