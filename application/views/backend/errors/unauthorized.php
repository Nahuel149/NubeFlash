<div class="error-container">
    <div class="error-content text-center">
        <h1 class="error-title">Acceso No Autorizado</h1>
        <div class="error-details">
            <p>Lo sentimos, no tiene permisos para acceder a esta página.</p>
            <p>Por favor, contacte al administrador si cree que esto es un error.</p>
        </div>
        <div class="error-actions">
            <a href="<?php echo base_url('backend/dashboard'); ?>" class="btn btn-primary">
                <i class="fas fa-home"></i> Volver al Dashboard
            </a>
            <a href="<?php echo base_url('backend/auth/logout'); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </div>
    </div>
</div>

<style>
.error-container {
    padding: 40px 20px;
    max-width: 600px;
    margin: 0 auto;
}

.error-content {
    background: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.error-title {
    color: #dc3545;
    margin-bottom: 20px;
    font-size: 2em;
}

.error-details {
    margin-bottom: 30px;
    color: #666;
}

.error-actions {
    display: flex;
    gap: 10px;
    justify-content: center;
}

.error-actions .btn {
    padding: 10px 20px;
}
</style> 