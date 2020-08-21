<!-- start banner Area -->

<section class="banner-area relative" id="home">	

	<div class="overlay overlay-bg"></div>

	<div class="container">

		<div class="row d-flex align-items-center justify-content-center">

			<div class="about-content col-lg-12">

				<h1 class="text-white">

					<?= $title ?>				

				</h1>	

				<p class="text-white link-nav"><a href="<?= base_url() ?>">Inicio </a>  <span class="lnr lnr-arrow-right"></span> <a href="<?= base_url('blog') ?>"> Blog</a> <span class="lnr lnr-arrow-right"></span> <a href="<?= base_url('blog/post/'.$post['slug']) ?>"> <?= $title ?></a></p>

			</div>											

		</div>

	</div>

</section>

<!-- End banner Area -->	



<!-- Start blog-posts Area -->

<section class="blog-posts-area section-gap">

	<div class="container">

		<div class="row">

            <?php 

                $tags = get_post_tags_by_id($post['id']); 

            ?>

			<div class="col-lg-8 post-list blog-post-list">

				<div class="single-post">

					<img class="img-fluid" src="<?= base_url($post['image_default']) ?>" alt="<?= $post['title'] ?>">



                    <ul class="tags">

                        <?php foreach($tags as $tag): ?>

                            <li><a href="<?= base_url('blog/tag/').$tag['tag_slug'] ?>"><?= $tag['tag'] ?></a></li>

                        <?php endforeach; ?>

                    </ul>

                    

					<a href="<?= base_url('blog/post/'.$post['slug']) ?>">

						<h1><?= $post['title'] ?></h1>

					</a>

					<div class="content-wrap">

						<p><?= $post['content'] ?></p>

					</div>



                <!-- Start nav Area -->

                <section class="nav-area pt-50 pb-100">

                    <div class="container">

                        <div class="row justify-content-between">



                            <?php $pre_post = get_previous_post($post['id']); ?>


                            <div class="col-sm-6 nav-left justify-content-start d-flex">
                            <?php if($pre_post):  ?>

                                <div class="thumb">

                                    <img src="<?= base_url($pre_post['image_default']) ?>" alt="" width="100">

                                </div>

                                <div class="post-details">

                                    <p>Prev Post</p>

                                    <h4 class="text-uppercase"><a href="<?= base_url('blog/post/').$pre_post['slug'] ?>"><?= $pre_post['title'] ?></a></h4>

                                </div>

                            <?php endif; ?>
                            </div>



                            <?php  $next_post = get_next_post($post['id']);  ?>


                            <div class="col-sm-6 nav-right justify-content-end d-flex">
                            <?php if($next_post):  ?>

                                <div class="post-details">

                                    <p>Next Post</p>

                                    <h4 class="text-uppercase"><a href="<?= base_url('blog/post/').$next_post['slug'] ?>"><?= $next_post['title'] ?></a></h4>

                                </div>             

                                <div class="thumb">

                                    <img src="<?= base_url($next_post['image_default']) ?>" alt="" width="100">

                                </div>                         

                            <?php endif; ?>
                            </div>

                        </div>

                    </div>    

                </section>

                <!-- End nav Area -->



				</div>																		

			</div>



			<?php $this->load->view('themes/blog/right_nav'); ?>



		</div>

	</div>	

</section>

<!-- End blog-posts Area -->