<?php

namespace App\Controllers\Panel;

use App\Models\BobotKriteriaModel;
use App\Models\KriteriaModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;

class BobotKriteriaController extends BaseResourceController
{
    protected BobotKriteriaModel $model;

    public function __construct()
    {
        $this->model = new BobotKriteriaModel();
    }

    public function index()
    {
        if ($this->wantsJSON()) {
            $records = $this->model
                ->select('bobot_kriteria.*, kriteria.nama_kriteria')
                ->join('kriteria', 'kriteria.id = bobot_kriteria.kriteria_id', 'left')
                ->findAll();

            return $this->respondSuccess(['data' => $records]);
        }

        return view('panel/bobot_kriteria/index', [
            'title'       => 'Bobot Kriteria',
            'pageTitle'   => 'Bobot Kriteria',
            'description' => 'Kelola bobot preferensi untuk setiap kriteria penilaian.',
        ]);
    }

    public function show(int $id): ResponseInterface
    {
        $record = $this->model->find($id);
        if (!$record) {
            return $this->respondNotFound('Bobot kriteria');
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
            return $this->respondNotFound('Bobot kriteria');
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
            return $this->respondNotFound('Bobot kriteria');
        }

        $this->model->delete($id);

        return $this->respondSuccess([
            'message' => 'Bobot kriteria berhasil dihapus.',
        ]);
    }

    public function new(): string
    {
        return view('panel/bobot_kriteria/form', [
            'title'            => 'Tambah Bobot Kriteria',
            'pageTitle'        => 'Tambah Bobot',
            'formAction'       => base_url('panel/bobot-kriteria'),
            'submitMethod'     => 'POST',
            'record'           => null,
            'kriteriaOptions'  => $this->kriteriaOptions(),
        ]);
    }

    public function edit(int $id): string
    {
        $record = $this->model->find($id);
        if (!$record) {
            throw PageNotFoundException::forPageNotFound('Bobot kriteria tidak ditemukan.');
        }

        return view('panel/bobot_kriteria/form', [
            'title'            => 'Edit Bobot Kriteria',
            'pageTitle'        => 'Ubah Bobot',
            'formAction'       => base_url('panel/bobot-kriteria/' . $id),
            'submitMethod'     => 'PUT',
            'record'           => $record,
            'kriteriaOptions'  => $this->kriteriaOptions(),
        ]);
    }

    private function kriteriaOptions(): array
    {
        $kriteriaModel = new KriteriaModel();

        return $kriteriaModel->select('id, nama_kriteria')->orderBy('nama_kriteria')->findAll();
    }
}
