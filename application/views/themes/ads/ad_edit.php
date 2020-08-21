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
          <a href="<?= base_url('profile/ads') ?>">Administrador de anuncios </a> <span class="lnr lnr-arrow-right"></span> <a href=""> <?= $title ?></a>
        </p>
      </div>                      
    </div>
  </div>
</section>
<!-- End banner Area -->  

<!-- Start Add Job Detail Area -->
<section class="error_area section-full">
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="add_job_content col-12">

        <?php $this->load->view('themes/_messages'); ?>

        <?php 
        $attributes = array('method' => 'post','class' => 'jsform'); 
        echo form_open_multipart('seller/ads/edit/'.$post['id'],$attributes); 
        ?>

        <div class="row">
          <div class="col-md-6">
            <div class="headline">
              <h3><i class="fa fa-info"></i> Detalles basicos</h3>
            </div>

            <div class="add_job_detail">

              <div class="row">
                <div class="col-md-12">
                  <div class="submit-field">
                    <h5>Categorias *</h5>
                    
                    <?php

                    $where = array('status' => 1);
                    $rows = get_records_where('ci_categories',$where);
                    $options = array('' => 'Seleccione una opción') + array_column($rows,'name','id');
                    echo form_dropdown('category',$options,$post['category'],'class="select2 form-control category" required');
                    
                    ?>
                  </div>
                </div>
              </div>

              <?php if($post['subcategory']): ?>
                <div class="row">
                  <div class="col-md-12 subcategory-wrapper">
                    <div class="submit-field">
                      <h5>Subcategorias *</h5>
                      <div class="subcategory">
                        <?php

                        $where = array('status' => 1,'parent' => $post['category']);
                        $rows = get_records_where('ci_subcategories',$where);
                        $options = array('' => 'Seleccione una opción') + array_column($rows,'name','id');
                        echo form_dropdown('subcategory',$options,$post['subcategory'],'class="select2 form-control select-subcategory" required');

                        ?>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endif; ?>

              <span class="custom-field-wrapper">
                <?php  
                if(!empty($post['subcategory']))
                  echo $this->fields->subcategory_fields_by_ad_id($post['subcategory'],$post['id']);
                else
                  echo $this->fields->category_fields_by_ad_id($post['category'],$post['id']);
                ?>
              </span>

              <div class="row">
                <div class="col-md-12">
                  <div class="submit-field">
                    <h5>Título *</h5>
                    <input class="form-control" type="text" name="title" placeholder="Título" value="<?= $post['title'] ?>" required>
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
                          <input type="text" class="form-control" name="price" placeholder="Precio" required value="<?= $post['price'] ?>">
                          <div class="input-group-append">
                            <span class="input-group-text">
                              <input type="checkbox" name="negotiable" value="1" <?= ($post['negotiable'] == '1') ? 'checked' : '' ?>> Negotiable
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
                    <input class="form-control" name="tags" type="text" placeholder="e.g. best car, grocery item in LA" value="<?= $post['tags'] ?>">
                    <small class="form-text text-muted">Mínimo 3 letras</small>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="submit-field">
                    <h5>Descripción</h5>
                    <textarea class="form-control" rows="5" name="description"><?= $post['description'] ?></textarea>
                    <small class="form-text text-muted">Mínimo 20 palabras</small>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- photo section -->
          <div class="col-md-6">  
            <div class="headline">
              <h3><i class="fa fa-camera"></i> Fotos</h3>
            </div>

            <div class="add_job_detail col-12">
              <small id="fileHelp" class="form-text text-muted">Imágenes que pueden ser útiles para describir su artículo.</small>
              <small>Min dimensión 360 x 220</small><br/>
              <div class="row">
                <div class="col-md-12">
                  <div class="submit-field"> 
                    <?php $img_1 = ($post['img_1']) ? $post['img_1'] : 'assets/img/default-img.jpg';  ?>
                    <div class="item__img__div">
                      <label  for="item_img_1" id="item_img_label_1" class="thumbnail_label">
                        <img src="<?= base_url($img_1) ?>" id="thumbnail_img_1" class="thumbnail_img" width="150">
                        <input type="file" name="img_1" id="item_img_1" class="hidden images" onchange="readURL('image',this,1)" accept="image/*">
                      </label>
                      <input type="hidden" name="old_img_1" value="<?= $post['img_1'] ?>">
                    </div>

                    <small>Imagen miniatura</small><br>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="submit-field"> 
                    <?php $img_2 = ($post['img_2']) ? $post['img_2'] : 'assets/img/default-img.jpg';  ?>
                    <div class="item__img__div">
                      <label  for="item_img_2" id="item_img_label_1" class="thumbnail_label">
                        <img src="<?= base_url($img_2) ?>" id="thumbnail_img_2" class="thumbnail_img" width="150">
                        <input type="file" name="img_2" id="item_img_2" class="hidden images" onchange="readURL('image',this,2)" accept="image/*">
                      </label>
                      <input type="hidden" name="old_img_2" value="<?= $post['img_2'] ?>">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="submit-field"> 
                    <?php $img_3 = ($post['img_3']) ? $post['img_3'] : 'assets/img/default-img.jpg';  ?>
                    <div class="item__img__div">
                      <label  for="item_img_3" id="item_img_label_1" class="thumbnail_label">
                        <img src="<?= base_url($img_3) ?>" id="thumbnail_img_3" class="thumbnail_img" width="150">
                        <input type="file" name="img_3" id="item_img_3" class="hidden images" onchange="readURL('image',this,3)" accept="image/*">
                      </label>
                      <input type="hidden" name="old_img_3" value="<?= $post['img_3'] ?>">
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
                    <input class="form-control w-100" type="text" name="video_1" value="<?= $post['video_1'] ?>" placeholder="Ingresa el link del video...">
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="submit-field"> 
                  <div class="item__img__div">
                    <h5>Video 2</h5>
                    <input class="form-control w-100" type="text" name="video_2" value="<?= $post['video_2'] ?>" placeholder="Ingresa el link del video...">
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="submit-field"> 
                  <div class="item__img__div">
                    <h5>Video 3</h5>
                    <input class="form-control w-100" type="text" name="video_3" value="<?= $post['video_3'] ?>" placeholder="Ingresa el link del video...">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /row -->



      <!-- Location -->
      <div class="col-md-12">
        <div class="headline">
          <h3><i class="fa fa-map-marker"></i> Ubicación</h3>
          <small id="fileHelp" class="form-text text-muted">Ingrese su ubicación correcta</small>
        </div>

        <div class="row">
          <div class="col-sm-6 col-md-6 order-md-6 add_job_detail">
            <div class="row">
              <div class="col-md-12">
                <div class="submit-field">
                  <h5>País *</h5>
                  <?php 
                  $options = array('' => 'Seleccione un país') + array_column($countries,'name','id');
                  echo form_dropdown('country',$options,$post['country'],'class="select2 form-control country" required');
                  ?>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="submit-field">

                  <h5>Estado *</h5>

                  <?php 
                  $where = array('country_id' => $post['country']);
                  $rows = get_records_where('ci_states',$where);
                  $options = array('' => 'Seleccione un estado') + array_column($rows,'name','id');
                  echo form_dropdown('state',$options,$post['state'],'class="select2 form-control state" required');
                  ?>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="submit-field">
                  <h5>Ciudad *</h5>
                  <?php 
                  $where = array('state_id' => $post['state']);
                  $rows = get_records_where('ci_cities',$where);
                  $options = array('' => 'Seleccione un ciudad') + array_column($rows,'name','id');
                  echo form_dropdown('city',$options,$post['city'],'class="select2 form-control city" required');
                  ?>
                </div>
              </div>
            </div>

            <div class="row address-wrapper">
              <div class="col-md-12">
                <div class="submit-field">
                  <h5>Dirección *</h5>
                  <input type="text" name="address" class="form-control" id="autocomplete" placeholder="Enter Street Address" value="<?= $post['location'] ?>" required>
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



        <!--  -->
        <div class="col-md-12">
          <div class="add_job_btn col-12 mt-5">
            <div class="submit-field">
              <input type="submit" class="job_detail_btn" value="Enviar" name="submit">
            </div>
          </div>
        </div>
      </div>
      <?php echo form_close(); ?>

    </div>
  </div>
</div>  
</section>
<!-- End Add Job Detail Area -->
<script>
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

<!-- GEO Location -->
<script>
  function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: <?= $post['lat'] ?>, lng: <?= $post['lang'] ?>},
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