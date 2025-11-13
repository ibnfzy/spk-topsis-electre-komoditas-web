<?php

namespace App\Models;

use CodeIgniter\Model;
use DateTime;
use RuntimeException;

class PerbandinganSpkModel extends Model
{
    protected $table         = 'perbandingan_metode';
    protected $allowedFields = ['rho_spearman', 'keterangan', 'created_at'];
    protected $useTimestamps = false;

    public function getTopsis(): array
    {
        return $this->db
            ->table('hasil_topsis')
            ->orderBy('komoditas_id')
            ->get()
            ->getResultArray();
    }

    public function getElectre(): array
    {
        return $this->db
            ->table('hasil_electre')
            ->orderBy('komoditas_id')
            ->get()
            ->getResultArray();
    }

    public function spearman(array $topsis, array $electre): array
    {
        $rankTopsis  = [];
        $rankElectre = [];

        foreach ($topsis as $row) {
            $rankTopsis[(int) $row['komoditas_id']] = (int) $row['ranking'];
        }

        foreach ($electre as $row) {
            $rankElectre[(int) $row['komoditas_id']] = (int) $row['ranking'];
        }

        $common = array_values(array_intersect(array_keys($rankTopsis), array_keys($rankElectre)));
        $n      = count($common);

        if ($n < 2) {
            return [
                'rho'        => null,
                'keterangan' => 'Data ranking belum mencukupi untuk korelasi.',
                'details'    => [],
            ];
        }

        $differences = [];
        foreach ($common as $komoditasId) {
            $d             = $rankTopsis[$komoditasId] - $rankElectre[$komoditasId];
            $differences[] = $d ** 2;
        }

        $sumDiff = array_sum($differences);
        $rho     = 1 - ((6 * $sumDiff) / ($n * (($n ** 2) - 1)));
        $rho     = max(-1, min(1, $rho));

        $interpretation = $this->interpretasi($rho);

        return [
            'rho'        => round($rho, 6),
            'keterangan' => $interpretation,
            'details'    => [
                'n'            => $n,
                'rank_topsis'  => $rankTopsis,
                'rank_electre' => $rankElectre,
                'sum_d2'       => $sumDiff,
            ],
        ];
    }

    public function simpan(array $hasil): void
    {
        $db      = $this->db;
        $builder = $db->table($this->table);

        $db->transStart();

        $timestamp = (new DateTime('now'))->format('Y-m-d H:i:s');
        $insert    = [
            'rho_spearman' => $hasil['rho'],
            'keterangan'   => $hasil['keterangan'],
            'created_at'   => $timestamp,
        ];

        $builder->insert($insert);

        $db->transComplete();

        if ($db->transStatus() === false) {
            throw new RuntimeException('Gagal menyimpan hasil perbandingan metode.');
        }
    }

    protected function interpretasi(float $rho): string
    {
        $abs = abs($rho);
        $arah = $rho > 0 ? 'positif' : ($rho < 0 ? 'negatif' : '');

        if ($abs === 1.0) {
            return 'Hubungan sempurna ' . ($arah ?: '');
        }

        if ($abs >= 0.8) {
            return 'Hubungan sangat kuat ' . $arah;
        }

        if ($abs >= 0.6) {
            return 'Hubungan kuat ' . $arah;
        }

        if ($abs >= 0.4) {
            return 'Hubungan sedang ' . $arah;
        }

        if ($abs >= 0.2) {
            return 'Hubungan lemah ' . $arah;
        }

        if ($abs > 0) {
            return 'Hubungan sangat lemah ' . $arah;
        }

        return 'Tidak ada korelasi.';
    }
}
