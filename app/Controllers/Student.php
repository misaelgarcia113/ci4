<?php
 
namespace App\Controllers;
 
class Student extends BaseController
{
    public function index()
    {
        $session = session();
        $db      = \Config\Database::connect();
 
        // Obtener datos del alumno logueado
        $builder = $db->table('tbl_enrollment e');
        $builder->select('
            u.pk_user         as matricula,
            p.person          as nombre,
            p.first_name,
            p.last_name,
            e.group_name,
            e.subject,
            tp.person         as profesor_nombre,
            tp.first_name     as profesor_first_name,
            tp.last_name      as profesor_last_name
        ');
        $builder->join('tbl_users u',   'u.pk_user   = e.fk_student_user');
        $builder->join('tbl_persons p', 'p.pk_phone  = u.fk_phone');
        $builder->join('tbl_users tu',  'tu.pk_user  = e.fk_teacher_user');
        $builder->join('tbl_persons tp','tp.pk_phone = tu.fk_phone');
 
        // Filtramos por el alumno logueado
        $builder->where('e.fk_student_user', $session->get('pk_user'));
 
        $data['materias'] = $builder->get()->getResultArray();
 
        return view('student/dashboard', $data);
    }
}
 