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
                'comment' => $row[7],
                'date' => $row[8],
                'rating' => $row[9],
                'account_id' => $row[10],
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];

            if(!empty($row[2])){
                $data += array('rumah_gadang_id' => $row[2]);
            }
            if(!empty($row[3])){
                $data += array('event_id' => $row[3]);
            }
            if(!empty($row[4])){
                $data += array('culinary_place_id' => $row[4]);
            }
            if(!empty($row[5])){
                $data += array('worship_place_id' => $row[5]);
            }
            if(!empty($row[6])){
                $data += array('souvenir_place_id' => $row[6]);
            }

            $this->db->table('review')->insert($data);
        }
    }
}
