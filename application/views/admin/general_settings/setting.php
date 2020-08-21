<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="card card-default color-palette-bo">
            <div class="card-header">
              <div class="d-inline-block">
                  <h3 class="card-title"> <i class="fa fa-plus"></i>
                  Configuración general </h3>
              </div>
            </div>
            <div class="card-body">   
                <!-- For Messages -->
                <?php $this->load->view('admin/includes/_messages.php') ?>

                <?php echo form_open_multipart(base_url('admin/general_settings/add')); ?>	
                <!-- Nav tabs -->
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#main" role="tab" aria-controls="main" aria-selected="true">Configuración general</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#social" role="tab" aria-controls="main" aria-selected="true">Configuración de redes sociales</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#email" role="tab" aria-controls="email" aria-selected="false">Configuración de correo electrónico</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#reCAPTCHA" role="tab" aria-controls="reCAPTCHA" aria-selected="false">Configuración de Google</a>
                  </li>
                </ul>
                 <!-- Tab panes -->
                <div class="tab-content">

                    <!-- General Setting -->
                    <div role="tabpanel" class="tab-pane active" id="main">
                        <div class="row">
                            <div class="col-12">
                                <h5>Informacion de aplicacion</h5>
                                <p>La información de su aplicación para el usuario y el motor de búsqueda.</p>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="control-label">Nombre de la aplicación</label>
                                    <input type="text" class="form-control" name="application_name" placeholder="Nombre de la aplicación" value="<?php echo html_escape($general_settings['application_name']); ?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Descripción</label>
                                    <textarea class="form-control" name="description" placeholder="Breve descripción de su aplicación."><?php echo html_escape($general_settings['description']); ?></textarea>
                                </div>
                                <div class="form-group">
                                   <label class="control-label">Términos y condiciones</label><br/>
                                   <textarea name="terms_and_conditions" class="form-control" ><?= $general_settings['terms_and_conditions'] ?></textarea>
                               </div>
                                <div class="form-group">
                                    <label class="control-label">Favicon (25*25)</label><br/>
                                    <?php if(!empty($general_settings['favicon'])): ?>
                                       <p><img src="<?= base_url($general_settings['favicon']); ?>" class="favicon"></p>
                                   <?php endif; ?>
                                   <input type="file" name="favicon" accept=".png, .jpg, .jpeg, .gif, .svg">
                                   <p><small class="text-success">Tipos permitidos: gif, jpg, png, jpeg</small></p>
                                   <input type="hidden" name="old_favicon" value="<?php echo html_escape($general_settings['favicon']); ?>">
                               </div>
                               <div class="form-group">
                                   <label class="control-label">Logo</label><br/>
                                   <?php if(!empty($general_settings['logo'])): ?>
                                       <p><img src="<?= base_url($general_settings['logo']); ?>" class="logo" width="150"></p>
                                   <?php endif; ?>
                                   <input type="file" name="logo" accept=".png, .jpg, .jpeg, .gif, .svg">
                                   <p><small class="text-success">Tipos permitidos: gif, jpg, png, jpeg</small></p>
                                   <input type="hidden" name="old_logo" value="<?php echo html_escape($general_settings['logo']); ?>">
                               </div>
                               
                           </div>
                       </div>
                        <hr>

                        <div class="row">
                            <div class="col-12">
                                <h5>Internacionalizacion</h5>
                                <p>Establezca la zona horaria, el idioma y la moneda predeterminados de sus sitios web</p>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="control-label">Zona horaria</label>
                                    <input type="text" class="form-control" name="timezone" placeholder="Zona horaria"
                                    value="<?php echo html_escape($general_settings['timezone']); ?>">
                                    <a href="http://php.net/manual/en/timezones.php" target="_blank">Zonas horarias</a>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Idioma</label>
                                    <?php 
                                        $language = get_languages_list();
                                        $options = array_column($language, 'name','id');
                                        echo form_dropdown('language',$options,$general_settings['language'],'class="form-control select2"');
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Moneda</label>
                                    <?php 
                                        $currency = get_currency_list();
                                        $options = array_column($currency, 'code','id');
                                        echo form_dropdown('currency',$options,$general_settings['currency'],'class="form-control select2"');
                                    ?>
                                </div>
                            </div>
                        </div>
                        <hr>
                        
                        <div class="row">
                            <div class="col-12">
                                <h5>Configuraciones de pie de página</h5>
                                <p>Administre el pie de página de su sitio web</p>
                            </div>
                            <div class="col-12">
                                <label class="control-label">Widgets de pie de página</label>
                                <div class="footer-widget">
                                    <div class="footer-widget-header">
                                        <div class="row">
                                            <div class="col-md-3">
                                                Título
                                            </div>
                                            <div class="col-md-2">
                                                Talla
                                            </div>
                                            <div class="col-md-6">
                                                Contenido
                                            </div>
                                            <div class="col-md-1">
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="footer-widget-body">

                                        <?php 
                                        foreach ($footer_settings as $footer):
                                        ?>

                                        <div class="widget">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" name="widget_field_title[]" value="<?= $footer['title'] ?>">
                                                </div>
                                                <div class="col-md-2">
                                                <?php 
                                                    $options = array('4' => '1/4','3' => '1/3','2' => '1/2',);
                                                    $others = array('class' => 'form-control');
                                                    echo form_dropdown('widget_field_column[]',$options,$footer['grid_column'],$others);
                                                ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <textarea class="form-control" name="widget_field_content[]"><?= $footer['content'] ?></textarea>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-danger remove-footer-widget"><i class="fa fa-trash"></i></button>
                                                </div>
                                            </div>
                                        </div>

                                        <?php endforeach; ?>

                                    </div>
                                </div>

                                <div class="row">
                                    <button type="button" class="btn btn-primary pull-right btn-add-widget"><i class="fa fa-plus"></i> Agregar widget</button>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Copyright</label>
                                    <input type="text" class="form-control" name="copyright"
                                    placeholder="Copyright"
                                    value="<?php echo html_escape($general_settings['copyright']); ?>">
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Social Media Setting -->
                    <div role="tabpanel" class="tab-pane" id="social">
                        
                        <div class="form-group">
                            <label class="control-label">Facebook</label>
                            <input type="text" class="form-control" name="facebook_link" placeholder="" value="<?php echo html_escape($general_settings['facebook_link']); ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Twitter</label>
                            <input type="text" class="form-control" name="twitter_link" placeholder="" value="<?php echo html_escape($general_settings['twitter_link']); ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Google Plus</label>
                            <input type="text" class="form-control" name="google_link" placeholder="" value="<?php echo html_escape($general_settings['google_link']); ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Youtube</label>
                            <input type="text" class="form-control" name="youtube_link" placeholder="" value="<?php echo html_escape($general_settings['youtube_link']); ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">LinkedIn</label>
                            <input type="text" class="form-control" name="linkedin_link" placeholder="" value="<?php echo html_escape($general_settings['linkedin_link']); ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Instagram</label>
                            <input type="text" class="form-control" name="instagram_link" placeholder="" value="<?php echo html_escape($general_settings['instagram_link']); ?>">
                        </div>
                    </div>

                    <!-- Email Setting -->
                    <div role="tabpanel" class="tab-pane" id="email">
                        <div class="form-group">
                            <label class="control-label">Correo electrónico de administradorl</label>
                            <input type="text" class="form-control" name="admin_email" placeholder= "no-reply@domain.com" value="<?php echo html_escape($general_settings['admin_email']); ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input type="text" class="form-control" name="email_from" placeholder= "no-reply@domain.com" value="<?php echo html_escape($general_settings['email_from']); ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Hosting SMTP</label>
                            <input type="text" class="form-control" name="smtp_host" placeholder="Hosting SMTP" value="<?php echo html_escape($general_settings['smtp_host']); ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Puerto SMTP</label>
                            <input type="text" class="form-control" name="smtp_port" placeholder="Puerto SMTP" value="<?php echo html_escape($general_settings['smtp_port']); ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Usuario SMTP</label>
                            <input type="text" class="form-control" name="smtp_user" placeholder="Usuario SMTP" value="<?php echo html_escape($general_settings['smtp_user']); ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Contraseña SMTP</label>
                            <input type="password" class="form-control" name="smtp_pass" placeholder="Contraseña SMTP" value="<?php echo html_escape($general_settings['smtp_pass']); ?>">
                        </div>
                    </div>

                    <!-- Google reCAPTCHA Setting-->
                    <div role="tabpanel" class="tab-pane" id="reCAPTCHA">
                        <div class="col-12">
                            <h5>Google reCAPTCHA</h5>
                        </div>
                        
                        <div class="col-12">
                            <div class="form-group">
                                <label class="control-label">Site Key</label>
                                <input type="text" class="form-control" name="recaptcha_site_key" placeholder="Clave del sitio" value="<?php echo ($general_settings['recaptcha_site_key']); ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Secret Key</label>
                                <input type="text" class="form-control" name="recaptcha_secret_key" placeholder="Llave secreta" value="<?php echo ($general_settings['recaptcha_secret_key']); ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Idioma</label>
                                <input type="text" class="form-control" name="recaptcha_lang" placeholder="Código de lenguaje" value="<?php echo ($general_settings['recaptcha_lang']); ?>">
                                <a href="https://developers.google.com/recaptcha/docs/language" target="_blank">https://developers.google.com/recaptcha/docs/language</a>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <h5>Google Map</h5>
                            
                        </div>
                        
                        <div class="col-12">
                            <div class="form-group">
                                <label class="control-label">API Key</label>
                                <input type="text" class="form-control" name="map_api_key" placeholder="Map API Key" value="<?php echo ($general_settings['map_api_key']); ?>">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="box-footer">
                    <input type="submit" name="submit" value="Guardar cambios" class="btn btn-primary pull-right">
                </div>	
                <?php echo form_close(); ?>
            </div>
        </div>
    </section>
</div>

<script>

    $("#setting").addClass('active');
    $('#myTabs a').on('click',function (e) {
     e.preventDefault()
     $(this).tab('show');
    });

</script>
