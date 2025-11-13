<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BobotKriteria extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kriteria_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'bobot'        => ['type' => 'DECIMAL', 'constraint' => '5,3'],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('kriteria_id', 'kriteria', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('bobot_kriteria');
    }

    public function down()
    {
        $this->forge->dropTable('bobot_kriteria');
    }
}
