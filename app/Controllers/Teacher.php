<?php
 
namespace App\Controllers;
 
class Teacher extends BaseController
{
    public function index()
    {
        $session = session();
        $db      = \Config\Database::connect();
 
        $builder = $db->table('tbl_enrollment e');
        $builder->select('
            u.pk_user         as matricula,
            p.person          as nombre,
            p.first_name,
            p.last_name,
            p.telegram_chat_id,
            e.group_name,
            e.subject,
            e.pk_enrollment
        ');
        $builder->join('tbl_users u',   'u.pk_user  = e.fk_student_user');
        $builder->join('tbl_persons p', 'p.pk_phone = u.fk_phone');
        $builder->where('e.fk_teacher_user', $session->get('pk_user'));
 
        $data['alumnos'] = $builder->get()->getResultArray();
 
        return view('teacher/dashboard', $data);
    }
 
    public function sendMessage()
    {
        $session = session();
        $db      = \Config\Database::connect();
 
        $pk_enrollment = $this->request->getPost('pk_enrollment');
        $mensaje       = $this->request->getPost('mensaje');
 
        if (!$pk_enrollment || !$mensaje)
        {
            ob_clean();
            return $this->response->setJSON([
                'status'  => '400',
                'message' => 'Datos incompletos'
            ]);
        }
 
        $builder = $db->table('tbl_enrollment e');
        $builder->select('
            p.telegram_chat_id,
            p.person          as alumno_nombre,
            p.first_name      as alumno_first,
            p.last_name       as alumno_last,
            e.subject,
            e.group_name,
            tp.person         as profesor_nombre,
            tp.first_name     as profesor_first,
            tp.last_name      as profesor_last
        ');
        $builder->join('tbl_users u',   'u.pk_user  = e.fk_student_user');
        $builder->join('tbl_persons p', 'p.pk_phone = u.fk_phone');
        $builder->join('tbl_users tu',  'tu.pk_user = e.fk_teacher_user');
        $builder->join('tbl_persons tp','tp.pk_phone = tu.fk_phone');
        $builder->where('e.pk_enrollment', $pk_enrollment);
 
        $enrollment = $builder->get()->getRowArray();
 
        if (!$enrollment)
        {
            ob_clean();
            return $this->response->setJSON([
                'status'  => '400',
                'message' => 'Inscripción no encontrada'
            ]);
        }
 
        $fecha    = date('d/m/Y');
        $hora     = date('H:i:s');
        $profesor = $enrollment['profesor_nombre'] . ' ' . 
                    $enrollment['profesor_first']  . ' ' . 
                    $enrollment['profesor_last'];
 
        $textoTelegram = "📢 *Mensaje de tu Profesor*\n\n"  .
                         "📅 Fecha: {$fecha}\n"             .
                         "🕐 Hora: {$hora}\n"               .
                         "👨‍🏫 Profesor: {$profesor}\n"      .
                         "📚 Materia: {$enrollment['subject']}\n" .
                         "👥 Grupo: {$enrollment['group_name']}\n\n" .
                         "💬 Mensaje:\n{$mensaje}";
 
        helper('telegram');
        $resultado = enviarMensajeTelegram($enrollment['telegram_chat_id'], $textoTelegram);
 
        if ($resultado)
        {
            ob_clean();
            return $this->response->setJSON([
                'status'   => '200',
                'message'  => 'Mensaje enviado correctamente',
                'fecha'    => $fecha,
                'hora'     => $hora,
                'profesor' => $profesor,
                'materia'  => $enrollment['subject'],
                'texto'    => $mensaje
            ]);
        }
        else
        {
            ob_clean();
            return $this->response->setJSON([
                'status'  => '500',
                'message' => 'Error al enviar mensaje a Telegram'
            ]);
        }
    }
}