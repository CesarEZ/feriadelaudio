<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="card card-default color-palette-bo">
            <div class="card-header">
              <div class="d-inline-block">
                  <h3 class="card-title"> <i class="fa fa-edit"></i>
                  &nbsp; Editar rol </h3>
              </div>
              <div class="d-inline-block float-right">
                <a href="<?= base_url('admin/admin_roles') ?>" class="btn btn-primary pull-right"><i class="fa fa-reply mr5"></i> atrás</a>
              </div>
            </div>
            <div class="card-body">
    			<?php echo form_open(base_url('admin/admin_roles/edit'), 'id="frmvalidate"');  ?> 
    						
                    <input type="hidden" name="admin_role_id" value="<?=$record['admin_role_id']?>"  />
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nombre de rol</label>
                                    <input class="form-control" type="text" required="required" name="admin_role_title" value="<?=isset($record['admin_role_title'])?$record['admin_role_title']:''?>">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Estado del tipo de usuario</label>
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
    </section>
</div>


