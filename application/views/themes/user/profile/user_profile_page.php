<!-- start banner Area -->
  <section class="banner-area relative" id="home">  
    <div class="overlay overlay-bg"></div>
    <div class="container">
      <div class="row d-flex align-items-center justify-content-center">
        <div class="about-content col-lg-12">
          <h1 class="text-white">
            <?= lang('user_profile') ?>        
          </h1> 
          <p class="text-white link-nav"><a href="<?= base_url() ?>"><?= lang('home') ?> </a>  <span class="lnr lnr-arrow-right"></span>  <a href=""> <?= lang('user_profile') ?></a></p>
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
              <h3> <?= lang('user_profile') ?></h3>
            </div>
            <div class="profile_job_detail">

              <?php 
                $attributes = array('method' => 'post','class' => 'jsform'); 
                echo form_open_multipart('profile/index',$attributes); 
              ?>

              <div class="row">
                
                <div class="col-md-6 col-sm-12">
                  <div class="submit-field">
                    <h5><?= lang('username') ?> *</h5>
                    <input class="form-control" name="username" type="text" value="<?= $user_info['username'] ?>" placeholder="<?= lang('username') ?>" readonly required>
                  </div>
                </div>

                <div class="col-md-6 col-sm-12">
                  <div class="submit-field">
                    <h5><?= lang('first_name') ?> *</h5>
                    <input class="form-control" name="firstname" type="text" value="<?= $user_info['firstname'] ?>" placeholder="e.g. John" required>
                  </div>
                </div>

                <div class="col-md-6 col-sm-12">
                  <div class="submit-field">
                    <h5><?= lang('last_name') ?> *</h5>
                    <input class="form-control" name="lastname" type="text" value="<?= $user_info['lastname'] ?>" placeholder="e.g. Lee" required>
                  </div>
                </div>

                <div class="col-md-6 col-sm-6">
                  <div class="submit-field">
                    <h5><?= lang('email') ?> *</h5>
                    <input class="form-control" name="email" type="email" placeholder="example@example.com" value="<?= $user_info['email'] ?>" required>
                  </div>
                </div>

                <div class="col-md-6 col-sm-6">
                  <div class="submit-field">
                    <h5><?= lang('contact') ?> *</h5>
                    <input class="form-control" name="contact" type="text" placeholder="0323145004" value="<?= $user_info['contact'] ?>" required>
                  </div>
                </div>

                <div class="col-md-6 col-sm-12">
                  <div class="submit-field">
                    <h5><?= lang('country') ?> *</h5>
                     <?php 
                        $options = array('' => 'Seleccione un país') + array_column($countries,'name','id');
                        echo form_dropdown('country',$options,$user_info['country'],'class="select2 form-control country" required');
                      ?>
                  </div>
                </div>  

                <div class="col-md-6 col-sm-12">
                  <div class="submit-field">
                    <h5><?= lang('state') ?> *</h5>
                    <?php 
                      $where = array('country_id' => $user_info['country']);
                      $rows = get_records_where('ci_states',$where);
                      $options = array('' => 'Seleccione un estado') + array_column($rows,'name','id');
                      echo form_dropdown('state',$options,$user_info['state'],'class="select2 form-control state" required');
                    ?>
                  </div>
                </div>  

                <div class="col-md-6 col-sm-12">
                  <div class="submit-field">
                    <h5><?= lang('city') ?> *</h5>
                     <?php 
                        $where = array('state_id' => $user_info['state']);
                        $rows = get_records_where('ci_cities',$where);
                        $options = array('' => 'Seleccione una ciudad') + array_column($rows,'name','id');
                        echo form_dropdown('city',$options,$user_info['city'],'class="select2 form-control city" required');
                      ?>
                  </div>
                </div> 

                <div class="col-md-6 col-sm-6">
                  <div class="submit-field">
                    <h5><?= lang('address') ?> *</h5>
                    <input class="form-control" type="text" name="address" placeholder="Dirección" value="<?= $user_info['address'] ?>" >
                  </div>
                </div>

                <div class="col-md-6 col-sm-6">
                  <div class="submit-field">
                    <h5><?= lang('profile_picture') ?></h5>
                    <input class="form-control" type="file" name="profile_picture" >
                    <input class="form-control" type="hidden" name="old_profile_picture" value="<?= $user_info['profile_picture'] ?>">
                  </div>
                </div>

              <div class="add_job_btn col-lg-12 mt-5">
                <div class="submit-field">
                   <input type="submit" class="job_detail_btn" name="update" value="Actualizar">
                </div>
              </div>  

              </div>

              <?php echo form_close(); ?>

            </div>
          </div>
        </div>
        
      </div>
    </div>  
  </section>
  <!-- End post Area -->