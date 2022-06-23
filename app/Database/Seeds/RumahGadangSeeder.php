<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class RumahGadangSeeder extends Seeder
{
    public function run()
    {

        $rows = array_map('str_getcsv', file(WRITEPATH.'seeds/'. 'rumah_gadang.csv'));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $data = [
                'id' => $row[0],
                'name' => $row[1],
                'address' => $row[2],
                'open' => $row[3],
                'close' => $row[4],
                'ticket_price' => $row[5],
                'contact_person' => $row[7],
                'recom' => $row[8],
                'owner' => $row[9],
                'lat' => $row[10],
                'long' => $row[11],
                'description' => $row[12],
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];

            $this->db->table('rumah_gadang')->insert($data);
        }

    }
}
