<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $configuracion['title']; ?></title>
  <link rel="icon"type="image/jpg" href="<?php echo base_url('assets/public/favicon.png') ?>">
  <?php 
    include("frontend/header.php");
    include("frontend/css.php");
  ?>
</head>
<body>
	<?php include("frontend/menu.php");?>
	<?php echo $contenido_main; ?>
	<?php include("frontend/footer.php"); ?>
	<SCRIPT TYPE="text/javascript">
		var base_url = '<?php echo base_url() ?>';
	</SCRIPT>
	<?php include("frontend/js.php"); ?>
</body>
</html>