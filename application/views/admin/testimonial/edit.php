<!-- bootstrap wysihtml5 - text editor -->

<link rel="stylesheet" href="<?= base_url() ?>assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">



<section class="content-wrapper">

  <section class="content">

    <!-- For Messages -->

    <?php $this->load->view('admin/includes/_messages.php') ?>

    <div class="card card-default">

      <div class="card-header">

        <div class="d-inline-block">

            <h3 class="card-title"> <i class="fa fa-list"></i>

            &nbsp; Editar testimonio </h3>

        </div>

        <div class="d-inline-block float-right">

          <a href="<?= base_url('admin/testimonial'); ?>" class="btn btn-success"><i class="fa fa-list"></i> Lista de testimonios</a>

        </div>

      </div>

      <div class="card-body">

        <div class="row">

          <div class="col-md-12">

            <!-- form start -->

            <?php echo validation_errors(); ?>           

            <?php echo form_open_multipart(base_url('admin/testimonial/edit/'.$testimonial['id']), 'class="form-horizontal"');  ?> 

              <div class="form-group">

                <label for="name" class="col-sm-3 control-label">Testimonio de</label>

                <div class="col-sm-12">

                  <input type="text" name="testimonial_by" class="form-control" value="<?= $testimonial['testimonial_by'] ?>" placeholder="Testimonio de">

                </div>

              </div>

              <div class="form-group">

                <label for="name" class="col-sm-3 control-label">Testimonio</label>

                <div class="col-sm-12">

                  <textarea name="testimonial" class="form-control textarea" rows="6" placeholder="Testimonio"><?= $testimonial['testimonial'] ?></textarea>

                </div>

              </div>

              <div class="form-group">

                <label for="name" class="col-sm-3 control-label">Empresa y designación</label>

                <div class="col-sm-12">

                  <input type="text" name="about" class="form-control" value="<?= $testimonial['comp_and_desig'] ?>" placeholder="Empresa y designación">

                </div>

              </div>

               <div class="form-group">

                <label for="name" class="col-sm-3 control-label">Imagen de usuario</label>

                <div class="col-sm-12">

                  <input type="file" name="photo" class="form-control" >

                  <input type="hidden" name="old_photo" value="<?= $testimonial['photo'] ?>">

                </div>

              </div>

              <div class="form-group">

                <label for="name" class="col-sm-3 control-label">Por defecto?</label>

                <div class="col-sm-12">

                  <?php 

                    $options =  array('0' => 'No', '1' => 'Yes');

                    echo form_dropdown('default',$options,$testimonial['is_default'],'class="form-control select2"');

                  ?>

                </div>

              </div>

              <div class="form-group">

                <label for="name" class="col-sm-3 control-label">Está activo?</label>

                <div class="col-sm-12">

                  <?php 

                    $options =  array('1' => 'Yes', '0' => 'No');

                    echo form_dropdown('status',$options,$testimonial['status'],'class="form-control select2"');

                  ?>

                </div>

              </div>

              <div class="form-group">

                <div class="col-md-12">

                  <input type="submit" name="submit" value="Añadir testimonio" class="btn btn-primary pull-right">

                </div>

              </div>

            <?php echo form_close( ); ?>

          </div>

          <!-- /form -->

        </div>

      </div>  

    </div>

  </section> 

</section> 



<!-- Bootstrap WYSIHTML5 -->

<script src="<?= base_url() ?>assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>



<script>

  $(function () {

    // bootstrap WYSIHTML5 - text editor

    $('.textarea').wysihtml5({

      toolbar: { fa: true }

    });

  })

</script>

<script>

  $("#testimonial").addClass('active');

</script>