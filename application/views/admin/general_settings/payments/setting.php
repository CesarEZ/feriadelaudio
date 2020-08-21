<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

    <!-- Main content -->

    <section class="content">

        <div class="card card-default color-palette-bo">

            <div class="card-header">

              <div class="d-inline-block">

                  <h3 class="card-title"> <i class="fa fa-plus"></i>

                  Configuraciones de pago </h3>

              </div>

            </div>

            <div class="card-body">   

                <!-- For Messages -->

                <?php $this->load->view('admin/includes/_messages.php') ?>



                <?php echo form_open_multipart(base_url('admin/general_settings/payments')); ?>	

                <!-- Nav tabs -->

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                  <li class="nav-item">

                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#stripe" role="tab" aria-controls="main" aria-selected="true">Configuración de Epayco</a>

                  </li>

                </ul>

                 <!-- Tab panes -->

                <div class="tab-content">

                    <!-- Stripe -->

                    <div role="tabpanel" class="tab-pane active" id="stripe">

                        <div class="row">

                            <div class="col-6">

                                <div class="form-group">

                                    <label class="control-label">Publishable Key</label>

                                    <input type="text" class="form-control" name="publishable_key" placeholder="Ingresar clave de publicación" value="<?php echo html_escape($stripe['publishable_key']); ?>">

                                </div>

                            </div>



                            <div class="col-6">

                                <div class="form-group">

                                    <label class="control-label">Secret Key</label>

                                    <input type="text" class="form-control" name="secret_key" placeholder="Ingresar clave secreta" value="<?php echo html_escape($stripe['secrate_key']); ?>">

                                </div>

                            </div>



                            <div class="col-6">

                                <div class="form-group">

                                    <label class="control-label">Estado</label>

                                    <?= form_dropdown('stripe_status',array('1' => 'Activo', '0' => 'Inactivo'),$stripe['stripe_status'],'class="form-control"') ?>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="box-footer">

                    <input type="submit" name="submit" value="Guardar cambios" class="btn btn-primary pull-right">

                </div>	

                <?php echo form_close(); ?>

            </div>

        </div>

    </section>

</div>



<script>



$("#setting").addClass('active');

$('#myTabs a').on('click',function (e) {

 e.preventDefault()

 $(this).tab('show');

});



</script>