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
                            <p class="text-muted mb-4">Crear una nueva cuenta</p>
                            <?php $this->load->view('admin/includes/_messages.php') ?>
                            <?php echo form_open(base_url('admin/auth/login'), 'class="login-form" '); ?>
                              <div class="form-group mb-3">
                                  <input type="text" name="username" id="name" value="<?= old("username"); ?>" class="form-control rounded-pill border-0 shadow-sm px-4 text-primary" placeholder="Usuario" >
                              </div>
                              <div class="form-group mb-3">
                                <input type="text" name="firstname" id="firstname" value="<?= old("firstname"); ?>" class="form-control rounded-pill border-0 shadow-sm px-4 text-primary" placeholder="Nombres" >
                              </div>
                              <div class="form-group mb-3">
                                <input type="text" name="lastname" id="lastname" value="<?= old("lastname"); ?>" class="form-control rounded-pill border-0 shadow-sm px-4 text-primary" placeholder="Apellidos" >
                              </div>
                              <div class="form-group mb-3">
                                <input type="text" name="email" id="email" value="<?= old("email"); ?>" class="form-control rounded-pill border-0 shadow-sm px-4 text-primary" placeholder="Email" >
                              </div>
                              <div class="form-group mb-3">
                                <input type="password" name="password" id="password" class="form-control rounded-pill border-0 shadow-sm px-4 text-primary" placeholder="Contraseña" >
                              </div>
                              <div class="form-group mb-3">
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control rounded-pill border-0 shadow-sm px-4 text-primary" placeholder="Confirmar contraseña" >
                              </div>
                              <div class="custom-control custom-checkbox mb-3">
                                  <input id="customCheck1" type="checkbox" checked class="custom-control-input">
                                  <label for="customCheck1" class="custom-control-label">Acepto los <a href="#">términos</a></label>
                              </div>
                              <input type="submit" name="submit" class="btn btn-primary btn-block text-uppercase mb-2 rounded-pill shadow-sm" value="Registrarme"/>
                              <div class="text-center d-flex justify-content-between mt-4">
                                <p> 
                                  <u><a  class="font-italic text-muted" href="<?= base_url('admin/auth/login'); ?>" class="text-center">Ya tengo una cuenta</a>
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