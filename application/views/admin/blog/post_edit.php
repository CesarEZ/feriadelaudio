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

	          &nbsp; Editar post </h3>

	      </div>

	      <div class="d-inline-block float-right">

	        <a href="<?= base_url('admin/blog'); ?>" class="btn btn-success pull-right"><span class="fa fa-list"></span> Ver lista de publicaciones</a>

	      </div>

	    </div>

		<div class="card-body">

			<div class="row">

				<?php $attributes = array('id' => 'edit_job', 'method' => 'post');

				echo form_open_multipart('admin/blog/edit/'.$post_detail['id'],$attributes);

				?>

				<div class="add_job_content col-lg-12">

					<div class="add_job_detail">

						<div class="row">

							<div class="col-md-12">

								<div class="form-group">

									<h5>Título*</h5>

									<input type="text" name="title" class="form-control" value="<?= $post_detail['title'] ?>" required>

								</div>

							</div>

							<div class="col-md-12">

								<div class="form-group">

									<h5>Contenido*</h5>

									<textarea name="content" class="form-control textarea" required><?= $post_detail['content'] ?></textarea>

								</div>

							</div>

							<div class="col-md-6">

								<div class="form-group">

									<h5>Etiquetas*</h5>

									<?php

										$tags = get_post_tags_by_id($post_detail['id']);

										$tags = implode(',', array_column($tags, 'tag'));

									?>

									<input type="text" name="tags" class="form-control" value="<?= $tags ?>" required="">

								</div>

							</div>



							<div class="col-md-6">

								<div class="form-group">

									<h5>Palabras clave*</h5>

									<input type="text" name="keywords" class="form-control" value="<?= $post_detail['keywords'] ?>" required="">

								</div>

							</div>





							<div class="col-md-6">

								<div class="form-group">

									<h5>Categoría*</h5>

									<?php 

										$result = get_blog_categories_list();

										$options = array('' => 'Seleccione una opción') + array_column($result, 'name','id');

										echo form_dropdown('category',$options,$post_detail['category_id'],'class="form-control select2"');

									?>

								</div>

							</div>



							<div class="col-md-6">

								<div class="form-group">

									<h5>Media*</h5>

									<input type="file" name="post_media" class="form-control">

									<input type="hidden" name="old_media" value="<?= $post_detail['image_default'] ?>">

								</div>

							</div>

						</div>

					</div>

				</div>

				<div class="add_job_btn col-lg-12 mt-3">

					<div class="form-group">

						<input type="submit" class="btn btn-primary pull-right" name="edit_post" value="Actualizar">

					</div>

				</div>

				<?php echo form_close(); ?>

			</div>

		</div>

	</div>

</section>





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

