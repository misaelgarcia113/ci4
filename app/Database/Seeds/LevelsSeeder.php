<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LevelsSeeder extends Seeder
{
    public function run()
    {
        $data = 
        [
            ['level' => 'Administrador'],
            ['level' => 'Vendedor'     ],
            ['level' => 'Cliente'      ],
            ['level' => 'Teacher'      ],
            ['level' => 'Student'      ],
            ['level' => 'Secretary'    ],
        ];

        $this->db->table('cat_levels')->insertBatch($data);
    }
}
