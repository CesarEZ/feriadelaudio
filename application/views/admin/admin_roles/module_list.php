<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap4.css"> 

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<section class="content">
		<!-- For Messages -->
   		<?php $this->load->view('admin/includes/_messages.php') ?>
		<div class="card">
			<div class="card-header">
				<div class="d-inline-block">
					<h3 class="card-title"><i class="fa fa-list"></i>&nbsp; Configuración del módulo</h3>
				</div>
				<div class="d-inline-block float-right">
					<a href="<?= base_url('admin/admin_roles/module_add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Agregar nuevo módulo</a>
				</div>
			</div>

			<div class="card-body table-responsive">
				<table id="example1" class="table table-bordered table-hover">
					<thead>
						<tr>
							<th width="50">ID</th>
							<th>Nombre del módulo</th>
							<th>Nombre del controlador</th>
							<th>Fa Icon</th>
							<th>Operaciones</th>
							<th>Submódulo</th>
							<th width="100">Acción</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($records as $record): ?>
							<tr>
								<td><?= $record['module_id']; ?></td>
								<td><?= $record['module_name']; ?></td>
								<td><?= $record['controller_name']; ?></td>
								<td><?= $record['fa_icon']; ?></td>
								<td><?= $record['operation']; ?></td>
								<td>
									<a href="<?= base_url('admin/admin_roles/sub_module/'.$record['module_id']) ?>" class="btn btn-info btn-xs mr5">
										<i class="fa fa-sliders"></i>
									</a>
								</td>
								<td>
									<a href="<?php echo site_url("admin/admin_roles/module_edit/".$record['module_id']); ?>" class="btn btn-warning btn-xs mr5" >
											<i class="fa fa-edit"></i>
										</a>
									<a href="<?php echo site_url("admin/admin_roles/module_delete/".$record['module_id']); ?>"  class="btn btn-danger btn-xs btn-delete"><i class="fa fa-remove"></i></a>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
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
  })
</script>