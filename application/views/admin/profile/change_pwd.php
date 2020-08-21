<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default color-palette-bo">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title"> <i class="fa fa-pencil"></i>
              &nbsp; Cambiar contraseña </h3>
          </div>
        </div>
        <div class="card-body">   
           <!-- For Messages -->
            <?php $this->load->view('admin/includes/_messages.php') ?>
           
            <?php echo form_open(base_url('admin/profile/change_pwd'), 'class="form-horizontal"');  ?> 
              <div class="form-group">
                <label for="password" class="col-sm-3 control-label">Nueva contraseña</label>

                <div class="col-md-12">
                  <input type="password" name="password" class="form-control" id="password" placeholder="Nueva contraseña">
                </div>
              </div>

              <div class="form-group">
                <label for="confirm_pwd" class="col-sm-3 control-label">Confirmar contraseña</label>

                <div class="col-md-12">
                  <input type="password" name="confirm_pwd" class="form-control" id="confirm_pwd" placeholder="Confirmar contraseña">
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Cambiar contraseña" class="btn btn-info pull-right">
                </div>
              </div>
            <?php echo form_close( ); ?>
        </div>
          <!-- /.box-body -->
      </div>
    </section> 
  </div>
