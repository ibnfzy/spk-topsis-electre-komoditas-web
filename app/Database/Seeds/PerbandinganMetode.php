<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PerbandinganMetode extends Seeder
{
    public function run()
    {
        $timestamp = date('Y-m-d H:i:s');

        $data = [
            [
                'rho_spearman' => 0.542,
                'keterangan'   => 'Perbandingan korelasi antara hasil TOPSIS dan ELECTRE menunjukkan hubungan positif sedang.',
                'created_at'   => $timestamp,
            ],
        ];

        $builder = $this->db->table('perbandingan_metode');
        $builder->truncate();
        $builder->insertBatch($data);
    }
}
