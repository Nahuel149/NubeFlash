<?php switch ($this->uri->segment(1)) {
	case 'mi-perfil':
		$title = "Mi Perfil";
		$image_header = '099-medal.png';
		break;
	case 'dashboard':
		$title = "Mi plan";
		$image_header = '174-star.png';
		break;
	case 'mi-token':
		$title = "Mi token";
		$image_header = 'confi.png';
		break;
} ?>
<nav class="navbar">
  <div style="flex-grow:1">
    <div class="d-flex align-items-center w-100">
        <div class="d-flex">
            <a style="font-size: 25px;padding:0px;" data-action="collapse" class="navbar-brand text-white d-none d-sm-none d-md-none d-lg-block" href="#"><img src="<?php echo base_url('assets/public/dashboard/menu_nube.png') ?>" width="40"></a>
        </div>
        <div class="d-flex flex-column w-75">
            <span class="text-title text-white"><?php if (isset($image_header) && $image_header) {?>
				<img src="<?php echo(base_url('assets/public/dashboard/icons/blanco/'.$image_header)); ?>" class="tam-icon icon-categoria"/></span>
			<?php } ?>

            <span class="text-subtitle text-white"></span>
        </div>
        <div class="d-flex w-25 flex-row-reverse">
            <div class="dropdown text-center">
                <a class="nav-link dropdown-toggle text-session line-botton" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo $this->session->userdata('name') ?> ¡Hola!
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="#" id="cambiarPassBtn">Cambiar contraseña</a>
                	<a class="dropdown-item" href="<?php echo(base_url('logout')); ?>">Cerrar sesión</a>
                </div>
            </div>
        </div>
		<button class="navbar-toggler d-block d-sm-block d-md-block d-lg-none" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="fas fa-bars text-white"></span>
		</button>
    </div>
  </div>
</nav>
<div class="collapse navbar-collapse d-lg-none" id="navbarNav" style="background-color:#297ded;">
	<ul class="navbar-nav">
		<!-- <li class="nav-item <?php echo($this->uri->segment(1) == 'dashboard' ? 'active':''); ?>">
			<a class="nav-link" href="<?php echo(base_url('dashboard')); ?>">
				<img src="<?php echo(base_url('assets/public/dashboard/icons/blanco/174-star.png')); ?>" class="tam-icon icon-plan" id="icon_perfil"/>&nbsp;&nbsp; Dashboard
			</a>
		</li> -->
		<li class="nav-item <?php echo($this->uri->segment(1) == 'mi-perfil' ? 'active':''); ?>">
			<a class="nav-link" href="<?php echo(base_url('mi-perfil')); ?>">
				<img src="<?php echo(base_url('assets/public/dashboard/icons/blanco/099-medal.png')); ?>" class="tam-icon icon-pago"/>&nbsp;&nbsp; Perfil
			</a>
		</li>
		<li class="nav-item <?php echo($this->uri->segment(1) == 'mi-token' ? 'active':''); ?>">
			<a class="nav-link" href="<?php echo(base_url('mi-token')); ?>">
				<img src="<?php echo(base_url('assets/public/dashboard/icons/blanco/confi.png')); ?>" class="tam-icon icon-envio"/>&nbsp; Token
			</a>
		</li>
	</ul>
</div>
<script type="text/javascript">
	jQuery(document).on('click', 'a[data-action="btnTienda"]', function(event) {
        event.preventDefault();
        jQuery.ajax({
            url: base_url + 'frontend/private/web_private/homeTemplate',
            type: 'POST',
            dataType: 'json',
            data: {
                valor: true,
            },
        })
        .done(function(data) {
            console.log(data.success);
        })
        .fail(function(data) {
            console.log("error");
        })
        .always(function(data) {

        });
    });

	jQuery(document).on('click', 'a[data-action="NotUrl"]', function(event) {
        event.preventDefault();
        swal('Error','No cuenta con un dominio registrado','error');
    });

	jQuery(document).on('click','[data-action="collapse"]',function (event) {
		event.preventDefault();

		if (jQuery('#aside').hasClass('aside-oculta'))
		{
			jQuery('#aside').removeClass('aside-oculta');
		} else {
			jQuery('#aside').addClass('aside-oculta');
		}

		if(jQuery('#nav-top').hasClass('col-lg-10'))
		{
			jQuery('#nav-top').removeClass('col-lg-10');	
			jQuery('#nav-top').addClass('col-lg-12');
		} else {
			jQuery('#nav-top').removeClass('col-lg-12');	
			jQuery('#nav-top').addClass('col-lg-10');
		}

	});
</script>