<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class DetailFacilityWorshipPlaceSeeder extends Seeder
{
    public function run()
    {
        $rows = array_map('str_getcsv', file(WRITEPATH.'seeds/'. 'detail_facility_worship_place.csv'));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $data = [
                'id' => $row[0],
                'worship_place_id' => $row[1],
                'facility_id' => $row[2],
                'condition_id' => $row[3],
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];

            $this->db->table('detail_facility_worship_place')->insert($data);
        }
    }
}
