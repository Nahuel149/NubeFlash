<div class="col-lg-12">
    <div class="element-box">

        <?php echo form_open("backend/auth/change_password");?>
           <div class="col-md-6">
            <div id="error-container">
                <?php if ($this->session->flashdata('message')){ ?>
                    <?php print_r($this->session->flashdata('message')) ?>
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="old"><?php echo "Password actual";?><span class="required">*</span></label>
                <?php echo form_input($old_password);?>
                <div id="old-feedback" class="validation-message"></div>
            </div>
            <div class="form-group">
                <label for="new"><?php echo "Nuevo password";?><span class="required">*</span></label>
                <?php echo form_input($new_password);?>
                <div id="new-feedback" class="validation-message"></div>
            </div>
            <div class="form-group">
                <label for="new_confirm"><?php echo "Confirmar nuevo password";?><span class="required">*</span></label>
                <?php echo form_input($new_password_confirm);?>
                <div id="new-confirm-feedback" class="validation-message"></div>
            </div>

            <?php echo form_input($user_id);?>
            <?php echo form_button(array(
                'type' => 'submit',
                'value' => 'Guardar',
                'name' => 'submit',
                'class' => 'btn btn-success',
                'id' => 'submit-btn'
            ), "Guardar"); ?> 
          </div>

        <?php echo form_close();?>

    </div>
</div>
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    var oldInput = document.getElementById('old');
    var newInput = document.getElementById('new');
    var confirmInput = document.getElementById('new_confirm');
    var submitBtn = document.getElementById('submit-btn');
    var errorContainer = document.getElementById('error-container');
    
    var oldFeedback = document.getElementById('old-feedback');
    var newFeedback = document.getElementById('new-feedback');
    var confirmFeedback = document.getElementById('new-confirm-feedback');
    
    // Password validation regex
    var passwordRegex = /^(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/;
    
    function validateOldPassword() {
        if (!oldInput.value) {
            oldInput.classList.remove('valid');
            oldInput.classList.add('invalid');
            oldFeedback.textContent = 'Este campo es obligatorio.';
            oldFeedback.style.color = '#dc3545';
            return false;
        }
        oldInput.classList.remove('invalid');
        oldInput.classList.add('valid');
        oldFeedback.textContent = '';
        return true;
    }
    
    function validateNewPassword() {
        if (!newInput.value) {
            newInput.classList.remove('valid');
            newInput.classList.add('invalid');
            newFeedback.textContent = 'Este campo es obligatorio.';
            newFeedback.style.color = '#dc3545';
            return false;
        }
        
        if (!passwordRegex.test(newInput.value)) {
            newInput.classList.remove('valid');
            newInput.classList.add('invalid');
            newFeedback.textContent = 'La contraseña debe tener al menos 8 caracteres, 1 letra mayúscula y 1 símbolo (por ejemplo, !@#$%^&*).';
            newFeedback.style.color = '#dc3545';
            return false;
        }
        
        newInput.classList.remove('invalid');
        newInput.classList.add('valid');
        newFeedback.textContent = 'Contraseña válida.';
        newFeedback.style.color = '#28a745';
        return true;
    }
    
    function validateConfirmPassword() {
        if (!confirmInput.value) {
            confirmInput.classList.remove('valid');
            confirmInput.classList.add('invalid');
            confirmFeedback.textContent = 'Este campo es obligatorio.';
            confirmFeedback.style.color = '#dc3545';
            return false;
        }
        
        if (confirmInput.value !== newInput.value) {
            confirmInput.classList.remove('valid');
            confirmInput.classList.add('invalid');
            confirmFeedback.textContent = 'Las contraseñas no coinciden.';
            confirmFeedback.style.color = '#dc3545';
            return false;
        }
        
        confirmInput.classList.remove('invalid');
        confirmInput.classList.add('valid');
        confirmFeedback.textContent = 'Las contraseñas coinciden.';
        confirmFeedback.style.color = '#28a745';
        return true;
    }
    
    // Add event listeners
    oldInput.addEventListener('input', function() {
        validateOldPassword();
        // Clear server-side error when user starts typing
        errorContainer.innerHTML = '';
    });
    oldInput.addEventListener('blur', validateOldPassword);
    
    newInput.addEventListener('input', function() {
        validateNewPassword();
        if (confirmInput.value) {
            validateConfirmPassword();
        }
        // Clear server-side error when user starts typing
        errorContainer.innerHTML = '';
    });
    newInput.addEventListener('blur', validateNewPassword);
    
    confirmInput.addEventListener('input', function() {
        validateConfirmPassword();
        // Clear server-side error when user starts typing
        errorContainer.innerHTML = '';
    });
    confirmInput.addEventListener('blur', validateConfirmPassword);
    
    // Form submission
    document.querySelector('form').addEventListener('submit', function(e) {
        var isOldValid = validateOldPassword();
        var isNewValid = validateNewPassword();
        var isConfirmValid = validateConfirmPassword();
        
        if (!isOldValid || !isNewValid || !isConfirmValid) {
            e.preventDefault();
            // Clear any server-side errors when client-side validation fails
            errorContainer.innerHTML = '';
        }
    });
});
</script>