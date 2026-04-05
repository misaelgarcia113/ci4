<?php
 
namespace App\Controllers;
 
use App\Models\PersonsModel;
use App\Models\UsersModel;
 
class Auth extends BaseController
{
    public function loginForm()
    {
        return view('accounts/login');
    }
    
    public function registerForm()
    {
        return view('accounts/register');
    }
    
    public function forget()
    {
        echo "Forget";
    }
 
    public function loginProcess()
    {
        $rules = 
        [
            'phone'    => 'required|min_length[10]|numeric',
            'password' => 'required|min_length[3]'
        ];
 
        if (!$this->validate($rules))
        {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
 
        $usersModel = new UsersModel();
 
        $pk_user  = substr($this->request->getPost('phone'), -4);
        $password = $this->request->getPost('password');
 
        $user = $usersModel->where('pk_user', $pk_user)->first();
 
        if ($user)
        {
            if (password_verify($password, $user['password']))
            {
                $session = session();
 
                $data = 
                [
                    'pk_user'   => $user['pk_user'],
                    'fk_level'  => $user['fk_level'],
                    'fk_phone'  => $user['fk_phone'],
                    'logged_in' => true
                ];
 
                $session->set($data);
 
                // Redirige según rol
                if ($user['fk_level'] == 1)
                {
                    return redirect()->route('adminDashboard');
                }
                elseif ($user['fk_level'] == 2)
                {
                    return redirect()->route('teacherDashboard');
                }
                elseif ($user['fk_level'] == 3)
                {
                    return redirect()->route('studentDashboard');
                }
                else
                {
                    return redirect()->route('adminDashboard');
                }
            }
            else
            {
                $this->validator->setError('phone', 'Usuario y/o password incorrectos');
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }
        else
        {
            $this->validator->setError('phone', 'Usuario y/o password incorrectos');
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    }
 
    public function registerProcess()
    {
        $fk_level = $this->request->getPost('fk_level');
 
        // Si es alumno (3), el telegram_chat_id es requerido
        // Si es otro rol, es opcional
        $telegramRule = ($fk_level == '3') 
            ? 'required|max_length[50]' 
            : 'permit_empty|max_length[50]';
 
        $rules = 
        [
            'phone'            => 'required|min_length[10]|max_length[10]|numeric|matches[cphone]',
            'cphone'           => 'required|min_length[10]|max_length[10]|numeric|matches[phone]',
            'name'             => 'required|alpha_space',
            'firstName'        => 'required|alpha_space',
            'lastName'         => 'required|alpha_space',
            'fk_level'         => 'required|in_list[1,2,3]',
            'telegram_chat_id' => $telegramRule,
            'password'         => 'required|min_length[6]',
        ]; 
        
        if (!$this->validate($rules))
        {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
 
        if ($this->request->is('post'))
        {
            $personsModel = new PersonsModel();
            $usersModel   = new UsersModel();
 
            // Solo guardar telegram_chat_id si es alumno
            $telegram = ($fk_level == '3') 
                ? $this->request->getPost('telegram_chat_id') 
                : null;
 
            $tbl_persons = 
            [
                'pk_phone'         => $this->request->getPost('phone'),
                'person'           => strtoupper($this->request->getPost('name')),
                'first_name'       => strtoupper($this->request->getPost('firstName')),
                'last_name'        => strtoupper($this->request->getPost('lastName')),
                'telegram_chat_id' => $telegram,
            ]; 
 
            $tbl_users = 
            [
                'pk_user'  => substr($this->request->getPost('phone'), -4),
                'fk_phone' => $this->request->getPost('phone'),
                'fk_level' => $fk_level,
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'locked'   => 0
            ]; 
 
            $insertPersons = $personsModel->insert($tbl_persons);
            $insertUsers   = $usersModel->insert($tbl_users);
 
            if ($insertPersons === false || $insertUsers === false) 
            {
                return $this->response->setJSON([
                    'status'  => '400',
                    'message' => 'Error al registrar usuario'
                ]);
            } 
            else 
            {
                return $this->response->setJSON([
                    'status'  => '200',
                    'message' => 'Usuario registrado correctamente'
                ]);
            }
        }           
    }
}
 