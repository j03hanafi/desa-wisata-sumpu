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
                'comment' => $row[6],
                'date' => $row[7],
                'rating' => $row[8],
                'account_id' => $row[9],
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];

            if(!empty($row[1])){
                $data += array('rumah_gadang_id' => $row[1]);
            }
            if(!empty($row[2])){
                $data += array('event_id' => $row[2]);
            }
            if(!empty($row[3])){
                $data += array('culinary_place_id' => $row[3]);
            }
            if(!empty($row[4])){
                $data += array('worship_place_id' => $row[4]);
            }
            if(!empty($row[5])){
                $data += array('souvenir_place_id' => $row[5]);
            }

            $this->db->table('review')->insert($data);
        }
    }
}
