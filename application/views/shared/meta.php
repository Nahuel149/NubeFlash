<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="mobile-web-app-capable" content="yes">
<meta name="theme-color" content="#007bff">
<meta name="application-name" content="NubeFlash">
<?php
// Set Content Security Policy
$csp = "default-src 'self'; " .
       "script-src 'self' 'unsafe-inline' 'unsafe-eval' " .
       "https://www.google.com/recaptcha/ " .
       "https://www.gstatic.com/recaptcha/ " .
       "https://cdn.jsdelivr.net " .
       "https://code.jquery.com " .
       "https://stackpath.bootstrapcdn.com " .
       "https://cdnjs.cloudflare.com " .
       "https://cdn.datatables.net; " .
       "style-src 'self' 'unsafe-inline' " .
       "https://fonts.googleapis.com " .
       "https://cdn.jsdelivr.net " .
       "https://cdnjs.cloudflare.com " .
       "https://cdn.datatables.net; " .
       "font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; " .
       "img-src 'self' data: https:; " .
       "connect-src 'self' https://cdn.datatables.net";

header("Content-Security-Policy: " . $csp);
?>
<title><?php echo isset($title) ? $title . ' - ' : ''; ?>NubeFlash</title> 