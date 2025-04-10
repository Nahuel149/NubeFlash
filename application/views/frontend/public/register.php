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
                            <input type="text" id="register-province-manual" name="province_manual" class="form-control mt-2" placeholder="Ingrese su Departamento/Provincia" style="display: none;" autocomplete="address-level1-manual">
                        </div>
                        <div class="form-group">
                            <label for="register-destination">Localidad <span class="required">*</span></label>
                            <select id="register-destination" disabled required name="destination" class="form-control" autocomplete="address-level2">
                                <option value="">Seleccione una Localidad</option>
                            </select>
                            <input type="text" id="register-destination-manual" name="destination_manual" class="form-control mt-2" placeholder="Ingrese su localidad o barrio" style="display: none;" autocomplete="address-level2-manual">
                        </div>
                        <div class="form-group">
                            <label for="register-postal-code">Código Postal <span class="required">*</span></label>
                            <input id="register-postal-code" required type="text" name="postal_code_manual" class="form-control" placeholder="Código Postal" autocomplete="postal-code" />
                             <div class="invalid-feedback postal-code-error" style="display: none; color: #dc3545; font-size: 0.85em;">
                                El código postal es obligatorio
                            </div>
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

    // Get CSRF token name and hash
    var csrfTokenName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    
    // Reusable AJAX setup for CSRF
    $.ajaxSetup({
        beforeSend: function(xhr, settings) {
            if (!/^(GET|HEAD|OPTIONS|TRACE)$/i.test(settings.type) && settings.data) {
                // Append CSRF token if data is string
                if (typeof settings.data === 'string') {
                    settings.data += '&' + csrfTokenName + '=' + csrfHash;
                } 
                // If data is object, add CSRF token property
                else if (typeof settings.data === 'object') {
                    settings.data[csrfTokenName] = csrfHash;
                }
            }
        },
        complete: function(xhr) {
            // Update CSRF hash from response headers if available
            var newCsrfHash = xhr.getResponseHeader('X-CSRF-Token');
            if (newCsrfHash) {
                csrfHash = newCsrfHash;
                $('input[name="' + csrfTokenName + '"]').val(csrfHash);
            }
            // Or from JSON response if available
            try {
                var jsonResponse = JSON.parse(xhr.responseText);
                if (jsonResponse && jsonResponse.csrf_hash) {
                    csrfHash = jsonResponse.csrf_hash;
                    $('input[name="' + csrfTokenName + '"]').val(csrfHash);
                }
            } catch (e) {
                // Not a JSON response, ignore
            }
        }
    });

    $("#register-country").change(function (e) { 
        e.preventDefault();
        var country_id = $(this).val();
        $.ajax({
            type: "POST",
            // Assuming a similar endpoint exists under frontend/ajax (VERIFY THIS)
            url: base_url + 'frontend/ajax/getProvince',
            data: {
                country_id: country_id
                // CSRF token added by ajaxSetup
            },
            dataType: "JSON",
            beforeSend: function () {
                $("#register-province").attr('disabled','disabled').html('<option value="">Seleccione un Departamento</option>');
                $("#register-destination").attr('disabled','disabled').html('<option value="">Seleccione una Localidad</option>');
                $("#register-postal-code").val('');
                $("#register-province-manual").hide().removeAttr('required').removeAttr('name').val('');
                $("#register-destination-manual").hide().removeAttr('required').removeAttr('name').val('');
                $("#register-province").prop('disabled', false).attr('required', true);
            },
        }).done(function (data) {
            var htm = "<option value=''>Seleccione un Departamento</option>";
            if(data.success && data.provinces) {
                $.each(data.provinces, function (index, value) { 
                     htm += "<option value='"+value.province_id+"'>"+value.name+"</option>";
                });
                htm += "<option value='other'>-- Otro --</option>";
                $("#register-province").html(htm).removeAttr('disabled');
            } else {
                console.error("Error fetching provinces:", data.message);
                 $("#register-province").html('<option value="">Error al cargar</option>');
            }
        }).fail(function (xhr, status, error) {
            console.error("AJAX Error fetching provinces:", status, error);
            $("#register-province").html('<option value="">Error de conexión</option>');
        });
    });

    $("#register-province").change(function (e) {
        e.preventDefault();
        var province_id = $(this).val();
        var manualProvinceInput = $("#register-province-manual");
        var destinationSelect = $("#register-destination");
        var manualDestinationInput = $("#register-destination-manual");
        var postalCodeInput = $("#register-postal-code");

        // Reset destination and postal code
        destinationSelect.attr('disabled','disabled').html('<option value="">Seleccione una Localidad</option>');
        manualDestinationInput.hide().removeAttr('required').removeAttr('name').val('');
        postalCodeInput.val('').removeAttr('required');
        destinationSelect.removeAttr('style'); // Remove inline styles if any

        if (province_id === 'other') {
            manualProvinceInput.show().attr('required', true).attr('name', 'province_manual');
            $(this).removeAttr('required'); // Select is no longer required
            
            // Set destination to 'other' and configure for manual input
            destinationSelect.html('<option value="other" selected>-- Otro --</option>');
            destinationSelect.val('other');
            destinationSelect.attr('name', 'destination').attr('required', true);
            destinationSelect.removeAttr('disabled'); // Keep it enabled but hidden for submission
             // Use CSS to hide while keeping it in flow for submission
            destinationSelect.css({
                'position': 'absolute', 'opacity': '0', 'pointer-events': 'none', 'z-index': '-1'
            });

            manualDestinationInput.show().attr('required', true).attr('name', 'destination_manual');
            postalCodeInput.attr('required', true);
            console.log('Manual province selected. Destination set to other.');

        } else if (province_id) {
            manualProvinceInput.hide().removeAttr('required').removeAttr('name').val('');
            $(this).attr('required', true); // Select is required

            // Fetch destinations for the selected province
            $.ajax({
                type: "POST",
                 // Assuming a similar endpoint exists under frontend/ajax (VERIFY THIS)
                url: base_url + 'frontend/ajax/getDestination',
                data: { 
                    province_id: province_id
                    // CSRF token added by ajaxSetup
                },
                dataType: "JSON",
                beforeSend: function() {
                    destinationSelect.attr('disabled', 'disabled').html('<option value="">Cargando...</option>');
                }
            }).done(function(data) {
                var htm = "<option value=''>Seleccione una Localidad</option>";
                if (data.success && data.destinations) {
                    $.each(data.destinations, function(index, value) {
                        htm += "<option value='" + value.destination_id + "' data-code='" + value.postal_code + "'>" + value.name + "</option>";
                    });
                     htm += "<option value='other'>-- Otro --</option>";
                    destinationSelect.html(htm).removeAttr('disabled').attr('name', 'destination').attr('required', true);
                } else {
                    console.error("Error fetching destinations:", data.message);
                    destinationSelect.html('<option value="">Error al cargar</option>').removeAttr('disabled');
                     // Still add Other option even on error?
                    destinationSelect.append("<option value='other'>-- Otro --</option>"); 
                }
            }).fail(function(xhr, status, error) {
                console.error("AJAX Error fetching destinations:", status, error);
                 destinationSelect.html('<option value="">Error de conexión</option>').removeAttr('disabled');
                 // Still add Other option even on error?
                 destinationSelect.append("<option value='other'>-- Otro --</option>"); 
            });
        } else {
             // No province selected (or invalid)
             manualProvinceInput.hide().removeAttr('required').removeAttr('name').val('');
             $(this).attr('required', true);
        }
    });

    // Destination change handler
    $("#register-destination").change(function (e) {
        e.preventDefault();
        var destination_id = $(this).val();
        var manualDestinationInput = $("#register-destination-manual");
        var postalCodeInput = $("#register-postal-code");

        if (destination_id === 'other') {
            manualDestinationInput.show().attr('required', true).attr('name', 'destination_manual');
            postalCodeInput.attr('required', true).val(''); // Require and clear postal code
             // Ensure the select itself still has the name attribute for submission
            $(this).attr('name', 'destination').attr('required', true); 
            console.log('Manual destination selected.');
        } else {
            manualDestinationInput.hide().removeAttr('required').removeAttr('name').val('');
            postalCodeInput.removeAttr('required'); // Postal code not strictly required if selected from list
             // Set postal code if available from selected destination
            var postal_code = $("#register-destination option:selected").data("code");
            if(postal_code) {
                postalCodeInput.val(postal_code);
            } else {
                postalCodeInput.val('');
            }
        }
    });

    // Form submission validation
    $('form').on('submit', function(e) {
        // Clear previous postal code errors
        $('#register-postal-code').removeClass('is-invalid');
        $('.postal-code-error').hide();

        // Check if destination is "other" and validate postal code
        if ($('#register-destination').val() === 'other') {
            const postalCode = $('#register-postal-code').val().trim();
            if (!postalCode) {
                e.preventDefault(); // Stop submission
                $('#register-postal-code').addClass('is-invalid');
                $('.postal-code-error').show();
                alert('El código postal es obligatorio cuando se ingresa una localidad manual.'); // Also show an alert
                return false;
            }
             // Ensure destination select has name attribute
            if ($('#register-destination').attr('name') !== 'destination') {
                 console.warn('Correcting missing name attribute on destination select during submit.');
                 $('#register-destination').attr('name', 'destination');
             }
        }
        
        // Add password confirmation check if needed
        const password = $('#register-password').val();
        const confirmPassword = $('#register-password-confirm').val();
        if (password !== confirmPassword) {
             e.preventDefault(); // Stop submission
             alert('Las contraseñas no coinciden.');
             // Optionally add visual feedback
             $('#register-password, #register-password-confirm').addClass('is-invalid');
             return false;
        }

        // Additional validation for password complexity can be added here if backend validation isn't sufficient
        // Example using regex (similar to backend):
        const passwordRegex = /^(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/;
        if (password && !passwordRegex.test(password)) {
             e.preventDefault();
             alert('La contraseña no cumple con los requisitos: 8+ caracteres, 1 mayúscula, 1 símbolo (!@#$%^&*).');
             $('#register-password').addClass('is-invalid');
             return false;
        }
        
    });

</script>