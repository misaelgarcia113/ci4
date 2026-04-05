<?php
 
namespace App\Filters;
 
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Filters\FilterInterface;
 
class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
 
        if (!$session->get('logged_in'))
        {
            return redirect()->route('loginForm');
        }
 
        $fk_level    = $session->get('fk_level');
        $currentPath = $request->getUri()->getPath();
 
        switch ($fk_level)
        {
            case 1:
                // Admin solo puede estar en rutas /admin/
                if (strpos($currentPath, 'admin') === false)
                {
                    return redirect()->route('adminDashboard');
                }
            break;
 
            case 2:
                // Profesor solo puede estar en rutas /teacher/
                if (strpos($currentPath, 'teacher') === false)
                {
                    return redirect()->route('teacherDashboard');
                }
            break;
 
            case 3:
                // Alumno solo puede estar en rutas /student/
                if (strpos($currentPath, 'student') === false)
                {
                    return redirect()->route('studentDashboard');
                }
            break;
 
            default:
                return redirect()->route('loginForm');
            break;
        }
    }
 
    public function after(RequestInterface $request, $response, $arguments = null)
    {
    }
}
 