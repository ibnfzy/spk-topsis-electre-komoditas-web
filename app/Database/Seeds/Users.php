<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Database\Seeder;

class Users extends Seeder
{
    public function run()
    {
        $now = new RawSql('(NOW())');

        $this->db->table('users')->insert([
            'username' => 'admin',
            'password' => 'admin',
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
