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
            ['nama' => 'Udang Vaname', 'nilai_pref' => 0.672345, 'ranking' => 1],
            ['nama' => 'Ikan Bandeng', 'nilai_pref' => 0.615432, 'ranking' => 2],
            ['nama' => 'Ikan Nila', 'nilai_pref' => 0.544321, 'ranking' => 3],
            ['nama' => 'Udang Windu', 'nilai_pref' => 0.421987, 'ranking' => 4],
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
