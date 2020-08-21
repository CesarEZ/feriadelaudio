<style type="text/css">
	.rating-stars {
		unicode-bidi: bidi-override;
		direction: rtl;
		float:left;
	}
	.rating-stars input {
		position: absolute;
		left: -999999px;
	}
	.rating-stars label {
		display:inline-block;
		font-size: 0;
		cursor:pointer;
	}
	.rating-stars label:before {
		position: relative;
		font: 24px/1 FontAwesome;
		display: block;
		content: "\f005";
		color: #ccc;
	}
	.rating-stars input:checked+label:before,
	.rating-stars input:checked+label ~ label:before {
		color: #ffa900;
	}
	.rating-stars label:hover:before,
	.rating-stars label:hover ~ label:before {
		color: #ffcc00 !important;
	}
	.textarea-review { border: 1px solid #ccc !important; resize: none; height: 150px; border-radius: 8px; padding: 10px !important; }
	.textarea-review:focus { border: 1px solid #ccc !important; }

	.rating-comments { padding: 20px !important; border-bottom: 1px solid #eee; }

	.form-control { border: 1px solid #ccc !important; border-radius: 8px !important; }
</style>
<br><br>
<!-- Start item detail Area -->

<section class="item-detail-area section-gap">

	<div class="container">

		<div class="row">
			<div class="col-lg-2"></div>
			<div class="col-lg-8 post-list blog-post-list">
				<div class="single-post">
					<h1>Información del pago</h1> 
					<hr class="line-separator">
					<div class="row">
						<div class="col-12">
							<h3><b>Información de usuario</b></h3><br>
							<p style="font-weight: bold; font-size: 18px;"><?= $info_ad[0]['username_ad'] ?></p>
							<p><?= $info_ad[0]['email_ad'] ?></p>
							<p><?= $info_ad[0]['contact_ad'] ?></p><br>
							<h3><b>Información de paquete</b></h3><br>
							<p style="font-weight: bold; font-size: 18px;"><?= $info_ad[0]['title_package'] ?></p>
							<p><small><?= get_currency_symbol($this->general_settings['currency']) ?></small><?= number_format($info_ad[0]['price_package'],0,",",".") ?></p>
							<p><?= $info_ad[0]['detail_package'] ?></p><br>
							<h3><b>Información del producto</b></h3><br>
							<table class="w-100">
								<tr style="border-bottom: 1px solid #ccc;">
									<td class="w-20 p-20">
										<img class="w-100" src="<?= base_url($info_ad[0]['img_1']); ?>" alt="Img Product - laferiadelaudio.com">
									</td>
									<td class="w-60 p-20">
										<?= $info_ad[0]['title'] ?>
									</td>
									<td class="w-20 p-20">
										<small><?= get_currency_symbol($this->general_settings['currency']) ?></small><?= number_format($info_ad[0]['price'],0,",",".") ?>
									</td>
								</tr>
								<tr>
									<td class="p-20" colspan="2" style="font-weight: bold; font-size: 18px;">Total a pagar</td>
									<td class="p-20" style="font-weight: bold; font-size: 18px;">
										<small><?= get_currency_symbol($this->general_settings['currency']) ?></small><?= number_format($info_ad[0]['price_package'],0,",",".") ?>
									</td>
								</tr>
							</table><br>
							<form>
								<script
								src="https://checkout.epayco.co/checkout.js"
								class="epayco-button"
								data-epayco-key="491d6a0b6e992cf924edd8d3d088aff1"
								data-epayco-amount="<?= $info_ad[0]['price_package'] ?>"
								data-epayco-name="Anuncio-<?= $info_ad[0]['title'] ?>-<?= $info_ad[0]['id'] ?>_<?= $info_ad[0]['id_user'] ?>_2"
								data-epayco-description="Anuncio-<?= $info_ad[0]['title'] ?>-<?= $info_ad[0]['id'] ?>_<?= $info_ad[0]['id_user'] ?>_<?= $info_ad[0]['id_package'] ?>_2"
								data-epayco-currency="cop"
								data-epayco-country="co"
								data-epayco-test="true"
								data-epayco-external="false"
								data-epayco-response="<?= base_url('seller/ads/epayco_response/view'); ?>"
								data-epayco-confirmation="<?= base_url('seller/ads/epayco_response/POST'); ?>">
							</script>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-2"></div>
	</div>
</div>
</section>

<!-- End item detail Area -->
