<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap4.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <!-- For Messages -->
    <?php $this->load->view('admin/includes/_messages.php') ?>
    <div class="card card-default">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title"> <i class="fa fa-list"></i>&nbsp; Lista de facturas </h3>
        </div>
      </div>
      <div class="card-body table-responsive">
        <table id="na_datatable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Factura#</th>
              <th>Cliente</th>
              <th>Cantidad</th>
    		      <th>Fecha de creación</th>
              <th>Estado</th>
              <th width="150" class="text-right">Acción</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
    <!-- /.card -->
  </section>  
</div>

<!-- DataTables -->
<script src="<?= base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap4.js"></script>

<script>
  //---------------------------------------------------
  var table = $('#na_datatable').DataTable( {
    "processing": true,
    "serverSide": false,
    "ajax": "<?=base_url('admin/invoices/datatable_json')?>",
    "order": [[4,'desc']],
    "columnDefs": [
    { "targets": 0, "name": "invoice_no", 'searchable':true, 'orderable':true},
    { "targets": 1, "name": "username", 'searchable':true, 'orderable':true},
    { "targets": 2, "name": "grand_total", 'searchable':true, 'orderable':true},
    { "targets": 3, "name": "due_date", 'searchable':true, 'orderable':true},
    { "targets": 4, "name": "is_active", 'searchable':false, 'orderable':false},
    { "targets": 5, "name": "Action", 'searchable':false, 'orderable':false,'width':'100px'}
    ]
  });
</script> 
<script>
  $("#invoices").addClass('active');
</script>        
