<?php

namespace App\Controllers\Panel;

use App\Models\KomoditasTambakModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;

class KomoditasController extends BaseResourceController
{
    protected KomoditasTambakModel $model;

    public function __construct()
    {
        $this->model = new KomoditasTambakModel();
    }

    public function index()
    {
        if ($this->wantsJSON()) {
            return $this->respondSuccess(['data' => $this->model->findAll()]);
        }

        return view('panel/komoditas/index', [
            'title'       => 'Manajemen Komoditas Tambak',
            'pageTitle'   => 'Komoditas Tambak',
            'description' => 'Kelola daftar komoditas tambak lengkap dengan informasi kategori dan deskripsi.',
        ]);
    }

    public function show(int $id): ResponseInterface
    {
        $record = $this->model->find($id);
        if (!$record) {
            return $this->respondNotFound('Komoditas tambak');
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
            return $this->respondNotFound('Komoditas tambak');
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
            return $this->respondNotFound('Komoditas tambak');
        }

        $this->model->delete($id);

        return $this->respondSuccess([
            'message' => 'Komoditas tambak berhasil dihapus.',
        ]);
    }

    public function new(): string
    {
        return view('panel/komoditas/form', [
            'title'        => 'Tambah Komoditas Tambak',
            'pageTitle'    => 'Tambah Komoditas',
            'formAction'   => base_url('panel/komoditas'),
            'submitMethod' => 'POST',
            'record'       => null,
        ]);
    }

    public function edit(int $id): string
    {
        $record = $this->model->find($id);
        if (!$record) {
            throw PageNotFoundException::forPageNotFound('Komoditas tambak tidak ditemukan.');
        }

        return view('panel/komoditas/form', [
            'title'        => 'Edit Komoditas Tambak',
            'pageTitle'    => 'Ubah Komoditas',
            'formAction'   => base_url('panel/komoditas/' . $id),
            'submitMethod' => 'PUT',
            'record'       => $record,
        ]);
    }
}
