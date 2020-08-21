<style type="text/css">
 .rating-stars {
  unicode-bidi: bidi-override;
  direction: rtl;
  float:left;
}
.rating-stars input {
  position: absolute;
  left: -999999px;
}
.rating-stars label {
  display:inline-block;
  font-size: 0;
  cursor:pointer;
}
.rating-stars label:before {
  position: relative;
  font: 24px/1 FontAwesome;
  display: block;
  content: "\f005";
  color: #ccc;
}
.rating-stars input:checked+label:before,
.rating-stars input:checked+label ~ label:before {
  color: #ffa900;
}
.rating-stars label:hover:before,
.rating-stars label:hover ~ label:before {
  color: #ffcc00 !important;
}
.textarea-review { border: 1px solid #ccc !important; resize: none; height: 150px; border-radius: 8px; padding: 10px !important; }
.textarea-review:focus { border: 1px solid #ccc !important; }

.rating-comments { padding: 20px !important; border-bottom: 1px solid #eee; }

.form-control { border: 1px solid #ccc !important; border-radius: 8px !important; }

.bg-f5f5f5 { background-color: #f5f5f5 !important; }
.section-full { padding: 0px 0px 100px !important; }
</style>

<!-- start banner Area -->

<section class="banner-area relative">  

  <div class="overlay overlay-bg"></div>

  <div class="container">

    <div class="row d-flex align-items-center justify-content-center">

      <div class="about-content col-lg-12">

        <h1 class="text-white">

          <?= $ad['title'] ?>     

        </h1> 

        <p class="text-white link-nav">Inicio <span class="lnr lnr-arrow-right"></span> <?php $categoryName = $this->ad_model->get_category_by_id($ad['category']); echo $categoryName[0]['name']; ?> <span class="lnr lnr-arrow-right"></span> <?= $ad['title'] ?></p>

      </div>                      

    </div>

  </div>

</section>

<!-- End banner Area -->  



<!-- Start item detail Area -->

<section class="item-detail-area section-gap">

  <div class="container">

    <div class="row">

      <div class="col-lg-9 post-list blog-post-list">

        <div class="single-post">

          <!-- Slider -->

          <div id="slider_05" class="carousel slide thumb_btm_cntr thumb_scroll_x swipe_x ps_ease" data-ride="carousel" data-pause="hover" data-interval="5000" data-duration="1000">



            <!-- Indicators -->

            <ol class="carousel-indicators ps_indicators_thumb ps_indicators_bottom_center">

              <!-- Indicator -->

              <?php 

              $numberFile  = 0;
              $numberImage = 0;
              $numberVideo = 0;

              if (isset($ad['img_1']) && $ad['img_1']!='') { $numberFile = $numberFile + 1; $numberImage = $numberImage + 1; }
              if (isset($ad['img_2']) && $ad['img_2']!='') { $numberFile = $numberFile + 1; $numberImage = $numberImage + 1; }
              if (isset($ad['img_3']) && $ad['img_3']!='') { $numberFile = $numberFile + 1; $numberImage = $numberImage + 1; }
              if (isset($ad['video_1']) && $ad['video_1']!='') { $numberFile = $numberFile + 1; $numberVideo = $numberVideo + 1; }
              if (isset($ad['video_2']) && $ad['video_2']!='') { $numberFile = $numberFile + 1; $numberVideo = $numberVideo + 1; }
              if (isset($ad['video_3']) && $ad['video_3']!='') { $numberFile = $numberFile + 1; $numberVideo = $numberVideo + 1; }

              for($i = 1; $i <= $numberFile; $i++) {

                $number = $i;

                if ($number > $numberVideo) {
                  $number = $number - $numberVideo;
                } 

                if(isset($ad['img_'.$i]) ||isset($ad['video_'.$number])) { ?>

                  <li data-target="#slider_05" data-slide-to="<?= $i ?>" class="<?= ($i == '1') ? 'active' : '' ?>"></li>

                <?php } } ?>

              </ol>



              <!-- Wrapper For Slides -->

              <div class="carousel-inner" role="listbox">

                <!-- First Slide -->




                <?php 

                for($i = 1; $i <= $numberFile; $i++) { 

                  $number = $i;

                  if ($number > $numberVideo) {
                    $number = $number - $numberVideo;
                  }
                  ?>

                  <div class="carousel-item <?= ($i == '1') ? 'active' : '' ?>">

                    <!-- Slide Background -->
                    <?php  if(isset($ad['video_'.$i]) && $ad['video_'.$i]!='') { 

                      $video_exp = explode('=', $ad['video_'.$i]);

                      $link = "https://www.youtube.com/embed/".$video_exp[1];
                      ?> 

                      <iframe style="margin: auto; width: 70%; height: 500px; display: block;" src="<?= $link ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                    <?php } else if(isset($ad['img_'.$number]) && $ad['img_'.$number]!='') {  ?>

                      <img src="<?= base_url($ad['img_'.$number]) ?>" alt="<?= $ad['title'] ?> photo" style="margin: auto; width: 100%; height: 500px; display: block;" />

                    <?php } ?>
                  </div>
                <?php } ?>

                <!-- End of Slide -->

              </div> <!-- End of Wrapper For Slides -->

              <a class="carousel-control-prev" href="#slider_05" role="button" data-slide="prev">
                <i style="font-size: 20px; padding: 10px; background-color: #777777;" class="fa fa-chevron-left"></i>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#slider_05" role="button" data-slide="next">
                <i style="font-size: 20px; padding: 10px; background-color: #777777;" class="fa fa-chevron-right"></i>
                <span class="sr-only">Next</span>
              </a>

            </div> <!-- End Slider -->



            <div class="content-wrap">

              <h2><?= $ad['title'] ?></h2>

              <div class="content-break-wrap">

                <?= ($ad['description']) ? $ad['description'] : 'No hay descripción disponible' ?>

              </div>

              <!-- <p></p> -->



              <?php if($others) { ?>



                <h3>Otros detalles</h3>

                <table class="table text-center">

                  <?php  

                  foreach($others as $row):

                    $field_value = $this->fields->feild_value($row['field_id'],$row['field_value']);

                    ?>



                    <tr>

                      <th><?= $row['fname'] ?></th>

                      <td><?= $field_value ?></td>

                    </tr>



                  <?php endforeach; ?>

                </table>

              <?php } ?>

            </div>
          </div>  
          <div class="single-post">
            <h3>Valoraciones</h3>
            <?php 
            if (isset($all_rating) && $all_rating != "") {
              foreach ($all_rating as $all_rat) { ?>
                <div class="rating-comments">
                  <p style="font-weight: bold !important; font-size: 18px; text-transform: capitalize;"><?php echo htmlspecialchars_decode(html_entity_decode($all_rat->username)); ?></p>
                  <ul class="gp_products_caption_rating">

                    <?php

                    for ($i = 1; $i < 6; $i++):



                      if($all_rat->rating >= $i)



                      {

                        ?>

                        <li><i class="fa fa-star"></i></li>

                        <?php 

                      }

                      else

                      {

                        ?>

                        <li><i class="fa fa-star-o"></i></li>

                        <?php

                      }

                    endfor;

                    ?>

                  </ul>
                  <p><?php echo htmlspecialchars_decode(html_entity_decode($all_rat->comments)); ?></p>
                  <small>
                    <?php

                    date_default_timezone_set('America/Bogota');
                    $date_start     = strtotime($all_rat->ad_date);
                    $date_end       = strtotime(date("Y-m-d H:i:s"));
                    $segundos       = $date_end-$date_start;
                    $minutos        = $segundos/60;
                    $horas          = $segundos/60/60;
                    $days           = $segundos/60/60/60;
                    $last_active    = 0;

                    if ($segundos <= 60) {
                      $last_active = 'Hace '.round($segundos).' segundos';
                    } else if ($segundos > 60 && $segundos < 3600) {
                      $last_active = 'Hace '.round($minutos).' minutos';
                    } else if ($segundos > 3600 && $segundos < 86400) {
                      $last_active = 'Hace '.round($horas).' horas';
                    } else if ($segundos > 86400) {
                      $last_active = 'Hace '.round($days+1).' días';
                    }
                    echo $last_active;
                    ?>
                  </small>
                </div>
              <?php } } else { ?>
                <br><p>No hay comentarios aún.</p>
                <br><p>Sé el primero en opinar sobre "<?php echo $ad['title']; ?>"</p>
              <?php } ?>
            </div>   
            <div class="single-post">

              <h3>Calificar</h3>

              <small>Deja tu calificación <span class="text-danger">*</span></small>
              <?php 

              $ad_id = $ad['id'];

              $attributes = array('method' => 'post'); 
              echo form_open('ads/save_rating/products',$attributes); 
              ?>
              <input type="hidden" id="ad_id" name="ad_id" value="<?= $ad_id ?>">
              <input type="hidden" id="ad_slug" name="ad_slug" value="<?= $ad['slug']; ?>">
              <div class="rating-stars w-100">
                <?php for ($i = 1; $i < 6; $i++) { ?>
                  <input type="radio" id="rating-star<?php echo $i; ?>" name="rating-star" value="<?php echo $i; ?>" title="<?php echo $i; ?> stars">
                  <label for="rating-star<?php echo $i; ?>"><?php echo $i; ?></label>
                <?php } ?>
              </div>
              <?php if(!$this->session->userdata('is_user_login')) { ?>
                <small>Nombre completo <span class="text-danger">*</span></small><br>
                <input class="form-control" type="text" name="name"><br>
              <?php } ?>
              <textarea class="w-100 textarea-review" name="rating-comments" maxlength="500" required></textarea><br>
              <small>Deja tu comentario <span class="text-danger">*</span></small><br><br>
              <button type="submit" class="btn btn-success">Enviar</button>
              <?php echo form_close(); ?>

            </div>                               
          </div>

          <div class="col-lg-3 sidebar">

            <div class="item-widget">

              <h1><?= '<small>'.get_currency_symbol($this->general_settings['currency']).'</small>'.number_format($ad['price']) ?></h1>

              <p class="text-center"><?= (!empty($ad['negotiable'])) ? 'Negociable' : 'Precio Fijo' ?></p>  

            </div>



            <div class="item-info-widget">

              <h1>Información del producto</h1>

              <hr class="line-separator">

              <ul>

                <li><a href="#" class="justify-content-between align-items-center d-flex"><h6>Categoria:</h6> <span><?= $ad['category_name'] ?></span></a></li>



                <?php if($ad['subcategory_name']): ?>

                  <li><a href="#" class="justify-content-between align-items-center d-flex"><h6>Subcategoria:</h6> <span><?= $ad['subcategory_name'] ?></span></a></li>

                <?php endif; ?>



                <li><a href="#" class="justify-content-between align-items-center d-flex"><h6>Fecha de carga:</h6> <span><?= date_time($ad['created_date']) ?></span></a></li>



                <li>

                  <a class="justify-content-between align-items-center d-flex"><h6>Calificación:</h6>

                   <ul class="gp_products_caption_rating">

                    <?php 

                    $rating = get_post_rating($ad['id']);



                    for ($i = 1; $i < 6; $i++):



                      if($rating >= $i)



                      {

                        ?>

                        <li><i class="fa fa-star"></i></li>

                        <?php 

                      }

                      else

                      {

                        ?>

                        <li><i class="fa fa-star-o"></i></li>

                        <?php

                      }

                    endfor;

                    ?>

                  </ul>

                </li>

              </ul>



              <p class="tags primary">



                <?php  

                $tags = explode(',', $ad['tags']);

                foreach($tags as $tag):

                  ?>

                  <a href="#"><?= $tag ?></a>,

                  <?php 

                endforeach;

                ?>

              </p>

            </div>



            <div class="profile-widget">

              <h1>Información del vendedor</h1> 

              <hr class="line-separator">

              <?php $data_user = get_user($ad['seller']);
              if ($data_user['facebook_account_id']=="" || $data_user['facebook_account_id']==null) {
                $photo = base_url(get_user_profile_photo($this->session->user_id));
              } else {
                $photo = 'https://graph.facebook.com/'.$data_user['facebook_account_id'].'/picture?type=large';
              }
              ?>
              <img src="<?= $photo ?>"  alt="profile_widget_img">
              <?php $data['user_info'] = $this->profile_model->get_user_by_id($ad['seller']); ?>
              <h5><?= $data['user_info']['username'] ?></h5>

              <ul class="gp_products_caption_rating text-center">

                <?php 

                $rating = get_post_rating($ad['seller'], 'users');



                for ($i = 1; $i < 6; $i++):



                  if($rating >= $i)



                  {

                    ?>

                    <li><i class="fa fa-star"></i></li>

                    <?php 

                  }

                  else

                  {

                    ?>

                    <li><i class="fa fa-star-o"></i></li>

                    <?php

                  }

                endfor;

                ?>

              </ul>

              <p>Registrado en <?= date('F, Y',strtotime($ad['since'])) ?> </p>

              <br>

              <?php 
              $info_user = $this->common_model->get_user_by_id($ad['seller']);
              if ($info_user['facebook_account_id']!="" && $info_user['facebook_account_id']!=null) { 
                $query = $this->common_model->data_ci_facebook($info_user['facebook_account_id']); 

                ?>
                <a href="<?= $query[0]['user_link'] ?>" target="_blank" class="btn btn-primary btn-block btn-contact btn-profile-fb"><i class="fa fa-facebook"></i>&nbsp&nbspVer perfil en Facebook</a>
              <?php } ?>

              <a href="<?= base_url('ads/show_contact/'.$ad['seller']) ?>" class="btn btn-primary btn-block btn-contact">Mostrar contacto</a>

              <a href="<?= base_url('inbox/'.$ad['id'].'/'.$ad['slug']) ?>" class="btn btn-success btn-block">Enviar mensaje</a>

            </div>



            <!-- Map -->

            <div class="profile-widget h300px">

              <div id="map" class="h100p"></div>

            </div>



          </div>

        </div>

        <!-- row/ -->



        <?php if($similar_ads): ?>



          <h3>Productos similares</h3>

          <div class="row d-flex justify-content-center">

            <div id="adv_gp_products_3_columns_carousel" class="carousel slide gp_products_carousel_wrapper swipe_x ps_easeOutCirc" data-ride="carousel" data-duration="2000" data-interval="5000" data-pause="hover" data-column="<?php if (count($similar_ads)<=3) { echo count($similar_ads); } else { echo 3; } ?>" data-m576="1" data-m768="1" data-m992="<?= count($similar_ads) ?>" data-m1200="<?= count($similar_ads) ?>">

              <!--========= Wrapper for slides =========-->

              <div class="carousel-inner" role="listbox">



                <?php

                $counter = 1;

                foreach ($similar_ads as $ad):

                  ?>

                  <!--========= 1st slide =========-->

                  <div class="carousel-item <?= ($counter == 1) ? 'active' : '' ?>">

                    <div class="row"> <!-- Row -->

                      <div class="col gp_products_item">

                        <div class="gp_products_inner">

                          <div class="gp_products_item_image">

                            <a href="<?= base_url('ad/'.$ad['slug']) ?>">

                              <img class="img-size-standar" src="<?= base_url($ad['img_1']) ?>" alt="" />

                            </a>

                          </div>

                          <div class="gp_products_item_caption">

                            <ul class="gp_products_caption_name">

                              <li><a href="<?= base_url('ad/'.$ad['slug']) ?>"><?= $ad['title'] ?></a></li>

                              <li><small><?= $ad['category_name'] ?></small><a href="<?= base_url('ad/'.$ad['slug']) ?>" class="pull-right"><small><?= get_currency_symbol($this->general_settings['currency']) ?></small><?= number_format($ad['price'],2) ?></a></li>

                              <?php $favorite = is_favorite($ad['id'],$this->session->user_id); ?>
                              <li class="pull-right"><a href="javascript:void(0)" class="btn-favorite"><i class="fa <?= ($favorite) ? 'fa-heart' : 'fa-heart-o' ?> i-favorite" data-post="<?= $ad['id'] ?>"></i></a></li>

                            </ul>
                            <li>
                              <ul class="gp_products_caption_rating mt-2">
                                <?php 
                                $rating = get_post_rating($ad['id']);

                                for ($i = 1; $i < 6; $i++):

                                  if($rating >= $i)

                                  {
                                    ?>
                                    <li><i class="fa fa-star"></i></li>
                                    <?php 
                                  }
                                  else
                                  {
                                    ?>
                                    <li><i class="fa fa-star-o"></i></li>
                                    <?php
                                  }
                                endfor;
                                ?>
                              </ul>
                            </li>

                          </div>

                        </div>

                      </div>

                    </div>

                  </div>



                  <?php 

                  $counter++; 

                endforeach; 

                ?>



              </div>



              <!--======= Navigation Buttons =========-->



              <!--======= Left Button =========-->

              <a class="carousel-control-prev gp_products_carousel_control_left" href="#adv_gp_products_3_columns_carousel" data-slide="prev">

                <span class="fa fa-angle-left gp_products_carousel_control_icons" aria-hidden="true"></span>



              </a>



              <!--======= Right Button =========-->

              <a class="carousel-control-next gp_products_carousel_control_right" href="#adv_gp_products_3_columns_carousel" data-slide="next">

                <span class="fa fa-angle-right gp_products_carousel_control_icons" aria-hidden="true"></span>



              </a>

            </div>

          </div>

          <!-- slider End -->



        <?php endif; ?>

      </div>  

    </section>

    <!--*-*-*-*-*-*-*-*-*-*- BOOTSTRAP CAROUSEL  Featured Start*-*-*-*-*-*-*-*-*-*-->
    <?php if (isset($featured) && $featured != null): ?>
      <section class="section-full bg-f5f5f5">
        <div class="container">

          <h3>También te puede interesar</h3>

          <div class="row d-flex justify-content-center">
            <div id="adv_gp_products_3_columns_carousel" class="carousel slide gp_products_carousel_wrapper swipe_x ps_easeOutCirc" data-ride="carousel" data-duration="2000" data-interval="5000" data-pause="hover" data-column="<?php if (count($featured)<=3) { echo count($featured); } else { echo 3; } ?>" data-m576="1" data-m768="1" data-m992="<?= count($featured) ?>" data-m1200="<?= count($featured) ?>">
              <!--========= Wrapper for slides =========-->
              <div class="carousel-inner" role="listbox">

                <?php $count = 1; foreach($featured as $fpost): ?>

                <!--========= slide =========-->
                <div class="carousel-item <?= ($count == 1) ? 'active': ''?>">
                  <div class="row"> <!-- Row -->
                    <div class="col gp_products_item">
                      <div class="gp_products_inner">
                        <span class="featured_label"><?= get_featured_label($fpost['is_featured']) ?></span>
                        <div class="gp_products_item_image">
                          <a href="<?= base_url('ad/'.$fpost['slug']) ?>">
                            <img class="img-size-standar" src="<?= base_url($fpost['img_1']) ?>" alt="<?= $fpost['title'] ?>" />
                          </a>
                        </div>
                        <div class="gp_products_item_caption">
                          <ul class="gp_products_caption_name">
                            <li><a href="<?= base_url('ad/'.$fpost['slug']) ?>"><?= $fpost['title'] ?></a></li>
                            <li><small><?= $fpost['category_name'] ?></small><a href="<?= base_url('ad/'.$fpost['slug']) ?>" class="pull-right"><small><?= get_currency_symbol($this->general_settings['currency']); ?></small><?= number_format($fpost['price']) ?></a></li>
                            <?php $favorite = is_favorite($fpost['id'],$this->session->user_id); ?>
                            <li class="pull-right"><a href="javascript:void(0)" class="btn-favorite"><i class="fa <?= ($favorite) ? 'fa-heart' : 'fa-heart-o' ?> i-favorite" data-post="<?= $fpost['id'] ?>"></i></a></li>
                          </ul>
                          <li>
                            <ul class="gp_products_caption_rating mt-2">
                              <?php 
                              $rating = get_post_rating($fpost['id']);

                              for ($i = 1; $i < 6; $i++):

                                if($rating >= $i)

                                {
                                  ?>
                                  <li><i class="fa fa-star"></i></li>
                                  <?php 
                                }
                                else
                                {
                                  ?>
                                  <li><i class="fa fa-star-o"></i></li>
                                  <?php
                                }
                              endfor;
                              ?>
                            </ul>
                          </li>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <?php $count++; endforeach; ?>

              </div>

              <!--======= Navigation Buttons =========-->

              <!--======= Left Button =========-->
              <a class="carousel-control-prev gp_products_carousel_control_left" href="#adv_gp_products_3_columns_carousel" data-slide="prev">
                <span class="fa fa-angle-left gp_products_carousel_control_icons" aria-hidden="true"></span>

              </a>

              <!--======= Right Button =========-->
              <a class="carousel-control-next gp_products_carousel_control_right" href="#adv_gp_products_3_columns_carousel" data-slide="next">
                <span class="fa fa-angle-right gp_products_carousel_control_icons" aria-hidden="true"></span>

              </a>

            </div>
          </div>
        </div>
      </section> 
    <?php endif ?>
    <!--*-*-*-*-*-*-*-*-*-*- END BOOTSTRAP CAROUSEL Featured Items *-*-*-*-*-*-*-*-*-*-->

    <!-- End item detail Area -->


    <script src="https://maps.googleapis.com/maps/api/js?key=<?= $this->general_settings['map_api_key'] ?>&libraries=places&callback=initMap" async defer></script>

    <script>
      (function($) {

        $(document).on('click','.btn-contact',function(){

          $this = $(this);

          $this.text($this.data('contact'));

          $this.removeClass('btn-contact');

        });

      })(jQuery);
    </script>



    <script>

      var map;

      function initMap() {



        map = new google.maps.Map(document.getElementById('map'), {

          center: {lat: <?= $ad['lat'] ?>, lng: <?= $ad['lang'] ?>},

          zoom: 10

        });



        var marker = new google.maps.Marker({

          position: {lat: <?= $ad['lat'] ?>, lng: <?= $ad['lang'] ?>},

          map: map

        });

      }

    </script>