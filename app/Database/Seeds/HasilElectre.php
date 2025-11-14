<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HasilElectre extends Seeder
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
            ['nama' => 'Udang Vannamei', 'nilai_akhir' => 1.000000, 'ranking' => 1],
            ['nama' => 'Bandeng', 'nilai_akhir' => 0.500000, 'ranking' => 2],
            ['nama' => 'Rumput Laut Gracilaria', 'nilai_akhir' => 0.000000, 'ranking' => 3],
        ];

        $batch = [];
        foreach ($hasil as $row) {
            $komoditasId = $komoditasMap[$row['nama']] ?? null;
            if ($komoditasId === null) {
                continue;
            }

            $batch[] = [
                'komoditas_id' => $komoditasId,
                'nilai_akhir'  => $row['nilai_akhir'],
                'ranking'      => $row['ranking'],
                'created_at'   => $timestamp,
            ];
        }

        $builder = $this->db->table('hasil_electre');
        $builder->truncate();

        if (! empty($batch)) {
            $builder->insertBatch($batch);
        }
    }
}
