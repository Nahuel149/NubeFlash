<section class="container_main">
    <div class="header-nube"></div>
    <div class="complement_contactos">
        <div class="container wow bounceInUp">
            <h2 class="text-center simple-text text-white">CONTACTO</h2>
            <form class="pt-5" action="<?php echo base_url('contacto') ?>" method="POST">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                <div class="row">
                    <?php if ($this->session->flashdata('contactoProcesado')) { ?>
                        <div class="col-md-12">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo $this->session->flashdata('contactoProcesado') ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($this->session->flashdata('error')) { ?>
                        <div class="col-md-12">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $this->session->flashdata('error') ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="name" id="contact-name" placeholder="NOMBRE " class="form-control input-contact" required autocomplete="name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="enterprise" id="contact-enterprise" placeholder="EMPRESA " class="form-control input-contact" required autocomplete="organization">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="email" name="email" id="contact-email" placeholder="EMAIL" class="form-control input-contact" required autocomplete="email">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="tel" name="telephone" id="contact-telephone" placeholder="TELÉFONO" class="form-control input-contact" required autocomplete="tel">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea rows="3" name="message" id="contact-message" placeholder="MENSAJE" class="form-control input-contact" required></textarea>
                        </div>
                    </div>
                </div>
                <br>
                <div class="form-group d-flex justify-content-center">
                    <div class="g-recaptcha" data-sitekey="<?php echo CAPTCHA_KEY ?>" data-callback="recaptcha_callback"></div>
                </div>
                <div class="text-center padding-top-10">
                    <button class="btn btn-warning btn-send-contanct rounded-pill" id="enviar" disabled>ENVIAR </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script type="text/javascript">
    function recaptcha_callback() {  
        $('#enviar').prop("disabled", false);
    }
</script> 