<a href="#" id="back-to-top" class="btn btn-warning btn-lg btn-back-top"><i class="fa fa-angle-up"></i></a>
<footer>
	<div class="container pl-5 pr-5 pl-lg-2 pr-lg-2">
		<div class="row align-items-center">
			<div class="col-lg-4 d-none d-sm-none d-lg-block d-md-none">
				<div class="col-md-12">
					<img height="50" src="<?php echo base_url('assets/public/logo_nube.png') ?>">
				</div>
			</div>
			<div class="col-md-12 d-block d-sm-block d-lg-none d-md-block">
				<div class="col-md-12 text-center">
					<img height="50" src="<?php echo base_url('assets/public/logo_nube.png') ?>">
				</div>
			</div>
			<div class="col-lg-4 d-none d-sm-none d-lg-block d-md-none mt-1">
				<div class="row">
					<div class="col-md-6">
						<a href="<?php echo base_url('politicas-pdf') ?>" target="_blank"><p>política de privacidad</p></a>
					</div>
					<div class="col-md-6">
						<a href="<?php echo base_url('terminos-pdf') ?>" target="_blank"><p>términos y condiciones</p></a>
					</div>
				</div>
			</div>
			<div class="col-md-12 text-center d-block d-sm-block d-lg-none d-md-block mt-2">
				<div class="col-md-12 mt-2">
					<a href="<?php echo base_url('politicas-pdf') ?>" target="_blank"><p>política de privacidad</p></a>
				</div>
				<div class="col-md-12">
					<a href="<?php echo base_url('terminos-pdf') ?>" target="_blank"><p>términos y condiciones</p></a>
				</div>
			</div>
			<div class="col-lg-3 text-center d-none d-sm-none d-lg-block d-md-none align-self-center">
				<ul class="list-inline m-0">
					<?php if (!empty($configuracion['facebook'])): ?>
						<li class="list-inline-item">
							<a href="<?php echo $configuracion['facebook'] ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
						</li>
					<?php endif ?>
					<?php if (!empty($configuracion['instagram'])): ?>
						<li class="list-inline-item">
							<a href="<?php echo $configuracion['instagram'] ?>" target="_blank"><i class="fab fa-instagram"></i></a>
						</li>
					<?php endif ?>
					<?php if (!empty($configuracion['youtube'])): ?>
						<li class="list-inline-item">
							<a href="<?php echo $configuracion['youtube'] ?>" target="_blank"><i class="fab fa-youtube"></i></a>
						</li>
					<?php endif ?>
				</ul>
			</div>
			<div class="col-md-12 text-center d-block d-sm-block d-lg-none d-md-block mt-2">
				<ul class="list-inline m-0">
					<?php if (!empty($configuracion['facebook'])): ?>
						<li class="list-inline-item">
							<a href="<?php echo $configuracion['facebook'] ?>" target="_blank"><i class="fab fa-facebook-f ml-0"></i></a>
						</li>
					<?php endif ?>
					<?php if (!empty($configuracion['instagram'])): ?>
						<li class="list-inline-item">
							<a href="<?php echo $configuracion['instagram'] ?>" target="_blank"><i class="fab fa-instagram"></i></a>
						</li>
					<?php endif ?>
					<?php if (!empty($configuracion['youtube'])): ?>
						<li class="list-inline-item">
							<a href="<?php echo $configuracion['youtube'] ?>" target="_blank"><i class="fab fa-youtube"></i></a>
						</li>
					<?php endif ?>
				</ul>
			</div>
			<div class="col-lg-1 col-md-12 p-0 text-center">
				<span>&copy;<?php echo date('Y') ?> NubeFlash</span>
			</div>
		</div>
	</div>
</footer>
<div id="modalLogin" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="#" onsubmit="submitLogin(event, this);">
                <div class="modal-header">
                    <h5 class="modal-title">Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <input type="hidden" name="enviar_form" value="1" />
					<div class="form-group">
						<label for="login-email">Usuario</label>
						<input type="text" name="email" id="login-email" class="form-control" autocomplete="username" />
					</div>
					<div class="form-group">
						<label for="login-password">Contraseña</label>
						<input type="password" name="password" id="login-password" class="form-control" autocomplete="current-password" />
					</div>
                    <div id="modalLoginMessage"></div>
					<div class="text-center">
						<a href="<?php echo base_url('registro'); ?>">Registrarse</a>
					</div>
                </div>
                <div class="modal-footer justify-content-center">
                    <div class="col-md-12">
						<button type="submit" class="btn btn-primary rounded-pill btn-block">Ingresar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>