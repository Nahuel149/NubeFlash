<section class="register">
    <div class="container">
        <h3>REGÍSTRATE</h3>
        <hr class="color-line">
        <br>
        <div class="card">
            <?php if($this->session->flashdata('success')): ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success animated fadeInDown">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>              
                        <?php echo $this->session->flashdata('success') ?><br>         
                    </div>
                </div>
            </div>
            <?php endif ?>
            <?php if($this->session->flashdata('error')): ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger animated fadeInDown">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>              
                        <?php echo $this->session->flashdata('error') ?><br>         
                    </div>
                </div>
            </div>
            <?php endif ?>
            
            <?php if(validation_errors()): ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger animated fadeInDown">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>              
                        <?php echo validation_errors(); ?>        
                    </div>
                </div>
            </div>
            <?php endif ?>
            
            <div class="card-body">
                <form action="<?php echo current_url(); ?>" method="POST">
                    <?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
                    <div class="col-md-12">
                        <br>
                        <div class="form-group">
                            <label for="register-social-reason">Razón Social</label>
                            <input id="register-social-reason" type="text" name="social_reason" class="form-control" placeholder="Razón Social" autocomplete="organization" />
                        </div>
                        <div class="form-group">
                            <label for="register-fiscal-id">RUT de empresa</label>
                            <input id="register-fiscal-id" type="text" name="fiscal_identifier" class="form-control" placeholder="Identificador fiscal" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label for="register-country">País <span class="required">*</span></label>
                            <select class="form-control" id="register-country" required name="country" autocomplete="country">
                                <option value="">Seleccione un País</option>
                                <?php foreach($countries as $country){ ?>
                                    <option value="<?php echo $country->country_id ?>"><?php echo $country->name ?></option>
                                <?php } ?> 
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="register-province">Departamento/Provincia <span class="required">*</span></label>
                            <select id="register-province" disabled required name="province" class="form-control" autocomplete="address-level1">
                                <option value="">Seleccione un Departamento</option>
                            </select>
                            <input type="text" id="register-province-manual" class="form-control mt-2" placeholder="Ingrese su Departamento/Provincia" style="display: none;" autocomplete="address-level1-manual">
                        </div>
                        <div class="form-group">
                            <label for="register-destination">Localidad <span class="required">*</span></label>
                            <input id="register-destination" required type="text" name="destination_text" class="form-control" placeholder="Ingrese su localidad o barrio" autocomplete="address-level2" />
                        </div>
                        <div class="form-group">
                            <label for="register-contact">Persona de Contacto <span class="required">*</span></label>
                            <input id="register-contact" required type="text" name="person_contact" class="form-control" placeholder="Persona de contacto" autocomplete="name" />
                        </div>
                        <div class="form-group">
                            <label for="register-phone">Teléfono <span class="required">*</span></label>
                            <input id="register-phone" required type="tel" name="telephone" class="form-control" placeholder="Telefono" autocomplete="tel" />
                        </div>
                        <div class="form-group">
                            <label for="register-email">Correo electrónico <span class="required">*</span></label>
                            <input id="register-email" required type="email" name="email" class="form-control" placeholder="Correo electronico" autocomplete="email" />
                        </div>
                        <div class="form-group">
                            <label for="register-password">Contraseña <span class="required">*</span></label>
                            <input id="register-password" required type="password" name="password" class="form-control" placeholder="contraseña" autocomplete="new-password" />
                            <small class="form-text text-muted">
                                La contraseña debe tener al menos 8 caracteres, 1 letra mayúscula y 1 símbolo (por ejemplo, !@#$%^&*).
                            </small>
                        </div>
                        <div class="form-group">
                            <label for="register-password-confirm">Repetir contraseña <span class="required">*</span></label>
                            <input id="register-password-confirm" required type="password" name="re-password" class="form-control" placeholder="repetir contraseña" autocomplete="new-password" />
                        </div>
                        <div class="form-group text-center">
                            <label for="register-terms">
                                <input type="checkbox" id="register-terms" name="terms" required>
                                <a href="<?php echo base_url('terminos-pdf') ?>" target="_blank"> Acepto términos y condiciones</a>
                            </label>
                        </div>
                        <div class="form-group d-flex justify-content-center">
                            <div class="g-recaptcha" data-sitekey="<?php echo CAPTCHA_KEY ?>" data-callback="recaptcha_callback"></div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary rounded-pill prueba" id="enviar" disabled>REGISTRARME</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>   
</section>

<!-- Add password validation script after jQuery -->
<script src="<?php echo base_url('assets/frontend/js/password_validation.js'); ?>"></script>

<script type="text/javascript">
    function recaptcha_callback() {  
        $('#enviar').prop("disabled", false);
    }

    $("#register-country").change(function (e) { 
        e.preventDefault();
        var country_id = $(this).val();
        $.ajax({
            type: "POST",
            url: base_url + 'frontend/ajax/getProvince',
            data: {
                country_id: country_id,
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            dataType: "JSON",
            beforeSend: function () {
                $("#register-province").attr('disabled','');
                $("#register-destination").attr('disabled','');
                $("#register-province").html('<option value="">Seleccione un Departamento</option>');
                $("#register-destination").html('<option value="">Seleccione una Localidad</option>');
                $("#postal_code").val('');
                $("#register-province-manual").hide().removeAttr('required').removeAttr('name').val('');
                $("#register-province").prop('disabled', false).attr('required', true);
            },
        }).done(function (data) {
            var htm = "<option value=''>Seleccione un Departamento</option>";
            if(data.success)
            {
                $.each(data.provinces, function (index, value) { 
                     htm += "<option value='"+value.province_id+"'>"+value.name+"</option>";
                });
                htm += "<option value='other'>-- Otro --</option>";
                $("#register-province").html(htm);
                $("#register-province").removeAttr('disabled');
            }
            console.log("success")
        }).fail(function () {
            console.log("error")
        }).always(function () {
            console.log("complete")
        });
    });

    $("#register-province").change(function (e) {
        e.preventDefault();
        var selectedValue = $(this).val();
        var manualInput = $("#register-province-manual");

        if (selectedValue === 'other') {
            manualInput.show();
            manualInput.attr('required', true);
            manualInput.attr('name', 'province_manual'); // Add name attribute
            $(this).removeAttr('required'); // Remove required from select
            // Ensure 'Localidad' remains enabled
            $("#register-destination").removeAttr('disabled'); 
        } else {
            manualInput.hide();
            manualInput.removeAttr('required');
            manualInput.removeAttr('name'); // Remove name attribute
            manualInput.val(''); // Clear manual input value
            $(this).attr('required', true); // Add required back to select
            // Ensure 'Localidad' is enabled if a valid province is selected
            if (selectedValue) {
                $("#register-destination").removeAttr('disabled');
            }
        }
    });
</script>