<!-- start banner Area -->

<section class="banner-area relative" id="home">  

  <div class="overlay overlay-bg"></div>

  <div class="container">

    <div class="row d-flex align-items-center justify-content-center">

      <div class="about-content col-lg-12">

        <h1 class="text-white">

          <?= $title ?>

        </h1>   

        <p class="text-white"><?= count($ads) ?> Resultados encontrados</p>

      </div>                      

    </div>

  </div>

</section>

<!-- End banner Area -->  



<!-- Start post Area -->

<section class="post-area section-gap">

  <div class="container">

    <!-- top search -->
    <div class="ads-top-search">

      <form action="<?= base_url('ads') ?>" method="get" class="serach-form-area" accept-charset="utf-8">

        <div class="row justify-content-center form-wrap no-gutters">

          <div class="col-lg-8 rounded-left">

            <input type="text" class="form-control rounded-left" name="title" placeholder="¿Qué estás buscando?" value="<?= (isset($_GET['title'])) ? $_GET['title'] : '' ?>">

          </div>

          <div class="col-lg-3">

          <?php
            $selected = (isset($_GET['category'])) ? $_GET['category'] : '';
            $where = array('status' => 1);
            $rows = get_records_where('ci_categories',$where);
            $options = array('' => trans('all_categories')) + array_column($rows,'name','id');
            echo form_dropdown('category',$options,$selected,'class="form-control"');
          ?>

          </div>

          <div class="col-lg-1 rounded-right">

            <button type="submit" class="btn btn-success"> Buscar </button>
          
          </div> 

        </div>

      </form>

    </div>
    <!-- /top search -->


    <div class="row d-flex">

      <div class="col-lg-4 sidebar filter-sidebar" id="default-selects">

        <div class="single-slidebar">

          <h4  class="mb-0">Búsqueda avanzada</h4>

        </div>

        <?php 

          $this->load->view('themes/filters/advance-filters');

        ?>

      </div>



      <div class="col-lg-8 post-list">

        <div class="row d-flex">



          <?php 

            if(count($ads) > 0)

            {

            foreach($ads as $ad):  



              $featured = get_featured_label($ad['is_featured']);



          ?>



          <div class="col-md-6 col-12 gp_products_item mb-20">

            <div class="gp_products_inner">

              <!-- <?php 
              
                if($featured) 
              
                echo '<span class="featured_label">'.$featured.'</span>';
              
              ?> -->



              <div class="gp_products_item_image">

                <a href="<?= base_url('ad/'.$ad['slug']) ?>">

                  <img class="img-size-standar" src="<?= base_url($ad['img_1']) ?>" alt="<?= $ad['title'] ?>" />

                </a>

              </div>

              <div class="gp_products_item_caption">

                <ul class="gp_products_caption_name">

                  <li><a href="<?= base_url('ad/'.$ad['slug']) ?>"><?= $ad['title'] ?></a></li>

                  <li><small><?= $ad['category_name'] ?></small><a href="<?= base_url('ad/'.$ad['slug']) ?>" class="pull-right"><small><?= get_currency_symbol($this->general_settings['currency']); ?></small><?= number_format($ad['price']) ?></a></li>

                </ul>

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



                 <?php $favorite = is_favorite($ad['id'],$this->session->user_id); ?>



                  <li class="pull-right"><a href="javascript:void(0)" class="btn-favorite"><i class="fa <?= ($favorite) ? 'fa-heart' : 'fa-heart-o' ?> i-favorite" data-post="<?= $ad['id'] ?>"></i></a></li>



                </ul>

              </div>

            </div>

          </div>

          

          <?php 

            endforeach;

            }

            else

            {

              echo "<p class='text-center'>No se encontraron resultados</p>";

            }

          ?>           

        </div>

        <!-- pagination -->
          <div class="pull-right">
            <?php echo $this->pagination->create_links(); ?>
          </div>

      </div>



    </div>

  </div>  

</section>

<!-- End post Area