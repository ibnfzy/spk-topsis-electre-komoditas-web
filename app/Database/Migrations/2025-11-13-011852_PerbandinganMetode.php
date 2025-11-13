<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PerbandinganMetode extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'rho_spearman'      => ['type' => 'DECIMAL', 'constraint' => '5,3', 'null' => true],
            'keterangan'        => ['type' => 'TEXT', 'null' => true],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('perbandingan_metode');
    }

    public function down()
    {
        $this->forge->dropTable('perbandingan_metode');
    }
}
