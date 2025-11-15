<?php

namespace App\Controllers\Panel\Spk;

use App\Controllers\BaseController;
use App\Libraries\SpkResultPresenter;
use App\Models\TopsisSpkModel;
use CodeIgniter\HTTP\ResponseInterface;
use Throwable;

class TopsisSpkController extends BaseController
{
    public function hitung(): ResponseInterface
    {
        try {
            $model = new TopsisSpkModel();
            $data  = $model->getDataSPK();

            if (empty($data['alternatives']) || empty($data['criteria'])) {
                return $this->response->setStatusCode(422)->setJSON([
                    'status'  => 'error',
                    'message' => 'Data komoditas atau kriteria belum tersedia.',
                ]);
            }

            $normalized  = $model->normalisasi($data['matrix']);
            $weighted    = $model->pembobotan($normalized, $data['weights']);
            $ideal       = $model->solusiIdeal($weighted, $data['criteria']);
            $preferences = $model->preferensi($weighted, $ideal);

            $model->simpanHasil($preferences);

            $presentation = SpkResultPresenter::formatTopsis($data, $preferences, $normalized, $weighted);

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
