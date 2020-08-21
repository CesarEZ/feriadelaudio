<!-- bootstrap wysihtml5 - text editor -->

<link rel="stylesheet" href="<?= base_url() ?>assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

  <!-- Main content -->

  <section class="content">

  	<!-- For Messages -->

    <?php $this->load->view('admin/includes/_messages.php') ?>

    <div class="card card-default color-palette-bo">

		<div class="card-header">

	      <div class="d-inline-block">

	          <h3 class="card-title"> <i class="fa fa-edit"></i>

	          &nbsp; Nueva publicación</h3>

	      </div>

	      <div class="d-inline-block float-right">

	        <a href="<?= base_url('admin/blog')?>" class="btn btn-success pull-right"><i class="fa fa-plus mr5"></i> Ver lista de publicaciones</a>

	      </div>

	    </div>

		<div class="card-body">

			<div class="row">

				<?php $attributes = array('id' => 'blog_post', 'method' => 'post');

				echo form_open_multipart('admin/blog/post',$attributes);?>



				<div class="add_job_content col-lg-12">

					<div class="add_job_detail">

						<div class="row">

							<div class="col-md-12">

								<div class="form-group">

									<h5>Título*</h5>

									<input type="text" name="title" class="form-control" required>

								</div>

							</div>

							<div class="col-md-12">

								<div class="form-group">

									<h5>Contenido*</h5>

									<textarea name="content" class="form-control textarea" required></textarea>

								</div>

							</div>

							<div class="col-md-6">

								<div class="form-group">

									<h5>Etiquetas*</h5>

									<input type="text" name="tags" class="form-control" required="">

								</div>

							</div>



							<div class="col-md-6">

								<div class="form-group">

									<h5>Palabras clave*</h5>

									<input type="text" name="keywords" class="form-control" required="">

								</div>

							</div>





							<div class="col-md-6">

								<div class="form-group">

									<h5>Categoría*</h5>

									<?php 

										$options = array('' => 'Seleccione una opción') + array_column($categories, 'name','id');

										echo form_dropdown('category',$options,'','class="form-control select2"');

									?>

								</div>

							</div>



							<div class="col-md-6">

								<div class="form-group">

									<h5>Media*</h5>

									<input type="file" name="post_media" class="form-control" required>

								</div>

							</div>

						</div>

					</div>

				</div>

				<div class="add_job_btn col-lg-12 mt-3">

					<div class="form-group">

						<input type="submit" class="btn btn-primary pull-right" name="blog_post" value="Enviar">

					</div>

				</div>

				<?php echo form_close(); ?>

			</div>

		</div>

	</div>

</section>

</div>



<!-- Bootstrap WYSIHTML5 -->

<script src="<?= base_url() ?>assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>



<script>

  	$(function () {

	    // bootstrap WYSIHTML5 - text editor

	    $('.textarea').wysihtml5({

	      toolbar: { fa: true }

	    });

	});

</script>