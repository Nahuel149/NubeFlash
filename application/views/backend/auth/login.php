<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - La Nube</title>
    
    <style>
        body {
            background: #f0f7ff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .auth-box-w {
            background: white;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            padding: 2.5rem;
            margin: 1rem;
            text-align: center;
        }
        .logo-w {
            margin-bottom: 1rem;
        }
        .logo-w img {
            width: 168px; /* 40% bigger than 120px */
            height: auto;
        }
        .auth-description {
            color: #7f8c8d;
            font-size: 0.95rem;
            margin-bottom: 2rem;
            padding: 0 1rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #34495e;
            font-weight: 500;
            font-size: 0.9rem;
        }
        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            font-size: 0.9rem;
            box-sizing: border-box;
            transition: all 0.2s;
            background-color: #f8f9fa;
        }
        .form-control:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.1);
            background-color: white;
        }
        .form-control::placeholder {
            color: #95a5a6;
        }
        .btn {
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 4px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            margin-bottom: 1rem;
        }
        .btn-primary {
            background: #3498db;
            color: white;
        }
        .btn-primary:hover {
            background: #2980b9;
        }
        .forgot-pass-link {
            color: #7f8c8d;
            text-decoration: none;
            font-size: 0.85rem;
            transition: color 0.2s ease;
            display: inline-block;
            margin-bottom: 1rem;
        }
        .forgot-pass-link:hover {
            color: #3498db;
            text-decoration: underline;
        }
        .text-muted {
            color: #95a5a6;
            font-size: 0.8rem;
        }
        /* Animated background */
        .bg-bubbles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
            background: linear-gradient(45deg, #3498db, #2980b9);
        }
        .bubble {
            position: absolute;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 8s infinite;
        }
        .bubble:nth-child(1) { width: 80px; height: 80px; left: 10%; animation-delay: 0s; }
        .bubble:nth-child(2) { width: 60px; height: 60px; left: 20%; animation-delay: 1s; }
        .bubble:nth-child(3) { width: 100px; height: 100px; left: 35%; animation-delay: 2s; }
        .bubble:nth-child(4) { width: 50px; height: 50px; left: 50%; animation-delay: 3s; }
        .bubble:nth-child(5) { width: 70px; height: 70px; left: 65%; animation-delay: 4s; }
        .bubble:nth-child(6) { width: 90px; height: 90px; left: 80%; animation-delay: 5s; }
        .bubble:nth-child(7) { width: 120px; height: 120px; left: 90%; animation-delay: 6s; }

        @keyframes float {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0.8; }
            100% { transform: translateY(-100vh) rotate(360deg); opacity: 0; }
        }
    </style>
</head>
<body>
    <!-- Animated background -->
    <div class="bg-bubbles">
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
    </div>

    <div class="auth-box-w">
        <div class="logo-w">
            <img src="<?php echo base_url('assets/public/logo_nube.png') ?>" alt="La Nube Logo">
        </div>

        <div class="auth-description">
            Inserta tus credenciales de administrador
        </div>

        <?php echo form_open("backend/auth/login", array('class' => 'auth-form')); ?>
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

            <?php if ($this->session->flashdata('message')): ?>
                <?php echo $this->session->flashdata('message'); ?>
            <?php endif; ?>

            <div class="form-group">
                <label for="identity">Usuario</label>
                <input name="identity" id="identity" type="text" class="form-control" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Acceder</button>

            <a href="<?php echo base_url('backend/auth/forgot_password'); ?>" class="forgot-pass-link">
                ¿Olvidaste tu contraseña?
            </a>

            <div class="text-muted">
                &copy; <?php echo date('Y'); ?> NubeFlash
            </div>
        <?php echo form_close(); ?>
    </div>
</body>
</html>