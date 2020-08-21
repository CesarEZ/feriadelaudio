  <!-- start Subscribe Area -->
  <section class="Subscribe-area section-half">
    <div class="container">
      <div class="row section_padding">
        <div class="col-md-7">
          <p>Únete hoy a la página web que tanto has estado buscando</p>
        </div>
        <div class="col-md-5">
          <?php echo form_open(base_url('home/add_subscriber'), 'class="form-horizontal jsform"');  ?> 
            <div class="subscribe">
              <input class="form-control rounded-left" name="email" placeholder="Tu email aquí" required="" type="email">
              <button style="background:black;" class="btn btn-common rounded-right" name="submit" type="submit">Regístrate</button>
              <!-- message -->
              <?php if ($this->session->flashdata('success_subscriber')): ?>
                <div class="m-b-15">
                    <div class="alert alert-success alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <p>
                            <i class="icon fa fa-check"></i>
                            <?php echo $this->session->flashdata('success_subscriber'); ?>
                        </p>
                    </div>
                </div>
              <?php endif; ?>

            </div>
          <?php echo form_close( ); ?>
        </div>
      </div>
    </div>
  </section>
  <!-- End Subscribe Area --> 

<!-- start footer Area -->
<?php 
$footer =  get_footer_settings();
?>

<footer class="footer-area footer-section">
  <div class="container">
    <div class="row">
      <?php 
        foreach ($footer as $col):
      ?>

      <div class="col-lg-<?= $col['grid_column'] ?>  col-md-<?= $col['grid_column'] ?> col-sm-6">
        <div class="single-footer-widget newsletter">
          <h6><?= $col['title'] ?></h6>
          <?= $col['content'] ?>
        </div>
      </div>

      <?php endforeach; ?>

    </div>
  </div>
</footer>
<!-- End Footer Area -->

<div class="pre-loader hidden" id="pre-loader"></div>

<!-- start Copyright Area -->
<div class="contact-footerbottom">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p>Teléfono: 123 456 7890</p>
            </div>
            <div class="col-md-6">
                <p>Email: info@laferiadeaudio.com</p>
            </div>
        </div>
    </div>
</div>
<div class="redes-footerbottom">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p>Síguenos en nuestras redes:</p>
            </div>
            <div class="col-md-6">
                <div class="bottom_footer_logo text-center">
                  <ul class="list-inline">
                    <li class="list-inline-item"><a target="_blank" href="<?= $this->general_settings['instagram_link']; ?>"><i class="fa fa-instagram fa-2x"></i></a></li>
                    <li class="list-inline-item"><a target="_blank" href="<?= $this->general_settings['facebook_link']; ?>"><i class="fa fa-facebook fa-2x"></i></a></li>
                    <li class="list-inline-item"><a target="_blank" href="<?= $this->general_settings['twitter_link']; ?>"><i class="fa fa-twitter fa-2x"></i></a></li>
                  </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="copyright1">
  <div class="container">
    <div class="row"> 
      <div class="col-md-12">
        <div class="bottom_footer_info">
          <p align="center"><?= $this->general_settings['copyright']?></p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Copyright Area --> 