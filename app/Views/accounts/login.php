<?= $this->extend('layouts/main_layout'); ?>

<?= $this->section('content') ?>

    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <?= $this->include('layouts/logo_layout') ?>
      </div>
      
      <div class="login-box" style="height: 450px; width: 400px;">
        <?= form_open(base_url(route_to('loginProcess')), ['class'=>'login-form']); ?>

          <h3 class="login-head"><i class="bi bi-person me-2"></i>SIGN IN</h3>
          <div class="mb-3">
            <?= form_label('Phone', 'phone', ['class' => 'form-label']); ?>
            <?= form_input(['type' => 'text', 'name' => 'phone', 'id'=>'phone', 'value'=>old('phone'), 'placeholder'=>'Insert your number phone', 'class' => 'form-control']); ?>
            <small id="phoneHelp" class="form-text text-muted"><p class="text-danger"><?= validation_show_error('phone') ?></p></small> 										
          </div>
          <div class="mb-3">
            <?= form_label('Password', 'password', ['class' => 'form-label']); ?>
            <?= form_input(['type' => 'password', 'name' => 'password','id'=>'password', 'placeholder'=>'Insert your password', 'class' => 'form-control']); ?>
            <small id="passwordHelp" class="form-text text-muted"><p class="text-danger"><?= validation_show_error('password') ?></p></small> 										         
          </div>
          <div class="mb-3">
            <div class="utility">
            <div class="form-check">
              <label class="form-check-label">
                  <a href="<?= base_url(route_to('registerForm')); ?>">Register ?</a>
                  <a href="<?= base_url(route_to('forgetForm')); ?>">Forgot Password ?</a>
              </label>
            </div>
          </div>
          <hr>
          <div class="mb-3 btn-container d-grid">
          <?php 
            $data = 
            [
                'name'    => 'btnLogin',
                'id'      => 'btnLogin',
                'type'    => 'submit',
                'class'   => 'btn btn-primary btn-block',
                'content' => '<i class="bi bi-box-arrow-in-right me-2 fs-5"></i> SIGN IN'
            ];
            echo form_button($data);
          ?>
          </div>
        <?= form_close(); ?> 
        <!--<form class="forget-form" action="index.html">
          <h3 class="login-head"><i class="bi bi-person-lock me-2"></i>Forgot Password ?</h3>
          <div class="mb-3">
            <label class="form-label">EMAIL</label>
            <input class="form-control" type="text" placeholder="Email">
          </div>
          <div class="mb-3 btn-container d-grid">
            <button class="btn btn-primary btn-block"><i class="bi bi-unlock me-2 fs-5"></i>RESET</button>
          </div>
          <div class="mb-3 mt-3">
            <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="bi bi-chevron-left me-1"></i> Back to Login</a></p>
          </div>
        </form> -->
      </div>
    </section>
    
<?= $this->endSection() ?>