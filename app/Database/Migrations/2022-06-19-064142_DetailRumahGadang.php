<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailRumahGadang extends Migration
{
    public function up()
    {
        $fields = [
            'rumah_gadang_id' => [
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
        $this->forge->addPrimaryKey('rumah_gadang_id');
        $this->forge->addForeignKey('rumah_gadang_id', 'rumah_gadang', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('detail_rumah_gadang');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('detail_rumah_gadang');
    }
}
