<div class="content-wrapper">
  <section class="content">
    <!-- For Messages -->
    <?php $this->load->view('admin/includes/_messages.php') ?>
    <div class="card">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title"><i class="fa fa-list"></i>&nbsp; Editar campo personalizado</h3>
        </div>
        <div class="d-inline-block float-right">
          <a href="<?= base_url('admin/custom_fields'); ?>" class="btn btn-success"><i class="fa fa-list"></i> Lista de campos personalizados</a>
          <a href="<?= base_url('admin/custom_fields/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Agregar nuevo campo</a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-12">
            <div class="box">
              <div class="box-body">
                <?php validation_errors(); ?>
                <?php echo form_open(base_url('admin/custom_fields/edit/'.$field['id']), 'class="form-horizontal jsform"' )?> 
                    
                     <div class="form-group">
                      <label for="name" class="col-sm-3 control-label">Nombre</label>
                      <div class="col-sm-12">
                        <input type="text" name="name" class="form-control" placeholder="Nombre" value="<?= $field['name'] ?>">
                      </div>
                    </div>


                    <div class="form-group">
                      <label for="name" class="col-sm-3 control-label">Longitud del campo</label>
                      <div class="col-sm-12">
                        <input type="number" name="length" class="form-control" placeholder="Longitud del campo" value="<?= $field['length'] ?>" />
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="name" class="col-sm-3 control-label">Valor por defecto</label>
                      <div class="col-sm-12">
                        <input name="default" class="form-control" placeholder="Valor por defecto" value="<?= $field['default_value'] ?>"  />
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="name" class="col-sm-3 control-label">Requerido</label>
                      <div class="col-sm-12">
                        <input type="checkbox" name="required" <?= ($field['required']) ? 'checked' : '' ?>>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="name" class="col-sm-3 control-label">Activo</label>
                      <div class="col-sm-12">
                        <input type="checkbox" name="active" <?= ($field['status']) ? 'checked' : '' ?>>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="name" class="col-sm-3 control-label">Tipo</label>
                      <div class="col-sm-12">
                        <?php
                          $icons = get_record('ci_field_type');
                          $options = array('' => '-') + array_column($icons, 'name','name');
                          $attributes = array('class' => 'form-control field-type select2','required' => true);
                          echo form_dropdown('type',$options,$field['type'],$attributes);
                        ?>
                      </div>
                    </div>

                    <?php 
                      if($field['type'] == 'dropdown' || $field['type'] == 'checkbox_multiple'):
                        // get field options
                        $field_options = get_field_options($field['id']);
                        foreach ($field_options as $op):
                    ?>
                      <div class="form-group">
                        <div class="row">
                          <label class="col-sm-1"><i class="fa fa-times btn-delete-option"></i></label>
                          <div class="col-sm-7">
                            <span><?= $op['name']  ?></span>
                            <input type="hidden" value="<?= $op['name']  ?>" name="options[]">
                          </div>
                        </div>
                      </div>
                    <?php
                      endforeach;
                    ?>
                    
                    <div class="options-wrapper">

                      <div class="options">

                        <div class="form-group">
                          <label for="name" class="col-sm-3 control-label">Opción</label>         
                          <div class="col-sm-12">
                            <input type="text" class="form-control new-option" placeholder="Ingrese el valor de la opción">
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="name" class="col-sm-3 control-label"></label>         
                        <div class="col-sm-12">
                          <button type="button" class="btn btn-warning btn-sm btn-add-option">Agregar opción</button>
                        </div>
                      </div>
                    </div>

                    <?php 
                      endif; 
                    ?>


                    <div class="form-group">
                      <div class="col-md-12">
                        <input type="submit" name="submit" value="Actualizar campo" class="btn btn-primary pull-right">
                      </div>
                    </div>
                  <?php echo form_close(); ?>
                </div>
                <!-- /.box-body -->
            </div>
          </div>
        </div>  
      </div>
    </div>
  </section> 
</div>

<script>
  $("#category").addClass('active');
</script>