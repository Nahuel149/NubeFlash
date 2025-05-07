<!-- Back to top button -->
<a href="#" id="back-to-top" class="btn btn-primary rounded-circle shadow-sm" aria-label="Back to top"><i class="fa fa-angle-up"></i></a>

<!-- Footer -->
<footer class="footer-section py-5">
	<div class="container">
		<!-- Main Footer Content -->
		<div class="row mb-4">
			<!-- Logo and About Column -->
			<div class="col-lg-4 col-md-6 mb-4 mb-md-0">
				<div class="footer-logo mb-3">
					<img height="60" src="<?php echo base_url('assets/public/logo_nube.png') ?>" alt="NubeFlash Logo">
				</div>
				<p class="text-secondary mb-3">Ofrecemos herramientas integradas de eCommerce y servicios de entrega rápida. Desde su creación para la venta en línea, hasta el proceso de entrega de cualquier producto.</p>
				<!-- Social Media Links -->
				<ul class="list-inline social-links mb-0">
					<?php if (!empty($configuracion['facebook'])): ?>
						<li class="list-inline-item me-3">
							<a href="<?php echo $configuracion['facebook'] ?>" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
						</li>
					<?php endif ?>
					<?php if (!empty($configuracion['instagram'])): ?>
						<li class="list-inline-item me-3">
							<a href="<?php echo $configuracion['instagram'] ?>" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
						</li>
					<?php endif ?>
					<?php if (!empty($configuracion['youtube'])): ?>
						<li class="list-inline-item">
							<a href="<?php echo $configuracion['youtube'] ?>" target="_blank" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
						</li>
					<?php endif ?>
				</ul>
			</div>
			
			<!-- Quick Links Column -->
			<div class="col-lg-2 col-md-6 mb-4 mb-md-0">
				<h5 class="text-dark mb-4 footer-title">Enlaces rápidos</h5>
				<ul class="list-unstyled footer-links">
					<li class="mb-2"><a href="<?php echo base_url('index#section_aboutus') ?>">Sobre nosotros</a></li>
					<li class="mb-2"><a href="<?php echo base_url('index#section_service') ?>">Servicios</a></li>
					<li class="mb-2"><a href="<?php echo base_url('index#section_price') ?>">Precios</a></li>
					<li class="mb-2"><a href="<?php echo base_url('index#section_faqs') ?>">FAQs</a></li>
					<li class="mb-2"><a href="<?php echo base_url('index#section_contacto') ?>">Contacto</a></li>
				</ul>
			</div>
			
			<!-- Services Column -->
			<div class="col-lg-3 col-md-6 mb-4 mb-md-0">
				<h5 class="text-dark mb-4 footer-title">Nuestros servicios</h5>
				<ul class="list-unstyled footer-links">
					<li class="mb-2"><a href="<?php echo base_url('index#section_service') ?>">Envíos</a></li>
					<li class="mb-2"><a href="<?php echo base_url('index#section_service') ?>">Boxes</a></li>
					<li class="mb-2"><a href="<?php echo base_url('index#section_location') ?>">Donde estamos</a></li>
					<li class="mb-2"><a href="<?php echo base_url('index#section_delivery_time') ?>">Tiempos de entrega</a></li>
				</ul>
			</div>
			
			<!-- Contact Info Column -->
			<div class="col-lg-3 col-md-6">
				<h5 class="text-dark mb-4 footer-title">Información de contacto</h5>
				<ul class="list-unstyled footer-links contact-info">
					<li class="mb-3 d-flex align-items-start">
						<i class="fas fa-map-marker-alt me-3 text-primary" style="margin-top: 5px;"></i>
						<span><?php echo isset($configuracion['direccion_pie_pagina']) ? htmlspecialchars($configuracion['direccion_pie_pagina']) : 'Dirección no configurada'; ?></span>
					</li>
					<li class="mb-3 d-flex align-items-center">
						<i class="fas fa-phone-alt me-3 text-primary"></i>
						<span><?php echo isset($configuracion['telefono_pie_pagina']) ? htmlspecialchars($configuracion['telefono_pie_pagina']) : 'Teléfono no configurado'; ?></span>
					</li>
					<li class="mb-3 d-flex align-items-center">
						<i class="fas fa-envelope me-3 text-primary"></i>
						<span><?php echo isset($configuracion['email_pie_pagina']) ? htmlspecialchars($configuracion['email_pie_pagina']) : 'Email no configurado'; ?></span>
					</li>
				</ul>
			</div>
		</div>
		
		<!-- Legal Links -->
		<div class="row footer-bottom pt-4 mt-4 border-top">
			<div class="col-md-6 mb-2 mb-md-0">
				<p class="mb-0 text-secondary">&copy; 2021 NUBE FLASH. All rights reserved.</p>
			</div>
			<div class="col-md-6 text-md-end">
				<a href="<?php echo base_url('politicas-pdf') ?>" class="text-secondary me-3" target="_blank">Política de privacidad</a>
				<a href="<?php echo base_url('terminos-pdf') ?>" class="text-secondary" target="_blank">Términos y condiciones</a>
			</div>
		</div>
	</div>
</footer>

<!-- Login Modal -->
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

<style>
/* Footer styling */
.footer-section {
	background-color: #ffffff;
	color: #333;
	font-family: var(--font-customize);
	box-shadow: 0 -5px 20px rgba(0,0,0,0.05);
}

/* Back to top button */
#back-to-top {
	position: fixed;
	right: 20px;
	bottom: 30px;
	width: 40px;
	height: 40px;
	padding: 0;
	display: flex;
	align-items: center;
	justify-content: center;
	z-index: 99;
	background: var(--color-primary, #4e7de9);
	border: none;
}

#back-to-top:hover {
	background: #f2d046;
}

/* Footer elements styling */
.footer-title {
	position: relative;
	padding-bottom: 12px;
	font-weight: 600;
	text-transform: uppercase;
	letter-spacing: 1px;
	font-size: 1.1rem;
	color: #333;
}

.footer-title:after {
	content: '';
	position: absolute;
	left: 0;
	bottom: 0;
	width: 40px;
	height: 2px;
	background-color: #4e7de9;
}

.footer-links li a {
	color: #666;
	text-decoration: none;
	transition: all 0.3s ease;
	display: inline-block;
}

.footer-links li a:hover {
	color: #4e7de9;
	transform: translateX(5px);
}

.social-links li a {
	display: flex;
	align-items: center;
	justify-content: center;
	width: 36px;
	height: 36px;
	border-radius: 50%;
	background-color: rgba(78, 125, 233, 0.1);
	color: #4e7de9;
	transition: all 0.3s ease;
}

.social-links li a:hover {
	background-color: #4e7de9;
	color: #fff;
	transform: translateY(-3px);
}

.footer-bottom {
	border-color: #e9ecef !important;
}

/* Responsive adjustments */
@media (max-width: 767px) {
	.footer-title {
		margin-top: 1.5rem;
	}
	
	.social-links {
		margin-bottom: 1.5rem;
	}
	
	.footer-bottom {
		text-align: center;
	}
	
	.col-md-6.text-md-end {
		text-align: center !important;
		margin-top: 1rem;
	}
}

/* Contact info styling */
.contact-info li {
	line-height: 1.4;
}

.contact-info li i {
	font-size: 1.1rem;
	min-width: 20px;
}

.contact-info li span {
	color: #666;
}
</style>