<?php

namespace App\Controllers\Panel\Spk;

use App\Controllers\BaseController;
use App\Libraries\SpkResultPresenter;
use App\Models\ElectreSpkModel;
use App\Models\HasilElectreModel;
use App\Models\HasilTopsisModel;
use App\Models\KomoditasTambakModel;
use App\Models\PerbandinganSpkModel;
use App\Models\TopsisSpkModel;
use CodeIgniter\HTTP\ResponseInterface;
use Throwable;

class ResultsController extends BaseController
{
    public function topsis(): string
    {
        helper('url');

        $presentation = $this->prepareTopsisPresentation();

        return view('panel/spk/topsis', [
            'title'   => 'Hasil TOPSIS',
            'results' => $presentation['ranking'],
            'details' => $presentation['details'],
        ]);
    }

    public function topsisData(): ResponseInterface
    {
        try {
            $presentation = $this->prepareTopsisPresentation();

            return $this->response->setJSON([
                'status' => 'success',
                'data'   => $presentation,
            ]);
        } catch (Throwable $exception) {
            log_message('error', 'Gagal menyiapkan data TOPSIS (AJAX): {message}', ['message' => $exception->getMessage()]);

            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 'error',
                'message' => 'Tidak dapat memuat hasil TOPSIS saat ini.',
            ]);
        }
    }

    public function electre(): string
    {
        helper('url');

        $presentation = $this->prepareElectrePresentation();

        return view('panel/spk/electre', [
            'title'   => 'Hasil ELECTRE',
            'results' => $presentation['ranking'],
            'details' => $presentation['details'],
        ]);
    }

    public function electreData(): ResponseInterface
    {
        try {
            $presentation = $this->prepareElectrePresentation();

            return $this->response->setJSON([
                'status' => 'success',
                'data'   => $presentation,
            ]);
        } catch (Throwable $exception) {
            log_message('error', 'Gagal menyiapkan data ELECTRE (AJAX): {message}', ['message' => $exception->getMessage()]);

            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 'error',
                'message' => 'Tidak dapat memuat hasil ELECTRE saat ini.',
            ]);
        }
    }

    public function compare(): string
    {
        helper('url');

        $comparisonModel = new PerbandinganSpkModel();
        $topsisModel     = new HasilTopsisModel();
        $electreModel    = new HasilElectreModel();
        $komoditasModel  = new KomoditasTambakModel();

        $topsis   = $topsisModel->orderBy('komoditas_id', 'ASC')->findAll();
        $electre  = $electreModel->orderBy('komoditas_id', 'ASC')->findAll();
        $recent   = $comparisonModel->orderBy('created_at', 'DESC')->first();
        $alts     = [];

        foreach ($komoditasModel->findAll() as $alternative) {
            $alts[(int) ($alternative['id'] ?? 0)] = $alternative;
        }

        $presentation = SpkResultPresenter::formatComparison($topsis, $electre, $recent ?? [], $alts);

        return view('panel/spk/compare', [
            'title'      => 'Perbandingan Metode',
            'comparison' => $presentation,
        ]);
    }

    /**
     * Sinkronkan hasil TOPSIS yang tersimpan dengan hasil kalkulasi terkini.
     */
    private function prepareTopsisPresentation(): array
    {
        $topsisModel    = new TopsisSpkModel();
        $hasilModel     = new HasilTopsisModel();
        $alternativeMap = [];
        $presentation   = ['ranking' => [], 'details' => []];

        try {
            $data = $topsisModel->getDataSPK();
            if (! empty($data['alternatives']) && ! empty($data['criteria'])) {
                $normalized  = $topsisModel->normalisasi($data['matrix']);
                $weighted    = $topsisModel->pembobotan($normalized, $data['weights']);
                $ideal       = $topsisModel->solusiIdeal($weighted, $data['criteria']);
                $preferences = $topsisModel->preferensi($weighted, $ideal);

                foreach ($data['alternatives'] as $alternative) {
                    $alternativeMap[(int) ($alternative['id'] ?? 0)] = $alternative;
                }

                $presentation = SpkResultPresenter::formatTopsis($data, $preferences, $normalized, $weighted);
            }
        } catch (Throwable $exception) {
            log_message('error', 'Gagal menyiapkan hasil TOPSIS: {message}', ['message' => $exception->getMessage()]);
        }

        $storedResults = $hasilModel->orderBy('ranking', 'ASC')->findAll();
        if (empty($alternativeMap)) {
            $alternativeMap = $this->getAlternativeMap();
        }

        $results = $this->mergeTopsisResults($storedResults, $presentation['ranking'], $alternativeMap);

        return [
            'ranking' => $results,
            'details' => $presentation['details'],
        ];
    }

    private function mergeTopsisResults(array $stored, array $calculated, array $alternatives = []): array
    {
        if (empty($stored)) {
            return $calculated;
        }

        $calculatedMap = [];
        foreach ($calculated as $row) {
            $calculatedMap[(int) ($row['komoditas_id'] ?? 0)] = $row;
        }

        if (empty($alternatives)) {
            $alternatives = $this->getAlternativeMap();
        }

        $results = [];
        foreach ($stored as $row) {
            $id          = (int) ($row['komoditas_id'] ?? 0);
            $calculated  = $calculatedMap[$id] ?? [];
            $alternative = $alternatives[$id] ?? [];

            $results[] = [
                'komoditas_id'     => $id,
                'nama_komoditas'   => $calculated['nama_komoditas'] ?? ($alternative['nama_komoditas'] ?? null),
                'kategori'         => $calculated['kategori'] ?? ($alternative['kategori'] ?? null),
                'nilai_preferensi' => isset($row['nilai_pref']) ? (float) $row['nilai_pref'] : ($calculated['nilai_preferensi'] ?? null),
                'posisi'           => isset($row['ranking']) ? (int) $row['ranking'] : ($calculated['posisi'] ?? null),
            ];
        }

        return $results;
    }

    private function prepareElectrePresentation(): array
    {
        $electreModel   = new ElectreSpkModel();
        $hasilModel     = new HasilElectreModel();
        $alternativeMap = [];
        $presentation   = ['ranking' => [], 'details' => []];

        try {
            $data = $electreModel->getDataSPK();
            if (! empty($data['alternatives']) && ! empty($data['criteria'])) {
                $normalized  = $electreModel->normalisasi($data['matrix']);
                $weighted    = $electreModel->pembobotan($normalized, $data['weights']);
                $concordance = $electreModel->concordance($weighted, $data['weights']);
                $discordance = $electreModel->discordance($weighted);
                $dominance   = $electreModel->matrixDominan($concordance, $discordance);
                $ranking     = $electreModel->ranking($dominance, $data['alternatives']);

                foreach ($data['alternatives'] as $alternative) {
                    $alternativeMap[(int) ($alternative['id'] ?? 0)] = $alternative;
                }

                $presentation = SpkResultPresenter::formatElectre(
                    $data,
                    $normalized,
                    $weighted,
                    $concordance,
                    $discordance,
                    $dominance,
                    $ranking
                );
            }
        } catch (Throwable $exception) {
            log_message('error', 'Gagal menyiapkan hasil ELECTRE: {message}', ['message' => $exception->getMessage()]);
        }

        $storedResults = $hasilModel->orderBy('ranking', 'ASC')->findAll();
        if (empty($alternativeMap)) {
            $alternativeMap = $this->getAlternativeMap();
        }

        $results = $this->mergeElectreResults($storedResults, $presentation['ranking'], $alternativeMap);

        return [
            'ranking' => $results,
            'details' => $presentation['details'],
        ];
    }

    private function mergeElectreResults(array $stored, array $calculated, array $alternatives = []): array
    {
        if (empty($stored)) {
            return $calculated;
        }

        $calculatedMap = [];
        foreach ($calculated as $row) {
            $calculatedMap[(int) ($row['komoditas_id'] ?? 0)] = $row;
        }

        if (empty($alternatives)) {
            $alternatives = $this->getAlternativeMap();
        }

        $results = [];
        foreach ($stored as $row) {
            $id         = (int) ($row['komoditas_id'] ?? 0);
            $calculated = $calculatedMap[$id] ?? [];
            $alternative = $alternatives[$id] ?? [];

            $results[] = [
                'komoditas_id'    => $id,
                'nama_komoditas'  => $calculated['nama_komoditas'] ?? ($alternative['nama_komoditas'] ?? null),
                'kategori'        => $calculated['kategori'] ?? ($alternative['kategori'] ?? null),
                'nilai_outranking'=> isset($row['nilai_akhir']) ? (float) $row['nilai_akhir'] : ($calculated['nilai_outranking'] ?? null),
                'posisi'          => isset($row['ranking']) ? (int) $row['ranking'] : ($calculated['posisi'] ?? null),
            ];
        }

        return $results;
    }

    private function getAlternativeMap(): array
    {
        $model = new KomoditasTambakModel();
        $map   = [];
        foreach ($model->findAll() as $alternative) {
            $map[(int) ($alternative['id'] ?? 0)] = $alternative;
        }

        return $map;
    }
}
