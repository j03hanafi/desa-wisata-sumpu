<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailFacilitySouvenirPlace extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 6,
                'unique' => true,
            ],
            'souvenir_place_id' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
            ],
            'facility_id' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ];

        $this->db->disableForeignKeyChecks();
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('souvenir_place_id', 'souvenir_place', 'id');
        $this->forge->addForeignKey('facility_id', 'facility_souvenir_place', 'id');
        $this->forge->createTable('detail_facility_souvenir_place');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('detail_facility_souvenir_place');
    }
}
