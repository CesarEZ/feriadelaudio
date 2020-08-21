<div class="content-wrapper">
<section class="content">
  <!-- For Messages -->
  <?php $this->load->view('admin/includes/_messages.php') ?>
    <div class="card card-default">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title"> <i class="fa fa-list"></i>&nbsp; Agregar nueva categoría de blog </h3>
        </div>
        <div class="d-inline-block float-right">
          <a href="<?= base_url('admin/blog/category'); ?>" class="btn btn-success"><i class="fa fa-list"></i> Lista de categoría</a>
        </div>
      </div>
      <div class="card-body table-responsive">
        <?php echo validation_errors(); ?>           
        <?php echo form_open(base_url('admin/blog/category/add'), 'class="form-horizontal"');  ?> 
          <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Nombre de la categoría</label>
            <div class="col-sm-12">
              <input type="text" name="category" class="form-control" id="category" placeholder="">
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
              <input type="submit" name="submit" value="Añadir categoría" class="btn btn-primary pull-right">
            </div>
          </div>
        <?php echo form_close( ); ?>
      </div>

   
</section> 
</div>

<script>
  $("#category").addClass('active');
</script>