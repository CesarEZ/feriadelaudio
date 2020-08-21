<!-- start banner Area -->
<section class="relative" id="home">  
  <div class="overlay overlay-bg"></div>
  <div class="container">
    <div class="row align-items-center justify-content-center">
        <div class="col-md-4">
            <img src="/assets/img/logoOrgLFA.png">
        </div>
        <div class="banner-content col-md-8">
            <h1 class="text-white">
              <?= trans('home_welcome') ?>
            </h1> 
        <?php 
        $attributes = array('method' => 'get', 'class' => 'serach-form-area'); 
        echo form_open(base_url('ads'),$attributes);
        ?>
        <div class="row justify-content-center form-wrap no-gutters">
          <div class="col-lg-8 form-cols rounded-left">
            <input type="text" class="form-control rounded-left" name="q" placeholder="<?= trans('home_search') ?>">
          </div>
          <div class="col-lg-3 form-cols">
            <div>
              <?php
              $where = array('status' => 1);
              $rows = get_records_where('ci_categories',$where);
              $options = array('' => trans('all_categories')) + array_column($rows,'name','id');
              echo form_dropdown('category',$options,'','class="form-control"');
              ?>
            </div>                    
          </div>
          <div class="col-lg-1 form-cols rounded-right">
            <button type="submit" class="btn btn-info rounded" >
              <i class="lnr lnr-magnifier text-white"></i>
            </button>
          </div>                
        </div>
        <?php echo form_close(); ?>
        <p class="text-white"> <span><?= trans('search') ?>: </span> <?= trans('home_bottom_line') ?></p>
      </div>                      
    </div>
  </div>
</section>
<!-- End banner Area -->  

<!-- Start feature-cat Area -->
<?php if (isset($categories) && $categories != null): ?>
  <section class="feature-cat-area section-full" id="category">
    <div class="container">
      <div class="row d-flex justify-content-center">
        <div class="menu-content pb-40 col-lg-10">
          <div class="title text-center">
            <h1 class="mb-10"><?= trans('product_categories') ?></h1>
            <hr class="lines">
          </div>
        </div>
      </div>            
      <div class="row">

        <?php foreach($categories as $category): ?>
          <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
            <div class="single-fcat">
              <a href="<?= base_url('category/'.$category['slug']) ?>">
                <img src="<?= base_url($category['picture']) ?>" alt="<?= $category['name'] ?>">
              </a>
              <p><?= $category['name'] ?></p>
            </div>
          </div>

        <?php endforeach; ?>
      </div>
    </div>  
  </section>
<?php endif ?>  
<!-- End feature-cat Area -->



<!--*-*-*-*-*-*-*-*-*-*- BOOTSTRAP CAROUSEL  Featured Start*-*-*-*-*-*-*-*-*-*-->
<?php if (isset($featured) && $featured != null): ?>

  <section class=" section-full bg-gray">
    <div class="container">
      <div class="row d-flex justify-content-center">
        <div class="menu-content pb-40 col-lg-10">
          <div class="title text-center">
            <h1 class="mb-10"><?= trans('featured_ads') ?></h1>
            <hr class="lines">
          </div>
        </div>
      </div>
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

<!-- Start product Area -->
<?php if (isset($ads) && $ads != null): ?>
  <section class="product-area section-full">
    <div class="container">
      <div class="row d-flex justify-content-center">
        <div class="menu-content pb-40 col-lg-10">
          <div class="title text-center">
            <h1 class="mb-10"><?= trans('latest_ads') ?></h1>
            <hr class="lines">
          </div>
        </div>
      </div>
      <div class="row d-flex mb-30">
        <?php foreach($ads as $post):  ?>
          <div class="col-md-4 col-12 gp_products_item">
            <div class="gp_products_inner">
              <?php 
              $label = get_featured_label($post['is_featured']);
              if(!empty($label)):
                ?>
                <!-- <span class="featured_label"><?= get_featured_label($post['is_featured']) ?></span> -->
              <?php endif; ?>
              <div class="gp_products_item_image">
                <a href="<?= base_url('ad/'.$post['slug']) ?>">
                  <img class="img-size-standar" src="<?= base_url($post['img_1']) ?>" alt="<?= $post['title'] ?>" />
                </a>
              </div>
              <div class="gp_products_item_caption">
                <ul class="gp_products_caption_name">
                  <li><a href="<?= base_url('ad/'.$post['slug']) ?>"><?= $post['title'] ?></a></li>
                  <li><small><?= $post['category_name'] ?></small><a href="<?= base_url('ad/'.$post['slug']) ?>" class="pull-right"><small><?= get_currency_symbol($this->general_settings['currency']) ?></small><?= number_format($post['price']) ?></a></li>
                  <?php $favorite = is_favorite($post['id'],$this->session->user_id); ?>
                  <li class="pull-right"><a href="javascript:void(0)" class="btn-favorite"><i class="fa <?= ($favorite) ? 'fa-heart' : 'fa-heart-o' ?> i-favorite" data-post="<?= $post['id'] ?>"></i></a></li>
                </ul>
                <ul class="gp_products_caption_rating mt-2">
                  <?php 
                  $rating = get_post_rating($post['id']);

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
              </div>
            </div>
          </div>  
        <?php endforeach; ?>

        <div class="col-md-2">
          <a href="<?= base_url('ads') ?>" class="btn btn-success btn-block mt-20">Mostrar más</a>
        </div>

      </div>
    </div>  
  </section>
