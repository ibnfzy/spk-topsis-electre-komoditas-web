<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KomoditasTambak extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $data = [
            [
                'nama_komoditas' => 'Bandeng',
                'kategori'      => 'ikan',
                'deskripsi'     => 'Komoditas ikan bandeng yang populer untuk budidaya tambak karena adaptif dan mudah dipelihara.',
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'nama_komoditas' => 'Udang Vannamei',
                'kategori'      => 'krustasea',
                'deskripsi'     => 'Udang vannamei dengan permintaan pasar tinggi dan pertumbuhan cepat.',
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'nama_komoditas' => 'Rumput Laut Gracilaria',
                'kategori'      => 'rumput_laut',
                'deskripsi'     => 'Rumput laut gracilaria untuk produksi agar dengan toleransi salinitas yang baik.',
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
        ];

        $builder = $this->db->table('komoditas_tambak');
        $builder->truncate();
        $builder->insertBatch($data);
    }
}
