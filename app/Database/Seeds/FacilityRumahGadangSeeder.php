<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class FacilityRumahGadangSeeder extends Seeder
{
    public function run()
    {
        $rows = array_map('str_getcsv', file(WRITEPATH.'seeds/'. 'facility_rumah_gadang.csv'));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $data = [
                'id' => $row[0],
                'facility' => $row[1],
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];

            $this->db->table('facility_rumah_gadang')->insert($data);
        }
    }
}
