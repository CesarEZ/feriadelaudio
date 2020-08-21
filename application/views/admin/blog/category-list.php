 <!-- Datatable style -->
<link rel="stylesheet" href="<?= base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap4.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    <!-- For Messages -->
    <?php $this->load->view('admin/includes/_messages.php') ?>
    <div class="card card-default">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title"> <i class="fa fa-list"></i>&nbsp; Categorías de blog </h3>
        </div>
        <div class="d-inline-block float-right">
          <a href="<?= base_url('admin/blog/category/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Añadir nueva categoria</a>
        </div>
      </div>
      <div class="card-body table-responsive">
        <table id="example1" class="table table-bordered table-striped ">
          <thead>
          <tr>
            <th>No</th>
            <th>Nombre de la categoría</th>
            <th>Slug</th>
            <th class="text-right width-150p">Acción</th>
          </tr>
          </thead>
          <tbody>
            <?php $count=0; foreach($categories as $row):?>
            <tr>
              <td><?= ++$count; ?></td>
              <td><?= $row['name']; ?></td>
              <td><?= $row['slug']; ?></td>
              <td>
                
                <a title="Delete" class="btn-delete btn btn-danger pull-right" href="<?= base_url('admin/blog/category/del/'.$row['id']); ?>"> <i class="fa fa-remove"></i></a>
                <a title="Edit" class="update btn btn-warning pull-right" href="<?= base_url('admin/blog/category/edit/'.$row['id'])?>"> <i class="fa fa-pencil-square-o"></i></a>

              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- /.card -->
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
  </script>
  <script>
  $("#category").addClass('active');
  </script>

