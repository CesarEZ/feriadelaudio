<div class="content-wrapper">
  <section class="content">
    <!-- For Messages -->
    <?php $this->load->view('admin/includes/_messages.php') ?>
    <div class="card card-default">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title"> <i class="fa fa-plus"></i> &nbsp; Agregar nueva subcategoría a <?= get_category_name($this->uri->segment(3)) ?></h3>
        </div>
        <div class="d-inline-block pull-right">
          <a href="<?= base_url('admin/category'); ?>" class="btn btn-success"><i class="fa fa-list"></i> Lista de subcategorías</a>
        </div>
      </div>
      <div class="card-body">
        <?php $category = $this->uri->segment(3); ?>           
        <?php echo form_open(base_url('admin/category/'.$category.'/subcategories/add'), 'class="form-horizontal jsform"');  ?> 
          <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Nombre</label>
            <div class="col-sm-12">
              <input type="text" name="subcategory" class="form-control" id="subcategory" placeholder="Nombre">
            </div>
          </div>

          <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Descripción</label>
            <div class="col-sm-12">
              <textarea name="description" class="form-control" placeholder="Descripción"></textarea>
            </div>
          </div>

          <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Activo</label>
            <input type="hidden" name="category" value="<?=  $category ?>">
            <div class="col-sm-12">
              <input type="checkbox" name="active">
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-12">
              <input type="submit" name="submit" value="Añadir subcategoría" class="btn btn-primary pull-right">
            </div>
          </div>
        <?php echo form_close( ); ?>
      </div>
    </div>
  </section> 
</div>

<script>
  $("#category").addClass('active');
  </script>