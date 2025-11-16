<?php

namespace App\Controllers\Panel;

use App\Models\KomoditasTambakModel;
use App\Models\KriteriaModel;
use App\Models\NilaiKriteriaModel;
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
                ->orderBy('komoditas_tambak.nama_komoditas', 'ASC')
                ->orderBy('kriteria.nama_kriteria', 'ASC')
                ->findAll();

            return $this->respondSuccess(['data' => $records]);
        }

        $hasValues = $this->model->select('id')->limit(1)->first() !== null;

        return view('panel/nilai_kriteria/index', [
            'title'       => 'Penilaian Komoditas',
            'pageTitle'   => 'Nilai Kriteria',
            'description' => 'Kelola nilai penilaian setiap komoditas terhadap masing-masing kriteria.',
            'hasValues'   => $hasValues,
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
        return view('panel/nilai_kriteria/form', $this->formPayload(
            'Tambah Nilai Kriteria',
            'Matrix Penilaian Komoditas',
            false,
            []
        ));
    }

    public function editMatrix(): string
    {
        $matrix = $this->buildMatrix();
        if (empty($matrix)) {
            return redirect()->to(base_url('panel/nilai-kriteria/tambah'));
        }

        return view('panel/nilai_kriteria/form', $this->formPayload(
            'Edit Nilai Kriteria',
            'Perbarui Matrix Penilaian',
            true,
            $matrix
        ));
    }

    public function saveMatrix(): ResponseInterface
    {
        $payload = $this->getRequestInput();
        $nilai   = $payload['nilai'] ?? [];

        if (!is_array($nilai)) {
            return $this->respondValidationErrors(['nilai' => 'Format matrix tidak valid.']);
        }

        $db = \Config\Database::connect();
        $db->transStart();
        $db->table($this->model->getTable())->truncate();

        foreach ($nilai as $komoditasId => $kriteriaValues) {
            if (!is_array($kriteriaValues)) {
                continue;
            }

            foreach ($kriteriaValues as $kriteriaId => $value) {
                if ($value === null || $value === '') {
                    continue;
                }

                if (!is_numeric($value)) {
                    $db->transRollback();
                    return $this->respondValidationErrors(['nilai' => 'Nilai harus berupa angka.']);
                }

                $this->model->insert([
                    'komoditas_id' => (int) $komoditasId,
                    'kriteria_id'  => (int) $kriteriaId,
                    'nilai'        => (float) $value,
                ], false);
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->respondServerError('Gagal menyimpan matrix nilai.');
        }

        return $this->respondSuccess(['message' => 'Matrix nilai kriteria berhasil disimpan.']);
    }

    public function clearAll(): ResponseInterface
    {
        \Config\Database::connect()->table($this->model->getTable())->truncate();

        return $this->respondSuccess(['message' => 'Seluruh nilai kriteria berhasil dikosongkan.']);
    }

    private function formPayload(string $title, string $pageTitle, bool $isEditing, array $nilaiMatrix): array
    {
        $komoditasModel = new KomoditasTambakModel();
        $kriteriaModel  = new KriteriaModel();

        return [
            'title'             => $title,
            'pageTitle'         => $pageTitle,
            'isEditing'         => $isEditing,
            'matrixEndpoint'    => base_url('panel/nilai-kriteria/matrix'),
            'nilaiMatrix'       => $nilaiMatrix,
            'komoditasOptions'  => $komoditasModel->select('id, nama_komoditas')->orderBy('nama_komoditas')->findAll(),
            'kriteriaOptions'   => $kriteriaModel->select('id, nama_kriteria')->orderBy('nama_kriteria')->findAll(),
        ];
    }

    private function buildMatrix(): array
    {
        $records = $this->model->select('komoditas_id, kriteria_id, nilai')->findAll();
        $matrix  = [];

        foreach ($records as $record) {
            $matrix[$record['komoditas_id']][$record['kriteria_id']] = $record['nilai'];
        }

        return $matrix;
    }
}
