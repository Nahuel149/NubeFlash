<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="ibox">
    <div class="ibox-title">
        <h5>
            <i class="fas fa-key"></i> Tokens del Cliente: <?php echo $customer->social_reason; ?>
        </h5>
        <div class="ibox-tools">
            <?php if ($permisos_efectivos->insert): ?>
                <a href="<?php echo base_url('ecommerce/customers/generate_token/'.$customer->customer_id); ?>" 
                   class="btn btn-primary btn-xs">
                    <i class="fas fa-plus"></i> Generar Nuevo Token
                </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="ibox-content">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $this->session->flashdata('success'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $this->session->flashdata('error'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Token</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>Fecha de Creación</th>
                        <th>Última Actualización</th>
                        <?php if ($permisos_efectivos->delete): ?>
                            <th>Acciones</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($tokens)): ?>
                        <?php foreach ($tokens as $token): ?>
                            <tr>
                                <td>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm token-value" 
                                               value="<?php echo $token->token; ?>" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary btn-sm copy-token" 
                                                    type="button" title="Copiar Token">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <?php if ($token->token_dev): ?>
                                        <small class="text-muted">
                                            Dev Token: <?php echo $token->token_dev; ?>
                                        </small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($token->token_dev): ?>
                                        <span class="badge badge-info">Producción + Desarrollo</span>
                                    <?php else: ?>
                                        <span class="badge badge-primary">Producción</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($token->active): ?>
                                        <span class="badge badge-success">Activo</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Revocado</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($token->created_at)); ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($token->updated_at)); ?></td>
                                <?php if ($permisos_efectivos->delete): ?>
                                    <td>
                                        <?php if ($token->active): ?>
                                            <a href="<?php echo base_url('ecommerce/customers/revoke_token/'.$token->token_id); ?>" 
                                               class="btn btn-danger btn-sm" 
                                               onclick="return confirm('¿Está seguro que desea revocar este token?');">
                                                <i class="fas fa-ban"></i> Revocar
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">
                                No hay tokens registrados para este cliente.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="ibox-footer">
        <a href="<?php echo base_url('ecommerce/customers'); ?>" class="btn btn-default">
            <i class="fas fa-arrow-left"></i> Volver a Clientes
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize copy buttons
    document.querySelectorAll('.copy-token').forEach(function(button) {
        button.addEventListener('click', function() {
            var input = this.closest('.input-group').querySelector('.token-value');
            input.select();
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