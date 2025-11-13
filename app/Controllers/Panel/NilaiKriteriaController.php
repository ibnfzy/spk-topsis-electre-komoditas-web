<?php

namespace App\Controllers\Panel;

use App\Models\KomoditasTambakModel;
use App\Models\KriteriaModel;
use App\Models\NilaiKriteriaModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;

class NilaiKriteriaController extends BaseResourceController
{
    protected NilaiKriteriaModel $model;

    public function __construct()
    {
        $this->model = new NilaiKriteriaModel();
    }

    public function index()
    {
        if ($this->wantsJSON()) {
            $records = $this->model
                ->select('nilai_kriteria.*, komoditas_tambak.nama_komoditas, kriteria.nama_kriteria')
                ->join('komoditas_tambak', 'komoditas_tambak.id = nilai_kriteria.komoditas_id', 'left')
                ->join('kriteria', 'kriteria.id = nilai_kriteria.kriteria_id', 'left')
                ->findAll();

            return $this->respondSuccess(['data' => $records]);
        }

        return view('panel/nilai_kriteria/index', [
            'title'       => 'Penilaian Komoditas',
            'pageTitle'   => 'Nilai Kriteria',
            'description' => 'Kelola nilai penilaian setiap komoditas terhadap masing-masing kriteria.',
        ]);
    }

    public function show(int $id): ResponseInterface
    {
        $record = $this->model->find($id);
        if (!$record) {
            return $this->respondNotFound('Nilai kriteria');
        }

        return $this->respondSuccess(['data' => $record]);
    }

    public function store(): ResponseInterface
    {
        $data = $this->getRequestInput();
        if (!$this->model->insert($data)) {
            return $this->respondValidationErrors($this->model->errors());
        }

        $record = $this->model->find($this->model->getInsertID());

        return $this->respondSuccess(['data' => $record], ResponseInterface::HTTP_CREATED);
    }

    public function update(int $id): ResponseInterface
    {
        if (!$this->model->find($id)) {
            return $this->respondNotFound('Nilai kriteria');
        }

        $data = $this->getRequestInput();
        if (!$this->model->update($id, $data)) {
            return $this->respondValidationErrors($this->model->errors());
        }

        return $this->respondSuccess(['data' => $this->model->find($id)]);
    }

    public function delete(int $id): ResponseInterface
    {
        if (!$this->model->find($id)) {
            return $this->respondNotFound('Nilai kriteria');
        }

        $this->model->delete($id);

        return $this->respondSuccess([
            'message' => 'Nilai kriteria berhasil dihapus.',
        ]);
    }

    public function new(): string
    {
        return view('panel/nilai_kriteria/form', $this->formPayload('Tambah Nilai Kriteria', 'Tambah Nilai', base_url('panel/nilai-kriteria'), 'POST'));
    }

    public function edit(int $id): string
    {
        $record = $this->model->find($id);
        if (!$record) {
            throw PageNotFoundException::forPageNotFound('Nilai kriteria tidak ditemukan.');
        }

        return view('panel/nilai_kriteria/form', $this->formPayload('Edit Nilai Kriteria', 'Ubah Nilai', base_url('panel/nilai-kriteria/' . $id), 'PUT', $record));
    }

    private function formPayload(string $title, string $pageTitle, string $action, string $method, ?array $record = null): array
    {
        $komoditasModel = new KomoditasTambakModel();
        $kriteriaModel  = new KriteriaModel();

        return [
            'title'             => $title,
            'pageTitle'         => $pageTitle,
            'formAction'        => $action,
            'submitMethod'      => $method,
            'record'            => $record,
            'komoditasOptions'  => $komoditasModel->select('id, nama_komoditas')->orderBy('nama_komoditas')->findAll(),
            'kriteriaOptions'   => $kriteriaModel->select('id, nama_kriteria')->orderBy('nama_kriteria')->findAll(),
        ];
    }
}
