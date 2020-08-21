<?php

$html = '
	<section>
		<table border="" style="width: 100%">
			<tbody>
				<tr>
					<td width="60%"><img src="'.base_url($this->general_settings['favicon']).'"></td>
					<td>
						<h3>FACTURA</h3>
				  	  	<h4>FACTURA ID : '.strtoupper($invoice_detail['invoice_no']).'</h4>
				  	  	<h4>FECHA DE FACTURACIÓN : '.strtoupper($invoice_detail['created_date']).'</h4>
			  		</td>
				</tr>
			</tbody>
		</table>

		<table class="invoice" border="" style="width: 100%">
			<tbody>
				<tr >
					<th style="margin-right:1mm">
						<p>Facturación hasta</p>
					</th>
					<th>
						<p>Facturación desde</p>
					</th>
				</tr>
				<tr>		
					<td>
						<p><strong> '.ucwords($invoice_detail['firstname'].' '.$invoice_detail['lastname']).' </strong></p>
						<p> '.$invoice_detail['client_address'].' </p>
						<p> '.$invoice_detail['client_email'].' </p>
						<p> '.$invoice_detail['client_mobile_no'].'  </p>
				   	</td>
				   	<td>
						<p><strong> '.ucfirst( $this->general_settings['application_name']).' </strong></p>
						<p>'.'</p>
						<p>'.'</p>
						<p>'.'</p>
				   	</td>
				</tr>	
			</tbody>
		</table>


		<table class="invoice" border="" style="width: 100%">
			<thead>
				<tr class="">
					<th>Descripción del producto</th>
				    <th>Cantidad</th>
				    <th>Precio</th>
				    <th>Impuesto</th>
				    <th>Total</th>
				</tr>
			</thead>
			<tbody>';


			$html .= '
				<tr class="oddrow">
					<td> '.$invoice_detail['package'].' - '.$invoice_detail['post_title'].' </td>
					<td> 1 </td>
					<td> '.number_format($invoice_detail['package_price'],2).' </td>
					<td> '.number_format($invoice_detail['tax'],2).' </td>
					<td> '.number_format($invoice_detail['package_price']+$invoice_detail['tax'],2).' </td>
				</tr>';

			$html .= '	
			
			</tbody>
		</table>


		<table align="right" class="calculation bpmTopic" width="50%">
	        <tbody>
		          <tr>
		            <th style="width:60%">Subtotal:</th>
		            <td>'.$invoice_detail['sub_total'].'</td>
		          </tr>
		          <tr>
		            <th>Tax</th>
		            <td>'.$invoice_detail['total_tax'].'</td>
		          </tr>
		          <tr>
		            <th>Discount:</th>
		            <td>'.$invoice_detail['discount'].'</td>
		          </tr>
		          <tr>
		            <th>Total:</th>
		            <td>'.$invoice_detail['grand_total']. ' '.$invoice_detail['currency'].'</td>
		          </tr>
	        </tbody>
	    </table>
	</section>	
';

	echo $html;

?>