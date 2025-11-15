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
                'nama_komoditas' => 'Ikan Bandeng',
                'kategori'      => 'ikan',
                'deskripsi'     => 'Ikan bandeng yang adaptif terhadap berbagai kondisi tambak dan diminati untuk konsumsi.',
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'nama_komoditas' => 'Ikan Nila',
                'kategori'      => 'ikan',
                'deskripsi'     => 'Ikan nila air payau dengan pertumbuhan cepat dan permintaan pasar stabil.',
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'nama_komoditas' => 'Udang Vaname',
                'kategori'      => 'udang',
                'deskripsi'     => 'Udang vaname unggulan dengan produktivitas tinggi dan siklus budidaya singkat.',
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'nama_komoditas' => 'Udang Windu',
                'kategori'      => 'udang',
                'deskripsi'     => 'Udang windu premium dengan nilai jual tinggi dan kebutuhan manajemen ketat.',
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
        ];

        $builder = $this->db->table('komoditas_tambak');
        $builder->truncate();
        $builder->insertBatch($data);
    }
}
