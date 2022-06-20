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
                'address' => $row[4],
                'contact_person' => $row[2],
                'owner' => $row[3],
                'employee' => $row[5],
                'open' => $row[7],
                'close' => $row[8],
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];

            $this->db->table('souvenir_place')->insert($data);
        }
    }
}
