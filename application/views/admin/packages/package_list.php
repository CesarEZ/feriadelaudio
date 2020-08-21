<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap4.css">

<section class="content-wrapper">
  <section class="content">
    <!-- For Messages -->
    <?php $this->load->view('admin/includes/_messages.php') ?>
    <div class="card card-defaul">
      <div class="card-header">
        <div class="d-inline-block">
            <h3 class="card-title"> <i class="fa fa-list"></i>
            &nbsp; Paquetes </h3>
        </div>
        <div class="d-inline-block float-right">
          <a href="<?= base_url('admin/packages/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Agregar nuevo paquete</a>
        </div>
      </div>
        
      <div class="box-header">
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>#ID</th>
              <th>Título del paquete</th>
              <th>Precio</th>
              <th>No. de días</th>
              <th>No. de posts</th>
              <th>Estado</th>
              <th class="text-right width-150p">Acción</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($packages as $package): ?>
              <tr>
                <td><?= $package['id']; ?></td>
                <td><?= $package['title']; ?></td>
                <td><?= $package['price']; ?></td>
                <td><?= $package['no_of_days']; ?></td>
                <td><?= $package['no_of_posts']; ?></td>
                <td><?= ($package['is_active'] == 1)? '<span class="btn btn-success btn-xs">Activo</span>' : '<span class="btn btn-warning btn-xs">Inactivo'; ?></td>
                <td>
                  <a class="btn btn-warning btn-xs" href="<?= base_url('admin/packages/edit/'.$package['id']); ?>"><i class="fa fa-pencil-square-o"></i></a>
                  <a title="Delete" class="btn btn-danger btn-xs btn-delete" href="<?= base_url('admin/packages/del/'.$package['id']); ?>" > <i class="fa fa-remove"></i></a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section> 
</section>

<!-- DataTables -->

<script src="<?= base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap4.js"></script>
  <script>
  $(function () {
    $("#example1").DataTable();
  });
  </script>

  <script>
  $("#packages").addClass('active');
  </script>
 