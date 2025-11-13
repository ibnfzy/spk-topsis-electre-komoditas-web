<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Models\BobotKriteriaModel;
use App\Models\KomoditasTambakModel;
use App\Models\KriteriaModel;
use App\Models\NilaiKriteriaModel;

class DashboardController extends BaseController
{
    public function index(): string
    {
        helper('url');

        $kriteriaModel      = new KriteriaModel();
        $komoditasModel     = new KomoditasTambakModel();
        $bobotKriteriaModel = new BobotKriteriaModel();
        $nilaiKriteriaModel = new NilaiKriteriaModel();

        $stats = [
            'kriteria'        => $kriteriaModel->countAll(),
            'komoditas'       => $komoditasModel->countAll(),
            'bobot_kriteria'  => $bobotKriteriaModel->countAll(),
            'nilai_kriteria'  => $nilaiKriteriaModel->countAll(),
        ];

        $insights = [
            'avg_score'      => number_format(0, 2, ',', '.'),
            'top_commodity'  => 'Belum tersedia',
            'popular_method' => 'TOPSIS',
        ];

        return view('panel/dashboard', [
            'title'    => 'Dashboard Panel',
            'stats'    => $stats,
            'insights' => $insights,
        ]);
    }
}
