<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

abstract class BaseResourceController extends BaseController
{
    protected function getRequestInput(): array
    {
        $input = $this->request->getJSON(true);
        if (is_null($input)) {
            $input = $this->request->getRawInput();
            if (empty($input)) {
                $input = $this->request->getPost();
            }
        }

        return $input ?? [];
    }

    protected function respondNotFound(string $resource): ResponseInterface
    {
        return $this->response
            ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
            ->setJSON([
                'status'  => 'error',
                'message' => $resource . ' tidak ditemukan.',
            ]);
    }

    protected function respondValidationErrors(array $errors): ResponseInterface
    {
        return $this->response
            ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
            ->setJSON([
                'status'  => 'error',
                'message' => 'Data tidak valid.',
                'errors'  => $errors,
            ]);
    }

    protected function respondSuccess(array $payload, int $status = ResponseInterface::HTTP_OK): ResponseInterface
    {
        return $this->response
            ->setStatusCode($status)
            ->setJSON($payload);
    }
}
