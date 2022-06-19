<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailFacilityWorshipPlace extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 6,
                'unique' => true,
            ],
            'worship_place_id' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
            ],
            'facility_id' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
            ],
            'condition_id' => [
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
        $this->forge->addForeignKey('worship_place_id', 'worship_place', 'id');
        $this->forge->addForeignKey('facility_id', 'facility_worship_place', 'id');
        $this->forge->addForeignKey('condition_id', 'condition_worship_place', 'id');
        $this->forge->createTable('detail_facility_worship_place');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('detail_facility_worship_place');
    }
}
