<section class="login">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0">Iniciar Sesión</h4>
                    </div>
                    <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger m-3 animated fadeInDown">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>              
                        <?php echo $this->session->flashdata('error') ?><br>         
                    </div>
                    <?php endif ?>
                    <div class="card-body p-4">
                        <form action="<?php echo current_url(); ?>" method="POST">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                            <div class="form-group">
                                <label for="login-email">Usuario</label>
                                <input type="text" id="login-email" name="email" class="form-control" autocomplete="username" required />
                            </div>
                            <div class="form-group">
                                <label for="login-password">Contraseña</label>
                                <input type="password" id="login-password" name="password" class="form-control" autocomplete="current-password" required />
                            </div>
                            <div class="text-center mb-3">
                                <a href="<?php echo base_url('registro'); ?>">¿No tienes cuenta? Regístrate aquí</a>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary rounded-pill btn-block">Ingresar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>   
</section>