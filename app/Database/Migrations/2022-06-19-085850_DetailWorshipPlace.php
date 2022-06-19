<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailWorshipPlace extends Migration
{
    public function up()
    {
        $fields = [
            'worship_place_id' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
                'unique' => true,
            ],
            'lat' => [
                'type' => 'DECIMAL',
                'constraint' => '10,8',
            ],
            'long' => [
                'type' => 'DECIMAL',
                'constraint' => '11,8',
            ],
            'description' => [
                'type' => 'TEXT',
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
        $this->forge->addPrimaryKey('worship_place_id');
        $this->forge->addForeignKey('worship_place_id', 'worship_place', 'id');
        $this->forge->createTable('detail_worship_place');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('detail_worship_place');
    }
}
