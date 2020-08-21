<div class="content-wrapper">
<section class="content">
  <!-- For Messages -->
  <?php $this->load->view('admin/includes/_messages.php');  ?>
    <div class="card card-default">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title"> <i class="fa fa-list"></i>&nbsp; Editar categoria</h3>
        </div>
        <div class="d-inline-block float-right">
          <a href="<?= base_url('admin/blog/category'); ?>" class="btn btn-success"><i class="fa fa-list"></i> Lista de categoría</a>
          <a href="<?= base_url('admin/blog/category/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Añadir nueva categoria</a>
        </div>
      </div>
      <div class="card-body table-responsive">
        <?php echo form_open(base_url('admin/blog/category/edit/'.$category['id']), 'class="form-horizontal"' )?>
          <div class="form-group">
            <label for="category_name" class="col-sm-2 control-label">Nombre de la categoría</label>
            <div class="col-sm-12">
              <input type="text" name="category" value="<?= $category['name']; ?>" class="form-control" id="category" placeholder="">
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
              <input type="submit" name="submit" value="Actualizar categoría" class="btn btn-primary pull-right">
            </div>
          </div>
        <?php echo form_close( ); ?>
      </div>
</section> 
</div>

<script>
  $("#category").addClass('active');
  </script>