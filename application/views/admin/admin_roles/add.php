<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="card card-default color-palette-bo">
            <div class="card-header">
                <div class="d-inline-block">
                    <h3 class="card-title"> <i class="fa fa-plus"></i>
                  &nbsp; Agregar nuevo rol </h3>
                </div>
                 <div class="d-inline-block float-right">
                    <a href="<?= base_url('admin/admin_roles') ?>" class="btn btn-primary pull-right"><i class="fa fa-reply mr5"></i> atrás</a>
                </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="box">
                    <!-- form start -->
                    <div class="box-body">

                    <!-- For Messages -->
                    <?php $this->load->view('admin/includes/_messages.php') ?>

                    <?php echo form_open(base_url('admin/admin_roles/add'), 'id="frmvalidate"');  ?> 
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Rol de administrador</label>
                                    <input class="form-control" type="text" name="admin_role_title" value="<?=isset($record['admin_role_title'])?$record['admin_role_title']:''?>" required="">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Estado del rol de administrador</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="admin_role_status"  value="1" <?php if(isset($record['admin_role_status']) && $record['admin_role_status']==1 ){echo 'checked';}?> checked="checked">
                                            Activo
                                        </label>
                                        &nbsp;&nbsp;
                                        <label>
                                            <input type="radio" name="admin_role_status"  value="0" <?php if(isset($record['admin_role_status']) && $record['admin_role_status']==0 ){echo 'checked';}?>>
                                            Inactivo
                                        </label>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="submit" value="submit"  />
                        <button type="submit" class="btn btn-success pull-right">Enviar</button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </section>
</div>
