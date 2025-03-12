/**
 * Password Validation for Registration Form
 * Validación de contraseña para el formulario de registro
 * 
 * This script provides real-time feedback for password fields
 * Requirements:
 * - At least 8 characters
 * - At least 1 capital letter (A-Z)
 * - At least 1 symbol (e.g., !@#$%^&*)
 */
$(document).ready(function() {
    // Find the password field
    var passwordField = $('input[name="password"]');
    var isPasswordValid = false;
    
    // Apply capitalization to password fields (first letter only)
    passwordField.css('text-transform', 'capitalize');
    $('input[name="re-password"]').css('text-transform', 'capitalize');
    
    // Create feedback div if it doesn't exist
    if ($('#password-feedback').length === 0) {
        var feedbackDiv = $('<div id="password-feedback" style="margin-top: 5px;"></div>');
        passwordField.after(feedbackDiv);
    } else {
        var feedbackDiv = $('#password-feedback');
    }
    
    // Remove browser's default validation to avoid duplicate exclamation marks
    passwordField.attr('novalidate', true);
    
    // Password validation regex
    var passwordRegex = /^(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/;
    
    // Create tooltip content div once
    var tooltipContent = 'La contraseña debe tener:<br>- Al menos 8 caracteres<br>- Al menos 1 letra mayúscula<br>- Al menos 1 símbolo (ej: !@#$%^&*)';
    
    // Ensure password field has appropriate styling for the tooltip positioning
    passwordField.parent().css('position', 'relative');
    
    // Helper function to show tooltip
    function showPasswordTooltip() {
        // Remove any existing tooltip icon and tooltip
        hidePasswordTooltip();
        
        // Create the tooltip icon
        var tooltipHtml = '<div id="password-tooltip-icon" style="position: absolute; right: 10px; top: 50%; transform: translateY(15%); cursor: pointer; z-index: 1000;">' +
                          '<i class="fas fa-exclamation-circle" style="color: #dc3545; font-size: 16px;"></i>' +
                          '</div>';
        
        // Insert it after the password field
        passwordField.after(tooltipHtml);
        
        // Add direct event listeners for mouseenter and mouseleave
        $('#password-tooltip-icon').on('mouseenter', function() {
            // Remove any existing tooltip
            $('.custom-tooltip').remove();
            
            // Create the tooltip popup with high z-index
            var tooltipPopup = $('<div class="custom-tooltip" style="position: absolute; right: -280px; top: -30px; width: 270px; background-color: #333; color: white; padding: 10px; border-radius: 4px; z-index: 2000; font-size: 13px; line-height: 1.4; box-shadow: 0 2px 5px rgba(0,0,0,0.3);">' + tooltipContent + '</div>');
            
            // Append to tooltip icon
            $(this).append(tooltipPopup);
            
            // Make sure tooltip is visible and above other elements
            tooltipPopup.css({
                'display': 'block',
                'pointer-events': 'none'
            });
        });
        
        $('#password-tooltip-icon').on('mouseleave', function() {
            // Remove tooltip when mouse leaves
            $('.custom-tooltip').remove();
        });
    }
    
    // Helper function to hide tooltip
    function hidePasswordTooltip() {
        $('#password-tooltip-icon').remove();
        $('.custom-tooltip').remove();
    }
    
    // Function to validate password and show feedback
    function validatePassword() {
        var password = passwordField.val();
        var feedbackMessage = '';
        var feedbackColor = 'red';
        
        if (password.length === 0) {
            // Empty password field
            feedbackDiv.text('').hide();
            passwordField.removeClass('is-valid is-invalid');
            isPasswordValid = false;
            
            // Hide the tooltip
            hidePasswordTooltip();
            return;
        }
        
        if (passwordRegex.test(password)) {
            // All requirements met
            feedbackMessage = 'Contraseña válida.';
            feedbackColor = 'green';
            passwordField.removeClass('is-invalid').addClass('is-valid');
            isPasswordValid = true;
            
            // Hide the tooltip
            hidePasswordTooltip();
        } else {
            // Some requirements not met
            feedbackMessage = 'La contraseña debe tener: ';
            var errors = [];
            
            if (password.length < 8) {
                errors.push('al menos 8 caracteres');
            }
            
            if (!/[A-Z]/.test(password)) {
                errors.push('1 letra mayúscula');
            }
            
            if (!/[!@#$%^&*]/.test(password)) {
                errors.push('1 símbolo (por ejemplo, !@#$%^&*)');
            }
            
            feedbackMessage += errors.join(', ') + '.';
            passwordField.removeClass('is-valid').addClass('is-invalid');
            isPasswordValid = false;
            
            // Always show the tooltip icon when password is invalid
            showPasswordTooltip();
        }
        
        // Display feedback
        feedbackDiv.text(feedbackMessage).css('color', feedbackColor).show();
        
        // If we're validating password, also re-validate confirm password
        if (confirmField.length > 0 && confirmField.val()) {
            validateConfirmPassword();
        }
    }
    
    // Validate on input and initial load
    passwordField.on('input', validatePassword);
    
    // Also trigger validation when clicking into or out of the field
    passwordField.on('focus blur', validatePassword);
    
    // Also validate the confirm password field
    var confirmField = $('input[name="re-password"]');
    
    if (confirmField.length > 0) {
        // Remove browser's default validation for confirm field
        confirmField.attr('novalidate', true);
        
        // Create feedback div for confirm password
        if ($('#confirm-password-feedback').length === 0) {
            var confirmFeedbackDiv = $('<div id="confirm-password-feedback" style="margin-top: 5px;"></div>');
            confirmField.after(confirmFeedbackDiv);
        } else {
            var confirmFeedbackDiv = $('#confirm-password-feedback');
        }
        
        // Function to validate password confirmation
        function validateConfirmPassword() {
            var password = passwordField.val();
            var confirmPassword = confirmField.val();
            
            if (confirmPassword.length === 0) {
                confirmFeedbackDiv.text('').hide();
                confirmField.removeClass('is-valid is-invalid');
                return;
            }
            
            if (password === confirmPassword && isPasswordValid) {
                // Only show as valid if passwords match AND main password is valid
                confirmFeedbackDiv.text('Las contraseñas coinciden.').css('color', 'green').show();
                confirmField.removeClass('is-invalid').addClass('is-valid');
            } else {
                // Show specific error message
                if (password !== confirmPassword) {
                    confirmFeedbackDiv.text('Las contraseñas no coinciden.').css('color', 'red').show();
                } else {
                    confirmFeedbackDiv.text('La contraseña principal no cumple con los requisitos.').css('color', 'red').show();
                }
                confirmField.removeClass('is-valid').addClass('is-invalid');
            }
        }
        
        // Validate confirm password on input
        confirmField.on('input', validateConfirmPassword);
        
        // Also validate on focus/blur
        confirmField.on('focus blur', validateConfirmPassword);
    }
    
    // Run initial validation if the fields have values (e.g., after page refresh)
    if (passwordField.val()) {
        validatePassword();
    }
    
    if (confirmField.length > 0 && confirmField.val()) {
        validateConfirmPassword();
    }
    
    // Override default form validation to use our custom validation
    $('form').on('submit', function(e) {
        // Re-validate the password
        validatePassword();
        
        // If password is not valid, prevent submission
        if (!isPasswordValid) {
            e.preventDefault();
            return false;
        }
    });
    
    // Add additional CSS for validation styling
    $('<style>')
        .prop('type', 'text/css')
        .html(`
            .is-valid {
                border-color: #28a745 !important;
                padding-right: calc(1.5em + .75rem) !important;
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e") !important;
                background-repeat: no-repeat !important;
                background-position: right calc(.375em + .1875rem) center !important;
                background-size: calc(.75em + .375rem) calc(.75em + .375rem) !important;
            }
            .is-invalid {
                border-color: #dc3545 !important; 
                background-image: none !important;
                padding-right: 30px !important; /* Make room for our custom icon */
            }
            /* Hide browser's default validation popup */
            input:invalid {
                box-shadow: none;
            }
            /* Ensure tooltip is visible */
            .custom-tooltip {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
            /* Capitalize first letter of password fields */
            input[name="password"], input[name="re-password"] {
                text-transform: capitalize !important;
            }
        `)
        .appendTo('head');
}); 