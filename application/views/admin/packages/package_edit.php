<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?= base_url() ?>public/plugins/datepicker/datepicker3.css">

<section class="content-wrapper">
  <section class="content">
    <!-- For Messages -->
    <?php $this->load->view('admin/includes/_messages.php') ?>
    <div class="card card-defaul">
      <div class="card-header">
        <div class="d-inline-block">
            <h3 class="card-title"> <i class="fa fa-list"></i>
            &nbsp; Actualizar Paquete </h3>
        </div>
        <div class="d-inline-block float-right">
          <a href="<?= base_url('admin/packages'); ?>" class="btn btn-success"><i class="fa fa-list"></i> Lista de paquetes</a>
        </div>
      </div>  
      
      <div class="card-body">
        <?php echo form_open( base_url('admin/packages/edit/'.$package['id'])); ?>
        <div class="row">
          <div class="col-md-12">
            <div class="box-header with-border">
              <h3 class="box-title">Detalle del paquete</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <label for="title" class="control-label">Nombre del paquete</label>
                <input type="text" name="title" class="form-control" id="title" value="<?= $package['title']; ?>" placeholder="eg. basic, premium" required>
              </div>
              <div class="form-group">
                <label for="days" class="control-label">Precio</label>
                <input type="price" name="price" class="form-control" id="" value="<?= $package['price']; ?>" placeholder="" required>
              </div>
              <div class="form-group">
                <label for="days" class="control-label">No. de días</label>
                <input type="number" name="no_of_days" class="form-control" id="" value="<?= $package['no_of_days']; ?>" placeholder="" required>
              </div>
              <div class="form-group d-none">
                <label for="posts" class="control-label">No. de posts</label>
                <input type="number" name="no_of_posts" class="form-control" id="" value="<?= $package['no_of_posts']; ?>" placeholder="" required>
              </div>
              <div class="form-group">
                <label for="posts" class="control-label">Detalle del paquete</label>
                <input type="text" name="detail" class="form-control" id="" value="<?= $package['detail']; ?>" placeholder="" required>
              </div>
              <div class="form-group">
                <label for="status" class="control-label">Estado</label>
                <select name="status" class="form-control">
                  <option value="1">Activo</option>
                  <option value="0">Inactivo</option>
                </select>
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="box">
              <div class="box-body">
                <input type="submit" name="submit" value="Actualizar paquete" class="btn btn-primary pull-right">
              </div>
            </div>
          </div>
        </div> 
        <?php echo form_close(); ?>
      </div>
    </div>
  </section> 
</section> 

<script>
  $('#packages').addClass('active');
</script>

 