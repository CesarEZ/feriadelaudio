<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<section class="content">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<div class="pull-right">  
		                
							<a class="btn btn-primary create_pdf" 
		                    href="<?= base_url('admin/invoices/invoice_pdf_download/'.$invoice_detail['id']); ?>"><i class="fa fa-download"></i> Descargar</a>
		                    
							<a class="btn btn-danger emailView" id="<?= $invoice_detail['id']; ?>" data-toggle="modal" href="#email"><i class="fa fa-envelope"></i> Enviar correo electrónico</a>
		                    
						</div>	
					</div>
				</div>	
			</div>

			<div class="card-body">
				  <div class="row invoice-info">
				  	  <div class="col-md-6">
				  	  	<img src="<?= base_url($this->general_settings['favicon']); ?>">
				  	  </div>
				  	  <div class="col-md-4 text-right pull-right ">
				  	  	<h2>Factura</h2>
				  	  	<p><strong>ID DE FACTURA : </strong> <?= strtoupper($invoice_detail['invoice_no']); ?> </p>
				  	  	<p><strong>FECHA DE FACTURACIÓN : </strong> <?= strtoupper($invoice_detail['created_date']); ?> </p>
				  	  </div>
				  </div>	  
				
				  <div class="row invoice-info">	
					   <div class="col-md-6 col-sm-6">
					   		<address>
					   		<p class="billing">Facturación hasta</p>
							<p><strong> <?= $invoice_detail['firstname'].' '.$invoice_detail['lastname']; ?></strong></p>
							<p> <?= $invoice_detail['client_address']; ?> </p>
							<p> <?= $invoice_detail['client_email']; ?></p>
							<p> <?= $invoice_detail['client_mobile_no']; ?></p>
					   		</address>
					   		
					  </div>
					  <div class="col-md-6 col-sm-6 pull-rignt">
					  	<p class="billing">Facturación desde</p>
						<p><strong><?= $this->general_settings['application_name']; ?></strong></p>
						<p><?= $invoice_detail['company_address1']; ?></p>
						<p><?= $invoice_detail['company_email']; ?></p>
						<p><?= $invoice_detail['company_mobile_no']; ?></p>
					  </div>
					 
				  </div>
				  <table class="table table-striped table-hover items_detail">
					  <thead>
					  <tr>
						  <th>Descripción del producto</th>
						  <th>Cantidad</th>
						  <th>Precio</th>
						  <th>Impuesto</th>
						  <th>Total</th>
					  </tr>
					  </thead>
					  <tbody>
					 		<tr>
					 			<td><?= $invoice_detail['package'].' - '.$invoice_detail['post_title'] ?></td>
					 			<td>1</td>
					 			<td><?= number_format($invoice_detail['package_price'],2); ?></td>
					 			<td><?= number_format($invoice_detail['tax'],2); ?></td>
					 			<td><?= number_format($invoice_detail['package_price']+$invoice_detail['tax'],2); ?></td>
					 		</tr>
					  </tbody>
				  </table>

				  <div class="row">
				  	  <div class="col-md-6 ml-auto float-right">
				          <div class="table-responsive">
				            <table class="table">
				              <tbody><tr>
				                <th class="width-50pc">Subtotal:</th>
				                <td><?= $invoice_detail['sub_total']; ?></td>
				              </tr>
				              <tr>
				                <th>Impuesto</th>
				                <td><?= $invoice_detail['total_tax']; ?></td>
				              </tr>
				              <tr>
				                <th>Descuento:</th>
				                <td><?= $invoice_detail['discount']; ?></td>
				              </tr>
				              <tr>
				                <th>Total:</th>
				                <td><?= $invoice_detail['grand_total']. ' '.$invoice_detail['currency']; ?></td>
				              </tr>
				            </tbody></table>
				          </div>
				        </div>	

				  </div>
				  <div class="row">
					<div class="col-md-12 pd-t-50">
						<p>Nota del cliente:</p>
						<p class="inv-tnc">
							<?= $invoice_detail['client_note']; ?>
						</p>
					</div>
				  </div>
				  <div class="row">
					<div class="col-md-12 pd-t-50">
						<p>Términos y Condiciones:</p>
						<p class="inv-tnc">
							<?= $invoice_detail['termsncondition']; ?>
						</p>
					</div>
				  </div>
			</div>
	  
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<div class="pull-right">  

							<a class="btn btn-primary create_pdf" 
		                    href="<?= site_url()?>invoices/invoice_pdf_download/<?= $invoice_detail['id']; ?>"><i class="fa fa-download"></i> Descargar</a>
		                    
							<a class="btn btn-danger emailView" id="<?= $invoice_detail['id']; ?>" data-toggle="modal" href="#email"><i class="fa fa-envelope"></i> Enviar correo electrónico</a>
		                    
						</div>	
					</div>
				</div>
			</div>
		</div>
	</section>
	
