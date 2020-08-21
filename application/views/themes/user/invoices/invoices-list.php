
<!-- start banner Area -->
<section class="banner-area relative" id="home">	
	<div class="overlay overlay-bg"></div>
	<div class="container">
		<div class="row d-flex align-items-center justify-content-center">
			<div class="about-content col-lg-12">
				<h1 class="text-white">
					Facturas				
				</h1>	
				<p class="text-white link-nav"><a href="<?= base_url('profile') ?>">Perfil </a>  <span class="lnr lnr-arrow-right"></span>  <a href=""> Facturas</a></p>
			</div>											
		</div>
	</div>
</section>
<!-- End banner Area -->	

<!-- Start post Area -->
<section class="post-area section-gap">
	<div class="container">
		<div class="row justify-content-center d-flex">
			<div class="col-lg-3 sidebar">
				<?php $this->load->view($user_sidebar) ?>   							
			</div>
			<div class="col-lg-9 post-list">
				<div class="profile_job_content col-lg-12">
					<div class="headline">
						<h3>Facturas</h3>
					</div>
					<div class="profile_job_detail">
						<div class="row">
							<?php 
								foreach($invoices as $invoice): 
									$payment_method = ($invoice['payment_method'] == '1') ? 'Paypal' : 'Stripe';
							?>
								<div class="profile-notification">
									<div class="profile-notification-date">
										<p><?= date_time($invoice['created_date']) ?></p>
									</div>
									<div class="profile-notification-body">
										<p> <b><?= $invoice['title'] ?></b></p>
									</div>
									<div class="profile-notification-body">
										<p> <?= $invoice['currency'].' '.$invoice['grand_total'].' - '.$payment_method.' - '.$invoice['payment_status'] ?></p>
									</div>
									<div class="profile-notification-type">
										<span class="type-icon"><?= $invoice['invoice_no'] ?></span>
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
<!-- End post Area -->