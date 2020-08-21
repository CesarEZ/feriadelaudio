<style type="text/css">

  .banner-area-init { background-color: black; min-height: 100%; }
  .p-l-100 { padding-left: 100px !important; }
  .banner-content { padding: 100px 0px 0px 0px !important; }

  @media only screen and (max-width: 600px) {
    .banner-content {
      text-align: center !important;
      padding: 40px 0px 0px 0px !important;
    }
  }
</style>

<!-- start banner Area -->
<section class="banner-area-init relative" id="home">  
  <div class="overlay overlay-bg"></div>
  <div class="container">
    <div class="row align-items-center justify-content-center">
      <div class="banner-content text-right col-lg-6">
        <img class="w-80" src="assets/img/logoWhiteLFA.png" alt="La Feria de Audio">
      </div> 
      <div class="banner-content col-lg-6">
        <h1 class="login100-form-title" style="font-size: 20px;padding-left: 100px;text-align: left;margin-bottom: 20px;">Seleccione un país:</h1>
        <ul class="fsize-17 text-white text-left p-l-100" id="list_category">
          <?php for ($i=0; $i < count($countries); $i++) { ?>
            <li><a href="#" class="text-white" id="<?= $countries[$i]['id'] ?>-<?= $countries[$i]['name'] ?>"><img src="<?= base_url('assets/img/flags/'.$countries[$i]['id'].'.png') ?>" alt="<?= $countries[$i]['name'] ?> - LFA"> <?= $countries[$i]['name'] ?></a></li>
            <?php
          } ?>
        </ul>
      </div>                      
    </div>
  </div>

</section>
<!-- End banner Area --> 
<script type="text/javascript">
  $(document).ready(function() {
    $("#list_category > li").on('click', 'a', function () {
     var country = this.id;
     var data = country.split("-");
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
</script>