<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailFacilityCulinaryPlace extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 6,
                'unique' => true,
            ],
            'culinary_place_id' => [
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
        $this->forge->addForeignKey('culinary_place_id', 'culinary_place', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('facility_id', 'facility_culinary_place', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('detail_facility_culinary_place');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('detail_facility_culinary_place');
    }
}
