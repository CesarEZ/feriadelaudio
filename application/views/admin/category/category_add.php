<div class="content-wrapper">
  <section class="content">
    <!-- For Messages -->
    <?php $this->load->view('admin/includes/_messages.php') ?>
    <div class="card card-default">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title"> <i class="fa fa-list"></i>&nbsp; Añadir nueva categoria </h3>
        </div>
        <div class="d-inline-block pull-right">
          <a href="<?= base_url('admin/category'); ?>" class="btn btn-success"><i class="fa fa-list"></i> Lista de categoría</a>
        </div>
      </div>

      <div class="card-body">
        <?php echo form_open_multipart(base_url('admin/category/add'), 'class="form-horizontal jsform"');  ?> 
          <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Nombre</label>
            <div class="col-sm-12">
              <input type="text" name="category" class="form-control" id="category" placeholder="Nombre">
            </div>
          </div>

          <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Descripción</label>
            <div class="col-sm-12">
              <textarea name="description" class="form-control" placeholder="Descripción"></textarea>
            </div>
          </div>

          <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Imagen</label>
            <div class="col-sm-12">
              <input type="file" class="form-control" name="picture">
              <br>
              <p>Se utiliza en el área de categorías en la página de inicio (relacionado con el tipo de visualización: "Imagen como icono").</p>
            </div>
          </div>

          <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Activo</label>

            <div class="col-sm-12">
              <input type="checkbox" name="active">
            </div>
          </div>

          <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Mostrar en la página de inicio</label>

            <div class="col-sm-12">
              <input type="checkbox" name="home_page">
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-12">
              <input type="submit" name="submit" value="Añadir categoría" class="btn btn-primary pull-right">
            </div>
          </div>
        <?php echo form_close( ); ?>
      </div>
    </div>
<script>
  $("#category").addClass('active');
  </script>