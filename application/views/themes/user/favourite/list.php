
<!-- start banner Area -->
<section class="banner-area relative" id="home">	
	<div class="overlay overlay-bg"></div>
	<div class="container">
		<div class="row d-flex align-items-center justify-content-center">
			<div class="about-content col-lg-12">
				<h1 class="text-white">
					Mi favorito				
				</h1>	
				<p class="text-white link-nav"><a href="<?= base_url('profile') ?>">Perfil </a>  <span class="lnr lnr-arrow-right"></span>  <a href=""> Mi favorito</a></p>
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
						<h3>Favoritos</h3>
					</div>
					<div class="profile_job_detail">
						<div class="row">

							<?php
								if(count($favourites) > 0){
								foreach($favourites as $fav): 
							?>

							<div class="profile-notification">
								<!-- NOTIFICATION CLOSE -->
								<div class="profile-notification-date">
									<p><?= date_time($fav['created_date']); ?></p>
								</div>
								<div class="profile-notification-body">
									<figure class="user-avatar">
										<img src="<?= base_url($fav['img_1']) ?>" alt="user-avatar">
									</figure>
									<p><a href="<?= base_url('ad/'.$fav['slug']) ?>" target="_blank"><span><?= $fav['title'] ?></span></a> Añadido a favoritos</p>
								</div>
								<div class="profile-notification-type">
									<?php $favorite = is_favorite($fav['ad_id'],$this->session->user_id); ?>
									<i class="type-icon fa <?= ($favorite) ? 'fa-heart' : 'fa-heart-o' ?> i-favorite" data-post="<?= $fav['ad_id'] ?>"></i>
								</div>
							</div>
							
							<?php 
								endforeach;
							}
							else
							{
								echo "No hay artículos favoritos";
							}
							?>

						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>	
</section>
<!-- End post Area -->
