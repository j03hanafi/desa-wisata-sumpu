<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Review extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 7,
                'unique' => true,
            ],
            'rumah_gadang_id' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
                'null' => true,
            ],
            'event_id' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
                'null' => true,
            ],
            'culinary_place_id' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
                'null' => true,
            ],
            'worship_place_id' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
                'null' => true,
            ],
            'souvenir_place_id' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
                'default' => 0,
            ],
            'comment' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'date' => [
                'type' => 'DATETIME',
            ],
            'rating' => [
                'type' => 'INT',
            ],
            'account_id' => [
                'type' => 'VARCHAR',
                'constraint' => 7,
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
        $this->forge->addForeignKey('rumah_gadang_id', 'rumah_gadang', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('event_id', 'event', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('culinary_place_id', 'culinary_place', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('worship_place_id', 'worship_place', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('souvenir_place_id', 'souvenir_place', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('account_id', 'account', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('review');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('review');
    }
}
