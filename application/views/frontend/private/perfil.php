<section class="container_main">
    <div class="container">
        <h3>Información de usuario</h3>
        <br>
        <div class="card mb-5">
            <div class="card-body">
                <form id="form-perfil" method="POST">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Email:</strong>
                                <input type="text" name="email" id="email" value="<?php echo $customer->email ?>" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <strong>Identificador Fiscal:</strong>
                                <input type="text" name="id_fiscal" id="id_fiscal" value="<?php echo $customer->fiscal_identifier ?>" class="form-control">
                                <small class="form-text text-muted">Entre 5 y 25 caracteres (números y símbolos permitidos)</small>
                            </div>
                            <div class="form-group">
                                <strong>Razón Social:</strong>
                                <input type="text" name="social_reason" id="social_reason" value="<?php echo $customer->social_reason ?>" class="form-control">
                                <small class="form-text text-muted">Entre 3 y 100 caracteres</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Nombre:</strong>
                                <input type="text" name="name" id="name" value="<?php echo $customer->person_contact ?>" class="form-control" required minlength="3" maxlength="100">
                                <small class="form-text text-muted">Entre 3 y 100 caracteres</small>
                            </div>
                            <div class="form-group">
                                <strong>Teléfono:</strong>
                                <input type="tel" name="telephone" id="telephone" value="<?php echo $customer->telephone ?>" class="form-control" pattern="[+]?[0-9]{10,15}" title="Formato: +XXXXXXXXXX (10-15 dígitos, puede incluir + al inicio)" required>
                                <small class="form-text text-muted">Ejemplo: +598XXXXXXXXXX</small>
                            </div>
                            <div class="form-group">
                                <strong>Dirección:</strong>
                                <textarea type="text" name="address" id="address" class="form-control" required minlength="5" maxlength="255"><?php echo $customer->address ?></textarea>
                                <small class="form-text text-muted">Entre 5 y 255 caracteres</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Horario de atención para recojo:</strong>
                                <input type="text" name="business_hours" id="business_hours" value="<?php echo $customer->business_hours ?>" class="form-control" required maxlength="100">
                                <small class="form-text text-muted">Ingrese su horario de atención (máximo 100 caracteres)</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" id="btnSubmit" class="btn btn-primary rounded-pill btn-padding-private button-profile">
                                <span class="button-text">GUARDAR</span>
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">¡Éxito!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Los datos han sido actualizados correctamente.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Ha ocurrido un error al actualizar los datos. Por favor, intente nuevamente.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    if (typeof $ !== 'undefined') {
        $('[data-toggle="tooltip"]').tooltip();
    }

    // Form validation and submission
    const form = document.getElementById('form-perfil');
    const btnSubmit = document.getElementById('btnSubmit');
    const buttonText = btnSubmit.querySelector('.button-text');
    const spinner = btnSubmit.querySelector('.spinner-border');

    // Input masking for telephone
    const telephoneInput = document.getElementById('telephone');
    telephoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^\d+]/g, '');
        if (value.length > 0 && !value.startsWith('+')) {
            value = '+' + value;
        }
        if (value.length > 16) {
            value = value.slice(0, 16);
        }
        e.target.value = value;
    });

    // Business hours formatting helper
    const businessHoursInput = document.getElementById('business_hours');
    businessHoursInput.addEventListener('input', function(e) {
        if (e.target.value.length > 100) {
            e.target.value = e.target.value.slice(0, 100);
        }
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Show loading state
        buttonText.textContent = 'GUARDANDO...';
        spinner.classList.remove('d-none');
        btnSubmit.disabled = true;

        // Prepare form data
        const formData = new FormData(form);

        // Send AJAX request
        fetch(window.location.href, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Reset button state
            buttonText.textContent = 'GUARDAR';
            spinner.classList.add('d-none');
            btnSubmit.disabled = false;

            // Show appropriate modal
            if (data.success) {
                $('#successModal').modal('show');
            } else {
                document.querySelector('#errorModal .modal-body').textContent = 
                    data.message || 'Ha ocurrido un error al actualizar los datos. Por favor, intente nuevamente.';
                $('#errorModal').modal('show');
            }

            // Update CSRF token if provided
            if (data.csrf_token_name && data.csrf_hash) {
                document.querySelector('input[name="' + data.csrf_token_name + '"]').value = data.csrf_hash;
            }
        })
        .catch(error => {
            // Reset button state
            buttonText.textContent = 'GUARDAR';
            spinner.classList.add('d-none');
            btnSubmit.disabled = false;

            // Show error modal
            $('#errorModal').modal('show');
        });
    });
});
</script>

<style>
.form-group {
    margin-bottom: 1.5rem;
}

.form-control:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

.form-text {
    margin-top: 0.25rem;
}

.button-profile {
    min-width: 120px;
}

.button-profile:disabled {
    cursor: not-allowed;
}

.spinner-border {
    margin-left: 8px;
}

/* Custom validation styles */
.form-control:valid {
    border-color: #28a745;
}

.form-control:invalid {
    border-color: #dc3545;
}

.form-control:valid:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.form-control:invalid:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

/* Tooltip enhancement */
.far.fa-question-circle {
    font-size: 1.1em;
    cursor: help;
}

/* Modal enhancements */
.modal-header {
    border-bottom: 2px solid #dee2e6;
}

.modal-footer {
    border-top: none;
}
</style>
