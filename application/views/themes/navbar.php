<!-- #header Start-->
<header id="header" class="StickyHeader">
  <div class="header-top bg-1">
    <div class="container">
      <div class="header-top-menu">
        <div class="row">
          <div class="col-md-7 col-xs-12 col-6">
            <ul>
              <li>
                <select id="lang" class="lang">
                  <?php for ($i=0; $i < count($countries); $i++) { ?>
                    <option value="<?= $countries[$i]['id'] ?>-<?= $countries[$i]['name'] ?>" <?= ($countries[$i]['id']==$_COOKIE['country_user']) ? 'selected' : '' ?>><?= $countries[$i]['name'] ?></option>
                  <?php } ?>
                </select>
              </li>
              <li>
                <a class="btn btn-success" id="publicar-anuncios" href="<?= base_url('seller/ads/add') ?>"><?= trans('post_ad') ?></a>
              </li>
            </ul>
          </div>

          <div class="col-md-5 col-xs-12 col-6">
            <ul class="text-right">
              <?php if(!$this->session->userdata('is_user_login')): ?>
                <li><a class="btn btn-outline-success" id="login" href="<?= base_url('login') ?>"><?= trans('login') ?></a></li>
                <li><a class="btn btn-outline-success" id="register" href="<?= base_url('register') ?>"><?= trans('register') ?></a></li>
              <?php endif; ?>
            </ul>
            <div class="header-top-right">
              <?php if($this->session->userdata('is_user_login')): ?>
                <ul class="account">  
                  <li>
                    <a href="#">
                      <?php $data_user = get_user($this->session->user_id);
                      if ($data_user['facebook_account_id']=="" || $data_user['facebook_account_id']==null) {
                        $photo = base_url(get_user_profile_photo($this->session->user_id));
                      } else {
                        $photo = 'https://graph.facebook.com/'.$data_user['facebook_account_id'].'/picture?type=large';
                      }
                      ?>
                      <img src="<?= $photo ?>" alt="">
                      <?= $this->session->username ?>  <span>
                        <i class="fa fa-angle-down"></i></span>
                      </a>
                      <ul class="profile">
                        <li><a href="<?= base_url('profile') ?>">Mi perfil</a></li>
                        <li><a href="<?= base_url('profile/ads') ?>">Administrar anuncios</a></li>
                        <li><a href="<?= base_url('profile/favourite') ?>">Anuncios favoritos</a></li>
                        <li><a href="<?= base_url('profile/change_password') ?>">Cambiar contraseña</a></li>
                        <li><a href="<?= base_url('profile/notifications') ?>">Notificationes</a></li>
                        <li><a href="<?= base_url('inbox') ?>"><?= trans('messages') ?></a></li>
                        <li><a href="<?= base_url('auth/logout') ?>"><?= trans('logout') ?></a></li>
                      </ul>
                    </li>
                  </ul>

                  <?php 

              // get message notifications
                  $where = array(
                    'receiver_view' => '0',
                    'receiver' => $this->session->userdata('user_id')
                  );

                  $records = get_record('ci_inbox',$where);

                  $messages = (count($records) > 0) ? count($records) : '';

              // get user notifications
                  $where = array(
                    'user_view' => '0',
                    'user_id' => $this->session->userdata('user_id')
                  );

                  $records = get_record('ci_notifications',$where);

                  $notifications = (count($records) > 0) ? count($records) : '';

                  ?>

                  <ul class="account notification_icons">
                    <li>

                      <a href="#"><i class="fa fa-bell-o"></i>
                        <?php if($notifications): ?>

                          <span class="number notification-number"><?= $notifications ?></span>

                        <?php endif; ?>
                      </a>
                      <ul class="profile">
                        <li><a href="<?= base_url('profile/notifications') ?>"><?= ($notifications > 0) ? $notifications : 0  ?> Notificationes nuevas</a></li>
                      </ul>
                    </li>
                    <li>
                      <a href="#"><i class="fa fa-envelope-o"></i>
                        <?php if($messages): ?>
                          <span class="number"><?= $messages ?></span>
                        <?php endif; ?>
                      </a>
                      <ul class="profile">
                        <li><a href="<?= base_url('inbox') ?>"><?= ($messages > 0) ? $messages : 0  ?> Mensajes nuevos</a></li>
                      </ul>
                    </li>
                  </ul>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="header-bottom">
      <div class="container">
        <div class="row align-items-center d-flex">
          <div class="col-lg-3">
            <div id="logo">
              <a href="<?= base_url() ?>"><img class="" src="<?= base_url($this->general_settings['logo']); ?>" alt="<?= $this->general_settings['application_name']; ?>" title="<?= $this->general_settings['application_name']; ?>" /></a>
            </div>
          </div>
          <div class="col-lg-9">        
            <nav id="nav-menu-container">
              <ul class="nav-menu float-right">
                <?php 
                $menu = get_user_menu();
                foreach($menu as $link){
                  ?>
                  <li class="menu-has-children"><a href="<?= base_url($link['link']) ?>"><?= trans(strtolower($link['name'])) ?></a></li>
                <?php } ?>
              </ul>
            </nav><!-- #nav-menu-container -->  
          </div>          
        </div>
      </div>
    </div>
  </header>
  <!-- #header -->

  <script type="text/javascript">

    $(document).ready(function() {
      $("#lang").on('change', function () {
       var country = $("#lang").val();
       var data = country.split("-");

       deleteCookie("country_user");
       deleteCookie("name_country_user");
       setCookie("country_user", data[0], 30);
       setCookie("name_country_user", data[1], 30);
       window.location.href = "<?= base_url(); ?>";
     });
    });

    function setCookie(cname, cvalue, exdays) {
      var d = new Date();
      d.setTime(d.getTime() + (exdays*24*60*60*1000));
      var expires = "expires="+ d.toUTCString();
      document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function deleteCookie(cname) {
      var expiry = new Date();
      expiry.setTime(expiry.getTime() - 3600);
      document.cookie = cname + "=; expires=" + expiry.toGMTString() + "; path=/"
    }
  </script>