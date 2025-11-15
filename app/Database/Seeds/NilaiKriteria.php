<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NilaiKriteria extends Seeder
{
    public function run()
    {
        $komoditasRows = $this->db->table('komoditas_tambak')->select('id, nama_komoditas')->get()->getResultArray();
        $kriteriaRows  = $this->db->table('kriteria')->select('id, kode_kriteria')->get()->getResultArray();

        $komoditasMap = [];
        foreach ($komoditasRows as $row) {
            $komoditasMap[$row['nama_komoditas']] = (int) $row['id'];
        }

        $kriteriaMap = [];
        foreach ($kriteriaRows as $row) {
            $kriteriaMap[$row['kode_kriteria']] = (int) $row['id'];
        }

        $nilaiMatrix = [
            'Ikan Bandeng' => [
                'C1' => 8.2,
                'C2' => 7.8,
                'C3' => 3.2,
                'C4' => 7.5,
            ],
            'Ikan Nila' => [
                'C1' => 7.5,
                'C2' => 7.0,
                'C3' => 4.0,
                'C4' => 6.8,
            ],
            'Udang Vaname' => [
                'C1' => 8.7,
                'C2' => 8.5,
                'C3' => 3.8,
                'C4' => 8.0,
            ],
            'Udang Windu' => [
                'C1' => 7.0,
                'C2' => 6.5,
                'C3' => 5.5,
                'C4' => 6.0,
            ],
        ];

        $batch = [];
        foreach ($nilaiMatrix as $komoditasName => $kriteriaValues) {
            $komoditasId = $komoditasMap[$komoditasName] ?? null;
            if ($komoditasId === null) {
                continue;
            }

            foreach ($kriteriaValues as $kodeKriteria => $nilai) {
                $kriteriaId = $kriteriaMap[$kodeKriteria] ?? null;
                if ($kriteriaId === null) {
                    continue;
                }

                $batch[] = [
                    'komoditas_id' => $komoditasId,
                    'kriteria_id'  => $kriteriaId,
                    'nilai'        => $nilai,
                ];
            }
        }

        $builder = $this->db->table('nilai_kriteria');
        $builder->truncate();

        if (! empty($batch)) {
            $builder->insertBatch($batch);
        }
    }
}
