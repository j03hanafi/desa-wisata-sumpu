<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Role extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 6,
                'unique' => true,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
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
        $this->forge->createTable('role');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('role');
    }
}
