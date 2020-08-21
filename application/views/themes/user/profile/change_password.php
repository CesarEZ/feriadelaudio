<!-- start banner Area -->
  <section class="banner-area relative" id="home">  
    <div class="overlay overlay-bg"></div>
    <div class="container">
      <div class="row d-flex align-items-center justify-content-center">
        <div class="about-content col-lg-12">
          <h1 class="text-white">
            Perfil del usuario       
          </h1> 
          <p class="text-white link-nav"><a href="<?= base_url() ?>">Inicio </a>  <span class="lnr lnr-arrow-right"></span>  <a href=""> Perfil del usuario</a></p>
        </div>                      
      </div>
    </div>
  </section>
  <!-- End banner Area -->  
  
  <!-- Start post Area -->
  <section class="post-area section-gap">
    <div class="container">
      <div class="row justify-content-center d-flex">
        <div class="col-lg-3 sidebar">
          <!-- sidebar -->

          <?php $this->load->view($user_sidebar) ?>   

        </div>
        <div class="col-lg-9 post-list">
          <div class="profile_job_content col-lg-12">
            <div class="headline">
              <h3> Cambia la contraseña</h3>
            </div>
            <div class="profile_job_detail">

              <?php 
                $attributes = array('method' => 'post','class' => 'jsform'); 
                echo form_open('profile/change_password',$attributes); 
              ?>

              <div class="row">
                
                <div class="col-md-12 col-sm-12">
                  <div class="submit-field">
                    <h5>Contraseña actual *</h5>
                    <input class="form-control" name="current_password" type="password" value="" placeholder="Enter Current Password" required>
                  </div>
                </div>

                <div class="col-md-12 col-sm-12">
                  <div class="submit-field">
                    <h5>Nueva contraseña *</h5>
                    <input class="form-control" name="new_password" type="password" value="" placeholder="New Password" required>
                  </div>
                </div>

                <div class="col-md-12 col-sm-12">
                  <div class="submit-field">
                    <h5>Confirmar contraseña *</h5>
                    <input class="form-control" name="confirm_password" type="password" placeholder="Confirm Password" value="" required>
                  </div>
                </div>

                <div class="add_job_btn col-lg-12 mt-5">
                  <div class="submit-field">
                     <input type="submit" class="job_detail_btn" name="update" value="Actualizar">
                  </div>
                </div>  

              </div>

              <?php echo form_close(); ?>

            </div>
          </div>
        </div>
      </div>
    </div>  
  </section>
  <!-- End post Area -->

  <!-- start Subscribe Area -->
  <section class="Subscribe-area section-half">
      <div class="container">
          <div class="row section_padding">
              <div class="col-lg-6 col-md-6 col-12">
                  <p>¡Únase a nuestros más de 10,000 suscriptores y obtenga acceso a las últimas plantillas, regalos, anuncios y recursos!</p>
              </div>
              <div class="col-lg-6 col-md-6 col-12">
                  <form>
                      <div class="subscribe">
                          <input class="form-control rounded-left" name="email" placeholder="Tu email aquí" required="" type="email">
                          <button class="btn btn-common rounded-right" type="submit">Suscribir</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </section>
  <!-- End Subscribe Area --> 