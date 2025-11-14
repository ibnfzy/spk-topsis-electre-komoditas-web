<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Seed extends Seeder
{
    public function run()
    {
        $this->db->disableForeignKeyChecks();

        $this->call('Users');
        $this->call('KomoditasTambak');
        $this->call('Kriteria');
        $this->call('BobotKriteria');
        $this->call('NilaiKriteria');
        $this->call('HasilTopsis');
        $this->call('HasilElectre');
        $this->call('PerbandinganMetode');

        $this->db->enableForeignKeyChecks();
    }
}
