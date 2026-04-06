<!DOCTYPE html>
<html lang="es">
  <head>
    <meta name="description" content="Dashboard Profesor">
    <title>VillaNet - Profesor</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="<?= base_url('/css/main.css'); ?>">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.3.7/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body class="app sidebar-mini">
 
    <!-- Navbar -->
    <header class="app-header">
      <a class="app-header__logo" href="#">Profesor</a>
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
        <img class="app-sidebar__user-avatar" src="https://randomuser.me/api/portraits/men/1.jpg" alt="Profesor">
        <div>
          <p class="app-sidebar__user-name">Profesor</p>
          <p class="app-sidebar__user-designation">Docente</p>
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
          <h1><i class="bi bi-person-workspace"></i> Dashboard Profesor</h1>
          <p>Lista de alumnos inscritos</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
          <li class="breadcrumb-item">Profesor</li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ul>
      </div>
 
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h4 class="tile-title">Mis Alumnos</h4>
            <div class="table-responsive">
              <table id="tablaAlumnos" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Matrícula</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Grupo</th>
                    <th>Materia</th>
                    <th>Acción</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($alumnos as $alumno): ?>
                  <tr>
                    <td><?= esc($alumno['matricula']) ?></td>
                    <td><?= esc($alumno['nombre']) ?></td>
                    <td><?= esc($alumno['first_name']) ?></td>
                    <td><?= esc($alumno['last_name']) ?></td>
                    <td><?= esc($alumno['group_name']) ?></td>
                    <td><?= esc($alumno['subject']) ?></td>
                    <td>
                      <button 
                        class="btn btn-primary btn-sm btnEnviarMensaje"
                        data-pk="<?= esc($alumno['pk_enrollment']) ?>"
                        data-nombre="<?= esc($alumno['nombre'] . ' ' . $alumno['first_name']) ?>">
                        <i class="bi bi-send"></i> Mensaje
                      </button>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
 
      <!-- Historial de mensajes enviados -->
      <div class="row mt-3">
        <div class="col-md-12">
          <div class="tile">
            <h4 class="tile-title">Mensajes Enviados</h4>
            <div class="table-responsive">
              <table id="tablaMensajes" class="table table-striped">
                <thead>
                  <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Alumno</th>
                    <th>Materia</th>
                    <th>Mensaje</th>
                  </tr>
                </thead>
                <tbody id="bodyMensajes">
                  <!-- Se llena dinámicamente con Ajax -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
 
    </main>
 
    <!-- Modal para enviar mensaje -->
    <div class="modal fade" id="modalMensaje" tabindex="-1" aria-labelledby="modalMensajeLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalMensajeLabel"><i class="bi bi-send me-2"></i>Enviar Mensaje</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Enviando mensaje a: <strong id="nombreAlumnoModal"></strong></p>
            <input type="hidden" id="pkEnrollmentModal">
            <div class="mb-3">
              <label for="textoMensaje" class="form-label">Mensaje</label>
              <textarea class="form-control" id="textoMensaje" rows="4" placeholder="Escribe tu mensaje aquí..."></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" id="btnConfirmarMensaje">
              <i class="bi bi-send me-1"></i> Enviar
            </button>
          </div>
        </div>
      </div>
    </div>
 
    <!-- Scripts -->
    <script src="<?= base_url('/js/jquery-3.7.0.min.js'); ?>"></script>
    <script src="<?= base_url('/js/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('/js/main.js'); ?>"></script>
    <script src="https://cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 
    <script>
      $(document).ready(function() {
 
        // Inicializar DataTable
        $('#tablaAlumnos').DataTable({
          language: { url: 'https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-MX.json' }
        });
 
        // Abrir modal al dar clic en Mensaje
        $(document).on('click', '.btnEnviarMensaje', function() {
          const pk     = $(this).data('pk');
          const nombre = $(this).data('nombre');
          $('#pkEnrollmentModal').val(pk);
          $('#nombreAlumnoModal').text(nombre);
          $('#textoMensaje').val('');
          $('#modalMensaje').modal('show');
        });
 
        // Enviar mensaje por Ajax
        $('#btnConfirmarMensaje').on('click', function() {
          const pk      = $('#pkEnrollmentModal').val();
          const mensaje = $('#textoMensaje').val().trim();
 
          if (!mensaje) {
            Swal.fire('Error', 'Escribe un mensaje antes de enviar', 'warning');
            return;
          }
 
          $.ajax({
            url: '<?= base_url('teacher/sendMessage') ?>',
            method: 'POST',
            data: {
              pk_enrollment: pk,
              mensaje: mensaje
            },
            success: function(res) {
              if (res.status === '200') {
                $('#modalMensaje').modal('hide');
 
                // Agregar al historial de mensajes
                const fila = `<tr>
                  <td>${res.fecha}</td>
                  <td>${res.hora}</td>
                  <td>${$('#nombreAlumnoModal').text()}</td>
                  <td>${res.materia}</td>
                  <td>${res.texto}</td>
                </tr>`;
                $('#bodyMensajes').prepend(fila);
 
                Swal.fire('Enviado', 'Mensaje enviado correctamente a Telegram', 'success');
              } else {
                Swal.fire('Error', res.message, 'error');
              }
            },
            error: function() {
              Swal.fire('Error', 'No se pudo conectar con el servidor', 'error');
            }
          });
        });
 
      });
    </script>
 
  </body>
</html>
 