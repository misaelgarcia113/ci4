<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField(
        [
            'pk_user' => 
            [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
            ],

            'fk_phone' => 
            [
                'type'           => 'VARCHAR',
                'constraint'     => 10,
            ],

            'fk_level' => 
            [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
            ],

            'password' => 
            [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'locked' => 
            [
                'type'       => 'SMALLINT',
                'constraint' => 1,
                'default'    => 0,
            ],


            'created_at DATETIME default current_timestamp',
            'updated_at DATETIME default current_timestamp on update current_timestamp'
       
        ]);

        $this->forge->addKey('pk_user', true);

        $this->forge->addForeignKey('fk_phone','tbl_persons','pk_phone','CASCADE','CASCADE');
        $this->forge->addForeignKey('fk_level','cat_levels','pk_level','CASCADE','CASCADE');

        $this->forge->createTable('tbl_users');
    }

    public function down()
    {
        //
    }
}
