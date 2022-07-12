<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class VisitHistorySeeder extends Seeder
{
    public function run()
    {
        $rows = array_map('str_getcsv', file(WRITEPATH.'seeds/'. 'visit_history.csv'));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $data = [
                'id' => $row[0],
                'user_id' => $row[1],
                'date_visit' => $row[2],
                'object_id' => $row[3],
                'category' => $row[4],
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];

            $this->db->table('visit_history')->insert($data);
        }
    }
}
