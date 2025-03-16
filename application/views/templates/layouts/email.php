<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .email-header {
            text-align: center;
            padding: 20px 0;
            background-color: #f8f9fa;
        }
        .email-logo {
            max-width: 200px;
            height: auto;
        }
        .email-content {
            padding: 20px;
            background-color: #ffffff;
        }
        .email-footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #666;
            background-color: #f8f9fa;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            margin: 10px 0;
        }
        .alert {
            padding: 15px;
            margin: 10px 0;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .alert-warning {
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <img src="<?php echo base_url('assets/backend/images/logo_nube.png'); ?>" alt="NubeFlash Logo" class="email-logo">
        </div>

        <div class="email-content">
            <?php echo isset($content) ? $content : ''; ?>
        </div>

        <div class="email-footer">
            <p>&copy; <?php echo date('Y'); ?> NubeFlash. All rights reserved.</p>
            <p>
                This email was sent to <?php echo isset($to) ? $to : '[email]'; ?><br>
                Please do not reply to this email.
            </p>
        </div>
    </div>
</body>
</html> 