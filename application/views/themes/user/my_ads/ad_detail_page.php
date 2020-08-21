<!-- start banner Area -->
<section class="banner-area relative" id="home">	
	<div class="overlay overlay-bg"></div>
	<div class="container">
		<div class="row d-flex align-items-center justify-content-center">
			<div class="about-content col-lg-12">
				<h1 class="text-white">
					Detalles del trabajo				
				</h1>	
				<p class="text-white link-nav"><a href="<?= base_url(); ?>">Inicio </a>  <span class="lnr lnr-arrow-right"></span>  <a href=""> Detalles del trabajo</a></p>
			</div>											
		</div>
	</div>
</section>
<!-- End banner Area -->	

<!-- Start post Area -->
<section class="post-area section-gap">
	<div class="container">
		<div class="row d-flex">
			<div class="col-lg-8 col-12">
				<?php if($this->session->flashdata('applied_success')): ?>
		          <div class="alert alert-success">
		            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
		            <?=$this->session->flashdata('applied_success')?>
		          </div>
		        <?php  endif; ?>
		        <?php if($already_applied == true && $this->session->flashdata('applied_success') == null): ?>
		          <div class="alert alert-success">
		            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
		            Ya has solicitado esta aplicación
		          </div>
		        <?php  endif; ?>
		        <?php if($this->session->flashdata('validation_errors')): ?>
		         <div class="alert alert-danger">
		          <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
		          <?= $this->session->flashdata('validation_errors') ?>
		        </div>
		      <?php endif; ?>
			</div>
			<div class="col-lg-8 post-list">
				<div class="single-post d-flex flex-row">
					<div class="details col-12">
						<div class="title d-flex flex-row justify-content-between mb-2">
							<div class="titles">
								<h4><?= $job_detail['job_title']; ?></h4>
							</div>
							<ul class="btns">
								<?php
								 if($already_applied != true && !$this->session->flashdata('applied_success')): ?>
								<li><a id="btn-apply" data-toggle="collapse" href="#collapseExample" role="button">Apply</a></li>
								<?php endif;  ?>
							</ul>
						</div>
						<hr/>
						<p class="address">
							<strong>Category:</strong> <?= get_category_name($job_detail['category']); ?>
						</p>
						<p class="address">
							<strong>Total Positions:</strong> <?= $job_detail['total_positions']; ?>
						</p>
						<p class="address">
							<strong><?= ($job_detail['job_rate_type'] == 1) ? 'Fixed' : 'Hourly' ?> Rate:</strong> <?= get_currency_symbol($job_detail['salary_currency']); ?> <?= $job_detail['job_rate']; ?>
						</p>
						<p class="address">
							<strong>Job Timings:</strong> <?= date('h:i a',strtotime($job_detail['job_start_time'])) ?> - <?= date('h:i a',strtotime($job_detail['job_end_time'])).' ('.$job_detail['job_hours'].' Hours)' ?>
						</p>
						<p class="address">
							<strong>Break:</strong> <?= ($job_detail['break_time'] == 1) ? '60 Minutes' : '30 Minutes' ?> - <?= ($job_detail['break_paid'] == 1) ? 'Paid' : 'Not Paid' ?>
						</p>
						<p class="address">
							<strong>Education:</strong> <?= ($job_detail['education']) ? get_education_level($job_detail['education']) : 'Not Specified'; ?>
						</p>
						<p class="address">
							<strong>Location:</strong> <?= get_city_name($job_detail['city']).', '.get_country_name($job_detail['country']); ?>
						</p>
						<p class="address">
							<strong>Job Description:</strong> <?= $job_detail['description']; ?>
						</p>
					</div>
				</div>	
				<div id="apply-block">
					<div class="collapse" id="collapseExample">
						<div class="card card-body">
							<h4 class="card-title">Apply for this job</h4>
						    <?php $attributes = array('id' => 'job-form', 'method' => 'post');
		        			echo form_open(base_url('jobs/apply_job'),$attributes);
		        			?>	
						      	<div class="form-group">
							       <textarea name="cover_letter" class="form-control" rows="5" placeholder="Su mensaje/carta de presentación enviada al empleador"></textarea>
							    </div> 

							    <!-- Hidden Inputs -->
							    <input type="hidden" name="username" value="<?= $user_detail['firstname']; ?>">
							    <input type="hidden" name="email" value="<?= $user_detail['email']; ?>" >
							    <input type="hidden" name="job_id" value="<?= $job_detail['id']; ?>" >
							    <input type="hidden" name="emp_id" value="<?= $job_detail['employer_id']; ?>" >
							    <input type="hidden" name="job_title" value="<?= $job_detail['job_title']; ?>" >
							    <!-- current url for redirect to same job detail page  -->
							    <input type="hidden" name="job_actual_link" value="<?= $job_actual_link ?>" >
								
								<?php
								    $last_request_page = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
								    $this->session->set_userdata('last_request_page', $last_request_page); 
								 ?>

								<?php if($this->session->userdata('is_user_login') == true): ?>
								    <button type="submit" name="submit" value="submit" class="btn btn-primary btn-block">Send Application</button>

								<?php elseif($this->session->userdata('is_employer_login') == true): ?>
								    <a href="<?= base_url('auth/login'); ?>" class="btn btn-primary btn-block">Por favor, inicie sesión como JobSeeker</a>
								<?php else: ?>
								    <a href="<?= base_url('auth/login'); ?>" class="btn btn-primary btn-block">Por favor, inicie sesión como JobSeeker</a> 
								<?php endif; ?>    

							<?php echo form_close(); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 sidebar">
				<div class="single-slidebar">
		            <h4>Jobs by Location</h4>
		            <ul class="cat-list">
		              <?php foreach($countries_job as $location):?>
		               <li><a class="justify-content-between d-flex" href="<?= base_url('jobs/location/'.get_country_name($location['country_id'])); ?>"><p><?= get_country_name($location['country_id']); ?></p><span><?= $location['total_jobs']; ?></span></a></li>
		             <?php endforeach; ?>
		           </ul>
		         </div>													
			</div>
		</div>
	</div>	
</section>
<!-- End post Area -->

<script>
    $(document).ready(function (){
        $("#btn-apply").on('click',function (){
            $('html, body').animate({
                scrollTop: $("#apply-block").offset().top-90
            }, 1000);
        });
    });
</script>