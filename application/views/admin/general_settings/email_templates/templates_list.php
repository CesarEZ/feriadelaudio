<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="<?= base_url() ?>assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<section class="content">
		<!-- For Messages -->
   		<?php $this->load->view('admin/includes/_messages.php') ?>
		<div class="card">
			<div class="card-header">
				<div class="d-inline-block">
					<h3 class="card-title"><i class="fa fa-list"></i>&nbsp; Configuración de plantillas de correo electrónico</h3>
				</div>
			</div>

			<div class="card-body">
				<div class="row">
					<div class="col-3">
						<table class="table table-bordered table-hover templates-table text-center">
							<thead>
								<tr>
									<th>Plantillas de correo electrónico</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($templates as $row): ?>
								<tr>
									<td class="btn-template-link" data-type="<?= $row['id'] ?>">
										<span class="btn-template-link" data-type="<?= $row['id'] ?>" ><?= $row['name'] ?></span>
									</td>
								</tr>
								<?php  endforeach; ?>
							</tbody>
						</table>
					</div>
					<div class="col-9 template-wrapper">
						<div class="template-body empty-template text-center">
							<p>Selecciona una plantilla</p>
						</div>
						<!-- form start -->
			            <?php echo validation_errors(); ?>           
			            <?php echo form_open(base_url('admin/general_settings/email_templates'), 'class="form-horizontal template-form"');  ?> 
						<div class="template-body non-empty-template hidden">
							<div class="row">
								<div class="col-12">
								    <div class="form-group">
						                <div class="col-12">
						                  <input type="text" name="subject" class="form-control" placeholder="Asunto del email">
						                </div>
					                </div>
					             	<div class="form-group">
						                <div class="col-12">
						                  <textarea name="content" class="textarea form-control" rows="10"></textarea>
						                </div>
					              	</div>
					              	<div class="form-group">
						                <div class="col-12">
						                	<label>Variables</label>
						                  	<input type="text" name="variables" class="form-control" placeholder="Variables de plantilla"  disabled>
						                </div>
				                	</div>
					                <div class="form-group">
						                <div class="col-md-12">
						                  <input type="hidden" name="template_id">
						                  <input type="submit" name="submit" value="Guardar plantilla" class="btn btn-primary pull-right">
						                  <input type="button" value="Preview" class="btn btn-warning pull-right mr-1" id="btn_preview_email">
						                </div>
						            </div>
						        </div>
							</div>
						</div>
			            <?php echo form_close( ); ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>

<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url() ?>assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<script>
  $(function () {
    // bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5({
      toolbar: { fa: true }
    });

    //  get email template content
    $('.btn-template-link').on('click',function(){
    	$this = $(this);
    	$('.empty-template').addClass('hidden');
    	$('.non-empty-template').removeClass('hidden');

	    $.post('<?=base_url("admin/general_settings/get_email_template_content_by_id")?>',
		{
			'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
				template_id : $this.data('type'),
		},
		function(data){
			obj = JSON.parse(data);
			template = obj['template'];
			variables = obj['variables'];

			$('input[name=subject]').val(template.subject);
			$('input[name=template_id]').val(template.id);
			$('input[name=variables]').val(variables);
			$('iframe').contents().find('.wysihtml5-editor').html(template.body);
			console.log(variables);
			// $.notify("Status Changed Successfully", "success");
		});
    });
    // 

    //  update email template content
    $('.template-form').on('submit',function(){
    	event.preventDefault();
	    $.post('<?=base_url("admin/general_settings/email_templates")?>',
		{
			'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
				id : $('input[name=template_id]').val(),
				subject : $('input[name=subject]').val(),
				content : $('iframe').contents().find('.wysihtml5-editor').html(),
		},
		function(data){
			console.log(data);
			$.notify("Plantilla actualizada con éxito", "success");
		});
    });
    // 

     // Preview Email
    $('#btn_preview_email').on('click',function(){
      $.post('<?=base_url("admin/general_settings/email_preview")?>',
      {
        '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
        head : $('input[name=subject]').val(),
        content : $('.textarea').val(),
      },
      function(data){
        var w = window.open();
        w.document.open();
        w.document.write(data);
        w.document.close();
      });
    });
  })
</script>
<script>
  $("#setting").addClass('active');
</script>