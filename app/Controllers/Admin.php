<?php
 
namespace App\Controllers;
 
class Admin extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
 
        // Obtener profesores (fk_level = 2)
        $profesores = $db->table('tbl_users u')
            ->select('u.pk_user, p.person, p.first_name, p.last_name')
            ->join('tbl_persons p', 'p.pk_phone = u.fk_phone')
            ->where('u.fk_level', 2)
            ->get()->getResultArray();
 
        // Obtener alumnos (fk_level = 3)
        $alumnos = $db->table('tbl_users u')
            ->select('u.pk_user, p.person, p.first_name, p.last_name')
            ->join('tbl_persons p', 'p.pk_phone = u.fk_phone')
            ->where('u.fk_level', 3)
            ->get()->getResultArray();
 
        // Obtener inscripciones existentes
        $inscripciones = $db->table('tbl_enrollment e')
            ->select('
                e.pk_enrollment,
                e.group_name,
                e.subject,
                tp.person       as profesor_nombre,
                tp.first_name   as profesor_first,
                tp.last_name    as profesor_last,
                ta.person       as alumno_nombre,
                ta.first_name   as alumno_first,
                ta.last_name    as alumno_last
            ')
            ->join('tbl_users up',  'up.pk_user  = e.fk_teacher_user')
            ->join('tbl_persons tp','tp.pk_phone = up.fk_phone')
            ->join('tbl_users ua',  'ua.pk_user  = e.fk_student_user')
            ->join('tbl_persons ta','ta.pk_phone = ua.fk_phone')
            ->get()->getResultArray();
 
        // Obtener todos los usuarios con su nivel y datos personales
        $usuarios = $db->table('tbl_users u')
            ->select('
                u.pk_user,
                u.fk_phone,
                u.locked,
                u.created_at,
                c.level,
                p.person,
                p.first_name,
                p.last_name,
                p.telegram_chat_id
            ')
            ->join('tbl_persons p', 'p.pk_phone = u.fk_phone')
            ->join('cat_levels c',  'c.pk_level = u.fk_level')
            ->orderBy('u.created_at', 'DESC')
            ->get()->getResultArray();
 
        // Obtener niveles para el select del modal editar
        $niveles = $db->table('cat_levels')
            ->select('pk_level, level')
            ->get()->getResultArray();
 
        return view('admin/dashboard', [
            'profesores'    => $profesores,
            'alumnos'       => $alumnos,
            'inscripciones' => $inscripciones,
            'usuarios'      => $usuarios,
            'niveles'       => $niveles,
        ]);
    }
 
    // ─── CRUD USUARIOS ───────────────────────────────────────
 
    // Obtener un usuario para editar vía Ajax
    public function getUser()
    {
        $db      = \Config\Database::connect();
        $pk_user = $this->request->getPost('pk_user');
 
        $user = $db->table('tbl_users u')
            ->select('u.pk_user, u.fk_phone, u.fk_level, u.locked, p.person, p.first_name, p.last_name, p.telegram_chat_id')
            ->join('tbl_persons p', 'p.pk_phone = u.fk_phone')
            ->where('u.pk_user', $pk_user)
            ->get()->getRowArray();
 
        if ($user)
        {
            return $this->response->setJSON(['status' => '200', 'user' => $user]);
        }
 
        return $this->response->setJSON(['status' => '404', 'message' => 'Usuario no encontrado']);
    }
 
    // Actualizar usuario vía Ajax
    public function updateUser()
    {
        $db      = \Config\Database::connect();
        $pk_user = $this->request->getPost('pk_user');
        $fk_level = $this->request->getPost('fk_level');
        $locked   = $this->request->getPost('locked');
        $person   = strtoupper($this->request->getPost('person'));
        $first    = strtoupper($this->request->getPost('first_name'));
        $last     = strtoupper($this->request->getPost('last_name'));
        $telegram = $this->request->getPost('telegram_chat_id');
 
        // Obtener fk_phone del usuario
        $user = $db->table('tbl_users')->where('pk_user', $pk_user)->get()->getRowArray();
 
        if (!$user)
        {
            return $this->response->setJSON(['status' => '404', 'message' => 'Usuario no encontrado']);
        }
 
        // Actualizar tbl_users
        $db->table('tbl_users')
            ->where('pk_user', $pk_user)
            ->update([
                'fk_level' => $fk_level,
                'locked'   => $locked,
            ]);
 
        // Actualizar tbl_persons
        $db->table('tbl_persons')
            ->where('pk_phone', $user['fk_phone'])
            ->update([
                'person'           => $person,
                'first_name'       => $first,
                'last_name'        => $last,
                'telegram_chat_id' => $telegram ?: null,
            ]);
 
        return $this->response->setJSON(['status' => '200', 'message' => 'Usuario actualizado correctamente']);
    }
 
    // Eliminar usuario vía Ajax
    public function deleteUser()
    {
        $db      = \Config\Database::connect();
        $pk_user = $this->request->getPost('pk_user');
 
        $user = $db->table('tbl_users')->where('pk_user', $pk_user)->get()->getRowArray();
 
        if (!$user)
        {
            return $this->response->setJSON(['status' => '404', 'message' => 'Usuario no encontrado']);
        }
 
        // Eliminar inscripciones relacionadas
        $db->table('tbl_enrollment')
            ->where('fk_teacher_user', $pk_user)
            ->orWhere('fk_student_user', $pk_user)
            ->delete();
 
        // Eliminar usuario
        $db->table('tbl_users')->where('pk_user', $pk_user)->delete();
 
        // Eliminar persona
        $db->table('tbl_persons')->where('pk_phone', $user['fk_phone'])->delete();
 
        return $this->response->setJSON(['status' => '200', 'message' => 'Usuario eliminado correctamente']);
    }
 
    // ─── INSCRIPCIONES ───────────────────────────────────────
 
    public function createEnrollment()
    {
        $db = \Config\Database::connect();
 
        $fk_teacher = $this->request->getPost('fk_teacher_user');
        $fk_student = $this->request->getPost('fk_student_user');
        $group_name = $this->request->getPost('group_name');
        $subject    = $this->request->getPost('subject');
 
        if (!$fk_teacher || !$fk_student || !$group_name || !$subject)
        {
            return $this->response->setJSON(['status' => '400', 'message' => 'Todos los campos son obligatorios']);
        }
 
        $existe = $db->table('tbl_enrollment')
            ->where('fk_teacher_user', $fk_teacher)
            ->where('fk_student_user', $fk_student)
            ->where('subject', $subject)
            ->countAllResults();
 
        if ($existe > 0)
        {
            return $this->response->setJSON(['status' => '409', 'message' => 'El alumno ya está inscrito en esa materia con ese profesor']);
        }
 
        $data = 
        [
            'fk_teacher_user' => $fk_teacher,
            'fk_student_user' => $fk_student,
            'group_name'      => strtoupper($group_name),
            'subject'         => $subject,
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
        ];
 
        $db->table('tbl_enrollment')->insert($data);
        $pk = $db->insertID();
 
        if ($pk)
        {
            return $this->response->setJSON(['status' => '200', 'message' => 'Inscripción creada correctamente', 'pk_enrollment' => $pk]);
        }
 
        return $this->response->setJSON(['status' => '500', 'message' => 'Error al crear la inscripción']);
    }
 
    public function deleteEnrollment()
    {
        $db = \Config\Database::connect();
        $pk = $this->request->getPost('pk_enrollment');
 
        if (!$pk)
        {
            return $this->response->setJSON(['status' => '400', 'message' => 'ID de inscripción requerido']);
        }
 
        $db->table('tbl_enrollment')->where('pk_enrollment', $pk)->delete();
 
        return $this->response->setJSON(['status' => '200', 'message' => 'Inscripción eliminada correctamente']);
    }
 
    public function dashboardForm()
    {
    }
}