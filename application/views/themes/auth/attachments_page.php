
<!-- registration-section-starts -->
<div class="container-login100">
  <div class="wrap-login100 w-800px">
    <div class="container">
      <span class="login100-form-title pb-5">
       Registrarse (archivos adjuntos)
      </span>
      
      <div class="line-title-left"></div>
      <?php 
      if($this->session->flashdata('error')){
        echo '<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>';
      }
      ?>

      <?php 
        $attributes = array('method' => 'post','id' => 'attachment_form'); 
        echo form_open_multipart('auth/attachment',$attributes); 
      ?>
      <div class="row">
        <div class="col-lg-6">
          <div class="form-group">
            <label class="form-label">Foto de perfil *</label>
            <input type="file" name="profile" class="form-control"  accept="image/png,image/jpeg"/>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="form-group">
            <label class="form-label">BC ID * <small>(Frente) (Tarjeta de identificación, licencia de conducir, tarjeta social, etc.)</small></label>
            <input type="file" name="id_front" class="form-control"  />
          </div>
        </div>

        <div class="col-lg-6">
          <div class="form-group">
            <label class="form-label">BC ID <small>(Atrás) (Tarjeta de identificación, permiso de conducir, tarjeta social, etc.)</small></label>
            <input type="file" name="id_back" class="form-control"  />
          </div>
        </div>

        <div class="col-lg-6">
          <div class="form-group">
            <label class="form-label">Prueba de seguro social no. (SIN) *</label>
            <input type="file" name="sin_prove" class="form-control"  />
          </div>
        </div>

        <div class="col-lg-6">
          <div class="form-group">
            <label class="form-label">Prueba de tener derecho legal a trabajar en Canadá *</label>
            <input type="file" name="work_prove" class="form-control"  />
          </div>
        </div>

        <div class="col-lg-6">
          <div class="form-group">
            <label class="form-label">Formulario de depósito directo o cheque *</label>
            <input type="file" name="deposit" class="form-control"  />
          </div>
        </div>

        <div class="col-lg-6">
          <div class="form-group">
            <label class="form-label">Currículum</label>
            <input type="file" name="resume" class="form-control"  />
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <?php if($this->recaptcha_status): ?>
              <div class="recaptcha-cnt">
                  <?php generate_recaptcha(); ?>
              </div>
            <?php endif; ?>
          <div class="form-group">
            <input type="submit" class="login100-form-btn btn-block" name="submit" value="Registrarse">
          </div>
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>  
  </div>  
</div>

<!-- registration-section-Ends -->