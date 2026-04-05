<?php

namespace App\Database\Seeds;


use CodeIgniter\Database\Seeder;
use Faker\Factory;

class PersonSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('es_ES');

        $persons = [];

        for ($i = 0; $i < 10; $i++) 
        {
            $name      = $faker->name;
            $firstName = $faker->firstName;
            $lastName  = $faker->lastName;

            $persons[] = 
            [
                'pk_phone'   => $faker->numerify('##########'), 
                'person'     => $name,
                'first_name' => $firstName,
                'last_name'  => $lastName,
            ];
        }

        $this->db->table('tbl_persons')->insertBatch($persons);
    }
}
