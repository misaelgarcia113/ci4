<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class UsersSeeder extends Seeder
{
    public function run()
    {

        $faker = Factory::create('es_ES');
        $db = \Config\Database::connect();

        $persons = $db->table('tbl_persons')->select('pk_phone')->get()->getResultArray();
        $levels  = $db->table('cat_levels')->select('pk_level')->get()->getResultArray();

        if (empty($persons) || empty($levels)) 
        {
            die("Error: Debes poblar primero tbl_persons y cat_levels.");
        }

        $users = [];
        
        foreach ($persons as $person) 
        {
            $users[] = 
            [
                'pk_user'    => substr($person['pk_phone'], -4),
                'fk_phone'   => $person['pk_phone'],
                'fk_level'   => $faker->randomElement($levels)['pk_level'],
                'password'   => password_hash('123', PASSWORD_DEFAULT),
                'locked'     => $faker->numberBetween(0, 1),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        $this->db->table('tbl_users')->insertBatch($users);
    }
}
