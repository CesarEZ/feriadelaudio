<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<section class="content">
		<div class="card">
		    <div class="card-body">
		      	<h3>Copia de seguridad de la base de datos</h3><br>
		      	<a href="<?= base_url('admin/export/dbexport'); ?>" class="btn btn-success"><i class="fa fa-download"></i> &nbsp; Descargar y crear copia de seguridad</a>
		    </div>
		</div>
	</section>
</div>

<script>
    $("#export").addClass('active');
</script>
