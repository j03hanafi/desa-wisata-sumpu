<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class DetailFacilitySouvenirPlaceSeeder extends Seeder
{
    public function run()
    {
        $rows = array_map('str_getcsv', file(WRITEPATH.'seeds/'. 'detail_facility_souvenir_place.csv'));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $data = [
                'id' => $row[0],
                'souvenir_place_id' => $row[1],
                'facility_id' => $row[2],
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];

            $this->db->table('detail_facility_souvenir_place')->insert($data);
        }
    }
}
