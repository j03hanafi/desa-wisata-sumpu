<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class CulinaryPlaceSeeder extends Seeder
{
    public function run()
    {
        $rows = array_map('str_getcsv', file(WRITEPATH.'seeds/'. 'culinary_place.csv'));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $data = [
                'id' => $row[0],
                'name' => $row[1],
                'address' => $row[2],
                'contact_person' => $row[3],
                'capacity' => $row[4],
                'open' => $row[5],
                'close' => $row[6],
                'employee' => $row[7],
                'description' => $row[9],
                'lat' => $row[10],
                'lng' => $row[11],
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];

            $this->db->table('culinary_place')->insert($data);
            $this->db->table('culinary_place')->set('geom', $row[8], false)->where('id', $row[0])->update();
        }
    }
}
