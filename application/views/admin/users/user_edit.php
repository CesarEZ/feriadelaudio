  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title"> <i class="fa fa-pencil"></i>
              &nbsp; Editar usuario </h3>
          </div>
          <div class="d-inline-block float-right">
            <a href="<?= base_url('admin/users'); ?>" class="btn btn-success"><i class="fa fa-list"></i> Users List</a>
            <a href="<?= base_url('admin/users/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Agregar nuevo usuario</a>
          </div>
        </div>
        <div class="card-body">
   
           <!-- For Messages -->
            <?php $this->load->view('admin/includes/_messages.php') ?>
           
            <?php echo form_open(base_url('admin/users/edit/'.$user['id']), 'class="form-horizontal"' )?> 
            
             <div class="form-group">
                <label for="firstname" class="col-md-2 control-label">Usuario</label>

                <div class="col-md-12">
                  <input type="text" name="username" value="<?= $user['username']; ?>" class="form-control" id="firstname" placeholder="">
                </div>
              </div>
              
              <div class="form-group">
                <label for="firstname" class="col-md-2 control-label">Nombres</label>

                <div class="col-md-12">
                  <input type="text" name="firstname" value="<?= $user['firstname']; ?>" class="form-control" id="firstname" placeholder="">
                </div>
              </div>

              <div class="form-group">
                <label for="lastname" class="col-md-2 control-label">Apellidos</label>

                <div class="col-md-12">
                  <input type="text" name="lastname" value="<?= $user['lastname']; ?>" class="form-control" id="lastname" placeholder="">
                </div>
              </div>

              <div class="form-group">
                <label for="email" class="col-md-2 control-label">Email</label>

                <div class="col-md-12">
                  <input type="email" name="email" value="<?= $user['email']; ?>" class="form-control" id="email" placeholder="">
                </div>
              </div>
              <div class="form-group">
                <label for="mobile_no" class="col-md-2 control-label">Contacto</label>

                <div class="col-md-12">
                  <input type="number" name="contact" value="<?= $user['contact']; ?>" class="form-control" id="contact" placeholder="">
                </div>
              </div>
              <div class="form-group">
                <label for="role" class="col-md-2 control-label">Seleccione un estado</label>

                <div class="col-md-12">
                  <select name="status" class="form-control">
                    <option value="">Seleccione un estado</option>
                    <option value="1" <?= ($user['is_active'] == 1)?'selected': '' ?> >Activo</option>
                    <option value="0" <?= ($user['is_active'] == 0)?'selected': '' ?>>Inactivo</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Actualizar usuario" class="btn btn-primary pull-right">
                </div>
              </div>
            <?php echo form_close(); ?>
        </div>
          <!-- /.box-body -->
      </div>  
    </section> 
  </div>