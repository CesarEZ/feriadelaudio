<script>
  $(document).ready(function() {
    checkLoginState();
  })

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
    } else {
      setCookie("btnCtrlStatusFb", "0", 30);
    }
  }

  function connectToFacebook(accessToken) {

    FB.api('/me', function(response) {

      var facebook_account_id = response.id;

      $.ajax({
        url      : '<?= base_url('auth/login_facebook/account_link/') ?>',
        data     : { facebook_account_id:facebook_account_id, accessToken:accessToken },
        type     : 'POST',
        success  : function(resp) {

          if (resp.trim() == "link_ok_for_"+facebook_account_id) {
            location.reload();
          } else if(resp.trim() == "exists_id_"+facebook_account_id) {
            $("#error_account").removeClass("d-none");
            $(".btn-fb").addClass("d-none");
          }
        }
      })
    });
  }

  function disconnectToFacebook(){
    FB.getLoginStatus(function(response) {
      var facebook_account_id = response.authResponse.userID;
      FB.logout(function(response){ 
        setCookie("btnCtrlStatusFb", "0", 30);

        $.ajax({ 
          url     : "<?= base_url('auth/logout_facebook/') ?>",
          success : function() {

            location.reload();  
          }
        })
      });
    });
  }

  function unlinkFacebook() {
    var confirmUnlink = confirm("¿Está seguro que desea desvincular esta cuenta de Facebook asociada?");
    if (confirmUnlink) {

      setCookie("btnCtrlStatusFb", "0", 30);

      $.ajax({ 
        url     : "<?= base_url('auth/unlink_facebook/') ?>",
        success : function() {

          location.reload();  
        }
      })
    }
  }

  function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }
</script>

<div class="single-slidebar-profile">
  <figure>

    <?php $data_user = get_user($this->session->user_id);
    if ($data_user['facebook_account_id']=="" || $data_user['facebook_account_id']==null) {
      $photo = base_url(get_user_profile_photo($this->session->user_id));
    } else {
      $photo = 'https://graph.facebook.com/'.$data_user['facebook_account_id'].'/picture?type=large';
    }
    ?>
    <a href="javascript:void(0)" class="employer-dashboard-thumb"><img src="<?= $photo ?>" alt=""></a>
    <figcaption>
      <h2><?=  $this->session->userdata('fname').' '.$this->session->userdata('lname') ?></h2>
    </figcaption>
  </figure>
</div> 

<div class="single-slidebar">
  <ul class="cat-list">
    <li><a class="justify-content-between d-flex text_active" href="<?= base_url('profile') ?>"><p><i class="fa fa-user-o pr-2"></i>  Mi perfil</p></a></li>
    <li><a class="justify-content-between d-flex" href="<?= base_url('profile/ads') ?>"><p><i class="fa fa-id-card-o pr-2"></i> Admin anuncios</p></a></li>
    <li><a class="justify-content-between d-flex" href="<?= base_url('profile/favourite') ?>"><p><i class="fa fa-heart-o pr-2"></i>  Anuncios favoritos</p></a></li>
    <li><a class="justify-content-between d-flex" href="<?= base_url('profile/notifications') ?>"><p><i class="fa fa-briefcase pr-2"></i>  Notificationes</p></a></li>
    <li><a class="justify-content-between d-flex" href="<?= base_url('profile/invoices') ?>"><p><i class="fa fa-list pr-2"></i>  Facturas</p></a></li>
    <li><a class="justify-content-between d-flex" href="<?= base_url('inbox') ?>"><p><i class="fa fa-bell-o pr-2"></i>  Mensajes</p></a></li>
    <li><a class="justify-content-between d-flex text-active" href="<?= base_url('profile/change_password') ?>"><p><i class="fa fa-lock pr-2"></i>  Cambiar contraseña</p></a></li>
    <li><a class="justify-content-between d-flex" href="<?= base_url('auth/logout') ?>"><p><i class="fa fa-sign-out pr-2"></i>  Cerrar sesión</p></a></li>
  </ul>
  <hr>
  <i class="fa fa-facebook"></i>&nbsp&nbspCuenta Facebook
  <br>

  <?php 
  $user_id   = $this->session->userdata('user_id');
  $info_user = $this->common_model->get_user_by_id($user_id);
  if ($info_user['facebook_account_id']=="" || $info_user['facebook_account_id']==null) { ?>
    <small>Integre su cuenta con Facebook</small><br>
    
    <div id="error_account" class="d-none"><p style="color: red !important; font-size: 12px !important;">Esta cuenta de Facebook ya se encuentra vinculada con otro usuario, por favor vincule una nueva cuenta.</p><br>
      <a class="btn btn-primary btn-block btn-contact btn-profile-fb w-100" onclick="disconnectToFacebook()" style="text-align: left; padding-left: 6px !important;"><i class="fa fa-facebook i-fb"></i>&nbsp&nbsp&nbsp&nbsp&nbspVincular otra cuenta</a>
    </div>

    <div class="fb-login-button btn-fb" style="text-align: left !important;" data-max-rows="1" data-size="medium" data-width="100%" data-button-type="login_with" data-use-continue-as="false"  data-auto-logout-link="false" data-onlogin="checkLoginState()" data-scope="public_profile,email,user_link"></div><br><br>

  <?php } else { 
    $query = $this->common_model->data_ci_facebook($info_user['facebook_account_id']); 
    ?>
    <br>
    <a href="<?= $query[0]['user_link'] ?>" target="_blank" class="btn btn-primary btn-block btn-contact btn-profile-fb w-100" style="text-align: left; padding-left: 6px !important;"><i class="fa fa-facebook i-fb"></i>&nbsp&nbsp&nbsp&nbsp&nbspVer perfil Facebook</a>
    <?php
    if (isset($_COOKIE['btnCtrlStatusFb'])) { 

     if ($_COOKIE['btnCtrlStatusFb']==0 && $info_user['is_facebook']==1) { ?>

      <div class="fb-login-button btn-fb" data-max-rows="1" data-size="medium" data-width="100%" data-button-type="login_with" data-use-continue-as="false"  data-auto-logout-link="false" data-onlogin="checkLoginState()" data-scope="public_profile,email,user_link"></div><br><br>

    <?php } else if ($_COOKIE['btnCtrlStatusFb']==1 && $info_user['is_facebook']==1) { ?> 

      <a class="btn btn-primary btn-block btn-contact btn-profile-fb w-100" onclick="disconnectToFacebook()" style="text-align: left; padding-left: 6px !important;"><i class="fa fa-facebook i-fb"></i>&nbsp&nbsp&nbsp&nbsp&nbspCerrar sesión Facebook</a>
    <?php } } else { ?>

      <div class="fb-login-button btn-fb" data-max-rows="1" data-size="medium" data-width="100%" data-button-type="login_with" data-use-continue-as="false"  data-auto-logout-link="false" data-onlogin="checkLoginState()" data-scope="public_profile,email,user_link"></div><br><br>

    <?php } ?>

    <a class="btn btn-primary btn-block btn-contact btn-profile-fb w-100" onclick="unlinkFacebook()" style="text-align: left; padding-left: 6px !important;"><i class="fa fa-facebook i-fb"></i>&nbsp&nbsp&nbsp&nbsp&nbspDesvincular Facebook</a>
  <?php } ?>

</div> 