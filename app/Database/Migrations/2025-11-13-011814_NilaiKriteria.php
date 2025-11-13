<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NilaiKriteria extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'komoditas_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'kriteria_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nilai'          => ['type' => 'DECIMAL', 'constraint' => '10,3', 'null' => false],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('komoditas_id', 'komoditas_tambak', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kriteria_id', 'kriteria', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('nilai_kriteria');
    }

    public function down()
    {
        $this->forge->dropTable('nilai_kriteria');
    }
}
