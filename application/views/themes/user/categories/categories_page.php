<!-- start banner Area -->
<section class="banner-area relative" id="home">  
  <div class="overlay overlay-bg"></div>
  <div class="container">
    <div class="row d-flex align-items-center justify-content-center">
      <div class="about-content col-lg-12">
        <h1 class="text-white">
          <?= lang('categories') ?>       
        </h1> 
        <p class="text-white link-nav"><a href="<?= base_url() ?>"><?= lang('home') ?> </a>  <span class="lnr lnr-arrow-right"></span>  <a href=""> <?= lang('categories') ?></a></p>
      </div>                      
    </div>
  </div>
</section>
<!-- End banner Area -->  

<!-- Start post Area -->
<section class="post-area section-gap">
  <div class="container">
    <div class="row justify-content-center d-flex">
      <div class="col-lg-12 post-list">
        <div class="row">
          
          <?php foreach($categories as $cat):  ?>
          
          <div class="col-lg-4 col-md-4 col-sm-6  mb-30">
            <div class="single-fcat">
              <a href="<?= base_url('category/'.$cat['slug']) ?>">
                <img src="<?= base_url($cat['picture']) ?>" alt="<?= $cat['name'] ?>" width="80">
              </a>
              <p><?= $cat['name'] ?></p>
            </div>
          </div>
          
          <?php endforeach; ?>        
        
        </div>
      </div>
    </div>
  </div>  
</section>
<!-- End post Area -->    