<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLevelsTable extends Migration
{
    public function up()
    {
        $this->forge->addField(
        [
            'pk_level' => 
            [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            
            'level' => 
            [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],

            'created_at DATETIME default current_timestamp',
            'updated_at DATETIME default current_timestamp on update current_timestamp'
        ]);

        $this->forge->addKey('pk_level', true);
        $this->forge->createTable('cat_levels');
    }

    public function down()
    {
        //$this->forge->dropTable('cat_levels');
    }
}