<?php endif ?>
<!-- End products Area -->

<!-- Start callto-action Area -->
<section class="callto-action-area section-half" id="join">
  <div class="container">
    <div class="row">
      <div class="col-md-3 col-sm-6 borderbenef">
        <div class="single-promo">
          <img src="assets/img/news/icon1.png">
          <h3 class="promo-heading">Productos de<br> alta calidad</h3>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 borderbenef">
        <div class="single-promo">
          <img src="assets/img/news/icon2.png">
          <h3 class="promo-heading">Compra tus equipos de manera rápida</h3>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 borderbenef">
        <div class="single-promo">
          <img src="assets/img/news/icon4.png">
          <h3 class="promo-heading">Elige el<br> mejor precio</h3>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="single-promo">
          <!--<span class="promo-icon"><i class="fa fa-money"></i></span>-->
          <img src="assets/img/news/icon5.png">
          <h3 class="promo-heading">Permite que la gente conozca tus servicios como artista</h3>
        </div>
      </div>
    </div>
  </div>  
</section>
<!-- End calto-action Area -->

<!-- Start hot Products Area -->
<?php if (isset($hot) && $hot != null): ?>
  <section class="hot-area section-full bg-gray">
    <div class="container">
      <div class="row d-flex justify-content-center">
        <div class="menu-content pb-40 col-lg-10">
          <div class="title text-center">
            <h1 class="mb-10"><?= trans('hot_items') ?></h1>
            <hr class="lines">
          </div>
        </div>
      </div>
      <div class="row d-flex justify-content-center">
        <div class="col-md-12 col-12">
          <!-- Paradise Slider -->
          <div id="w_shop_105" class="carousel slide w_shop_105_indicators w_shop_105_control_button thumb_scroll_x swipe_x ps_easeOutInCubic" data-ride="carousel" data-pause="hover" data-interval="8000" data-duration="2000">


            <!-- Indicators -->
            <ol class="carousel-indicators">
              <?php $counter = 0; foreach($hot as $hpost): ?>
              <!-- 1st Indicator -->
              <li data-target="#w_shop_105" data-slide-to="<?= $counter ?>" class="<?= ($counter == '0') ? 'active' : '' ?>"></li>

              <?php $counter++; endforeach; ?>
            </ol> <!-- /Indicators -->

            <!-- Wrapper For Slides -->
            <div class="carousel-inner" role="listbox">
              <?php $counter = 1; foreach($hot as $hpost): ?>
              <!-- 1st Slide -->
              <div class="carousel-item <?= ($counter == '1') ? 'active' : '' ?>">
                <!-- Image -->
                <img class="img-size-standar" src="<?= base_url($hpost['img_1']) ?>" alt="<?= $hpost['title'] ?>">
                <!-- Left Box -->
                <div class="w_shop_105_left_box">
                  <span data-animation="animated fadeInLeft"><?= get_currency_symbol($this->general_settings['currency']).number_format($hpost['price']) ?></span>
                  <h1 data-animation="animated fadeInLeft"><?= $hpost['title'] ?></h1>
                  <a href="<?= base_url('ad/'.$hpost['slug']) ?>" data-animation="animated fadeInLeft">visit now</a>
                </div>
                <!-- Right Box -->
                <div class="w_shop_105_right_box">
                  <ul>
                    <li data-animation="animated fadeInRight"><?= $hpost['category_name'] ?> Category</li>
                    <li data-animation="animated fadeInRight"><?= ($hpost['negotiable']) ? 'Final Price' : 'Negotiable' ?> Price</li>
                    <li data-animation="animated fadeInRight"><?= get_state_name($hpost['state']).','.get_country_name($hpost['country']) ?></li>
                    <li data-animation="animated fadeInRight">Listed on <?= date_time($hpost['created_date']) ?></li>
                  </ul>
                </div>
              </div>
              <!-- End of 1st Slide -->

              <?php $counter++; endforeach; ?>

            </div> <!-- End of Wrapper For Slides -->

          </div> <!-- End Paradise Slider -->
        </div>
      </div>
    </div>
  </section>
