<!DOCTYPE html>
<html lang="en">
<head>
 <title><?=isset($title) ? $title. ' - '. $this->general_settings['application_name']: $this->general_settings['application_name'] ; ?></title>
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
 <!--===============================================================================================-->
 <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/hamburgers.min.css">
 <!--===============================================================================================-->
 <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/util.css">
 <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/main.css">
 <!--===============================================================================================-->
</head>
<body>
<div class="limiter">
    <div class="container-login100" id="container-register">
        <div class="col-md-7">
              <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <img src="/assets/img/logo-blackLFA.png" class="centrarblock" width="250">
                    <p class="text-leftregister">La Feria de Audio es una página web donde podrás comprar y vender equipos usados en buen estado y excelente calidad. Además si eres DJ, productor, técnico en audio o prestas servicios de sonido e iluminación puedes mostrarlos en esta plataforma.</p>
                </div>
                <div class="col-md-3"></div>
              </div>
      </div>
        <div class="col-md-5 latblack">
        <div class="wrap-login100" style="display: table;margin: 0 auto;width: 70%;">
        <span class="login100-form-title p-b-55">
          ¡Regístrate aquí!
        </span>
        <?php 
        if($this->session->flashdata('error')){
          echo '<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>';
        }
        ?>
        <?php 
        $attributes = array('method' => 'post','class' => 'login100-form validate-form jsform'); 
        echo form_open('register',$attributes); 
        ?>

        <div class="wrap-input100 validate-input m-b-16" data-validate = "<?= trans('field_required') ?>">
          <input class="input100" type="text" name="username" placeholder="<?= trans('username') ?>">
          <span class="focus-input100"></span>
          <span class="symbol-input100">
            <span class="lnr lnr-user"></span>
          </span>
        </div>
        <div class="wrap-input100 validate-input m-b-16" data-validate = "<?= trans('email_required') ?>: ex@abc.xyz">
          <input class="input100" type="text" name="email" placeholder="<?= trans('email') ?>">
          <span class="focus-input100"></span>
          <span class="symbol-input100">
            <span class="lnr lnr-envelope"></span>
          </span>
        </div>
        <div class="wrap-input100 validate-input m-b-16" data-validate = "<?= trans('contact_required') ?>: 12369855">
          <input class="input100" type="text" name="contact" placeholder="<?= trans('contact') ?>">
          <span class="focus-input100"></span>
          <span class="symbol-input100">
            <span class="lnr lnr-phone"></span>
          </span>
        </div>
        <div class="wrap-input100 validate-input m-b-16" data-validate = "<?= trans('country_required') ?>">
          <?php 
          $options = array('' => 'Seleccionar un país') + array_column($countries,'name','id');
          echo form_dropdown('country',$options,'','class="input100" required');
          ?>
          <span class="focus-input100"></span>
          <span class="symbol-input100">
            <span class="lnr lnr-map"></span>
          </span>
        </div>
        <div class="wrap-input100 validate-input m-b-16" data-validate = "<?= trans('field_required') ?>">
          <input class="input100" type="password" name="password" placeholder="<?= trans('password') ?>">
          <span class="focus-input100"></span>
          <span class="symbol-input100">
            <span class="lnr lnr-lock"></span>
          </span>
        </div>
        <div class="wrap-input100 validate-input m-b-16" data-validate = "<?= trans('field_required') ?>">
          <input class="input100" type="password" name="confirmpassword" placeholder="<?= trans('confirm_password') ?>">
          <span class="focus-input100"></span>
          <span class="symbol-input100">
            <span class="lnr lnr-lock"></span>
          </span>
        </div>
        <?php if($this->recaptcha_status): ?>
          <div class="recaptcha-cnt">
            <?php generate_recaptcha(); ?>
          </div>
        <?php endif; ?>
        <div class="contact100-form-checkbox m-l-4">
          <input class="input-checkbox100" id="ckb1" type="checkbox" name="terms_n_conditions" required>
          <label class="label-checkbox100" for="ckb1">
            <?= lang('terms_conditions_exp') ?> <a href="void:javascript(0)" data-toggle="modal" data-target="#terms_and_conditions_modal"><?= lang('terms_conditions') ?></a>
          </label>
        </div>
        <div class="container-login100-form-btn p-t-25">
          <input type="submit" class="login100-form-btn" value="<?= trans('signup') ?>" name="register" />
        </div>
        <div class="text-center w-full pt-30">
          <span class="txt1">
            <?= trans('already_have_account') ?>
          </span>
          <a class="txt1 bo1 hov1" href="<?= base_url('login') ?>">
            <?= trans('login_now') ?>
          </a>
        </div>
        
        <?php echo form_close(); ?>
      </div>  
      </div>
    </div>
</div>
    <!-- The Modal -->
    <div class="modal" id="terms_and_conditions_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title"><?= lang('terms_conditions') ?></h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                  <?= get_tnc()  ?>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
  
  
  <!--===============================================================================================-->
  <script src="<?= base_url() ?>assets/js/vendor/jquery-2.2.4.min.js"></script>
  <!--===============================================================================================-->
  <script src="<?= base_url() ?>assets/js/vendor/bootstrap.min.js"></script>
  <!--===============================================================================================-->
  <script src="<?= base_url(); ?>assets/js/sweetalert.min.js"></script>
  <!--===============================================================================================-->
  <!-- Custom JS-->
  <script>
    var value = "<?php echo $_COOKIE['country_user']; ?>";
    var text  = "<?php echo $_COOKIE['name_country_user']; ?>"; 
    $(".input100").prepend("<option value='"+value+"' selected>"+text+"</option>").val();
  //--------------------------------------------------------
// jsform
$(document).on("submit",".jsform", function(event) {
  event.preventDefault();
  $('.pre-loader').removeClass('hidden');
  var $btn = $('input[type=submit]');
  var $txt = $btn.val();
  $btn.prop('disabled',true);
  $btn.val('Por favor espere...');
  $action = $(this).attr('action');
  $method = $(this).attr('method');
  $.ajax({
    type: $method,
    url: $action,
    data: new FormData(this),
    processData: false,
    contentType: false,
    dataType: "json",
    success: function(obj) {
      $('.pre-loader').addClass('hidden');
      $btn.prop('disabled',false);
      $btn.val($txt);
      if(obj.status == 'success')
      {
        swal("¡Exito!", obj.msg, obj.status);
        if (obj.redirect){
          window.location = obj.redirect; 
        }
        else{
          location.reload();
        }
      }
      else
      {
        swal(obj.status+"!", obj.msg, obj.status);
      }
    },
  });
}); 
</script>
</body>
</html>