<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use Myth\Auth\Password;

class AccountSeeder extends Seeder
{
    public function run()
    {
        $rows = array_map('str_getcsv', file(WRITEPATH.'seeds/'. 'account.csv'));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $data = [
                'username' => $row[1],
                'first_name' => $row[2],
                'last_name' => $row[3],
                'email' => $row[4],
                'address' => $row[5],
                'phone' => $row[6],
                'password_hash' => Password::hash($row[7]),
                'reset_hash' => null,
                'reset_at' => null,
                'reset_expires' => null,
                'active' => 1,
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];

            $this->db->table('users')->insert($data);
        }
    }
}
