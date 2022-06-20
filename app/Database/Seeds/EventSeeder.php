<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class EventSeeder extends Seeder
{
    public function run()
    {
        $rows = array_map('str_getcsv', file(WRITEPATH.'seeds/'. 'event.csv'));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $data = [
                'id' => $row[0],
                'name' => $row[1],
                'date_start' => $row[2],
                'date_end' => $row[3],
                'description' => $row[4],
                'ticket_price' => $row[5],
                'contact_person' => $row[6],
                'category_id' => $row[7],
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];

            $this->db->table('event')->insert($data);
        }
    }
}