<?php endif ?>
<!-- End hot Products Area -->


<!-- Start pricing Area -->
<!--   <section class="section-full pricing_plan" id="pricing_plan">
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="menu-content pb-40 col-lg-10">
        <div class="title text-center">
          <h1 class="mb-10 text-white"><?= trans('pricing_plans') ?></h1>
          <hr class="lines">
          <p class="text-white">Quienes están extremadamente enamorados del sistema ecológico.</p>
        </div>
      </div>
    </div>
      <div class="row">
        <?php foreach($packages as $pack): ?>
          <div class="col-md-3 col-sm-6">
              <div class="pricingTable">
                  <div class="pricingTable-header">
                      <h3 class="heading"><?= $pack['title'] ?></h3>
                      <div class="price-value">
                          <small><?= get_currency_symbol($this->general_settings['currency']) ?></small><?= $pack['price'] ?>
                      </div>
                  </div>
                  <div class="pricingContent">
                      <ul>
                          <li><b><?= $pack['no_of_days'] ?></b> días</li>
                          <li><?= $pack['detail'] ?></li>
                      </ul>
                  </div>/  CONTENT BOX
                  <div class="pricingTable-sign-up">
                      <a href="<?= base_url('register') ?>" class="btn btn-block">Regístrese</a>
                  </div>BUTTON BOX
              </div>
          </div>
        <?php  endforeach; ?>
      </div>
  </div>
</section> -->
<!-- End pricing Area -->

<!-- Start download Area -->
<!--   <section class="download-area section-gap" id="app">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 download-left">
        <img class="img-fluid" src="<?= base_url() ?>assets/img/d1.png" alt="">
      </div>
      <div class="col-lg-6 download-right">
        <h1>Download the <br>
        Job Listing App Today!</h1>
        <p class="subs">
          It won’t be a bigger problem to find one video game lover in your neighbor. Since the introduction of Virtual Game, it has been achieving great heights so far as its popularity and technological advancement are concerned.
        </p>
        <div class="d-flex flex-row">
          <div class="buttons">
            <i class="fa fa-apple" aria-hidden="true"></i>
            <div class="desc">
              <a href="#">
                <p>
                  <span>Available</span> <br>
                  on App Store
                </p>
              </a>
            </div>
          </div>
          <div class="buttons">
            <i class="fa fa-android" aria-hidden="true"></i>
            <div class="desc">
              <a href="#">
                <p>
                  <span>Available</span> <br>
                  on Play Store
                </p>
              </a>
            </div>
          </div>                  
        </div>            
      </div>
    </div>
  </div>  
</section> -->
<!-- End download Area -->

<!-- Start testimonial Area -->
<?php if (isset($testimonial) && $testimonial != null): ?>
  <section class="testimonial-area section-full">
    <div class="container">
      <div class="row d-flex justify-content-center">
        <div class="menu-content pb-40 col-lg-10">
          <div class="title text-center">
            <h1 class="mb-10"><?= trans('client_testimonials') ?></h1>
            <hr class="lines">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 shdw pt-4 pb-4">
          <div id="testimonial-slider" class="owl-carousel">
            <?php foreach($testimonials as $row): ?>
              <div class="testimonial">
                <div class="pic">
                  <img src="<?= base_url() ?>assets/img/user.jpg" alt="">
                </div>
                <h3 class="testimonial-title">
                 <?= $row['testimonial_by'] ?><small>,  <?= $row['comp_and_desig'] ?></small>
               </h3>
               <p class="description">
                <?= $row['testimonial'] ?>
              </p>
            </div>
          <?php  endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php endif ?>
  <!-- End testimonial Area -->