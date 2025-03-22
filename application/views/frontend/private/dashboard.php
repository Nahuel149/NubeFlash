<section class="container_main">
    <div class="container">
        <h3>Bienvenido a Nube Flash <?php echo $this->session->userdata('name'); ?></h3>
        <p class="text-muted">Accedé rápidamente a todas las funciones de tu cuenta</p>
        <br>
        <div class="row">
            <!-- Mi Perfil Card -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="<?php echo base_url('assets/public/flash_naranja.png'); ?>" class="tam-icon mr-2" alt="Perfil"/>
                            <h5 class="card-title mb-0">Mi Perfil</h5>
                        </div>
                        <p class="card-text">Gestiona tu información personal y datos de contacto.</p>
                        <a href="<?php echo base_url('mi-perfil'); ?>" class="btn btn-primary">Ir a Mi Perfil</a>
                    </div>
                </div>
            </div>

            <!-- Mis Pedidos Card -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="<?php echo base_url('assets/public/flash_naranja.png'); ?>" class="tam-icon mr-2" alt="Pedidos"/>
                            <h5 class="card-title mb-0">Mis Pedidos</h5>
                        </div>
                        <p class="card-text">Revisa y gestiona todos tus pedidos en un solo lugar.</p>
                        <a href="<?php echo base_url('mis-pedidos'); ?>" class="btn btn-primary">Ver Pedidos</a>
                    </div>
                </div>
            </div>

            <!-- Tokens Card -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="<?php echo base_url('assets/public/flash_naranja.png'); ?>" class="tam-icon mr-2" alt="Token"/>
                            <h5 class="card-title mb-0">Tokens de API</h5>
                        </div>
                        <p class="card-text">Administra tus tokens de integración para la API.</p>
                        <a href="<?php echo base_url('mi-token'); ?>" class="btn btn-primary">Gestionar Tokens</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enlaces Rápidos -->
        <div class="card mt-4">
            <div class="card-body">
                <h5>Enlaces Rápidos</h5>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <a href="<?php echo base_url('apis-documentacion'); ?>" class="btn btn-outline-primary btn-block mb-2">
                            <i class="far fa-file-code"></i> Documentación API
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="<?php echo base_url('index'); ?>" class="btn btn-outline-primary btn-block mb-2">
                            <i class="fas fa-home"></i> Página Principal
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="<?php echo base_url('contacto'); ?>" class="btn btn-outline-primary btn-block mb-2">
                            <i class="far fa-envelope"></i> Contacto
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>   
</section>