<<style type="text/css">
	.section-gap {
		padding: 150px 0px 50px !important;
	}
</style>
<section class="item-detail-area section-gap">

	<div class="container">

		<div class="row">
			<div class="col-lg-2"></div>
			<div class="col-lg-8 post-list blog-post-list">
				<div class="single-post">
					<h4 style='text-align:left'> Respuesta de la Transacción</h4>
					<hr>
					<div class='col-lg-12'>
						<div class='table-responsive'>
							<table class='table table-bordered'>
								<tbody>
									<tr>
										<td>Referencia</td>
										<td id='referencia'></td>
									</tr>
									<tr>
										<td class='bold'>Fecha</td>
										<td id='fecha'></td>
									</tr>
									<tr>
										<td> Respuesta </td>
										<td id='respuesta'></td>
									</tr>
									<tr>
										<td> Motivo </td>
										<td id='motivo'></td>
									</tr>
									<tr>
										<td class='bold'>Banco</td>
										<td id='banco'></td>
									</tr>
									<tr>
										<td class='bold'>Recibo</td>
										<td id='recibo'></td>
									</tr>
									<tr>
										<td class='bold'>Total</td>
										<td id='total'></td>
									</tr>
									<tr>
										<td colspan="2">
											<img src='https://369969691f476073508a-60bf0867add971908d4f26a64519c2aa.ssl.cf5.rackcdn.com/btns/epayco/pagos_procesados_por_epayco_260px.png' style='margin-top:10px; float:left'>  <img src='https://369969691f476073508a-60bf0867add971908d4f26a64519c2aa.ssl.cf5.rackcdn.com/btns/epayco/credibancologo.png'height='40px' style='margin-top:10px; float:right'>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-2"></div>
		</div>
	</div>
</section>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.js'> </script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'> </script>
<script>
	function getQueryParam(param) {
		location.search.substr(1).split('&').some(function(item) {
			return item.split('=')[0] == param && (param = item.split('=')[1])
		})
		return param
	}

	$(document).ready(function() {

		var ref_payco = getQueryParam('ref_payco');
		var url = 'POST/'+ref_payco+'/view/'; 
		$.ajax({
			url        : url,
			success    : function(resp) {
				console.log(resp);
			}
		});

		var urlapp = 'https://secure.epayco.co/validation/v1/reference/' + ref_payco;
		$.get(urlapp, function(response) {
			if (response.success) {
				$('#fecha').html(response.data.x_transaction_date);
				$('#respuesta').html(response.data.x_response);
				$('#referencia').text(response.data.x_id_invoice);
				$('#motivo').text(response.data.x_response_reason_text);
				$('#recibo').text(response.data.x_transaction_id);
				$('#banco').text(response.data.x_bank_name);
				$('#autorizacion').text(response.data.x_approval_code);
				$('#total').text(response.data.x_amount + ' ' + response.data.x_currency_code);
			} else {
				alert('Error consultando la información');
			}
		});
	});
</script>