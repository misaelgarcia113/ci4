<!DOCTYPE html>
<html lang="es">
  <head>
    <meta name="description" content="Dashboard Alumno">
    <title>VillaNet - Alumno</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="<?= base_url('/public/css/main.css'); ?>">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.3.7/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body class="app sidebar-mini">
 
    <!-- Navbar -->
    <header class="app-header">
      <a class="app-header__logo" href="#">Alumno</a>
      <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <ul class="app-nav">
        <!-- User Menu -->
        <li class="dropdown">
          <a class="app-nav__item" href="#" data-bs-toggle="dropdown" aria-label="Open Profile Menu">
            <i class="bi bi-person fs-4"></i>
          </a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2 fs-5"></i> Perfil</a></li>
            <li><a class="dropdown-item" href="<?= base_url(route_to('loginForm')); ?>"><i class="bi bi-box-arrow-right me-2 fs-5"></i> Cerrar Sesión</a></li>
          </ul>
        </li>
      </ul>
    </header>
 
    <!-- Sidebar -->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user">
        <img class="app-sidebar__user-avatar" src="https://randomuser.me/api/portraits/women/1.jpg" alt="Alumno">
        <div>
          <p class="app-sidebar__user-name">Alumno</p>
          <p class="app-sidebar__user-designation">Estudiante</p>
        </div>
      </div>
      <ul class="app-menu">
        <li>
          <a class="app-menu__item active" href="#">
            <i class="app-menu__icon bi bi-speedometer"></i>
            <span class="app-menu__label">Dashboard</span>
          </a>
        </li>
      </ul>
    </aside>
 
    <!-- Contenido principal -->
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="bi bi-mortarboard"></i> Dashboard Alumno</h1>
          <p>Mis materias y profesores</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
          <li class="breadcrumb-item">Alumno</li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ul>
      </div>
 
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h4 class="tile-title">Mis Materias</h4>
            <div class="table-responsive">
              <table id="tablaMaterias" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Grupo</th>
                    <th>Materia</th>
                    <th>Profesor</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($materias as $materia): ?>
                  <tr>
                    <td><?= esc($materia['group_name']) ?></td>
                    <td><?= esc($materia['subject']) ?></td>
                    <td><?= esc($materia['profesor_nombre']) ?></td>
                    <td><?= esc($materia['profesor_first_name']) ?></td>
                    <td><?= esc($materia['profesor_last_name']) ?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
 
    </main>
 
    <!-- Scripts -->
    <script src="<?= base_url('/js/jquery-3.7.0.min.js'); ?>"></script>
    <script src="<?= base_url('/js/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('/js/main.js'); ?>"></script>
    <script src="https://cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>
 
    <script>
      $(document).ready(function() {
        $('#tablaMaterias').DataTable({
          language: { url: 'https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-MX.json' }
        });
      });
    </script>
 
  </body>
</html>
 