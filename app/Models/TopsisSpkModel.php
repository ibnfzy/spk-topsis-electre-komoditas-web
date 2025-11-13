<?php

namespace App\Models;

use CodeIgniter\Model;
use DateTime;
use RuntimeException;

class TopsisSpkModel extends Model
{
    protected $table         = 'hasil_topsis';
    protected $allowedFields = ['komoditas_id', 'nilai_pref', 'ranking', 'created_at'];
    protected $useTimestamps = false;

    public function getDataSPK(): array
    {
        $db = $this->db;

        $alternatives = $db->table('komoditas_tambak')->get()->getResultArray();
        $criteria     = $db->table('kriteria')->orderBy('id')->get()->getResultArray();
        $weightsRows  = $db->table('bobot_kriteria')->get()->getResultArray();
        $valuesRows   = $db->table('nilai_kriteria')->get()->getResultArray();

        $weights = [];
        foreach ($weightsRows as $row) {
            $weights[(int) $row['kriteria_id']] = (float) $row['bobot'];
        }

        $matrix = [];
        foreach ($alternatives as $alt) {
            $altId = (int) $alt['id'];
            foreach ($criteria as $crit) {
                $critId                  = (int) $crit['id'];
                $matrix[$altId][$critId] = 0.0;
            }
        }

        foreach ($valuesRows as $row) {
            $altId                = (int) $row['komoditas_id'];
            $critId               = (int) $row['kriteria_id'];
            $matrix[$altId][$critId] = (float) $row['nilai'];
        }

        return [
            'alternatives' => $alternatives,
            'criteria'     => $criteria,
            'weights'      => $weights,
            'matrix'       => $matrix,
        ];
    }

    public function normalisasi(array $matrix): array
    {
        $denominators = [];
        foreach ($matrix as $values) {
            foreach ($values as $criterionId => $value) {
                $denominators[$criterionId] = ($denominators[$criterionId] ?? 0.0) + ($value ** 2);
            }
        }

        foreach ($denominators as $criterionId => $sumSquares) {
            $denominators[$criterionId] = $sumSquares > 0 ? sqrt($sumSquares) : 0.0;
        }

        $normalized = [];
        foreach ($matrix as $altId => $values) {
            foreach ($values as $criterionId => $value) {
                $denominator                 = $denominators[$criterionId] ?: 1.0;
                $normalized[$altId][$criterionId] = $denominator > 0 ? $value / $denominator : 0.0;
            }
        }

        return $normalized;
    }

    public function pembobotan(array $normalized, array $weights): array
    {
        $weighted = [];
        foreach ($normalized as $altId => $values) {
            foreach ($values as $criterionId => $value) {
                $weight = $weights[$criterionId] ?? 0.0;
                $weighted[$altId][$criterionId] = $value * $weight;
            }
        }

        return $weighted;
    }

    public function solusiIdeal(array $weighted, array $criteria): array
    {
        $positive = [];
        $negative = [];

        foreach ($criteria as $criterion) {
            $criterionId = (int) $criterion['id'];
            $values      = [];
            foreach ($weighted as $altValues) {
                $values[] = $altValues[$criterionId] ?? 0.0;
            }

            if ($criterion['jenis'] === 'cost') {
                $positive[$criterionId] = min($values);
                $negative[$criterionId] = max($values);
            } else {
                $positive[$criterionId] = max($values);
                $negative[$criterionId] = min($values);
            }
        }

        return [
            'positive' => $positive,
            'negative' => $negative,
        ];
    }

    public function preferensi(array $weighted, array $ideal): array
    {
        $results = [];
        foreach ($weighted as $altId => $values) {
            $dPositive = 0.0;
            $dNegative = 0.0;
            foreach ($values as $criterionId => $value) {
                $positive = $ideal['positive'][$criterionId] ?? 0.0;
                $negative = $ideal['negative'][$criterionId] ?? 0.0;

                $dPositive += ($value - $positive) ** 2;
                $dNegative += ($value - $negative) ** 2;
            }

            $dPositive = sqrt($dPositive);
            $dNegative = sqrt($dNegative);
            $preference = ($dPositive + $dNegative) > 0
                ? $dNegative / ($dPositive + $dNegative)
                : 0.0;

            $results[] = [
                'komoditas_id' => (int) $altId,
                'd_positive'   => round($dPositive, 6),
                'd_negative'   => round($dNegative, 6),
                'nilai_pref'   => round($preference, 6),
            ];
        }

        usort($results, static function (array $a, array $b): int {
            return $b['nilai_pref'] <=> $a['nilai_pref'];
        });

        $rank = 1;
        foreach ($results as &$row) {
            $row['ranking'] = $rank++;
        }

        return $results;
    }

    public function simpanHasil(array $preferences): void
    {
        $db      = $this->db;
        $builder = $db->table($this->table);

        $db->transStart();
        $builder->delete();

        $timestamp = (new DateTime('now'))->format('Y-m-d H:i:s');
        $batch     = [];
        foreach ($preferences as $row) {
            $batch[] = [
                'komoditas_id' => $row['komoditas_id'],
                'nilai_pref'   => $row['nilai_pref'],
                'ranking'      => $row['ranking'],
                'created_at'   => $timestamp,
            ];
        }

        if (! empty($batch)) {
            $builder->insertBatch($batch);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            throw new RuntimeException('Gagal menyimpan hasil TOPSIS.');
        }
    }
}
