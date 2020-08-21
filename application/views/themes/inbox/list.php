<!-- start banner Area -->
<section class="banner-area relative" id="home">	
	<div class="overlay overlay-bg"></div>
	<div class="container">
		<div class="row d-flex align-items-center justify-content-center">
			<div class="about-content col-lg-12">
				<h1 class="text-white">
					Mensajes				
				</h1>	
				<p class="text-white link-nav"><a href="<?= base_url('profile') ?>">Perfil </a>  <span class="lnr lnr-arrow-right"></span>  <a href="<?= base_url('inbox') ?>"> Mensajes</a></p>
			</div>											
		</div>
	</div>
</section>
<!-- End banner Area -->

<!-- Start post Area -->
<section class="post-area section-gap">
	<div class="container">
		<div class="row justify-content-center d-flex">
			<!-- for messages -->
			<?php $this->load->view('themes/_messages'); ?>

			<div class="col-lg-3 sidebar">
          	<!-- sidebar -->
			<?php $this->load->view($user_sidebar) ?>
			</div>
			<div class="col-lg-9 post-list">
				<div class="profile_job_content col-lg-12">
					<div class="headline">
						<h3>Messages</h3>
					</div>
					<div class="profile_job_detail">
						<div class="row">
							<?php 

							if(count($messages) > 0)
							{

							foreach($messages as $msg): 

							?>

								<ul class="message_detail">
									
									<li>
										<?php $thumbnail = get_ad_thumbnail_photo($msg['pid']) ?>
										<div class="msg_img">
											<img src="<?= base_url($thumbnail) ?>" alt="Ad Photo">
										</div>
									</li>
									
									<li><h6><?= get_user_full_name($msg['receiver']) ?></h6></li>
									
									<li><a href="<?= base_url('inbox/'.$msg['pid'].'/'.$msg['slug']) ?>"><?= $msg['title'] ?></a></li>
									
									<li><small><?= get_category_name($msg['category']).' > '.get_subcategory_name($msg['subcategory']) ?> </small></li>
									
									<li><p><?= date_time($msg['created_date']) ?></p></li>

									<li><a href="<?= base_url('inbox/'.$msg['pid'].'/'.$msg['slug']) ?>">
										<?php 

										if($msg['receiver_view'] == '0' && $msg['receiver'] == $this->session->user_id)
										{
											echo '<i class="fa fa-envelope-o"></i>';
										}
										else
										{
											echo '<i class="fa fa-envelope-open-o"></i>';
										}

										?>

										
										</a>
									</li>
								</ul>

							<?php 

							endforeach;

							}

							else

							{
								echo '<p>Bandeja de entrada vacía </p>';
							}

							?>

						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>	
</section>
<!-- End post Area