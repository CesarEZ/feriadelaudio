 <!-- Datatable style -->
<link rel="stylesheet" href="<?= base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap4.css"> 

<div class="content-wrapper">
  <section class="content">
    <!-- For Messages -->
    <?php $this->load->view('admin/includes/_messages.php') ?>
    <div class="card card-default">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title"> <i class="fa fa-list"></i>&nbsp; Idiomas </h3>
        </div>
        <div class="d-inline-block pull-right">
          <a href="<?= base_url('admin/misc/language/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Agregar nuevo idioma</a>
        </div>
      </div>
      <div class="card-body table-responsive">
        <table id="na_datatable" class="table table-bordered table-striped ">
        <thead>
        <tr>
          <th>No</th>
          <th>Nombre del lenguaje</th>
          <th>Short Form</th>
          <th>Código de lenguaje</th>
          <th>Estado</th>
          <th class="text-right">Acción</th>
        </tr>
        </thead>
      </table>
      </div>
    </div>
    
  </section>  
</div>

<!-- DataTables -->
<script src="<?= base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap4.js"></script>

<script>
  //---------------------------------------------------
  var table = $('#na_datatable').DataTable({
    "processing": true,
    "serverSide": false,
    "ajax": "<?= base_url('admin/misc/language_datatable_json') ?>",
    "order": [[1,'asc']],
    "columnDefs": [
    { "targets": 0, "name": "sr", 'searchable':true, 'orderable':true},
    { "targets": 1, "name": "name", 'searchable':true, 'orderable':true},
    { "targets": 2, "name": "short_form", 'searchable':true, 'orderable':true},
    { "targets": 3, "name": "code", 'searchable':true, 'orderable':true},
    { "targets": 4, "name": "status", 'searchable':true, 'orderable':true},
    { "targets": 5, "name": "Action", 'searchable':false, 'orderable':false}
    ]
  });
</script> 

<script>
$("#misc").addClass('active');
</script>

