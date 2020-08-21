<div class="container-fluid">
    <div class="row no-gutter">
        <!-- The image half -->
        <div class="col-md-6 d-none d-md-flex bg-image"></div>


        <!-- The content half -->
        <div class="col-md-6 bg-light">
            <div class="login d-flex align-items-center py-5">

                <!-- Demo content-->
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 col-xl-7 mx-auto">
                            <h3 class="display-4"><?= $this->general_settings['application_name']; ?></h3>
                            <p class="text-muted mb-4">Contraseña olvidada</p>
                            <?php $this->load->view('admin/includes/_messages.php') ?>
                            <?php echo form_open(base_url('admin/auth/forgot_password'), 'class="login-form" '); ?>
                              <div class="form-group mb-3">
                                  <input type="email" name="email" id="name" class="form-control rounded-pill border-0 shadow-sm px-4" placeholder="Dirección de correo electrónico">
                              </div>
                              <input type="submit" name="submit" class="btn btn-primary btn-block text-uppercase mb-2 rounded-pill shadow-sm" value="Enviar"/>
                              <div class="text-center d-flex justify-content-between mt-4">
                                <p> 
                                  <u><a  class="font-italic text-muted" href="<?= base_url('admin/auth/login'); ?>">¿Recuerdas tu contraseña? Registrarse </a>
                                  </u>
                                </p>
                              </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div><!-- End -->

            </div>
        </div><!-- End -->

    </div>
</div>