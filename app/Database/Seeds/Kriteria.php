<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Kriteria extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $data = [
            [
                'kode_kriteria' => 'C1',
                'nama_kriteria' => 'Kualitas Lingkungan dan Kesesuaian Habitat',
                'jenis'         => 'benefit',
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'kode_kriteria' => 'C2',
                'nama_kriteria' => 'Potensi Ekonomi dan Permintaan Pasar',
                'jenis'         => 'benefit',
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'kode_kriteria' => 'C3',
                'nama_kriteria' => 'Risiko Penyakit dan Ketahanan Komoditas',
                'jenis'         => 'cost',
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'kode_kriteria' => 'C4',
                'nama_kriteria' => 'Ketersediaan Sarana Budidaya dan Teknologi Pendukung',
                'jenis'         => 'benefit',
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
        ];

        $builder = $this->db->table('kriteria');
        $builder->truncate();
        $builder->insertBatch($data);
    }
}
