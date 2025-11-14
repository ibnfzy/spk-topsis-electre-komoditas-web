<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Database\Seeder;

class Users extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('users');

        $builder->truncate();

        $builder->insert([
            'username'   => 'admin',
            'password'   => password_hash('admin', PASSWORD_DEFAULT),
            'created_at' => new RawSql('NOW()'),
            'updated_at' => new RawSql('NOW()'),
        ]);
    }
}
