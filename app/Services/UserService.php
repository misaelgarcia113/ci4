<?php

namespace App\Services;

class UserService
{
    public function getUsers()
    {
        return 
        [
            [
                'id'     => 1,
                'nombre' => 'Juan'
            ],
            [
                'id'     => 2,
                'nombre' => 'María'
            ],
            [
                'id'     => 3,
                'nombre' => 'Pedro'
            ],
            [
                'idMsg'     => 200,
                'msg' => 'Obtiene todos los registros'
            ],
        ];
    }
}
