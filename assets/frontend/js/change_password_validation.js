jQuery(document).ready(function($) {
    var currentPasswordField = $('#current_pass');
    var newPasswordField = $('#pass');
    var repeatPasswordField = $('#pass2');
    
    var feedbackCurrent = $('<div id="current-password-feedback" style="margin-top: 5px;"></div>');
    var feedbackNew = $('<div id="new-password-feedback" style="margin-top: 5px;"></div>');
    var feedbackRepeat = $('<div id="repeat-password-feedback" style="margin-top: 5px;"></div>');
    
    // Replace existing feedback divs if they exist
    $('#current-password-feedback').replaceWith(feedbackCurrent);
    newPasswordField.after(feedbackNew);
    repeatPasswordField.after(feedbackRepeat);

    var passwordRegex = /^(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/;
    
    // Disable new password fields initially until current password is validated
    newPasswordField.prop('disabled', true);
    repeatPasswordField.prop('disabled', true);
    
    function validateCurrentPassword() {
        var currentPassword = currentPasswordField.val();
        if (currentPassword.length > 0) {
            // Check if current password is valid via AJAX
            $.ajax({
                type: "POST",
                url: base_url + 'frontend/ajax/validateCurrentPassword',
                data: {
                    current_password: currentPassword,
                    [csrf_token_name]: csrf_hash
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.valid) {
                        feedbackCurrent.text('Contraseña actual válida.').css('color', 'green');
                        newPasswordField.prop('disabled', false);
                        repeatPasswordField.prop('disabled', false);
                    } else {
                        feedbackCurrent.text('Contraseña actual incorrecta.').css('color', 'red');
                        newPasswordField.prop('disabled', true);
                        repeatPasswordField.prop('disabled', true);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error validating password:", error);
                    feedbackCurrent.text('Error al validar la contraseña actual.').css('color', 'red');
                }
            });
        } else {
            feedbackCurrent.text('');
            newPasswordField.prop('disabled', true);
            repeatPasswordField.prop('disabled', true);
        }
    }

    function validateNewPassword() {
        var password = newPasswordField.val();
        var feedbackMessage = '';
        var feedbackColor = 'red';
        if (passwordRegex.test(password)) {
            feedbackMessage = 'Contraseña válida.';
            feedbackColor = 'green';
        } else {
            feedbackMessage = 'La nueva contraseña debe tener: ';
            var errors = [];
            if (password.length < 8) errors.push('al menos 8 caracteres');
            if (!/[A-Z]/.test(password)) errors.push('1 letra mayúscula');
            if (!/[!@#$%^&*]/.test(password)) errors.push('1 símbolo (por ejemplo, !@#$%^&*)');
            feedbackMessage += errors.join(', ') + '.';
        }
        feedbackNew.text(feedbackMessage).css('color', feedbackColor);
        validateRepeatPassword();
    }

    function validateRepeatPassword() {
        var newPass = newPasswordField.val();
        var repeatPass = repeatPasswordField.val();
        var feedbackMessage = '';
        var feedbackColor = 'red';
        if (newPass === repeatPass && newPass !== '') {
            feedbackMessage = 'Las contraseñas coinciden.';
            feedbackColor = 'green';
        } else if (repeatPass !== '') {
            feedbackMessage = 'Las contraseñas no coinciden.';
        }
        feedbackRepeat.text(feedbackMessage).css('color', feedbackColor);
    }

    // Add debounce to avoid too many AJAX requests
    var debounceTimer;
    currentPasswordField.on('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(validateCurrentPassword, 500);
    });
    
    newPasswordField.on('input', validateNewPassword);
    repeatPasswordField.on('input', validateRepeatPassword);
}); 