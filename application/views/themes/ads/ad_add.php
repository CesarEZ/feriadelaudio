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
          data    : { facebook_account_id:facebook_account_id },
          type    : "POST",
          success : function() {

            location.reload();  
          }
        })
      });
    });
  }

  function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }
</script>

<!-- start banner Area -->
<section class="banner-area relative" id="home">  
  <div class="overlay overlay-bg"></div>
  <div class="container">
    <div class="row d-flex align-items-center justify-content-center">
      <div class="about-content col-lg-12">
        <h1 class="text-white">
          <?= $title ?>    
        </h1> 
        <p class="text-white link-nav">
          <a href="<?= base_url() ?>">Administrador de anuncios </a> <span class="lnr lnr-arrow-right"></span> <a href=""> <?= $title ?></a>
        </p>
      </div>                      
    </div>
  </div>
</section>
<!-- End banner Area -->  
<!-- Start Add Job Detail Area -->
<section class="error_area section-full">
  <div class="container add_job_content">
    <?php $this->load->view('themes/_messages'); ?>
    <?php 
    $attributes = array('method' => 'post','class' => 'jsform'); 
    echo form_open_multipart('seller/ads/add',$attributes); 
    ?>
    <div class="row">
      <div class="col-md-6">         
        <div class="headline">
          <h3><i class="fa fa-info"></i> Detalles basicos</h3>
        </div>
        <div class="add_job_detail">
          <div class="row">
            <div class="col-md-12">
              <div class="submit-field"><br>
                <h5>Perfil en Facebook *</h5>
                <?php 
                $user_id   = $this->session->userdata('user_id');
                $info_user = $this->common_model->get_user_by_id($user_id);
                if ($info_user['facebook_account_id']=="" || $info_user['facebook_account_id']==null) { ?>
                  <small>Debe integrar su cuenta con Facebook</small><br>

                  <div id="error_account" class="d-none"><p style="color: red !important; font-size: 12px !important;">Esta cuenta de Facebook ya se encuentra vinculada con otro usuario, por favor vincule una nueva cuenta.</p><br>
                    
                    <a class="btn btn-primary btn-block btn-contact btn-profile-fb btn-w-60" onclick="disconnectToFacebook()"><i class="fa fa-facebook"></i>&nbsp&nbsp&nbsp&nbsp&nbspVincular otra cuenta</a>
                  </div>
                  <div class="fb-login-button btn-fb" style="text-align: left !important;" data-max-rows="1" data-size="large" data-button-type="login_with" data-use-continue-as="true" data-onlogin="checkLoginState()" data-scope="public_profile,email,user_link"></div><br><br>

                <?php } else { ?>
                  <small>Cuenta verificada con Facebook</small><br><br>
                  <a class="btn btn-primary btn-block btn-contact btn-profile-fb btn-w-60"><i class="fa fa-facebook"></i>&nbsp&nbspConectado con Facebook</a>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="submit-field">
                <h5>Categoria *</h5>

                <?php

                $where = array('status' => 1);
                $rows = get_records_where('ci_categories',$where);
                $options = array('' => 'Selecciona una opción') + array_column($rows,'name','id');
                echo form_dropdown('category',$options,'','class="select2 form-control category" ');

                ?>

              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 subcategory-wrapper hidden">
              <div class="submit-field">
                <h5>Subcategoria *</h5>
                <div class="subcategory"></div>
              </div>
            </div>
          </div>

          <span class="custom-field-wrapper hidden"></span>

          <div class="row">
            <div class="col-md-12">
              <div class="submit-field">
                <h5>Título *</h5>
                <input class="form-control" type="text" name="title" placeholder="Título" >
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="submit-field">
                <h5>Precio *</h5>
                <div class="row">
                  <div class="col-md-12">
                    <div class="input-group">
                      <div class="input-group-append">
                        <span class="input-group-text"><?= get_currency_symbol($this->general_settings['currency']) ?></span>
                      </div>
                      <input type="text" class="form-control" name="price" placeholder="Precio" >
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <input type="checkbox" name="negotiable" value="1"> Negociable
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="submit-field">
                <h5>Tags <small>(opcional)</small></h5>
                <input class="form-control" name="tags" type="text" placeholder="ej. guitarra, mezclador de dj">
                <small class="form-text text-muted">Mínimo 3 letras</small>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="submit-field">
                <h5>Descripción</h5>
                <textarea class="form-control" rows="5" name="description"></textarea>
                <small class="form-text text-muted">Mínimo 20 palabras</small>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Photo Section -->
      <div class="col-md-6">  
        <div class="headline">
          <h3><i class="fa fa-camera"></i> Fotos</h3>
        </div>

        <div class="add_job_detail col-12">
         <small id="fileHelp" class="form-text text-muted">Imágenes que pueden ser útiles para describir su artículo.</small>
         <small>Min dimensión 360 x 220</small><br/>
         <small>Peso máximo por imagen 2MB</small><br/>
         <div class="row">
          <div class="col-md-12">
            <div class="submit-field"> 
              <div class="item__img__div">
                <label  for="item_img_1" id="item_img_label_1" class="thumbnail_label">
                  <img src="<?= base_url('assets/img/default-img.jpg') ?>" id="thumbnail_img_1" class="thumbnail_img img-fluid" width="150">
                  <input type="file" name="img_1" id="item_img_1" class="hidden images" onchange="readURL('image',this,1)" accept="image/*">
                </label>
              </div>
              <small>Imagen miniatura</small><br>
            </div>
          </div>

          <div class="col-md-6">
            <div class="submit-field"> 
              <div class="item__img__div">
                <label  for="item_img_2" id="item_img_label_1" class="thumbnail_label">
                  <img src="<?= base_url('assets/img/default-img.jpg') ?>" id="thumbnail_img_2" class="thumbnail_img" width="150">
                  <input type="file" name="img_2" id="item_img_2" class="hidden images" onchange="readURL('image',this,2)" accept="image/*">
                </label>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="submit-field"> 
              <div class="item__img__div">
                <label  for="item_img_3" id="item_img_label_1" class="thumbnail_label">
                  <img src="<?= base_url('assets/img/default-img.jpg') ?>" id="thumbnail_img_3" class="thumbnail_img" width="150">
                  <input type="file" name="img_3" id="item_img_3" class="hidden images" onchange="readURL('image',this,3)" accept="image/*">
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="headline">
        <h3><i class="fa fa-camera"></i> Videos</h3>
      </div>
      <div class="add_job_detail col-12">
       <small id="fileHelp" class="form-text text-muted">Videos que pueden ser útiles para describir su artículo.</small><br>
       <div class="row">
        <div class="col-md-12">
          <div class="submit-field"> 
            <div class="item__img__div">
              <h5>Video 1</h5>
              <input class="form-control w-100" type="text" name="video_1" placeholder="Ingresa el link del video...">
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="submit-field"> 
            <div class="item__img__div">
              <h5>Video 2</h5>
              <input class="form-control w-100" type="text" name="video_2" placeholder="Ingresa el link del video...">
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="submit-field"> 
            <div class="item__img__div">
              <h5>Video 3</h5>
              <input class="form-control w-100" type="text" name="video_3" placeholder="Ingresa el link del video...">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Location -->
  <div class="col-md-12">  
    <div class="headline">
      <h3><i class="fa fa-map-marker"></i> Ubicación</h3>
      <small id="fileHelp" class="form-text text-muted">Ingrese su ubicación correcta</small>
    </div>

    <div class="row">
      <div class="col-sm-6 col-md-6 add_job_detail">
        <div class="row">
          <div class="col-md-12 hidden">
            <div class="submit-field">
              <h5>País *</h5>
              <select class="form-control country" name="country">
                <option value="<?= $_COOKIE['country_user']?>" selected><?= $_COOKIE['name_country_user']?></option>
                <option value="">Seleccione un país</option>
                <?php foreach($countries as $country):?>
                  <option value="<?= $country['id']?>"><?= $country['name']?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="col-md-12">
            <div class="submit-field">
              <h5>Estado *</h5>
              <select class="form-control state" name="state" >
               <option value="">Seleccione un estado</option>
             </select>
           </div>
         </div>

         <div class="col-md-12">
          <div class="submit-field">
            <h5>Ciudad *</h5>
            <select class="form-control city" name="city" >
              <option value="">Selecccione un ciudad</option>
            </select>
          </div>
        </div>

        <div class="col-md-12">
          <div class="submit-field">
            <h5>Dirección *</h5>
            <input type="text" name="address" class="form-control address" id="autocomplete" placeholder="Ingrese su dirección">
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-md-6 order-md-6 pt-5">
      <div id="map" class="h100p-w95p"></div>
      <input type="hidden" name="address-lang" id="address-lang" class="address-lang" value="">
      <input type="hidden" name="address-lat" id="address-lat" class="address-lat" value="">
    </div>
  </div>
</div>

<?php           
$payment = $this->setting_model->get_stripe_settings();
$statusPayment = $payment['stripe_status'];

if ($statusPayment == "1") { ?>
  <div class="col-md-12">
    <div class="headline">
      <h3><i class="fa fa-dollar"></i> Precio de anuncios</h3>
      <small id="fileHelp" class="form-text text-muted">Use anuncios destacados para llegar a más clientes.</small>
    </div>

    <div class="add_job_detail col-12">
      <h5>Paquetes *</h5>
      <br>
      <?php foreach($packages as $pack): ?>
        <div class="row">
          <div class="col-md-6 col-sm-6">
            <div class="submit-field">
              <label class="form-label" style="font-weight: bold">
                <input type="radio" class="form package-radio" name="package" value="<?= $pack['id'] ?>" data-price="<?= $pack['price'] ?>">
                <?= $pack['title'] ?>
              </label>
            </div>
          </div>
          <div class="col-md-6 col-sm-6">
            <div class="submit-field">
              <span style="font-weight: bold"><?php $price = (!$pack['price']) ? 'Free' : get_currency_symbol($this->general_settings['currency']).number_format($pack['price'],0,",","."); ?>
              <?= $price ?> por <?= $pack['no_of_days'] ?> días</span><br>
              <?= $pack['detail'] ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>  
<?php } ?>
<div class="col-md-12">
  <div class="add_job_btn col-12 mt-5">
    <div class="submit-field">
      <input type="hidden" name="verify_link_fb_user" value="<?= $info_user['facebook_account_id'] ?>" readonly>
      <input type="submit" class="job_detail_btn" value="Enviar" name="submit">
    </div>
  </div>
</div>
</div>
<?php echo form_close(); ?>
</div>
</section>

<!-- End Add Job Detail Area -->
<script>

  $(document).ready(function() {

    var value = "<?php echo $_COOKIE['country_user']; ?>";
    var text  = "<?php echo $_COOKIE['name_country_user']; ?>"; 


    var data =  {
      country : value,
    }
    data[csfr_token_name] = csfr_token_value;
    $.ajax({
      type: "POST",
      url: "<?= base_url('auth/get_country_states') ?>",
      data: data,
      dataType: "json",
      success: function(obj) {
        $('.state').html(obj.msg);
        $('.pre-loader').addClass('hidden');
      },
    });

    $(document).on('click','.package-radio',function(){
      price = $(this).data('price');
      if (parseInt(price) > 0) 
        $('.payment-method-wrapper').removeClass('hidden');
      else
        $('.payment-method-wrapper').addClass('hidden');
    });
  });

  function readURL(obj,input,i) {

    if (input.files && input.files[0]) {

      var reader = new FileReader();

      reader.onload = function(e) {

        if (obj == 'image') {

          $('#thumbnail_img_'+i).attr('src', e.target.result);
          $('#item_img_label_'+i).after('<i class="cross-cons-img ficon ft-trash"></i>');

        } else if (obj == 'video') {

          var fileContent = e.target.result;
          $('#response_video_'+i).html('<video style="margin: 20px 0px; width: 100%; height: 200px;" src="' + fileContent + '" controls></video>');
        }
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=<?= $this->general_settings['map_api_key'] ?>&libraries=places&callback=initMap" async defer></script>

<script>

  // GEO Location //
  function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: -33.8688, lng: 151.2195},
      zoom: 13
    });
    var options = {
    };
    var card = document.getElementById('pac-card');
    var input = document.getElementById('autocomplete');
    var types = document.getElementById('type-selector');
    var strictBounds = document.getElementById('strict-bounds-selector');

    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

    var autocomplete = new google.maps.places.Autocomplete(input,options);

    // Bind the map's bounds (viewport) property to the autocomplete object,
    // so that the autocomplete requests use the current map bounds for the
    // bounds option in the request.
    autocomplete.bindTo('bounds', map);

    // Set the data fields to return when the user selects a place.
    autocomplete.setFields(
      ['address_components', 'geometry', 'icon', 'name']);

    var infowindow = new google.maps.InfoWindow();
    var infowindowContent = document.getElementById('infowindow-content');
    infowindow.setContent(infowindowContent);
    var marker = new google.maps.Marker({
      map: map,
      anchorPoint: new google.maps.Point(0, -29)
    });

    autocomplete.addListener('place_changed', function() {
      infowindow.close();
      marker.setVisible(false);
      var place = autocomplete.getPlace();
      if (!place.geometry) {
        // User entered the name of a Place that was not suggested and
        // pressed the Enter key, or the Place Details request failed.
        swal("Error","No such address available for input: '" + place.name + "'",'error');
        $('.address').val('');
        $('.address-lang').val('');
        $('.address-lat').val('');
        return false;
      }

      // If the place has a geometry, then present it on a map.
      if (place.geometry.viewport) {
        map.fitBounds(place.geometry.viewport);
      } else {
        map.setCenter(place.geometry.location);
        map.setZoom(17);  // Why 17? Because it looks good.
      }
      marker.setPosition(place.geometry.location);
      marker.setVisible(true);

      var address = '';
      if (place.address_components) {
        address = [
        (place.address_components[0] && place.address_components[0].short_name || ''),
        (place.address_components[1] && place.address_components[1].short_name || ''),
        (place.address_components[2] && place.address_components[2].short_name || '')
        ].join(' ');
      }

      document.getElementById('address-lat').value = place.geometry.location.lat();
      document.getElementById('address-lang').value = place.geometry.location.lng();
      infowindow.open(map, marker);
    });
  }
</script>