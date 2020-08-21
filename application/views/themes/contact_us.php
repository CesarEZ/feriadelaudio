<!-- start banner Area -->
      <section class="banner-area relative" id="contact">  
        <div class="overlay overlay-bg"></div>
        <div class="container">
          <div class="row d-flex align-items-center justify-content-center">
            <div class="about-content col-lg-12">
              <h1 class="text-white">
                <?= $title ?>       
              </h1> 
              <p class="text-white"><a href="<?= base_url(); ?>">Inicio </a>  <span class="lnr lnr-arrow-right"></span>  <a href=""> <?= $title ?></a></p>
            </div>                      
          </div>
        </div>
      </section>
      <!-- End banner Area -->  

      <!-- Start contact-page Area -->
      <section class="contact-page-area section-gap">
        <div class="container">
          <div class="row">
            <div class="col-lg-3 d-flex flex-column">
              <a class="contact-btns" href="<?= base_url('login') ?>">Mi cuenta</a>
              <a class="contact-btns" href="<?= base_url('seller/ads/add') ?>">Publicar anuncio</a>
              <a class="contact-btns" href="<?= base_url('register') ?>">Crear una cuenta</a>
            </div>
            <div class="col-lg-9">
              <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                  <?=$this->session->flashdata('success')?>
                </div>
              <?php  endif; ?>
         
              <?php $attributes = array('id' => '', 'method' => 'post' , 'class' => 'form-area contact-form text-right'); ?>
              <?php echo form_open('contact',$attributes);?>  
                <div class="row"> 
                  <div class="col-lg-12 form-group">
                    <input name="username" placeholder="Ingrese su nombre" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Ingrese su nombre'" class="common-input mb-20 form-control" required="" type="text">
                  
                    <input name="email" placeholder="Ingrese su email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Ingrese su email'" class="common-input mb-20 form-control" required="" type="email">

                    <input name="subject" placeholder="Ingrese su tema" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Ingrese su tema'" class="common-input mb-20 form-control" required="" type="text">

                    <textarea class="common-textarea mt-10 form-control" name="message" placeholder="Mensaje" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Mensaje'" required=""></textarea>
                    <input type="submit" name="submit" value="Enviar mensaje" class="primary-btn mt-20 text-white text-right" />
                  </div>
                </div>
              </form> 
            </div>
          </div>
        </div>  
      </section>
      <!-- End contact-page Area -->