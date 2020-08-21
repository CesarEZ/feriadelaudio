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
					<h1>Información del vendedor</h1> 
					<hr class="line-separator">
					<div class="row">
						<div class="col-lg-4">
							<?php $data_user = get_user($user_info['id']);
							if ($data_user['facebook_account_id']=="" || $data_user['facebook_account_id']==null) {
								$photo = base_url(get_user_profile_photo($this->session->user_id));
							} else {
								$photo = 'https://graph.facebook.com/'.$data_user['facebook_account_id'].'/picture?type=large';
							}
							?>
							<img class="w-100" src="<?= $photo ?>" alt="profile_widget_img">
						</div>
						<div class="col-lg-8">
							<br>
							<h5 style="font-size: 20px;"><?= $user_info['username'] ?></h5>
							<p style="font-size: 16px;"><?= $user_info['firstname'].' '.$user_info['lastname'] ?></p>
							<p style="font-size: 16px;"><?= $user_info['email'] ?></p>
							<p style="font-size: 16px;"><?= $user_info['contact'] ?></p>
							<p style="font-size: 16px;">Registrado en <?= date('F, Y',strtotime($user_info['created_date'])) ?> </p>
							<ul class="gp_products_caption_rating">

								<?php 

								$rating = get_post_rating($user_info['id'], 'users');



								for ($i = 1; $i < 6; $i++):



									if($rating >= $i)



									{

										?>

										<li><i class="fa fa-star"></i></li>

										<?php 

									}

									else

									{

										?>

										<li><i class="fa fa-star-o"></i></li>

										<?php

									}

								endfor;

								?>

							</ul>
							<?php 
							if ($user_info['facebook_account_id']!="" && $user_info['facebook_account_id']!=null) { 
								$query = $this->common_model->data_ci_facebook($user_info['facebook_account_id']); 
								?>
								<a href="<?= $query[0]['user_link'] ?>" target="_blank" class="btn btn-primary btn-block btn-contact btn-profile-fb w-50"><i class="fa fa-facebook"></i>&nbsp&nbspVer perfil en Facebook</a>
							<?php } ?>

						</li>

					</ul>
				</div>
			</div>
		</div>
		<div class="single-post">
			<h3>Valoraciones</h3>
			<?php 
			if (isset($all_rating) && $all_rating != "") {
				foreach ($all_rating as $all_rat) { ?>
					<div class="rating-comments">
						<p style="font-weight: bold !important; font-size: 18px; text-transform: capitalize;"><?php echo htmlspecialchars_decode(html_entity_decode($all_rat->username)); ?></p>
						<ul class="gp_products_caption_rating">

							<?php

							for ($i = 1; $i < 6; $i++):



								if($all_rat->rating >= $i)



								{

									?>

									<li><i class="fa fa-star"></i></li>

									<?php 

								}

								else

								{

									?>

									<li><i class="fa fa-star-o"></i></li>

									<?php

								}

							endfor;

							?>

						</ul>
						<p><?php echo htmlspecialchars_decode(html_entity_decode($all_rat->comments)); ?></p>
						<small>
							<?php

							date_default_timezone_set('America/Bogota');
							$date_start     = strtotime($all_rat->ad_date);
							$date_end       = strtotime(date("Y-m-d H:i:s"));
							$segundos       = $date_end-$date_start;
							$minutos        = $segundos/60;
							$horas          = $segundos/60/60;
							$days           = $segundos/60/60/60;
							$last_active    = 0;

							if ($segundos <= 60) {
								$last_active = 'Hace '.round($segundos).' segundos';
							} else if ($segundos > 60 && $segundos < 3600) {
								$last_active = 'Hace '.round($minutos).' minutos';
							} else if ($segundos > 3600 && $segundos < 86400) {
								$last_active = 'Hace '.round($horas).' horas';
							} else if ($segundos > 86400) {
								$last_active = 'Hace '.round($days+1).' días';
							}
							echo $last_active;
							?>
						</small>
					</div>
				<?php } } else { ?>
					<br><p>No hay comentarios aún.</p>
					<br><p>Sé el primero en opinar sobre "<?php echo $user_info['username']; ?>"</p>
				<?php } ?>
			</div>
			<div class="single-post">

				<h3>Calificar</h3>

				<small>Deja tu calificación <span class="text-danger">*</span></small>
				<?php 

				$user_id = $this->session->userdata('user_id');
				$ad_id = $user_info['id'];

				$attributes = array('method' => 'post'); 
				echo form_open('ads/save_rating/users',$attributes); 
				?>
				<input type="hidden" id="ad_id" name="ad_id" value="<?= $ad_id ?>">
				<input type="hidden" id="ad_slug" name="ad_slug" value="<?= $ad_id; ?>">
				<div class="rating-stars w-100">
					<?php for ($i = 1; $i < 6; $i++) { ?>
						<input type="radio" id="rating-star<?php echo $i; ?>" name="rating-star" value="<?php echo $i; ?>" title="<?php echo $i; ?> stars">
						<label for="rating-star<?php echo $i; ?>"><?php echo $i; ?></label>
					<?php } ?>
				</div>
				<?php if(!$this->session->userdata('is_user_login')) { ?>
					<small>Nombre completo <span class="text-danger">*</span></small><br>
					<input class="form-control" type="text" name="name"><br>
				<?php } ?>
				<textarea class="w-100 textarea-review" name="rating-comments" maxlength="500" required></textarea><br>
				<small>Deja tu comentario <span class="text-danger">*</span></small><br><br>
				<button type="submit" class="btn btn-success">Enviar</button>
				<?php echo form_close(); ?>
			</div>  
		</div>
		<div class="col-lg-2"></div>
	</div>
</div>
</section>

<!-- End item detail Area -->
