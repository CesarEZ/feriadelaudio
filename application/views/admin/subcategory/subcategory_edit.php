<div class="content-wrapper">
  <section class="content">
    <!-- For Messages -->
    <?php $this->load->view('admin/includes/_messages.php') ?>
    <div class="card card-default">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title"> <i class="fa fa-plus"></i> &nbsp; Editar subcategoría</h3>
        </div>
        <div class="d-inline-block pull-right">
          <a href="<?= base_url('admin/category/'.$category['parent'].'/subcategories'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  Lista de subcategorías</a>
          <a href="<?= base_url('admin/category/'.$category['parent'].'/subcategories/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Agregar nueva subcategoría</a>
        </div>
      </div>
      <div class="card-body">
        <?php echo form_open(base_url('admin/subcategory/edit/'.$category['id']), 'class="form-horizontal jsform"' )?> 
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Nombre</label>
              <div class="col-sm-12">
                <input type="text" name="subcategory" class="form-control" placeholder="Nombre" value="<?= $category['name'] ?>">
                <input type="hidden" name="category" value="<?= $category['parent'] ?>">
              </div>
            </div>

            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Descripción</label>
              <div class="col-sm-12">
                <textarea name="description" class="form-control" placeholder="Descripción"><?= $category['description'] ?></textarea>
              </div>
            </div>

            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Activo</label>

              <div class="col-sm-12">
                <input type="checkbox" name="active" <?= ($category['status']) ? 'checked' : '' ?>>
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-12">
                <input type="submit" name="submit" value="Actualizar subcategoría" class="btn btn-primary pull-right">
              </div>
            </div>
          <?php echo form_close(); ?>
      </div>
    </div>
  </section> 
</div>

<script>
  $("#category").addClass('active');
  </script>