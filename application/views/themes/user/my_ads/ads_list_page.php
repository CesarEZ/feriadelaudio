<?php 
$payment = $this->setting_model->get_stripe_settings();
$statusPayment = $payment['stripe_status'];
?>

<!-- start banner Area -->
<section class="banner-area relative" id="home">	
	<div class="overlay overlay-bg"></div>
	<div class="container">
		<div class="row d-flex align-items-center justify-content-center">
			<div class="about-content col-lg-12">
				<h1 class="text-white">
					<?= $title ?>			
				</h1>	
				<p class="text-white link-nav"><a href="<?= base_url() ?>">Inicio </a>  <span class="lnr lnr-arrow-right"></span>  <a href=""> <?= $title ?></a></p>
			</div>											
		</div>
	</div>
</section>
<!-- End banner Area -->	

<!-- Start post Area -->
<section class="post-area section-gap">
	<div class="container">
		<?php $this->load->view('themes/_messages'); ?>
		<div class="row justify-content-center d-flex">
			<div class="col-lg-3 sidebar">
				<?php $this->load->view($user_sidebar);  ?>
			</div>
			<div class="col-lg-9 post-list">
				<div class="profile_job_content col-lg-12">
					<div class="headline">
						<h3>Administrar mis anuncios</h3>
					</div>
					<div class="profile_job_detail">
						<div class="row">
							<div class="col-md-4 col-12 gp_products_item">
								<div class="gp_products_inner">
									<div class="gp_products_item_image">
										<a href="<?= base_url('seller/ads/add') ?>">
											<img src="<?= base_url('assets/') ?>img/default-img.jpg" alt="gp product 001" />
										</a>
									</div>
									<div class="gp_products_item_caption">
										<ul class="gp_products_caption_name text-center">
											<li><a href="<?= base_url('seller/ads/add') ?>">Publicar nuevo anuncio</a></li>
											<li><p class="pt-2">Lorem ipsum dolor sit amet adipisicing elit,consectetur elit labore.</p></li>
										</ul>
									</div>
								</div>
							</div>

							<?php 
							foreach ($ads as $row): 

								if($row['is_status'] == '1')
									$ad_url = base_url('ad/'.$row['slug']);
								else
									$ad_url = 'void:javascript(0)';
								?>

								<div class="col-md-4 col-12 gp_products_item">
									<div class="gp_products_inner">
										<div class="gp_products_item_image">
											<a href="<?= $ad_url ?>">
												<img style="width: 100%; height: 200px" src="<?= base_url($row['img_1']) ?>" alt="<?= $row['title'] ?>" />
											</a>
										</div>
										<div class="gp_products_item_caption">
											<ul class="gp_products_caption_name">
												<li><a href="<?= $ad_url ?>"><?= $row['title'] ?></a></li>
												<li><small><?= $row['category_name'] ?></small><a href="<?= $ad_url ?>" class="pull-right"><small><?= get_currency_symbol($this->general_settings['currency']) ?></small><?= number_format($row['price']) ?></a></li>
											</ul>
											<ul class="gp_products_caption_rating mt-2">

												<?php if($row['is_status'] != '2' && $row['is_status'] != '3'): ?>
													<?php if($row['is_status'] != '1'): ?>
														<li title="Editar anuncio"><a href="<?= base_url('seller/ads/edit/'.$row['id']) ?>"><i class="fa fa-edit"></i></a></li>
													<?php endif; ?>
													<?php if($row['is_status'] != '0' && $row['is_status'] != '4'): ?>
														<li title="Marcar como vendido"><a href="<?= base_url('seller/ads/change_status/sold/'.$row['id']) ?>"><i class="fa fa-check-square"></i></a></li>
													<?php endif; ?>
												<?php endif; ?>
												<?php if($row['is_status'] != '0' && $row['is_status'] != '1' && $row['is_status'] != '4'): ?>
													<li title="Reactivar anuncio"><a href="<?= base_url('seller/ads/change_status/reactivate/'.$row['id']) ?>"><i class="fa fa-toggle-on"></i></a></li>
												<?php endif; ?>
												<?php if($row['is_payment'] != '1'  && $statusPayment==1): ?>
													<li title="Pagar anuncio" class="create_cookie" data-create-cookie="<?php echo $row['product_code']; ?>"><a href="<?= base_url('seller/ads/add/pay') ?>"><i class="fa fa-credit-card"></i></a></li>
												<?php endif; ?>
												<li title="Eliminar anuncio"><a href="<?= base_url('seller/ads/delete/'.$row['id']) ?>" class="btn-delete"><i class="fa fa-trash"></i></a></li>

												<li class="pull-right" style="padding-right: 10px;">
													<a href="void:javascript(0)">
														<?php if($row['is_status'] == '0') echo 'Pendiente'; ?>
														<?php if($row['is_status'] == '1') echo 'Activo'; ?>
														<?php if($row['is_status'] == '2') echo 'Expiró'; ?>
														<?php if($row['is_status'] == '3') echo 'Vendido'; ?>
														<?php if($row['is_status'] == '4') echo 'No Aprobado'; ?>


													</a>
												</li>
											</ul>
										</div>
									</div>
								</div>

							<?php endforeach; ?>

						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>	
</section>

<script type="text/javascript">
	$(document).ready(function() {
		$(".create_cookie").click(function() {
			var data = $(this).data("create-cookie");
			setCookie('product_code', data, 30);
		})
	})

	function setCookie(cname, cvalue, exdays) {
		var d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		var expires = "expires="+ d.toUTCString();
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}
</script>
<!-- End post Area -->