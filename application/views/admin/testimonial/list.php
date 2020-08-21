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
            &nbsp; Testimonios </h3>
        </div>
        <div class="d-inline-block float-right">
          <a href="<?= base_url('admin/testimonial/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Añadir nuevo testimonio</a>
        </div>
      </div>

      <div class="card-body table-responsive">
        <table id="example1" class="table table-bordered table-hover">
          <thead>
          <tr>
            <th>No</th>
            <th>Testimonio de</th>
            <th>Testimonio</th>
            <th>Status</th>
            <th class="width-150p">Acción</th>
          </tr>
          </thead>
          <tbody>
            <?php $count=0; foreach($testimonials as $row):?>
            <tr>
              <td><?= ++$count; ?></td>
              <td><?= $row['testimonial_by']; ?></td>
              <td><?= $row['testimonial']; ?></td>
              <td><span class="btn btn-success btn-xs"><?= ($row['status'] == 1)? 'Active' : 'Inactive'; ?></span></td>
              <td>
              <a title="Edit" class="btn btn-warning btn-xs mr5" href="<?= base_url('admin/testimonial/edit/'.$row['id'])?>"> <i class="fa fa-pencil-square-o"></i></a>
              <a title="Delete" class="btn btn-danger btn-xs '.$disabled.' btn-delete" href="<?= base_url('admin/testimonial/del/'.$row['id']); ?>" > <i class="fa fa-remove"></i></a>
              
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

