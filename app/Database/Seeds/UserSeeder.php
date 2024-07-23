<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'email' => 'admin@admin.com',
                'password' => password_hash('admin12345', PASSWORD_DEFAULT),
                'first_name' => 'Admin',
                'last_name' => 'Uno',
            ],
        ];

        // Insertar los datos en la tabla 'user'
        $this->db->table('user')->insertBatch($data);
    }
}
