<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap4.css"> 

<div class="content-wrapper">
  <section class="content">
    <!-- For Messages -->
    <?php $this->load->view('admin/includes/_messages.php') ?>
    <div class="card">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title"><i class="fa fa-list"></i>&nbsp; Campos Personalizados</h3>
        </div>
        <div class="d-inline-block float-right">
          <a href="<?= base_url('admin/custom_fields/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Agregar nuevo campo</a>
        </div>
      </div>

      <div class="card-body">
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-hover">
            <thead>
            <tr>
              <th>Nombre</th>
              <th>Tipo</th>
              <th>Estado</th>
              <th class="text-right width-150p">Acciones</th>
            </tr>
            </thead>
            <tbody>
              <?php $count=0; foreach($fields as $row):?>
              <tr>
                <td><?= $row['name']; ?></td>
                <td><?= $row['type']; ?></td>
                <td><span class="btn btn-success"><?= ($row['status']) ? 'Activo' : 'Inactivo'; ?></span></td>
                <td>

                  <a href="<?= base_url('admin/custom_fields/'.$row['id'].'/categories/add') ?>" class="btn btn-default btn-sm"><i class="fa fa-plus"></i> Agregar a la categoría</a>
                  
                  <a title="Delete" class="btn-delete btn btn-sm btn-danger " href="<?= base_url('admin/custom_fields/del/'.$row['id']); ?>"> <i class="fa fa-remove"></i></a>
                  
                  <a title="Edit" class="btn btn-sm btn-warning " href="<?= base_url('admin/custom_fields/edit/'.$row['id'])?>"> <i class="fa fa-pencil-square-o"></i></a>
                  
                  <?php if($row['type'] == 'dropdown' || $row['type'] == 'multiple_checkbox' || $row['type'] == 'multiple_radio'): ?>
                  
                  <a title="Edit" class="btn btn-sm btn-info " href="<?= base_url('admin/custom_fields/edit/'.$row['id'])?>"> <i class="fa fa-cog"></i> Opciones</a>
                  
                  <?php endif; ?>

                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.card-body -->
    </div>
  </section>  
</div>

  <!-- Scripts for this page -->
  <!-- DataTables -->
<script src="<?= base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap4.js"></script>

<script>
  $(function () {
    $("#example1").DataTable();
  });

  $("#category").addClass('active');
</script>

