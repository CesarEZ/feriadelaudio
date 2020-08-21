 <!-- Datatable style -->
<link rel="stylesheet" href="<?= base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap4.css">    

<div class="content-wrapper">
  <section class="content">
    <!-- For Messages -->
    <?php $this->load->view('admin/includes/_messages.php') ?>
    <div class="card card-default">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title"> <i class="fa fa-list"></i> &nbsp; <b><?= get_category_name($this->uri->segment(3)) ?></b>'s Subcategorias</h3>
        </div>
        <div class="d-inline-block pull-right">
          <a href="<?= base_url('admin/category/'.$this->uri->segment(3).'/subcategories/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Agregar nueva subcategoría</a>
        </div>
      </div>
      <div class="card-body table-responsive">
        <table id="example1" class="table table-bordered table-striped ">
        <thead>
        <tr>
          <th>No</th>
          <th>Nombre</th>
          <th>Estado</th>
          <th class="text-right width-150p">Acción</th>
        </tr>
        </thead>
        <tbody>
          <?php $count=0; foreach($subcategories as $row):?>
          <tr>
            <td><?= ++$count; ?></td>
            <td><?= $row['name']; ?></td>
            <td><button type="button" class="btn btn-success"><?= ($row['status']) ? 'Active' : 'Inactive' ; ?></button></td>
            <td>
              <!-- <a href="<?= base_url('admin/category/custom_fields/'.$row['parent']) ?>" class="btn btn-default btn-sm"><i class="fa fa-plus"></i> Custom Fields</a> -->
              <a title="Delete" class="btn-delete btn btn-danger " href="<?= base_url('admin/category/del_subcategory/'.$row['id']); ?>"> <i class="fa fa-remove"></i></a>
              <a title="Edit" class="btn btn-warning " href="<?= base_url('admin/subcategory/edit/'.$row['id'])?>"> <i class="fa fa-pencil-square-o"></i></a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      </div>
    </div>
  </section>  
</div>
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

