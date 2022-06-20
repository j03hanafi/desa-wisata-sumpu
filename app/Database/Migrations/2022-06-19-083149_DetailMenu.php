<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailMenu extends Migration
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
            'menu_id' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
            ],
            'price' => [
                'type' => 'INT',
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
        $this->forge->addForeignKey('menu_id', 'menu', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('detail_menu');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('detail_menu');
    }
}
