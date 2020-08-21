<div class="content-wrapper">
  <section class="content">
    <!-- For Messages -->
    <?php $this->load->view('admin/includes/_messages.php') ?>
    <div class="card card-default">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title"> <i class="fa fa-list"></i>&nbsp; Editar idioma </h3>
        </div>
        <div class="d-inline-block pull-right">
          <a href="<?= base_url('admin/misc/language'); ?>" class="btn btn-success"><i class="fa fa-list"></i> Lista de idiomas</a>
        </div>
      </div>
      <div class="card-body table-responsive">
        <?php echo form_open(base_url('admin/misc/language/edit/'.$language['id']), 'class="form-horizontal"');  ?> 
          <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Nombre del lenguaje</label>
            <div class="col-sm-12">
              <input type="text" name="language" class="form-control" value="<?= $language['name'] ?>" placeholder="Language Name">
            </div>
          </div>

          <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Short Form</label>
            <div class="col-sm-12">
              <input type="text" name="short_form" class="form-control" value="<?= $language['short_form'] ?>" placeholder="e.g. en">
            </div>
          </div>

          <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Código de lenguaje</label>
            <div class="col-sm-12">
              <input type="text" name="code" class="form-control" value="<?= $language['code'] ?>" placeholder="e.g. en_us">
            </div>
          </div>

          <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Estado</label>
            <div class="col-sm-12">
              <?php 
                $options = array('1' => 'Active', '0' => 'Inactive');
                echo form_dropdown('status',$options,$language['status'],'class="form-control"');
              ?>
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-12">
              <input type="submit" name="submit" value="Agregar idioma" class="btn btn-primary pull-right">
            </div>
          </div>
        <?php echo form_close( ); ?>
      </div>
    </div>
  </section> 
</div>

<script>
  $("#language").addClass('active');
</script>