<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap4.css"> 

<section class="content-wrapper">
  <section class="content">
    <!-- For Messages -->
    <?php $this->load->view('admin/includes/_messages.php') ?>
    <div class="card card-default">

      <div class="card-header">
        <div class="d-inline-block">
            <h3 class="card-title"> <i class="fa fa-list"></i>
            &nbsp; Pages </h3>
        </div>
        <div class="d-inline-block float-right">
          <a href="<?= base_url('admin/pages/add'); ?>" class="btn btn-success"><i class="fa fa-list"></i> Add New Page</a>
        </div>
      </div>

      <div class="card-body">
        <table id="example1" class="table table-bordered table-hover">
          <thead>
          <tr>
            <th>No</th>
            <th>Page Name</th>
            <th>Sort Order</th>
            <th>Status</th>
            <th class="text-right width-150p">Action</th>
          </tr>
          </thead>
          <tbody>
            <?php $count=0; foreach($pages as $row):?>
            <tr>
              <td><?= ++$count; ?></td>
              <td><?= $row['title']; ?></td>
              <td><?= $row['sort_order']; ?></td>
              <td><?= ($row['is_active'] == 1)? '<span class="btn btn-success btn-xs">Active</span>': '<span class="btn btn-success btn-xs">Inactive</span>'; ?></td>
              <td>
              
              <a title="Edit" class="btn btn-warning btn-xs mr5" href="<?= base_url('admin/pages/edit/'.$row['id'])?>"> <i class="fa fa-pencil-square-o"></i></a>
              <a title="Delete" class="btn btn-danger btn-xs '.$disabled.' btn-delete"  href="<?= base_url('admin/pages/del/'.$row['id']); ?>" > <i class="fa fa-remove"></i></a>
              
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
  $("#pages").addClass('active');
  </script>

