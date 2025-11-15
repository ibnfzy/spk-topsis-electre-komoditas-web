<?php

namespace App\Controllers\Panel\Spk;

use App\Controllers\BaseController;
use App\Libraries\SpkResultPresenter;
use App\Models\ElectreSpkModel;
use CodeIgniter\HTTP\ResponseInterface;
use Throwable;

class ElectreSpkController extends BaseController
{
    public function hitung(): ResponseInterface
    {
        try {
            $model = new ElectreSpkModel();
            $data  = $model->getDataSPK();

            if (empty($data['alternatives']) || empty($data['criteria'])) {
                return $this->response->setStatusCode(422)->setJSON([
                    'status'  => 'error',
                    'message' => 'Data komoditas atau kriteria belum tersedia.',
                ]);
            }

            $normalized  = $model->normalisasi($data['matrix']);
            $weighted    = $model->pembobotan($normalized, $data['weights']);
            $concordance = $model->concordance($weighted, $data['weights']);
            $discordance = $model->discordance($weighted);
            $dominance   = $model->matrixDominan($concordance, $discordance);
            $ranking     = $model->ranking($dominance, $data['alternatives']);

            $model->simpanHasil($ranking);

            $presentation = SpkResultPresenter::formatElectre(
                $data,
                $normalized,
                $weighted,
                $concordance,
                $discordance,
                $dominance,
                $ranking
            );

            return $this->response->setJSON([
                'status' => 'success',
                'data'   => $presentation,
            ]);
        } catch (Throwable $exception) {
            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
