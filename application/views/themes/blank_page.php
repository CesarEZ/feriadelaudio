<!-- start banner Area -->
<section class="banner-area relative" id="home">  
  <div class="overlay overlay-bg"></div>
  <div class="container">
    <div class="row d-flex align-items-center justify-content-center">
      <div class="about-content col-lg-12">
        <h1 class="text-white">
          <?= $body['title'] ?>        
        </h1> 
        <p class="text-white"><a href="<?= base_url(); ?>">Inicio </a>  <span class="lnr lnr-arrow-right"></span>  <a href=""> <?= $body['title'] ?></a></p>
      </div>                      
    </div>
  </div>
</section>
<!-- End banner Area -->  

<!-- Start contact-page Area -->
<section class="contact-page-area section-gap">
  <div class="container">
    <?= $body['content'] ?>
  </div>  
</section>
<!-- End contact-page Area -->