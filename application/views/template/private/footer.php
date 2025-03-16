<footer class="align-self-center">
  <div class="col-md-12 text-right">
    <img src="<?php echo base_url('assets/public/logo_nube.png') ?>">
  </div>
</footer>

<!-- Password Change Modal -->
<div class="modal fade" id="cambiarpass" tabindex="-1" role="dialog" aria-labelledby="cambiarPassLabel">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cambiarPassLabel">Cambiar contraseña</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="password-change-form">
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
          <div class="form-group">
            <label for="current_pass"><strong>Contraseña actual:</strong></label>
            <input type="password" class="form-control" name="current_pass" id="current_pass" autocomplete="current-password">
            <div id="current-password-feedback" class="text-danger mt-1"></div>
          </div>
          <div class="form-group">
            <label for="pass"><strong>Contraseña nueva:</strong></label>
            <input type="password" class="form-control" name="pass" id="pass" autocomplete="new-password" disabled>
            <div id="new-password-feedback" class="text-danger mt-1"></div>
            <small class="form-text text-muted">La contraseña debe tener al menos 8 caracteres, 1 letra mayúscula y 1 símbolo (por ejemplo, !@#$%^&*).</small>
          </div>
          <div class="form-group">
            <label for="pass2"><strong>Repetir contraseña:</strong></label>
            <input type="password" class="form-control" name="pass2" id="pass2" autocomplete="new-password" disabled>
            <div id="repeat-password-feedback" class="text-danger mt-1"></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btn-change-password" onclick="cambioPassword(this)">Guardar</button>
      </div>
    </div>
  </div>
</div>

<script>
// Add client-side validation for the password change form
$(document).ready(function() {
    // Initialize modal
    if (typeof $.fn.modal === 'function') {
        $('#cambiarpass').modal({
            show: false,
            backdrop: 'static',
            keyboard: false
        });
    }
    
    // Enable validation on current password field
    $('#current_pass').on('input', function() {
        if ($(this).val().length > 0) {
            $('#pass').prop('disabled', false);
            $('#current-password-feedback').text('');
        } else {
            $('#pass').prop('disabled', true);
            $('#pass2').prop('disabled', true);
            $('#current-password-feedback').text('Por favor, ingrese su contraseña actual.');
        }
    });
    
    // Enable validation on new password field
    $('#pass').on('input', function() {
        var password = $(this).val();
        var passwordRegex = /^(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/;
        
        if (password.length > 0) {
            $('#pass2').prop('disabled', false);
            
            if (!passwordRegex.test(password)) {
                $('#new-password-feedback').text('La contraseña debe cumplir con los requisitos de seguridad.');
                $('#new-password-feedback').css('color', 'red');
            } else {
                $('#new-password-feedback').text('Contraseña válida');
                $('#new-password-feedback').css('color', 'green');
            }
        } else {
            $('#pass2').prop('disabled', true);
            $('#new-password-feedback').text('');
        }
    });
    
    // Validate password confirmation
    $('#pass2').on('input', function() {
        if ($(this).val() !== $('#pass').val()) {
            $('#repeat-password-feedback').text('Las contraseñas no coinciden.');
            $('#repeat-password-feedback').css('color', 'red');
        } else {
            $('#repeat-password-feedback').text('Las contraseñas coinciden.');
            $('#repeat-password-feedback').css('color', 'green');
        }
    });
});
</script>