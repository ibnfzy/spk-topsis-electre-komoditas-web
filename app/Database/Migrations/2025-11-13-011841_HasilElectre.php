<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HasilElectre extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'komoditas_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nilai_akhir'    => ['type' => 'DECIMAL', 'constraint' => '10,5'],
            'ranking'        => ['type' => 'INT', 'constraint' => 3],
            'created_at'     => ['type' => 'DATETIME', 'null' => true]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('komoditas_id', 'komoditas_tambak', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('hasil_electre');
    }

    public function down()
    {
        $this->forge->dropTable('hasil_electre');
    }
}
