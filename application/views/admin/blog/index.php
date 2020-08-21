<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap4.css"> 

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <!-- For Messages -->
    <?php $this->load->view('admin/includes/_messages.php') ?>
    <div class="card card-default color-palette-bo">
      <div class="card-header">
        <div class="d-inline-block">
            <h3 class="card-title"> <i class="fa fa-edit"></i>
            &nbsp; Administrar publicaciones</h3>
        </div>
        <div class="d-inline-block float-right">
          <a href="<?= base_url('admin/blog/post')?>" class="btn btn-success pull-right"><i class="fa fa-plus mr5"></i> Añadir nueva publicación</a>
        </div>
      </div>

      <div class="card-body">
        <?php echo form_open("/",'class="filterdata"') ?> 
          <div class="row">
            <div class="col-3">
              <label>Categoría:</label>
              <select onchange="filter_data()" name="post_search_category"  class="form-control select2">
                <option value=""> Seleccione una opción</option>
                <?php   foreach ($categories as $category): ?>
                <option value="<?php echo $category['id']; ?>"> <?php echo $category['name']; ?> </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-3">
              <label>Fecha desde:</label>
              <input name="post_search_from" type="text" class="form-control form-control-inline input-medium datepicker" />
            </div>
            <div class="col-3">
              <label>Fecha hasta:</label>
              <input name="post_search_to" type="text" class="form-control form-control-inline input-medium datepicker" />
            </div>
            <div class="col-2 text-right">
              <button type="button" onclick="filter_data()" class="btn btn-success mg-t-20">Enviar</button>
              <a href="<?= base_url('admin/blog'); ?>" class="btn btn-danger mg-t-20">
                <i class="fa fa-repeat"></i>
              </a>
            </div>
          </div>
        <?php echo form_close(); ?>
        <hr>
        <!-- Load Admin list (json request)-->
        <div class="data_container"></div>
      </div>

    </div>
    <!-- /card -->
  </section>
</div>


<!-- DataTables -->
<script src="<?= base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap4.js"></script>

<script>
  $(function () {
    $("#example1").DataTable();
  });
		
//------------------------------------------------------------------
function filter_data()
{
$('.data_container').html('<div class="text-center"><img src="<?=base_url('assets/admin/dist/img')?>/loading.png"/></div>');
$.post('<?=base_url('admin/blog/search')?>',$('.filterdata').serialize(),function(){
  $('.data_container').load('<?=base_url('admin/blog/post_list')?>');
});
}
//------------------------------------------------------------------
function load_records()
{
$('.data_container').html('<div class="text-center"><img src="<?=base_url('assets/admin/dist/img')?>/loading.png"/></div>');
$('.data_container').load('<?=base_url('admin/blog/post_list')?>');
}
load_records();
</script>

<script>
  $('#blog').addClass('active');
</script>