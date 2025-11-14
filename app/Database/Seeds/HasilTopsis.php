<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HasilTopsis extends Seeder
{
    public function run()
    {
        $komoditasRows = $this->db->table('komoditas_tambak')->select('id, nama_komoditas')->get()->getResultArray();
        $komoditasMap  = [];

        foreach ($komoditasRows as $row) {
            $komoditasMap[$row['nama_komoditas']] = (int) $row['id'];
        }

        $timestamp = date('Y-m-d H:i:s');

        $hasil = [
            ['nama' => 'Rumput Laut Gracilaria', 'nilai_pref' => 0.709877, 'ranking' => 1],
            ['nama' => 'Bandeng', 'nilai_pref' => 0.471522, 'ranking' => 2],
            ['nama' => 'Udang Vannamei', 'nilai_pref' => 0.290123, 'ranking' => 3],
        ];

        $batch = [];
        foreach ($hasil as $row) {
            $komoditasId = $komoditasMap[$row['nama']] ?? null;
            if ($komoditasId === null) {
                continue;
            }

            $batch[] = [
                'komoditas_id' => $komoditasId,
                'nilai_pref'   => $row['nilai_pref'],
                'ranking'      => $row['ranking'],
                'created_at'   => $timestamp,
            ];
        }

        $builder = $this->db->table('hasil_topsis');
        $builder->truncate();

        if (! empty($batch)) {
            $builder->insertBatch($batch);
        }
    }
}
