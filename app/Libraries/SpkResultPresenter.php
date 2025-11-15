<?php

namespace App\Libraries;

use function array_key_exists;

class SpkResultPresenter
{
    /**
     * Format TOPSIS results and detail sections for presentation.
     *
     * @param array $dataSPK     Dataset containing alternatives and criteria metadata.
     * @param array $preferences Ranked preferences produced by the TOPSIS algorithm.
     * @param array $normalized  Normalized decision matrix keyed by alternative and criterion IDs.
     * @param array $weighted    Weighted decision matrix keyed by alternative and criterion IDs.
     */
    public static function formatTopsis(array $dataSPK, array $preferences, array $normalized, array $weighted): array
    {
        $alternatives = self::mapAlternatives($dataSPK['alternatives'] ?? []);
        $criteria     = $dataSPK['criteria'] ?? [];

        $ranking = [];
        foreach ($preferences as $row) {
            $id          = (int) ($row['komoditas_id'] ?? 0);
            $alternative = $alternatives[$id] ?? [];

            $ranking[] = [
                'komoditas_id'     => $id,
                'nama_komoditas'   => $alternative['nama_komoditas'] ?? null,
                'kategori'         => $alternative['kategori'] ?? null,
                'nilai_preferensi' => isset($row['nilai_pref']) ? (float) $row['nilai_pref'] : null,
                'd_positive'       => isset($row['d_positive']) ? (float) $row['d_positive'] : null,
                'd_negative'       => isset($row['d_negative']) ? (float) $row['d_negative'] : null,
                'posisi'           => isset($row['ranking']) ? (int) $row['ranking'] : null,
            ];
        }

        $details = [
            'normalisasi' => self::formatAlternativeMatrix($normalized, $criteria, $alternatives),
            'pembobotan'  => self::formatAlternativeMatrix($weighted, $criteria, $alternatives),
            'jarak'       => self::formatDistanceRows($preferences, $alternatives),
            'skor'        => self::formatScoreRows($preferences, $alternatives, 'nilai_pref'),
        ];

        return [
            'ranking' => $ranking,
            'details' => $details,
        ];
    }

    /**
     * Format ELECTRE results and detail sections for presentation.
     */
    public static function formatElectre(
        array $dataSPK,
        array $normalized,
        array $weighted,
        array $concordance,
        array $discordance,
        array $dominance,
        array $ranking
    ): array {
        $alternatives = self::mapAlternatives($dataSPK['alternatives'] ?? []);

        $rankingRows = [];
        foreach ($ranking as $row) {
            $id          = (int) ($row['komoditas_id'] ?? 0);
            $alternative = $alternatives[$id] ?? [];

            $rankingRows[] = [
                'komoditas_id'    => $id,
                'nama_komoditas'  => $alternative['nama_komoditas'] ?? null,
                'kategori'        => $alternative['kategori'] ?? null,
                'nilai_outranking'=> isset($row['nilai_akhir']) ? (float) $row['nilai_akhir'] : null,
                'skor'            => isset($row['skor']) ? (float) $row['skor'] : null,
                'posisi'          => isset($row['ranking']) ? (int) $row['ranking'] : null,
            ];
        }

        $details = [
            'concordance' => self::formatPairMatrix($concordance, $alternatives, 'C'),
            'discordance' => self::formatPairMatrix($discordance, $alternatives, 'D'),
            'outranking'  => self::formatDominanceMatrix($dominance, $alternatives),
            'hasil'       => self::formatScoreRows($ranking, $alternatives, 'nilai_akhir'),
        ];

        return [
            'ranking' => $rankingRows,
            'details' => $details,
        ];
    }

    /**
     * Format comparison dataset for visualisation between TOPSIS and ELECTRE.
     */
    public static function formatComparison(array $topsis, array $electre, ?array $comparison, array $alternatives): array
    {
        $topsisMap  = [];
        $electreMap = [];

        foreach ($topsis as $row) {
            $topsisMap[(int) ($row['komoditas_id'] ?? 0)] = $row;
        }

        foreach ($electre as $row) {
            $electreMap[(int) ($row['komoditas_id'] ?? 0)] = $row;
        }

        $orderedIds = array_map('intval', array_column($topsis, 'komoditas_id'));
        if (! $orderedIds) {
            $orderedIds = array_map('intval', array_keys($electreMap));
        }

        $orderedIds = array_values(array_unique($orderedIds));

        $labels          = [];
        $rankingTopsis   = [];
        $rankingElectre  = [];

        foreach ($orderedIds as $id) {
            $alternative  = $alternatives[$id] ?? [];
            $labels[]     = $alternative['nama_komoditas'] ?? ('Komoditas #' . $id);
            $rankingTopsis[]  = isset($topsisMap[$id]['ranking']) ? (int) $topsisMap[$id]['ranking'] : 0;
            $rankingElectre[] = isset($electreMap[$id]['ranking']) ? (int) $electreMap[$id]['ranking'] : 0;
        }

        return [
            'rho'              => $comparison['rho'] ?? ($comparison['rho_spearman'] ?? null),
            'interpretasi'     => $comparison['keterangan'] ?? null,
            'labels'           => $labels,
            'ranking_topsis'   => $rankingTopsis,
            'ranking_electre'  => $rankingElectre,
            'details'          => $comparison['details'] ?? ($comparison['detail'] ?? []),
        ];
    }

