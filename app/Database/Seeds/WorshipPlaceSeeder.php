<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class WorshipPlaceSeeder extends Seeder
{
    public function run()
    {
        $rows = array_map('str_getcsv', file(WRITEPATH.'seeds/'. 'worship_place.csv'));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $data = [
                'id' => $row[0],
                'name' => $row[1],
                'address' => $row[2],
                'park_area_size' => $row[3],
                'building_size' => $row[4],
                'capacity' => $row[5],
                'last_renovation' => $row[6],
                'description' => $row[8],
                'lat' => $row[9],
                'lng' => $row[10],
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];

            $this->db->table('worship_place')->insert($data);
            $this->db->table('worship_place')->set('geom', $row[7], false)->where('id', $row[0])->update();
        }
    }
}
