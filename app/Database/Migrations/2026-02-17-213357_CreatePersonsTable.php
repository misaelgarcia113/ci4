<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePersonsTable extends Migration
{

    public function up()
    {
        $this->forge->addField(
        [ 
            'pk_phone' => 
             [ 
                'type'       => 'VARCHAR', 
                'constraint' => 10, 
             ],

            'person' => 
            [ 
                'type'       => 'VARCHAR',
                'constraint' => 50, 
            ],
              
            'first_name' => 
            [ 
                'type'       => 'VARCHAR', 
                'constraint' => 50,
            ],

            'last_name' => 
            [ 
                'type' => 'VARCHAR', 
                'constraint' => 50, 
            ],

            'created_at DATETIME default current_timestamp', 
            'updated_at DATETIME default current_timestamp on update current_timestamp' 
        
        ]); 
           
        $this->forge->addKey('pk_phone', true); 
        $this->forge->createTable('tbl_persons');
    }

    public function down()
    {
        //
    }
}
