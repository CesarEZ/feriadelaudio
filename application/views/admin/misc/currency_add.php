<div class="content-wrapper">
  <section class="content">
    <!-- For Messages -->
    <?php $this->load->view('admin/includes/_messages.php') ?>
    <div class="card card-default">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title"> <i class="fa fa-list"></i>&nbsp; Agregar nueva moneda </h3>
        </div>
        <div class="d-inline-block pull-right">
          <a href="<?= base_url('admin/misc/currency'); ?>" class="btn btn-success"><i class="fa fa-list"></i> Lista de divisas</a>
        </div>
      </div>
      <div class="card-body table-responsive">
        <?php echo form_open(base_url('admin/misc/currency/add'), 'class="form-horizontal"');  ?> 
          <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Nombre de moneda</label>
            <div class="col-sm-12">
              <input type="text" name="currency" class="form-control" id="name" placeholder="">
            </div>
          </div>

          <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Código de moneda</label>
            <div class="col-sm-12">
              <input type="text" name="code" class="form-control" id="name" placeholder="">
            </div>
          </div>

          <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Símbolo de moneda</label>
            <div class="col-sm-12">
              <input type="text" name="symbol" class="form-control" id="name" placeholder="">
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
              <input type="submit" name="submit" value="Agregar moneda" class="btn btn-primary pull-right">
            </div>
          </div>
        <?php echo form_close( ); ?>
      </div>
    </div>
  </section> 
</div>

<script>
  $("#country").addClass('active');
</script>