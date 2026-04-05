<!DOCTYPE html>
<html lang="es">
  <head>
    <meta name="description" content="VillaNet Admin">
    <title>VillaNet - Admin</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="<?= base_url('/public/css/main.css'); ?>">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.3.7/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body class="app sidebar-mini">
 
    <header class="app-header">
      <a class="app-header__logo" href="#">Admin</a>
      <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <ul class="app-nav">
        <li class="dropdown">
          <a class="app-nav__item" href="#" data-bs-toggle="dropdown" aria-label="Open Profile Menu">
            <i class="bi bi-person fs-4"></i>
          </a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li><a class="dropdown-item" href="<?= base_url(route_to('loginForm')); ?>"><i class="bi bi-box-arrow-right me-2 fs-5"></i> Cerrar Sesión</a></li>
          </ul>
        </li>
      </ul>
    </header>
 
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user">
        <img class="app-sidebar__user-avatar" src="https://randomuser.me/api/portraits/men/1.jpg" alt="Admin">
        <div>
          <p class="app-sidebar__user-name">Administrador</p>
          <p class="app-sidebar__user-designation">Admin</p>
        </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item active" href="#"><i class="app-menu__icon bi bi-speedometer"></i><span class="app-menu__label">Dashboard</span></a></li>
      </ul>
    </aside>
 
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="bi bi-speedometer"></i> Dashboard</h1>
          <p>Panel de administración</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ul>
      </div>
 
      <!-- Niveles -->
      <div class="row">
        <div class="col-md-4">
          <div class="d-grid">
            <?php
              echo form_button([
                'name' => 'btnLevel', 'id' => 'btnLevel', 'type' => 'button',
                'class' => 'mb-2 btn btn-primary btn-block',
                'content' => '<i class="bi bi-plus fs-5"></i> Add level'
              ]);
            ?>
          </div>
          <div class="tile p-0">
            <h4 class="tile-title folder-head">New Level</h4>
            <div class="tile-body">
              <div class="mb-3 mx-3">
                <?= form_label('Level', 'level', ['class' => 'form-label']); ?>
                <?= form_input(['type' => 'text', 'name' => 'level', 'id' => 'level', 'value' => old('level'), 'placeholder' => 'Insert the new level', 'class' => 'form-control']); ?>
                <small class="form-text text-muted"><p class="text-danger"><?= validation_show_error('level') ?></p></small>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="tile">
            <h4>Lista de niveles</h4>
            <div class="table-responsive mailbox-messages">
              <table id="myTableLevels" class="table table-striped"><tbody></tbody></table>
            </div>
          </div>
        </div>
      </div>
 
      <!-- Inscripciones -->
      <div class="row mt-4">
        <div class="col-md-4">
          <div class="tile p-0">
            <h4 class="tile-title folder-head"><i class="bi bi-person-plus me-2"></i>Nueva Inscripción</h4>
            <div class="tile-body">
              <div class="mb-3 mx-3">
                <label class="form-label">Profesor</label>
                <select id="sel_profesor" class="form-control form-select mb-2">
                  <option value="">-- Selecciona profesor --</option>
                  <?php foreach ($profesores as $p): ?>
                    <option value="<?= $p['pk_user'] ?>"><?= esc($p['person'] . ' ' . $p['first_name'] . ' ' . $p['last_name']) ?></option>
                  <?php endforeach; ?>
                </select>
                <label class="form-label">Alumno</label>
                <select id="sel_alumno" class="form-control form-select mb-2">
                  <option value="">-- Selecciona alumno --</option>
                  <?php foreach ($alumnos as $a): ?>
                    <option value="<?= $a['pk_user'] ?>"><?= esc($a['person'] . ' ' . $a['first_name'] . ' ' . $a['last_name']) ?></option>
                  <?php endforeach; ?>
                </select>
                <label class="form-label">Grupo</label>
                <input type="text" id="inp_group" class="form-control mb-2" placeholder="Ej: ISC-801">
                <label class="form-label">Materia</label>
                <input type="text" id="inp_subject" class="form-control mb-2" placeholder="Ej: Programación Web">
                <div class="d-grid mt-3">
                  <button id="btnInscribir" class="btn btn-success"><i class="bi bi-plus-circle me-1"></i> Inscribir</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="tile">
            <h4 class="tile-title">Lista de Inscripciones</h4>
            <div class="table-responsive">
              <table id="tablaInscripciones" class="table table-striped table-bordered">
                <thead>
                  <tr><th>Profesor</th><th>Alumno</th><th>Grupo</th><th>Materia</th><th>Acción</th></tr>
                </thead>
                <tbody id="bodyInscripciones">
                  <?php foreach ($inscripciones as $i): ?>
                  <tr id="row-enr-<?= $i['pk_enrollment'] ?>">
                    <td><?= esc($i['profesor_nombre'] . ' ' . $i['profesor_first'] . ' ' . $i['profesor_last']) ?></td>
                    <td><?= esc($i['alumno_nombre']  . ' ' . $i['alumno_first']  . ' ' . $i['alumno_last']) ?></td>
                    <td><?= esc($i['group_name']) ?></td>
                    <td><?= esc($i['subject']) ?></td>
                    <td>
                      <button class="btn btn-danger btn-sm btnEliminarEnr" data-pk="<?= $i['pk_enrollment'] ?>">
                        <i class="bi bi-trash"></i>
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
 
      <!-- Usuarios registrados -->
      <div class="row mt-4">
        <div class="col-md-12">
          <div class="tile">
            <h4 class="tile-title"><i class="bi bi-people me-2"></i>Usuarios Registrados</h4>
            <div class="table-responsive">
              <table id="tablaUsuarios" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Matrícula</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Teléfono</th>
                    <th>Rol</th>
                    <th>Telegram ID</th>
                    <th>Estado</th>
                    <th>Registrado</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($usuarios as $u): ?>
                  <tr id="row-usr-<?= $u['pk_user'] ?>">
                    <td><?= esc($u['pk_user']) ?></td>
                    <td><?= esc($u['person']) ?></td>
                    <td><?= esc($u['first_name']) ?></td>
                    <td><?= esc($u['last_name']) ?></td>
                    <td><?= esc($u['fk_phone']) ?></td>
                    <td><span class="badge bg-primary"><?= esc($u['level']) ?></span></td>
                    <td><?= $u['telegram_chat_id'] ? esc($u['telegram_chat_id']) : '<span class="text-muted">—</span>' ?></td>
                    <td>
                      <?php if ($u['locked'] == 0): ?>
                        <span class="badge bg-success">Activo</span>
                      <?php else: ?>
                        <span class="badge bg-danger">Bloqueado</span>
                      <?php endif; ?>
                    </td>
                    <td><?= esc(date('d/m/Y', strtotime($u['created_at']))) ?></td>
                    <td>
                      <button class="btn btn-warning btn-sm btnEditarUsr me-1"
                        data-pk="<?= $u['pk_user'] ?>"
                        data-person="<?= esc($u['person']) ?>"
                        data-first="<?= esc($u['first_name']) ?>"
                        data-last="<?= esc($u['last_name']) ?>"
                        data-level="<?= $u['fk_level'] ?? '' ?>"
                        data-locked="<?= $u['locked'] ?>"
                        data-telegram="<?= esc($u['telegram_chat_id'] ?? '') ?>">
                        <i class="bi bi-pencil"></i>
                      </button>
                      <button class="btn btn-danger btn-sm btnEliminarUsr" data-pk="<?= $u['pk_user'] ?>">
                        <i class="bi bi-trash"></i>
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
 
    </main>
 
    <!-- Modal Editar Usuario -->
    <div class="modal fade" id="modalEditarUsr" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Editar Usuario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="edit_pk_user">
            <div class="mb-2">
              <label class="form-label">Nombre</label>
              <input type="text" id="edit_person" class="form-control">
            </div>
            <div class="mb-2">
              <label class="form-label">Apellido Paterno</label>
              <input type="text" id="edit_first_name" class="form-control">
            </div>
            <div class="mb-2">
              <label class="form-label">Apellido Materno</label>
              <input type="text" id="edit_last_name" class="form-control">
            </div>
            <div class="mb-2">
              <label class="form-label">Rol</label>
              <select id="edit_fk_level" class="form-control form-select">
                <?php foreach ($niveles as $n): ?>
                  <option value="<?= $n['pk_level'] ?>"><?= esc($n['level']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="mb-2">
              <label class="form-label">Telegram Chat ID</label>
              <input type="text" id="edit_telegram" class="form-control" placeholder="Opcional">
            </div>
            <div class="mb-2">
              <label class="form-label">Estado</label>
              <select id="edit_locked" class="form-control form-select">
                <option value="0">Activo</option>
                <option value="1">Bloqueado</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" id="btnGuardarUsr"><i class="bi bi-save me-1"></i> Guardar</button>
          </div>
        </div>
      </div>
    </div>
 
    <script src="<?= base_url('/public/js/jquery-3.7.0.min.js'); ?>"></script>
    <script src="<?= base_url('/public/js/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('/public/js/main.js'); ?>"></script>
    <script src="<?= base_url('/public/js/levels.js'); ?>"></script>
    <script src="https://cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 
    <script>
    $(document).ready(function() {
 
      $('#tablaInscripciones').DataTable({ language: { url: 'https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-MX.json' } });
      $('#tablaUsuarios').DataTable({ language: { url: 'https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-MX.json' } });
 
      // ── Crear inscripción ──────────────────────────────────
      $('#btnInscribir').on('click', function() {
        const profesor = $('#sel_profesor').val();
        const alumno   = $('#sel_alumno').val();
        const grupo    = $('#inp_group').val().trim();
        const materia  = $('#inp_subject').val().trim();
 
        if (!profesor || !alumno || !grupo || !materia) {
          Swal.fire('Error', 'Todos los campos son obligatorios', 'warning'); return;
        }
 
        $.ajax({
          url: '<?= base_url('admin/createEnrollment') ?>',
          method: 'POST',
          data: { fk_teacher_user: profesor, fk_student_user: alumno, group_name: grupo, subject: materia },
          success: function(res) {
            if (res.status === '200') {
              const profNombre  = $('#sel_profesor option:selected').text();
              const alumNombre  = $('#sel_alumno option:selected').text();
              $('#bodyInscripciones').prepend(`<tr id="row-enr-${res.pk_enrollment}">
                <td>${profNombre}</td><td>${alumNombre}</td>
                <td>${grupo.toUpperCase()}</td><td>${materia}</td>
                <td><button class="btn btn-danger btn-sm btnEliminarEnr" data-pk="${res.pk_enrollment}"><i class="bi bi-trash"></i></button></td>
              </tr>`);
              $('#sel_profesor,#sel_alumno').val('');
              $('#inp_group,#inp_subject').val('');
              Swal.fire('Listo', 'Inscripción creada correctamente', 'success');
            } else { Swal.fire('Error', res.message, 'error'); }
          }
        });
      });
 
      // ── Eliminar inscripción ───────────────────────────────
      $(document).on('click', '.btnEliminarEnr', function() {
        const pk = $(this).data('pk');
        Swal.fire({ title: '¿Eliminar inscripción?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Sí, eliminar', cancelButtonText: 'Cancelar' })
        .then(r => { if (r.isConfirmed) {
          $.ajax({ url: '<?= base_url('admin/deleteEnrollment') ?>', method: 'POST', data: { pk_enrollment: pk },
            success: function(res) {
              if (res.status === '200') { $(`#row-enr-${pk}`).remove(); Swal.fire('Eliminado', '', 'success'); }
            }
          });
        }});
      });
 
      // ── Abrir modal editar usuario ─────────────────────────
      $(document).on('click', '.btnEditarUsr', function() {
        $('#edit_pk_user').val($(this).data('pk'));
        $('#edit_person').val($(this).data('person'));
        $('#edit_first_name').val($(this).data('first'));
        $('#edit_last_name').val($(this).data('last'));
        $('#edit_fk_level').val($(this).data('level'));
        $('#edit_locked').val($(this).data('locked'));
        $('#edit_telegram').val($(this).data('telegram'));
        $('#modalEditarUsr').modal('show');
      });
 
      // ── Guardar cambios usuario ────────────────────────────
      $('#btnGuardarUsr').on('click', function() {
        $.ajax({
          url: '<?= base_url('admin/updateUser') ?>',
          method: 'POST',
          data: {
            pk_user:          $('#edit_pk_user').val(),
            person:           $('#edit_person').val(),
            first_name:       $('#edit_first_name').val(),
            last_name:        $('#edit_last_name').val(),
            fk_level:         $('#edit_fk_level').val(),
            locked:           $('#edit_locked').val(),
            telegram_chat_id: $('#edit_telegram').val()
          },
          success: function(res) {
            if (res.status === '200') {
              $('#modalEditarUsr').modal('hide');
              Swal.fire('Guardado', 'Usuario actualizado correctamente', 'success')
              .then(() => location.reload());
            } else { Swal.fire('Error', res.message, 'error'); }
          }
        });
      });
 
      // ── Eliminar usuario ───────────────────────────────────
      $(document).on('click', '.btnEliminarUsr', function() {
        const pk = $(this).data('pk');
        Swal.fire({ title: '¿Eliminar usuario?', text: 'Se eliminarán también sus inscripciones', icon: 'warning', showCancelButton: true, confirmButtonText: 'Sí, eliminar', cancelButtonText: 'Cancelar' })
        .then(r => { if (r.isConfirmed) {
          $.ajax({ url: '<?= base_url('admin/deleteUser') ?>', method: 'POST', data: { pk_user: pk },
            success: function(res) {
              if (res.status === '200') { $(`#row-usr-${pk}`).remove(); Swal.fire('Eliminado', '', 'success'); }
              else { Swal.fire('Error', res.message, 'error'); }
            }
          });
        }});
      });
 
    });
    </script>
 
  </body>
</html>