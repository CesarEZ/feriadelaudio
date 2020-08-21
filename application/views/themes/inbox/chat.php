<!-- start banner Area -->
<section class="banner-area relative" id="home">	
	<div class="overlay overlay-bg"></div>
	<div class="container">
		<div class="row d-flex align-items-center justify-content-center">
			<div class="about-content col-lg-12">
				<h1 class="text-white">
					<?= $ad['title'] ?>				
				</h1>	
				<p class="text-white link-nav"><a href="<?= base_url('inbox') ?>">Mensajes </a>  <span class="lnr lnr-arrow-right"></span>  <a href=""> <?= $ad['title'] ?></a></p>
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
          	<!-- sidebar -->
			<?php $this->load->view($user_sidebar) ?>
			</div>
			<div class="col-lg-9 post-list">
				<div class="profile_job_content col-lg-12">
					<div class="headline">
						<h3>Bandeja de entrada</h3>
					</div>

					<div class="profile_job_detail">
						<div class="row">
							<ul class="message_detail">
								<li>
									<div class="msg_img">
										<img src="<?= base_url($ad['img_1']) ?>" alt="user-avatar">
									</div>
								</li>
								<li><h6><?= $ad['firstname'].' '.$ad['lastname'] ?></h6></li>
								<li><a href="<?= base_url('ad/'.$ad['slug']) ?>" target="_blank"><?= $ad['title'] ?></a></li>
								<li><small><?= $ad['category_name'] .' > '.$ad['subcategory_name'] ?> </small></li>
								<li><p><?= date_time($ad['created_date']) ?></p></li>
							</ul>
						</div>
					</div>

					<!-- inbox -->
					<div class="profile_job_detail">

						<div class="inbox_body">

							<?php
								$info = get_chat_buyer_and_seller($this->uri->segment(2));

								$buyer = $info['sender'];
								$seller = $info['receiver'];
								
								if($info)
									$receiver = ($buyer === $this->session->user_id) ? $seller : $buyer;
								else
									$receiver = $ad['seller'];

								foreach($messages as $msg): 

								if($msg['sender'] === $this->session->user_id)

								{
							?>

							<div class="container whiter">

							  <span class="user-left">You</span>

							  <p><?= $msg['message'] ?></p>

							  <span class="time-right"><?= date('H:i F j, Y',strtotime($msg['created_date'])) ?></span>

							</div>

							<?php 

								}

								else

								{

							?>

							<div class="container darker">

							  <span class="user-right"><?= get_user_full_name($msg['sender']) ?></span>

							  <p><?= $msg['message'] ?></p>

							  <span class="time-left"><?= date('H:i F j, Y',strtotime($msg['created_date'])) ?></span>

							</div>

							<?php 
							
				            update_message_notification_view($msg['id']);

								}

							endforeach; 

							?>

						</div>

						<div class="form-group row">

			                <div class="col-sm-10">

			                    <input type="text" name="message" class="form-control message" placeholder="Enter ....">

			                </div>

			                <div class="col-sm-2">
			                	<input type="hidden" name="receiver" class="receiver" value="<?= $receiver ?>">
			                	<input type="hidden" name="post" class="post" value="<?= $ad['id'] ?>">
			                    <button type="button" class="btn job_detail_btn send_message">Enviar</button>

			                </div>

			            </div>

					</div>
				</div>
			</div>
			
		</div>
	</div>	
</section>
<!-- End post Area -->