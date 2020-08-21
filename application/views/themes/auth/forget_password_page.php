<!DOCTYPE html>
<html lang="en">
<head>
  <title><?=isset($title) ? $title. ' - '. $this->general_settings['application_name']: $this->general_settings['application_name']; ?></title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
  <link rel="shortcut icon" href="<?= base_url($this->general_settings['favicon']); ?>">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/bootstrap.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/font-awesome.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/icon-font.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/animate.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/hamburgers.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/util.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/main.css">
<!--===============================================================================================-->
</head>
<body>
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
          <span class="login100-form-title pb-4">
              Recuperar contraseña
          </span>
          <p>Ingrese su correo electrónico y le enviaremos instrucciones sobre cómo restablecer su contraseña</p>
          <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
              <?=$this->session->flashdata('success')?>
            </div>
          <?php endif; ?>
          <?php if($this->session->flashdata('error')): ?>
           <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            <?=$this->session->flashdata('error')?>
          </div>
        <?php endif; ?>
    
          <?php $attributes = array('id' => 'login_form', 'method' => 'post' , 'class' => 'login100-form validate-form');
            echo form_open(base_url('auth/forgot_password'), $attributes);?>
    
            <div class="wrap-input100  mb-3">
              <input class="input100" type="text" name="email" placeholder="Email">
              <span class="focus-input100"></span>
              <span class="symbol-input100">
                <span class="lnr lnr-envelope"></span>
              </span>
            </div>
            <div class="container-login100-form-btn pt-2">
              <input type="submit" class="login100-form-btn" name="submit" value="Recuperar contraseña">
            </div>
          <?php echo form_close(); ?>
    
          <div class="text-center w-full pt-4">
              <span class="txt1">¿Recuerdas tu contraseña?</span>
              <a class="txt1 bo1 hov1" href="<?= base_url(); ?>login">
                Iniciar sesión            
              </a>
          </div>
        </div>
    </div>
</div>

<!--===============================================================================================-->  
  <script src="<?= base_url() ?>assets/js/vendor/jquery-2.2.4.min.js"></script>
<!--===============================================================================================-->
  <script src="<?= base_url() ?>assets/js/vendor/bootstrap.min.js"></script>
<!--===============================================================================================-->

</body>
</html>