</div>


 <!-- Modal -->
  <div class="modal fade" id="email" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		  <div class="modal-content">
			  <div class="modal-header">
				  <h4 class="modal-title">Escribe</h4> <!-- NaumaNJunaiD#007 -->
				  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			  </div>
			  <div class="modal-body">
				  <form class="form-horizontal email-from" role="form">
				  	  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />	
					  <div class="form-group">
						  <label  class="col-md-2 control-label">A</label>
						  <div class="col-md-10">
							  <input type="email" class="form-control" id="email" name="email" value="<?= $invoice_detail['client_email']; ?>" placeholder="">
                              <input type="hidden" class="form-control" id="file" name="file">
						  </div>
					  </div>
					  <div class="form-group">
						  <label  class="col-md-2 control-label">Cc / Bcc</label>
						  <div class="col-md-10">
							  <input type="email" class="form-control" id="cc" name="cc" placeholder="">
						  </div>
					  </div>
					  <div class="form-group">
						  <label class="col-md-2 control-label">Sujeto</label>
						  <div class="col-md-10">
							  <input type="text" class="form-control" id="subject" name="subject" value="<?= $this->general_settings['application_name']; ?> Invoice" placeholder="">
						  </div>
					  </div>
					  <div class="form-group">
						  <label class="col-md-2 control-label">Mensaje</label>
						  <div class="col-md-10">
							  <textarea name="message" id="message" class="form-control" cols="30" rows="10"></textarea>
						  </div>
					  </div>

					  <div class="form-group">
						  <div class="col-md-offset-2 col-md-10">
							  <span class="btn green fileinput-button">
								<i class="fa fa-plus fa fa-white"></i>
								<span><a href="" id="pdf_url" target="_blank"></a></span>
							  </span>
							  <button type="button" class="btn btn-send sendEmail">Enviar</button>
						  </div>
					  </div>
				  </form>
			  </div>
		  </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


<script type="text/javascript">

	// Create pdf js function
	$('.emailView').on('click',function(e) {
	    var id = $('.emailView').attr('id');

	   var csrf = {
          '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
        };

	    $.ajax({
	        type: "POST",
	        url: "<?= site_url(); ?>admin/invoices/create_pdf/"+id,
			data: csrf,
	      	success: function(response) {
	      		console.log(response);
					if(response != ''){
						$("#pdf_url").attr("href", response);
						var index = response.lastIndexOf("/") + 1;
						var filename = response.substr(index);				 
						$("#pdf_url").html(filename);
						$("#file").val(filename);
						
					}
				}
	    }); 
		
	});

	// Sending Invoice with email attachment js function
	$('.sendEmail').on('click',function(e) {
	  	//alert($(".email-from").serialize());
	  
	    $.ajax({
				type: 'POST',
				url: '<?= site_url("admin/invoices/send_email_with_invoice"); ?>',
				data: $(".email-from").serialize(),
				beforeSend: function(){
					$(".sendEmail").attr('disabled', true);
					$(".sendEmail").html('<i class="fa fa-spinner fa-pulse"></i>');
				},
				success: function (response) {
					//alert(response);
					if(response){
						$(".sendEmail").attr('disabled', false);
						$(".sendEmail").html('Send');
						$(".email-from").trigger('reset');
						
						$('.close').trigger('click');
						//$('#email').modal('hide');
						
					}
				}
				
			});	   
		});


	function removePopup(){
		$('#email').removeClass('fade in')
		.addClass('fade').css('display', 'none');
		$('#email').attr('aria-hidden', 'true');
	}

	 
 
</script>
<script>
    $('#invoices').addClass('active');
 </script>