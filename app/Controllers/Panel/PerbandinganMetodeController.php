<?php

namespace App\Controllers\Panel;

use App\Models\PerbandinganMetodeModel;
use CodeIgniter\HTTP\ResponseInterface;

class PerbandinganMetodeController extends BaseResourceController
{
    protected PerbandinganMetodeModel $model;

    public function __construct()
    {
        $this->model = new PerbandinganMetodeModel();
    }

    public function index(): ResponseInterface
    {
        return $this->respondSuccess(['data' => $this->model->findAll()]);
    }

    public function show(int $id): ResponseInterface
    {
        $record = $this->model->find($id);
        if (!$record) {
            return $this->respondNotFound('Perbandingan metode');
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
            return $this->respondNotFound('Perbandingan metode');
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
            return $this->respondNotFound('Perbandingan metode');
        }

        $this->model->delete($id);

        return $this->respondSuccess([
            'message' => 'Perbandingan metode berhasil dihapus.',
        ]);
    }
}