    private static function mapAlternatives(array $alternatives): array
    {
        $map = [];
        foreach ($alternatives as $alternative) {
            $map[(int) ($alternative['id'] ?? 0)] = $alternative;
        }

        return $map;
    }

    private static function formatAlternativeMatrix(array $matrix, array $criteria, array $alternatives): array
    {
        $rows = [];

        foreach ($matrix as $altId => $values) {
            $alternative = $alternatives[(int) $altId] ?? [];
            $labelParts  = [];
            foreach ($criteria as $criterion) {
                $criterionId = (int) ($criterion['id'] ?? 0);
                $criterionLabel = $criterion['kode_kriteria'] ?? $criterion['nama_kriteria'] ?? ('K' . $criterionId);
                $value = array_key_exists($criterionId, $values) ? (float) $values[$criterionId] : 0.0;
                $labelParts[] = sprintf('%s: %.4f', $criterionLabel, $value);
            }

            $rows[] = sprintf('%s → %s', $alternative['nama_komoditas'] ?? ('Komoditas #' . $altId), implode(', ', $labelParts));
        }

        return $rows;
    }

    private static function formatDistanceRows(array $preferences, array $alternatives): array
    {
        $rows = [];
        foreach ($preferences as $row) {
            $id          = (int) ($row['komoditas_id'] ?? 0);
            $alternative = $alternatives[$id] ?? [];
            $rows[]      = sprintf(
                '%s → D+: %.4f • D-: %.4f',
                $alternative['nama_komoditas'] ?? ('Komoditas #' . $id),
                isset($row['d_positive']) ? (float) $row['d_positive'] : 0.0,
                isset($row['d_negative']) ? (float) $row['d_negative'] : 0.0
            );
        }

        return $rows;
    }

    private static function formatScoreRows(array $rows, array $alternatives, string $valueKey): array
    {
        $formatted = [];
        foreach ($rows as $row) {
            $id          = (int) ($row['komoditas_id'] ?? 0);
            $alternative = $alternatives[$id] ?? [];
            $value       = isset($row[$valueKey]) ? (float) $row[$valueKey] : 0.0;
            $ranking     = isset($row['ranking']) ? (int) $row['ranking'] : 0;

            $formatted[] = sprintf(
                '%s → %.4f (Ranking %s)',
                $alternative['nama_komoditas'] ?? ('Komoditas #' . $id),
                $value,
                $ranking ?: '-'
            );
        }

        return $formatted;
    }

    private static function formatPairMatrix(array $matrix, array $alternatives, string $prefix): array
    {
        $rows = [];
        foreach ($matrix as $i => $targets) {
            foreach ($targets as $j => $value) {
                if ((int) $i === (int) $j) {
                    continue;
                }

                $from = $alternatives[(int) $i]['nama_komoditas'] ?? ('Komoditas #' . $i);
                $to   = $alternatives[(int) $j]['nama_komoditas'] ?? ('Komoditas #' . $j);

                $rows[] = sprintf('%s(%s, %s) = %.4f', $prefix, $from, $to, (float) $value);
            }
        }

        return $rows;
    }

    private static function formatDominanceMatrix(array $dominance, array $alternatives): array
    {
        $matrix     = $dominance['matrix'] ?? [];
        $thresholdC = isset($dominance['thresholdC']) ? (float) $dominance['thresholdC'] : null;
        $thresholdD = isset($dominance['thresholdD']) ? (float) $dominance['thresholdD'] : null;

        $rows = [];
        if ($thresholdC !== null || $thresholdD !== null) {
            $rows[] = sprintf('Threshold Concordance: %.4f', $thresholdC ?? 0.0);
            $rows[] = sprintf('Threshold Discordance: %.4f', $thresholdD ?? 0.0);
        }

        foreach ($matrix as $i => $targets) {
            foreach ($targets as $j => $value) {
                if ((int) $i === (int) $j) {
                    continue;
                }

                $from = $alternatives[(int) $i]['nama_komoditas'] ?? ('Komoditas #' . $i);
                $to   = $alternatives[(int) $j]['nama_komoditas'] ?? ('Komoditas #' . $j);

                $rows[] = sprintf('%s outranks %s: %s', $from, $to, ((int) $value) === 1 ? 'Ya' : 'Tidak');
            }
        }

        return $rows;
    }
}
