<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableEnrollment extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'pk_enrollment' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'fk_teacher_user' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
            ],
            'fk_student_user' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
            ],
            'group_name' => [
                'type'           => 'VARCHAR',
                'constraint'     => '20',
            ],
            'subject' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
        ]);

        $this->forge->addKey('pk_enrollment', true);
        $this->forge->addForeignKey('fk_teacher_user', 'tbl_users', 'pk_user', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('fk_student_user', 'tbl_users', 'pk_user', 'CASCADE', 'CASCADE');

        $this->forge->createTable('tbl_enrollment');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_enrollment');
    }
}