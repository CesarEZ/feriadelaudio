<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap4.css"> 
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
         <!-- For Messages -->
        <?php $this->load->view('admin/includes/_messages.php') ?>
        <div class="card">
            <div class="card-body">
                <div class="d-inline-block">
                  <h3 class="card-title">
                    <i class="fa fa-list"></i>
                    Lista de administradores
                  </h3>
              </div>
              <div class="d-inline-block float-right">
                
              </div>
            </div>
            <div class="card-body">
                <?php echo form_open("/",'class="filterdata"') ?>    
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="type" class="form-control select2" onchange="filter_data()" >
                                <option value="">Todos los tipos de administrador</option>
                                <?php foreach($admin_roles as $admin_role):?>
                                    <option value="<?=$admin_role['admin_role_id']?>"><?=$admin_role['admin_role_title']?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <select name="status" class="form-control select2" onchange="filter_data()" >
                                <option value="">Todo el estado</option>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="keyword" class="form-control"  placeholder="Busque desde aquí..." onkeyup="filter_data()" />
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?> 
            </div> 
        </div>
    </section>


    <!-- Main content -->
    <section class="content mt10">
    	<div class="card">
    		<div class="card-body">
               <!-- Load Admin list (json request)-->
               <div class="data_container"></div>
           </div>
       </div>
    </section>
    <!-- /.content -->
</div>

<!-- DataTables -->
<script src="<?= base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap4.js"></script>
<script>
$(function () {

    $("#example1").DataTable();

    //---------------------------------------------------------------------
    $("body").on("change",".tgl_checkbox",function(){
        $.post('<?=base_url("admin/admin/change_status")?>',
        {
            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
            id : $(this).data('id'),
            status : $(this).is(':checked')==true?1:0
        },
        function(data){
            $.notify("Status Changed Successfully", "success");
        });
    });
    
});

//------------------------------------------------------------------
function filter_data()
{
$('.data_container').html('<div class="text-center"><img src="<?=base_url('assets/admin/dist/img')?>/loading.png"/></div>');
$.post('<?=base_url('admin/admin/filterdata')?>',$('.filterdata').serialize(),function(){
    $('.data_container').load('<?=base_url('admin/admin/list_data')?>');
});
}
//------------------------------------------------------------------
function load_records()
{
$('.data_container').html('<div class="text-center"><img src="<?=base_url('assets/admin/dist/img')?>/loading.png"/></div>');
$('.data_container').load('<?=base_url('admin/admin/list_data')?>');
}
load_records();

</script>