<?php

namespace App\Controllers\Panel;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;

class UsersController extends BaseResourceController
{
    protected UserModel $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function index()
    {
        if ($this->wantsJSON()) {
            return $this->respondSuccess(['data' => $this->model->findAll()]);
        }

        return view('panel/users/index', [
            'title'       => 'Manajemen Pengguna',
            'pageTitle'   => 'Pengguna Sistem',
            'description' => 'Atur akun pengguna yang memiliki akses ke panel administrasi.',
        ]);
    }

    public function show(int $id): ResponseInterface
    {
        $user = $this->model->find($id);
        if (!$user) {
            return $this->respondNotFound('Pengguna');
        }

        return $this->respondSuccess(['data' => $user]);
    }

    public function store(): ResponseInterface
    {
        $data = $this->prepareData($this->getRequestInput());
        if (!$this->model->insert($data)) {
            return $this->respondValidationErrors($this->model->errors());
        }

        $user = $this->model->find($this->model->getInsertID());

        return $this->respondSuccess(['data' => $user], ResponseInterface::HTTP_CREATED);
    }

    public function update(int $id): ResponseInterface
    {
        if (!$this->model->find($id)) {
            return $this->respondNotFound('Pengguna');
        }

        $data = $this->prepareData($this->getRequestInput());
        if (empty($data['password'])) {
            unset($data['password']);
        }

        if (!$this->model->update($id, $data)) {
            return $this->respondValidationErrors($this->model->errors());
        }

        return $this->respondSuccess(['data' => $this->model->find($id)]);
    }

    public function delete(int $id): ResponseInterface
    {
        if (!$this->model->find($id)) {
            return $this->respondNotFound('Pengguna');
        }

        $this->model->delete($id);

        return $this->respondSuccess([
            'message' => 'Pengguna berhasil dihapus.',
        ]);
    }

    public function new(): string
    {
        return view('panel/users/form', [
            'title'        => 'Tambah Pengguna',
            'pageTitle'    => 'Tambah Pengguna',
            'formAction'   => base_url('panel/users'),
            'submitMethod' => 'POST',
            'record'       => null,
        ]);
    }

    public function edit(int $id): string
    {
        $record = $this->model->find($id);
        if (!$record) {
            throw PageNotFoundException::forPageNotFound('Pengguna tidak ditemukan.');
        }

        unset($record['password']);

        return view('panel/users/form', [
            'title'        => 'Edit Pengguna',
            'pageTitle'    => 'Ubah Pengguna',
            'formAction'   => base_url('panel/users/' . $id),
            'submitMethod' => 'PUT',
            'record'       => $record,
        ]);
    }

    private function prepareData(array $data): array
    {
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        return $data;
    }
}
