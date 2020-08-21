<div class="content-wrapper">
  <section class="content">
    <!-- For Messages -->
    <?php $this->load->view('admin/includes/_messages.php') ?>
    <div class="card">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title"><i class="fa fa-list"></i> &nbsp; Añadir <b><?= $field['name'] ?></b> a nueva categoría</h3>
        </div>
        <div class="d-inline-block float-right">
          <a href="<?= base_url('admin/custom_fields'); ?>" class="btn btn-success"><i class="fa fa-reply"></i> Regresar a todos los campos</a>
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
                  echo form_open(base_url('admin/custom_fields/add_to_category/'.$this->uri->segment(3)), 'class="form-horizontal jsform" novalidate');
                ?> 

                <div class="form-group">
                  <label for="name" class="col-sm-3 control-label">Categoría</label>
                  <div class="col-sm-12">
                    <?php

                        $where = array('status' => 1);
                        $rows = get_records_where('ci_categories',$where);
                        $options = array('' => 'Seleccione una opción') + array_column($rows,'name','id');
                        echo form_dropdown('category',$options,'','class="select2 form-control admin-category" required');
                      
                      ?>
                  </div>
                </div>

                <div class="form-group admin-subcategory-wrapper hidden">
                  <label for="name" class="col-sm-3 control-label">Subcategoría</label>
                  <div class="col-sm-12 admin-subcategory"></div>
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
  </section> 
</div>

<script>
  $("#category").addClass('active');
</script>