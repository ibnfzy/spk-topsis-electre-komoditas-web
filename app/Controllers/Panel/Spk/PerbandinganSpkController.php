<?php

namespace App\Controllers\Panel\Spk;

use App\Controllers\BaseController;
use App\Models\PerbandinganSpkModel;
use CodeIgniter\HTTP\ResponseInterface;
use Throwable;

class PerbandinganSpkController extends BaseController
{
    public function bandingkan(): ResponseInterface
    {
        try {
            $model   = new PerbandinganSpkModel();
            $topsis  = $model->getTopsis();
            $electre = $model->getElectre();

            if (empty($topsis) || empty($electre)) {
                return $this->response->setStatusCode(422)->setJSON([
                    'status'  => 'error',
                    'message' => 'Hasil TOPSIS dan ELECTRE belum tersedia untuk dibandingkan.',
                ]);
            }

            $hasil = $model->spearman($topsis, $electre);

            $model->simpan($hasil);

            return $this->response->setJSON([
                'status' => 'success',
                'data'   => [
                    'rho'           => $hasil['rho'],
                    'interpretasi'  => $hasil['keterangan'],
                    'detail'        => $hasil['details'],
                ],
            ]);
        } catch (Throwable $exception) {
            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
