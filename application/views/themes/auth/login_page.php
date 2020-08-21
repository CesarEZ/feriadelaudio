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
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/hamburgers.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/util.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/main.css">
  <!--===============================================================================================-->
  <script>
    window.fbAsyncInit = function() {
      FB.init({
        appId      : '287632632254773',
        cookie     : true,                     
        xfbml      : true,                     
        version    : 'v7.0'           
      });
    };

    (function(d, s, id) {                      
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "https://connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    function checkLoginState() {               
      FB.getLoginStatus(function(response) {   
        statusChangeCallback(response);
      });
    }

    function statusChangeCallback(response) {                  
      if (response.status === 'connected') {  
        setCookie("btnCtrlStatusFb", "1", 30);
        connectToFacebook(response.authResponse.accessToken);  
      }
    }

    function connectToFacebook(accessToken) {

      FB.api('/me', function(response) {

        var facebook_account_id = response.id;

        $.ajax({
          url      : '<?= base_url('auth/login_facebook/login_fb/') ?>',
          data     : { facebook_account_id:facebook_account_id, accessToken:accessToken },
          type     : 'POST',
          success  : function(resp) {
            if (resp.trim() == "connect_ok_for_"+facebook_account_id) {
              location.reload();
            }
          }
        })
      });
    }

    function setCookie(cname, cvalue, exdays) {
      var d = new Date();
      d.setTime(d.getTime() + (exdays*24*60*60*1000));
      var expires = "expires="+ d.toUTCString();
      document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }
  </script>
</head>
<body>

  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100">
        <!-- for messages -->
        <img src="/assets/img/iniciarsesionboton.png">
        <span class="login100-form-title p-b-55">
         <!--  //trans('login') -->
        </span>
        <?php $this->load->view('themes/_messages'); ?>
        
        <?php 
        $attributes = array('method' => 'post','class' => 'login100-form validate-form jsform'); 
        echo form_open('auth/login',$attributes); 
        ?>
        <div class="wrap-input100 validate-input m-b-16" data-validate = "Se requiere correo electrónico válido: ex@abc.xyz">
          <input class="input100" type="text" name="email" placeholder="<?= trans('email') ?>">
          <span class="focus-input100"></span>
          <span class="symbol-input100">
            <span class="lnr lnr-envelope"></span>
          </span>
        </div>
        <div class="wrap-input100 validate-input m-b-16" data-validate = "Se requiere contraseña">
          <input class="input100" type="password" name="password" placeholder="<?= trans('password') ?>">
          <span class="focus-input100"></span>
          <span class="symbol-input100">
            <span class="lnr lnr-lock"></span>
          </span>
        </div>
        <div class="contact100-form-checkbox m-l-4">
          <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
          <label class="label-checkbox100" for="ckb1">
            <?= trans('remember_me') ?>
          </label>
        </div>
        <div class="contact100-form-checkbox m-l-4">
          <a href="<?= base_url('auth/forgot_password') ?>">
            <?= trans('forgot_password') ?>
          </a>
        </div>
        <div class="container-login100-form-btn p-t-25">
          <input type="submit" class="login100-form-btn" value="<?= trans('login') ?>" name="login" />
        </div>
        <div class="text-center w-full pt-30">
          <span class="txt1">
           <?= trans('not_a_member') ?>?
         </span>
         <a class="txt1 bo1 hov1" href="<?= base_url('register') ?>">
          <?= trans('signup_now') ?>
        </a>
      </div>
      <?php echo form_close(); ?><br>
      <div class="fb-login-button btn-fb" data-max-rows="1" data-size="large" data-button-type="login_with" data-use-continue-as="false" data-onlogin="checkLoginState()" data-scope="public_profile,email,user_link"></div>
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
<script>
  //--------------------------------------------------------
// jsform
$(document).on("submit",".jsform", function(event) {
  event.preventDefault();
  $('.pre-loader').removeClass('hidden');
  var $btn = $('input[type=submit]');
  var $txt = $btn.val();
  $btn.prop('disabled',true);
  $btn.val('Por favor espere...');
  $action = $(this).attr( 'action' );
  $method = $(this).attr( 'method' );
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
        swal("Exito!", obj.msg, obj.status);
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
