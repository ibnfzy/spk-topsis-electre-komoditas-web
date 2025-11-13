<?php

namespace App\Controllers\Panel;

use App\Models\KriteriaModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;

class KriteriaController extends BaseResourceController
{
    protected KriteriaModel $model;

    public function __construct()
    {
        $this->model = new KriteriaModel();
    }

    public function index()
    {
        if ($this->wantsJSON()) {
            return $this->respondSuccess(['data' => $this->model->findAll()]);
        }

        return view('panel/kriteria/index', [
            'title'       => 'Manajemen Kriteria',
            'pageTitle'   => 'Daftar Kriteria',
            'description' => 'Kelola parameter penilaian yang digunakan dalam metode TOPSIS & ELECTRE.',
        ]);
    }

    public function show(int $id): ResponseInterface
    {
        $record = $this->model->find($id);
        if (!$record) {
            return $this->respondNotFound('Kriteria');
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
            return $this->respondNotFound('Kriteria');
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
            return $this->respondNotFound('Kriteria');
        }

        $this->model->delete($id);

        return $this->respondSuccess([
            'message' => 'Kriteria berhasil dihapus.',
        ]);
    }

    public function new(): string
    {
        return view('panel/kriteria/form', [
            'title'        => 'Tambah Kriteria',
            'pageTitle'    => 'Tambah Kriteria',
            'formAction'   => base_url('panel/kriteria'),
            'submitMethod' => 'POST',
            'record'       => null,
        ]);
    }

    public function edit(int $id): string
    {
        $record = $this->model->find($id);
        if (!$record) {
            throw PageNotFoundException::forPageNotFound('Kriteria tidak ditemukan.');
        }

        return view('panel/kriteria/form', [
            'title'        => 'Edit Kriteria',
            'pageTitle'    => 'Ubah Kriteria',
            'formAction'   => base_url('panel/kriteria/' . $id),
            'submitMethod' => 'PUT',
            'record'       => $record,
        ]);
    }
}
