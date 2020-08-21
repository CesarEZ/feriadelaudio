  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title"> <i class="fa fa-pencil"></i> Editar submódulo</h3>
          </div>
          <div class="d-inline-block float-right">
            <a href="<?= base_url('admin/admin_roles/sub_module/'.$module['parent']); ?>" class="btn btn-success"><i class="fa fa-list"></i> Lista de submódulos</a>
          </div>
        </div>
        
        <div class="card-body">
   
           <!-- For Messages -->
            <?php $this->load->view('admin/includes/_messages.php') ?>

            <?php echo form_open(base_url('admin/admin_roles/sub_module_edit/'.$module['id']), 'class="form-horizontal"');  ?> 

              <div class="form-group">
                <label for="module_name" class="col-md-2 control-label">Nombre del módulo</label>
                <div class="col-md-12">
                  <?php 
                    $menu = get_sidebar_menu();
                    $others = array('class' => 'form-control select2', 'id' => 'module_name');
                    $options =  array_column($menu, 'module_name','module_id');
                    echo form_dropdown('module_name',$options,$module['parent'],$others);
                  ?>
                </div>
              </div>

              <div class="form-group">
                <label for="module_name" class="col-md-2 control-label">Nombre del submódulo</label>

                <div class="col-md-12">
                  <input type="text" name="sub_module_name" value="<?= $module['name']; ?>" class="form-control" id="sub_module_name" placeholder="">
                </div>
              </div>
              
              
              <div class="form-group">
                <label for="operation" class="col-md-2 control-label">Link</label>

                <div class="col-md-12">
                  <input type="text" name="operation" value="<?= $module['link']; ?>" class="form-control" id="operation" placeholder="eg. about_us">
                </div>
              </div>
              <div class="form-group">
                <label for="sort_order" class="col-md-2 control-label">Orden de clasificación</label>

                <div class="col-md-12">
                  <input type="number" name="sort_order" value="<?= $module['sort_order']; ?>" class="form-control" id="sort_order" placeholder="">
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Actualizar submódulo" class="btn btn-primary pull-right">
                </div>
              </div>
            <?php echo form_close( ); ?>
        </div>
          <!-- /.box-body -->
      </div>
    </section> 
  </div>