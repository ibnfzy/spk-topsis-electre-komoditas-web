<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KomoditasTambak extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_komoditas'    => ['type' => 'VARCHAR', 'constraint' => 100],
            'kategori'          => ['type' => 'ENUM("ikan","udang")', 'default' => 'ikan'],
            'deskripsi'         => ['type' => 'TEXT', 'null' => true],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('komoditas_tambak');
    }

    public function down()
    {
        $this->forge->dropTable('komoditas_tambak');
    }
}
