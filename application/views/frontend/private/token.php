<section class="container_main">
    <div class="container">
        <h3>Token <span data-toggle="tooltip" data-placement="bottom" title="Tendrás 2 tokens de integración, uno para producción y el otro para testing." class="text-warning far fa-question-circle"></span></h3>
        <!-- <h6 class="mt-4"></h6> -->
        <br>
        <div class="card mb-5">
            <div class="card-body">
                <strong>Usuario:</strong> <span><?php echo $customer->email ?></span></br>
                <?php if (!empty($tokens)): ?>
                    <div class="mt-3">
                        <h5>Tokens Activos:</h5>
                        <?php foreach ($tokens as $token): ?>
                            <div class="border-bottom py-3">
                                <div class="mb-2">
                                    <strong>Token Producción:</strong>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="<?php echo $token->token ?>" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary copy-btn" type="button" title="Copiar Token">
                                                <i class="far fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <strong>Token Desarrollo:</strong>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="<?php echo $token->token_dev ?>" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary copy-btn" type="button" title="Copiar Token">
                                                <i class="far fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <small class="text-muted">Creado: <?php echo date('d/m/Y H:i', strtotime($token->created_at)) ?></small>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning mt-3" role="alert">
                        No tienes ningún token activo en este momento. Por favor, contacta con el administrador para obtener un nuevo token.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>   
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add click event listeners to all copy buttons
    document.querySelectorAll('.copy-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            // Find the input field within the same input group
            var input = this.closest('.input-group').querySelector('input');
            
            // Select the text
            input.select();
            input.setSelectionRange(0, 99999); // For mobile devices
            
            // Copy the text
            document.execCommand('copy');
            
            // Show feedback
            var originalTitle = this.getAttribute('title');
            this.setAttribute('title', '¡Copiado!');
            setTimeout(() => {
                this.setAttribute('title', originalTitle);
            }, 1500);
        });
    });
});
</script>