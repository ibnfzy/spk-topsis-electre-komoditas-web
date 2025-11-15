<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BobotKriteria extends Seeder
{
    public function run()
    {
        $kriteriaRows = $this->db->table('kriteria')->select('id, kode_kriteria')->get()->getResultArray();
        $kriteriaMap  = [];

        foreach ($kriteriaRows as $row) {
            $kriteriaMap[$row['kode_kriteria']] = (int) $row['id'];
        }

        $bobotData = [
            ['kode' => 'C1', 'bobot' => 0.35],
            ['kode' => 'C2', 'bobot' => 0.30],
            ['kode' => 'C3', 'bobot' => 0.20],
            ['kode' => 'C4', 'bobot' => 0.15],
        ];

        $batch = [];
        foreach ($bobotData as $item) {
            $kriteriaId = $kriteriaMap[$item['kode']] ?? null;
            if ($kriteriaId === null) {
                continue;
            }

            $batch[] = [
                'kriteria_id' => $kriteriaId,
                'bobot'       => $item['bobot'],
            ];
        }

        $builder = $this->db->table('bobot_kriteria');
        $builder->truncate();

        if (! empty($batch)) {
            $builder->insertBatch($batch);
        }
    }
}
