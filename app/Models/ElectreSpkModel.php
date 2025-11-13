<?php

namespace App\Models;

use CodeIgniter\Model;
use DateTime;
use RuntimeException;

class ElectreSpkModel extends Model
{
    protected $table         = 'hasil_electre';
    protected $allowedFields = ['komoditas_id', 'nilai_akhir', 'ranking', 'created_at'];
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
            foreach ($criteria as $criterion) {
                $criterionId               = (int) $criterion['id'];
                $matrix[$altId][$criterionId] = 0.0;
            }
        }

        foreach ($valuesRows as $row) {
            $altId                         = (int) $row['komoditas_id'];
            $criterionId                   = (int) $row['kriteria_id'];
            $matrix[$altId][$criterionId] = (float) $row['nilai'];
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

    public function concordance(array $weighted, array $weights): array
    {
        $alternatives = array_keys($weighted);
        $matrix       = [];

        foreach ($alternatives as $i) {
            foreach ($alternatives as $j) {
                if ($i === $j) {
                    $matrix[$i][$j] = 0.0;
                    continue;
                }

                $sum = 0.0;
                foreach ($weighted[$i] as $criterionId => $value) {
                    $weight = $weights[$criterionId] ?? 0.0;
                    if (($weighted[$i][$criterionId] ?? 0.0) >= ($weighted[$j][$criterionId] ?? 0.0)) {
                        $sum += $weight;
                    }
                }

                $matrix[$i][$j] = $sum;
            }
        }

        return $matrix;
    }

    public function discordance(array $weighted): array
    {
        $alternatives = array_keys($weighted);
        $matrix       = [];

        foreach ($alternatives as $i) {
            foreach ($alternatives as $j) {
                if ($i === $j) {
                    $matrix[$i][$j] = 0.0;
                    continue;
                }

                $numerator   = 0.0;
                $denominator = 0.0;

                foreach ($weighted[$i] as $criterionId => $value) {
                    $diff        = abs(($weighted[$i][$criterionId] ?? 0.0) - ($weighted[$j][$criterionId] ?? 0.0));
                    $denominator = max($denominator, $diff);

                    if (($weighted[$i][$criterionId] ?? 0.0) < ($weighted[$j][$criterionId] ?? 0.0)) {
                        $numerator = max($numerator, $diff);
                    }
                }

                $matrix[$i][$j] = $denominator > 0 ? $numerator / $denominator : 0.0;
            }
        }

        return $matrix;
    }

    public function matrixDominan(array $concordance, array $discordance): array
    {
        $alternatives = array_keys($concordance);
        $n            = count($alternatives);

        $sumC = 0.0;
        $sumD = 0.0;
        foreach ($concordance as $i => $row) {
            foreach ($row as $j => $value) {
                if ($i === $j) {
                    continue;
                }
                $sumC += $value;
            }
        }

        foreach ($discordance as $i => $row) {
            foreach ($row as $j => $value) {
                if ($i === $j) {
                    continue;
                }
                $sumD += $value;
            }
        }

        $thresholdC = ($n > 1) ? $sumC / ($n * ($n - 1)) : 0.0;
        $thresholdD = ($n > 1) ? $sumD / ($n * ($n - 1)) : 0.0;

        $dominance = [];
        foreach ($alternatives as $i) {
            foreach ($alternatives as $j) {
                if ($i === $j) {
                    $dominance[$i][$j] = 0;
                    continue;
                }

                $isDominant = 0;
                if (($concordance[$i][$j] ?? 0.0) >= $thresholdC && ($discordance[$i][$j] ?? 0.0) <= $thresholdD) {
                    $isDominant = 1;
                }

                $dominance[$i][$j] = $isDominant;
            }
        }

        return [
            'thresholdC' => $thresholdC,
            'thresholdD' => $thresholdD,
            'matrix'     => $dominance,
        ];
    }

    public function ranking(array $dominance, array $alternatives): array
    {
        $matrix = $dominance['matrix'];
        $n      = count($alternatives);

        $results = [];
        foreach ($alternatives as $alt) {
            $altId = (int) $alt['id'];
            $row   = $matrix[$altId] ?? [];
            $score = array_sum($row ?? []);
            $normalizedScore = ($n > 1) ? $score / ($n - 1) : 0.0;

            $results[] = [
                'komoditas_id' => $altId,
                'nilai_akhir'  => round($normalizedScore, 6),
                'skor'         => (float) $score,
            ];
        }

        usort($results, static function (array $a, array $b): int {
            return $b['nilai_akhir'] <=> $a['nilai_akhir'];
        });

        $rank = 1;
        foreach ($results as &$row) {
            $row['ranking'] = $rank++;
        }

        return $results;
    }

    public function simpanHasil(array $ranking): void
    {
        $db      = $this->db;
        $builder = $db->table($this->table);

        $db->transStart();
        $builder->delete();

        $timestamp = (new DateTime('now'))->format('Y-m-d H:i:s');
        $batch     = [];
        foreach ($ranking as $row) {
            $batch[] = [
                'komoditas_id' => $row['komoditas_id'],
                'nilai_akhir'  => $row['nilai_akhir'],
                'ranking'      => $row['ranking'],
                'created_at'   => $timestamp,
            ];
        }

        if (! empty($batch)) {
            $builder->insertBatch($batch);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            throw new RuntimeException('Gagal menyimpan hasil ELECTRE.');
        }
    }
}
