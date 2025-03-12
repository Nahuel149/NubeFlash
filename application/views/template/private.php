<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $configuracion['title']; ?></title>
	<link rel="icon"type="image/jpg" href="<?php echo base_url('assets/public/favicon.png') ?>">
	<!-- Ensure jQuery is loaded first -->
	<script src="<?php echo base_url() ?>assets/backend/bower_components/jquery/dist/jquery.min.js"></script>
	<script>
		// Define jQuery as a global variable if it's not already defined
		if (typeof jQuery === 'undefined') {
			console.error('jQuery failed to load');
		} else {
			console.log('jQuery loaded successfully');
		}
	</script>
	<?php 
		include("private/header.php");
		include("private/css.php");
	?>
	<?php if (!empty($configuracion['google_analytics'])): ?>
		<?php echo $configuracion['google_analytics'] ?>
	<?php endif ?>
</head>
<body>
	<div class="row m-0" style="width:100%;height:100vh;">
		<div id="aside" class="col-md-2 p-0 d-none d-sm-none d-lg-block d-md-none" style="background-color:#ffffff">
			<?php include("private/menu.php");?>
		</div>
		<div id="nav-top" class="col-lg-10 col-md-12 col-sm-12 col-12 p-0">
			<div class="row mr-0">
				<div id="init_nav" class="col-md-12 pr-0">
					<?php include("private/nav.php");?>
				</div>
				<div class="col-md-12 mt-5 mb-5">
					<?php echo $contenido_main; ?>
				</div>
			</div>
			<div class="container nube-background-aqua"></div>
		</div>
		<div class="row m-0" id="footer-private">
			<?php include("private/footer.php");?>
		</div>
	</div>
	<SCRIPT TYPE="text/javascript">
		var base_url = '<?php echo base_url() ?>';
		var csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
		var csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
	</SCRIPT>
	<?php include("private/js.php"); ?>
</body>
</html>