<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    var telefonoInput = document.getElementById('telefono');
    var celularInput = document.getElementById('celular');
    var emailInput = document.getElementById('email');
    var nombreInput = document.getElementById('nombre');
    var apellidoInput = document.getElementById('apellido');
    var erroresDiv = document.getElementById('errores');
    
    // Validation functions
    function validatePhoneField(input, fieldName) {
        var value = input.value;
        // Check if the value is empty
        if (!value) {
            input.classList.remove('invalid');
            input.classList.add('valid');
            clearErrors();
            return true;
        }
        
        // Check if the value starts with '+' and is followed by numbers only
        if (/^\+\d+$/.test(value)) {
            input.classList.remove('invalid');
            input.classList.add('valid');
            clearErrors();
            return true;
        }
        
        // Check if the value contains only numbers (when no '+' is present)
        if (/^\d+$/.test(value)) {
            input.classList.remove('invalid');
            input.classList.add('valid');
            clearErrors();
            return true;
        }
        
        input.classList.remove('valid');
        input.classList.add('invalid');
        showError(`El campo ${fieldName} debe contener solo números o comenzar con '+' seguido de números.`);
        return false;
    }
    
    function validateEmail(input) {
        if (input.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input.value)) {
            input.classList.remove('valid');
            input.classList.add('invalid');
            showError('El email ingresado no es válido.');
            return false;
        }
        input.classList.remove('invalid');
        input.classList.add('valid');
        clearErrors();
        return true;
    }
    
    function validateRequiredField(input, fieldName) {
        if (!input.value.trim()) {
            input.classList.remove('valid');
            input.classList.add('invalid');
            showError(`El campo ${fieldName} es obligatorio.`);
            return false;
        }
        input.classList.remove('invalid');
        input.classList.add('valid');
        clearErrors();
        return true;
    }
    
    // Error handling functions
    function showError(message) {
        erroresDiv.innerHTML = `<div class="alert alert-warning alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Error!</strong> ${message}
        </div>`;
    }
    
    function clearErrors() {
        erroresDiv.innerHTML = '';
    }
    
    // Helper function to handle phone input
    function handlePhoneInput(e) {
        var input = e.target;
        var value = input.value;
        var cursorPos = input.selectionStart;
        
        // Allow '+' only at the beginning
        if (value.includes('+') && !value.startsWith('+')) {
            // Remove all '+' and add it at the beginning if it was there
            value = value.replace(/\+/g, '');
            if (e.data === '+') {
                value = '+' + value;
            }
            input.value = value;
            // Adjust cursor position
            input.setSelectionRange(cursorPos, cursorPos);
        }
        
        // Remove any additional '+' symbols if there are more than one
        if ((value.match(/\+/g) || []).length > 1) {
            value = value.replace(/\+/g, '');
            if (value.length > 0) {
                value = '+' + value;
            }
            input.value = value;
            // Adjust cursor position
            input.setSelectionRange(cursorPos, cursorPos);
        }
    }
    
    // Function to handle keydown for phone fields
    function handlePhoneKeydown(e) {
        // Allow '+' only if it's at the beginning
        if (e.key === '+' && e.target.selectionStart > 0) {
            e.preventDefault();
        }
    }
    
    // Event listeners for validation
    if (telefonoInput) {
        telefonoInput.addEventListener('input', (e) => {
            handlePhoneInput(e);
            validatePhoneField(telefonoInput, 'Teléfono Fijo/Compañía');
        });
        telefonoInput.addEventListener('keydown', handlePhoneKeydown);
        telefonoInput.addEventListener('blur', () => validatePhoneField(telefonoInput, 'Teléfono Fijo/Compañía'));
    }
    
    if (celularInput) {
        celularInput.addEventListener('input', (e) => {
            handlePhoneInput(e);
            validatePhoneField(celularInput, 'Celular');
        });
        celularInput.addEventListener('keydown', handlePhoneKeydown);
        celularInput.addEventListener('blur', () => validatePhoneField(celularInput, 'Celular'));
    }
    
    if (emailInput) {
        emailInput.addEventListener('input', () => validateEmail(emailInput));
        emailInput.addEventListener('blur', () => validateEmail(emailInput));
    }
    
    if (nombreInput) {
        nombreInput.addEventListener('input', () => validateRequiredField(nombreInput, 'Nombre'));
        nombreInput.addEventListener('blur', () => validateRequiredField(nombreInput, 'Nombre'));
    }
    
    if (apellidoInput) {
        apellidoInput.addEventListener('input', () => validateRequiredField(apellidoInput, 'Apellido'));
        apellidoInput.addEventListener('blur', () => validateRequiredField(apellidoInput, 'Apellido'));
    }
    
    // Form submission validation
    document.querySelector('form').addEventListener('submit', function(e) {
        let isValid = true;
        
        if (nombreInput) {
            isValid = validateRequiredField(nombreInput, 'Nombre') && isValid;
        }
        
        if (apellidoInput) {
            isValid = validateRequiredField(apellidoInput, 'Apellido') && isValid;
        }
        
        if (telefonoInput && telefonoInput.value) {
            isValid = validatePhoneField(telefonoInput, 'Teléfono Fijo/Compañía') && isValid;
        }
        
        if (celularInput && celularInput.value) {
            isValid = validatePhoneField(celularInput, 'Celular') && isValid;
        }
        
        if (emailInput && emailInput.value) {
            isValid = validateEmail(emailInput) && isValid;
        }
        
        if (!isValid) {
            e.preventDefault();
        }
    });
});

// Function to delete user photo
function deleteFoto(id, tipo) {
    Swal.fire({
        title: '¿Desea eliminar la imagen?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url("backend/ajax/deleteFoto") ?>',
                data: {
                    id: id,
                    tipo: tipo,
                    <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            title: '¡Eliminada!',
                            text: 'La imagen ha sido eliminada correctamente',
                            icon: 'success',
                            confirmButtonColor: '#3085d6'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.message || 'Error al eliminar la foto',
                            icon: 'error',
                            confirmButtonColor: '#d33'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    let errorMessage = 'Error al eliminar la foto';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        title: 'Error',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonColor: '#d33'
                    });
                }
            });
        }
    });
}

// Update AJAX setup with proper CSRF handling
$.ajaxSetup({
    beforeSend: function(xhr) {
        xhr.setRequestHeader('X-CSRF-TOKEN', '<?php echo $this->security->get_csrf_hash(); ?>');
    },
    data: {
        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
    }
});

function validarSi(){
    var Si = $('#username').val();
    var url = '<?php echo base_url()."backend/users/validarSi/" ?>';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            username: Si,
            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
        },
        dataType: 'json',
        success: function(response){
            if(response.exists){
                Swal.fire({
                    title: 'Error',
                    text: 'El nombre de usuario ya existe',
                    icon: 'error'
                });
                $('#username').val('');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'Error al validar el usuario',
                icon: 'error'
            });
        }
    });
}

function validarEmail(){
    var email = $('#email').val();
    var url = '<?php echo base_url()."backend/users/validarEmail/" ?>';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            email: email,
            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
        },
        dataType: 'json',
        success: function(response){
            if(response.exists){
                Swal.fire({
                    title: 'Error',
                    text: 'El email ya existe',
                    icon: 'error'
                });
                $('#email').val('');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'Error al validar el email',
                icon: 'error'
            });
        }
    });
}
</script>