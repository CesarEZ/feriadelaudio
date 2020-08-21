<div class="content-wrapper">
  <section class="content">
    <!-- For Messages -->
    <?php $this->load->view('admin/includes/_messages.php') ?>
    <div class="card card-default">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title"> <i class="fa fa-list"></i>&nbsp; Administrar campos personalizados de <b><?= get_category_name($this->uri->segment(4)) ?></b> </h3>
        </div>
        <div class="d-inline-block pull-right">
          <a href="<?= base_url('admin/category'); ?>" class="btn btn-success"><i class="fa fa-list"></i>Lista de categoría</a>
        </div>
      </div>

      <div class="card-body">
        <div class="row">
          <div class="col-12">
            <div class="box border-top-solid">
              <!-- form start -->
              <div class="box-body my-form-body">

                <?php echo validation_errors(); ?>           
                <?php
                  $category_id = $this->uri->segment(4);
                  echo form_open(base_url('admin/category/custom_fields/'.$category_id), 'class="form-horizontal jsform" novalidate');
                ?> 

                <div class="form-group">
                  <label for="name" class="col-sm-3 control-label">Categoría</label>
                  <div class="col-sm-12">
                    <?php
                        $where = array('status' => 1,'id' => $category_id);
                        $rows = get_records_where('ci_categories',$where);
                        $options = array_column($rows,'name','id');
                        echo form_dropdown('category',$options,'','class="select2 form-control category" required');
                      ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="name" class="col-sm-3 control-label">Subcategoría</label>
                  <div class="col-sm-12">
                    <?php
                      $where = array('status' => 1,'parent' => $category_id);
                      $rows = get_records_where('ci_subcategories',$where);
                      $options = array('' => 'Seleccione una subcategoría')+array_column($rows,'name','id');
                      echo form_dropdown('subcategory',$options,'','class="select2 form-control"');
                    ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="name" class="col-sm-3 control-label">Campos Personalizados</label>
                  <div class="col-sm-12">
                    <?php
                      $where = array('status' => 1);
                      $rows = get_records_where('ci_fields',$where);
                      $options = array('' => 'Seleccione una opción')+array_column($rows,'name','id');
                      echo form_dropdown('field',$options,'','class="select2 form-control" required');
                    ?>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-12">
                    <input type="submit" name="submit" value="Agregue campo" class="btn btn-primary pull-right">
                  </div>
                </div>

                <?php echo form_close( ); ?>

              </div>
              <!-- /.box-body -->
            </div>
          </div>
        </div>  
      </div>
      
    </div>

    <div class="card card-default">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title"> <i class="fa fa-list"></i>&nbsp; <b><?= get_category_name($this->uri->segment(4)) ?></b> Lista de campos personalizados añadidos</h3>
        </div>
      </div>
      <!-- list -->
      <div class="card-body">
        <div class="row">
          <div class="col-12">
            <div class="box border-top-solid">
              <!-- form start -->
              <div class="box-body">
                <table class="table">
                  <thead>
                    <th>Sr.</th>
                    <th>Categoría</th>
                    <th>Subcategoría</th>
                    <th>Campo</th>
                    <th>Acción</th>
                  </thead>
                  <tbody>
                    <?php 
                      $counter = 0; foreach($records as $field): 
                    ?>
                    <tr>
                      <td><?= ++$counter ?></td>
                      <td><?= get_category_name($field['category']) ?></td>
                      <td><?= get_subcategory_name($field['subcategory']) ?></td>
                      <td><?= get_feild_name_by_id($field['field']) ?></td>
                      <td>
                        <a title="Delete" class="btn-delete btn btn-sm btn-danger" href="<?= base_url('admin/category/custom_field_del/'.$field['id'].'/'.$category_id); ?>"> <i class="fa fa-remove"></i></a>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
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