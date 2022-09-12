<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class SouvenirPlaceSeeder extends Seeder
{
    public function run()
    {
        $rows = array_map('str_getcsv', file(WRITEPATH.'seeds/'. 'souvenir_place.csv'));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $data = [
                'id' => $row[0],
                'name' => $row[1],
                'address' => $row[2],
                'contact_person' => $row[3],
                'employee' => $row[4],
                'open' => $row[6],
                'close' => $row[7],
                'description' => $row[8],
                'lat' => $row[9],
                'lng' => $row[10],
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];

            $this->db->table('souvenir_place')->insert($data);
            $this->db->table('souvenir_place')->set('geom', $row[5], false)->where('id', $row[0])->update();
        }
    }
}
