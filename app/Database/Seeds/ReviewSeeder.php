<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        $rows = array_map('str_getcsv', file(WRITEPATH.'seeds/'. 'review.csv'));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $data = [
                'id' => $row[0],
                'status' => $row[1],
                'comment' => $row[4],
                'date' => $row[5],
                'rating' => $row[6],
                'user_id' => $row[7],
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];

            if(!empty($row[2])){
                $data += array('rumah_gadang_id' => $row[2]);
            }
            if(!empty($row[3])){
                $data += array('event_id' => $row[3]);
            }

            $this->db->table('review')->insert($data);
        }
    }
}
