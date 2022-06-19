<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class WorshipPlace extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
                'unique' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'park_area_size' => [
                'type' => 'INT',
                'null' => true,
            ],
            'building_size' => [
                'type' => 'INT',
                'null' => true,
            ],
            'capacity' => [
                'type' => 'INT',
                'null' => true,
            ],
            'last_renovation' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'geom' => [
                'type' => 'GEOMETRY',
                'null' => true,
            ],
            'category_id' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
                'null' => true,
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
        $this->forge->addForeignKey('category_id', 'category_worship_place', 'id');
        $this->forge->createTable('worship_place');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('worship_place');
    }
}
