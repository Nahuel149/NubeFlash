<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="<?php echo isset($configuracion['descripcion']) ? $configuracion['descripcion'] : 'La Nube - Logística y eCommerce'; ?>">
<meta name="author" content="La Nube">
<meta name="keywords" content="<?php echo isset($configuracion['keywords']) ? $configuracion['keywords'] : 'logística, ecommerce, envíos, paquetes'; ?>">

<?php if (isset($configuracion['og_title']) && !empty($configuracion['og_title'])): ?>	
<meta property="og:url"                content="<?php echo current_url() ?>" />
<meta property="og:type"               content="article" />
<meta property="og:title"              content="<?php echo $configuracion['og_title'] ?>" />
<meta property="og:description"        content="<?php echo $configuracion['og_description'] ?>" />
<meta property="og:image"              content="<?php echo $configuracion['og_image'] ?>" />
<?php endif ?>