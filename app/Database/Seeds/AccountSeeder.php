<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class AccountSeeder extends Seeder
{
    public function run()
    {
        $rows = array_map('str_getcsv', file(WRITEPATH.'seeds/'. 'account.csv'));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $data = [
                'id' => $row[0],
                'username' => $row[1],
                'first_name' => $row[2],
                'last_name' => $row[3],
                'email' => $row[4],
                'address' => $row[5],
                'phone' => $row[6],
                'password' => $row[7],
                'avatar' => $row[8],
                'last_login' => $row[9],
                'role_id' => $row[10],
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];

            $this->db->table('account')->insert($data);
        }
    }
}
