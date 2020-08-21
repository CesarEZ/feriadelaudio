
<!-- start banner Area -->
<section class="banner-area relative" id="home">	
	<div class="overlay overlay-bg"></div>
	<div class="container">
		<div class="row d-flex align-items-center justify-content-center">
			<div class="about-content col-lg-12">
				<h1 class="text-white">
					Notificaciones				
				</h1>	
				<p class="text-white link-nav"><a href="<?= base_url('profile') ?>">Perfil </a>  <span class="lnr lnr-arrow-right"></span>  <a href=""> Notificaciones</a></p>
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
						<h3>Notificaciones</h3>
					</div>
					<div class="profile_job_detail">
						<div class="row">
							<?php foreach($notifications as $notify): ?>
								<div class="profile-notification">
									<div class="profile-notification-date">
										<p><?= date_time($notify['created_at']) ?></p>
									</div>
									<div class="profile-notification-body">
										
										<p><?= $notify['content'] ?></p>
									</div>

									<?php if(!$notify['user_view']): ?>
									<div class="profile-notification-type">
										<span class="type-icon lnr lnr-eye primary i-notification-view" data-notification="<?= $notify['id'] ?>"></span>
									</div>
									<?php endif; ?>
									
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

<style type="text/css">
	@media only screen and (max-width: 600px) {
		.profile-notification { height: 150px !important; }
		.profile-notification-date p { line-height: 35px !important; }
		.profile-notification-body p { line-height: 25px !important; }
		.type-icon { top: 0px !important; }
	}
</style>