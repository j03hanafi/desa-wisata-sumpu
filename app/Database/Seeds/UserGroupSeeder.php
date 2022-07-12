<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use Myth\Auth\Password;

class UserGroupSeeder extends Seeder
{
    public function run()
    {
        $rows = array_map('str_getcsv', file(WRITEPATH.'seeds/'. 'auth_groups_users.csv'));
        $header = array_shift($rows);
        
        foreach ($rows as $row) {
            $data = [
                'group_id' => $row[0],
                'user_id' => $row[1],
            ];
            
            $this->db->table('auth_groups_users')->insert($data);
        }
    }
}
