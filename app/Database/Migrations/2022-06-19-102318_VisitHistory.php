<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class VisitHistory extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
                'unique' => true,
            ],
            'account_id' => [
                'type' => 'VARCHAR',
                'constraint' => 7,
            ],
            'object_id' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
                'null' => true,
            ],
            'category' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
                'default' => '0',
            ],
            'date_visit' => [
                'type' => 'DATETIME',
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
        $this->forge->addForeignKey('account_id', 'account', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('visit_history');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('visit_history');
    }
}
