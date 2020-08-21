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
          &nbsp; Administrar anuncios </h3>
        </div>
      </div>

      <div class="card-body">
        <?php echo form_open("/",'class="filterdata"') ?> 
        <div class="row">
          <div class="col-2">
            <label>Categoría:</label>
            <select onchange="filter_data()" name="ad_search_category"  class="form-control select2 admin-category">
              <option value="">Seleccionar una opción</option>
              <?php   foreach ($categories as $category): ?>
                <option value="<?php echo $category['id']; ?>"> <?php echo $category['name']; ?> </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-2 admin-subcategory-wrapper">
            <label>Subcategoría:</label>
            <span class="admin-subcategory">
              <select onchange="filter_data()" name="subcategory" id="get_subcategory" class="form-control select2">
                <option value="">Seleccionar una opción</option>
              </select>
            </span>
          </div>
          <div class="col-2">
            <label>Plan:</label>
            <select onchange="filter_data()" name="ad_search_package"  class="form-control select2">
              <option value="">Seleccionar una opción</option>
              <?php   foreach ($packages as $package): ?>
                <option value="<?php echo $package['id']; ?>"> <?php echo $package['title']; ?> </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-2">
            <label>Status:</label>
            <select onchange="filter_data()" name="ad_search_status"  class="form-control select2">
              <option value="">Seleccionar una opción</option>
              <option value="0">Inactivo</option>
              <option value="1">Activo</option>
              <option value="2">Expirado</option>
              <option value="3">Vendido</option>
              <option value="4">No aprobado</option>
            </select>
          </div>
          <div class="col-2">
            <label>Fecha desde:</label>
            <input name="ad_search_from" type="text" class="form-control form-control-inline input-medium datepicker" />
          </div>
          <div class="col-2">
            <label>Fecha hasta:</label>
            <input name="ad_search_to" type="text" class="form-control form-control-inline input-medium datepicker" />
          </div>
          <div class="col-2 text-right">
            <button type="button" onclick="filter_data()" class="btn btn-success mg-t-20">Búsqueda</button>
            <a href="<?= base_url('admin/ads'); ?>" class="btn btn-danger mg-t-20" >
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

  $(document).ready(function() {

    $(".admin-category").on("change", function() {

      var id = $(".admin-category").val();

      $.ajax({
        type : "POST",
        data : {id:id},
        url  : "<?= base_url('admin/ads/get_subcategory_ajax/') ?>",
        success: function(obj) {
          if (obj.trim()!="no_data") {

            $("#get_subcategory").append(obj);
           
          }
        },
      });
    })
  });

//------------------------------------------------------------------
function filter_data()
{
  $('.data_container').html('<div class="text-center"><img src="<?=base_url('assets/admin/dist/img')?>/loading.png"/></div>');
  $.post('<?=base_url('admin/ads/search')?>',$('.filterdata').serialize(),function(){
    $('.data_container').load('<?=base_url('admin/ads/ad_list')?>');
  });
}
//------------------------------------------------------------------
function load_records()
{
  $('.data_container').html('<div class="text-center"><img src="<?=base_url('assets/admin/dist/img')?>/loading.png"/></div>');
  $('.data_container').load('<?=base_url('admin/ads/ad_list')?>');
}
load_records();
</script>

<script>
  $('#ads').addClass('active');
</script>