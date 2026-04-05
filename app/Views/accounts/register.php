<?= $this->extend('layouts/main_layout'); ?>
 
<?= $this->section('content') ?>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <?= $this->include('layouts/logo_layout') ?>
      </div>
      <div class="login-box">
      <?= form_open(base_url(route_to('registerProcess')), ['class'=>'login-form']); ?>
 
        <h3 class="login-head"><i class="bi bi-plus me-2"></i>NUEVA CUENTA</h3>
        
        <!-- Teléfono y Confirmar teléfono -->
        <div class="row">
          <div class="col-md-6 mb-2">
            <?= form_input(['type' => 'text', 'name' => 'phone', 'id' => 'phone', 'value' => old('phone'), 'placeholder' => 'Teléfono (10 dígitos)', 'class' => 'form-control']); ?>
            <small class="form-text text-muted">
              <p class="text-danger"><?= validation_show_error('phone') ?></p>
            </small>
          </div>
          <div class="col-md-6 mb-2">
            <?= form_input(['type' => 'text', 'name' => 'cphone', 'id' => 'cphone', 'value' => old('cphone'), 'placeholder' => 'Confirmar teléfono', 'class' => 'form-control']); ?>
            <small class="form-text text-muted">
              <p class="text-danger"><?= validation_show_error('cphone') ?></p>
            </small>
          </div>
        </div>
 
        <!-- Nombre, Apellido Paterno, Apellido Materno -->
        <div class="row">
          <div class="col-md-4 mb-2">
            <?= form_input(['type' => 'text', 'name' => 'name', 'id' => 'name', 'value' => old('name'), 'placeholder' => 'Nombre', 'class' => 'form-control']); ?>
            <small class="form-text text-muted">
              <p class="text-danger"><?= validation_show_error('name') ?></p>
            </small>
          </div>
          <div class="col-md-4 mb-2">
            <?= form_input(['type' => 'text', 'name' => 'firstName', 'id' => 'firstName', 'value' => old('firstName'), 'placeholder' => 'Apellido Paterno', 'class' => 'form-control']); ?>
            <small class="form-text text-muted">
              <p class="text-danger"><?= validation_show_error('firstName') ?></p>
            </small>
          </div>
          <div class="col-md-4 mb-2">
            <?= form_input(['type' => 'text', 'name' => 'lastName', 'id' => 'lastName', 'value' => old('lastName'), 'placeholder' => 'Apellido Materno', 'class' => 'form-control']); ?>
            <small class="form-text text-muted">
              <p class="text-danger"><?= validation_show_error('lastName') ?></p>
            </small>
          </div>
        </div>
 
        <!-- Rol -->
        <div class="row">
          <div class="col-md-12 mb-2">
            <?= form_dropdown(
              'fk_level',
              [
                ''  => '-- Selecciona un rol --',
                '1' => 'Administrador',
                '2' => 'Profesor',
                '3' => 'Alumno',
              ],
              old('fk_level'),
              ['class' => 'form-control form-select', 'id' => 'fk_level', 'onchange' => 'toggleTelegram(this.value)']
            ); ?>
            <small class="form-text text-muted">
              <p class="text-danger"><?= validation_show_error('fk_level') ?></p>
            </small>
          </div>
        </div>
 
        <!-- Telegram Chat ID — solo visible si es Alumno -->
        <div class="row" id="campoTelegram" style="display:none;">
          <div class="col-md-12 mb-2">
            <?= form_input(['type' => 'text', 'name' => 'telegram_chat_id', 'id' => 'telegram_chat_id', 'value' => old('telegram_chat_id'), 'placeholder' => 'Telegram Chat ID', 'class' => 'form-control']); ?>
            <small class="form-text text-muted">
              Escríbele a <strong>@userinfobot</strong> en Telegram para obtener tu ID
            </small>
            <small class="form-text text-muted">
              <p class="text-danger"><?= validation_show_error('telegram_chat_id') ?></p>
            </small>
          </div>
        </div>
 
        <!-- Contraseña -->
        <div class="row">
          <div class="col-md-12 mb-2">
            <?= form_input(['type' => 'password', 'name' => 'password', 'id' => 'password', 'placeholder' => 'Contraseña', 'class' => 'form-control']); ?>
            <small class="form-text text-muted">
              <p class="text-danger"><?= validation_show_error('password') ?></p>
            </small>
          </div>
        </div>
 
        <!-- Links -->
        <div class="mb-3">
          <div class="utility">
            <div class="form-check">
              <label class="form-check-label">
                <a href="<?= base_url(route_to('loginForm')); ?>">¿Ya tienes cuenta? Login</a>
              </label>
            </div>
          </div>
        </div>
 
        <!-- Botón -->
        <div class="mb-3 btn-container d-grid">
          <?php 
            $data = 
            [
                'name'    => 'btnRegister',
                'id'      => 'btnRegister',
                'type'    => 'submit',
                'class'   => 'btn btn-primary btn-block',
                'content' => '<i class="bi bi-plus me-2 fs-5"></i> CREAR CUENTA'
            ];
            echo form_button($data);
          ?>
        </div>
 
      <?= form_close(); ?> 
      </div>
    </section>
 
    <script>
      // Mostrar campo Telegram solo cuando el rol seleccionado es Alumno (3)
      function toggleTelegram(value) {
        const campo = document.getElementById('campoTelegram');
        campo.style.display = value === '3' ? 'block' : 'none';
      }
 
      // Si al recargar la página por error de validación el rol era Alumno, mostrar el campo
      document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('fk_level');
        if (select.value === '3') {
          document.getElementById('campoTelegram').style.display = 'block';
        }
      });
    </script>
 
<?= $this->endSection() ?>
 