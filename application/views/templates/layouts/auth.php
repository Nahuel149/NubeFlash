<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view('shared/meta'); ?>
    
    <!-- Core CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/backend/bower_components/bootstrap/dist/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/backend/icon_fonts_assets/font-awesome/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/backend/css/backend.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/backend/css/auth.css'); ?>">
    
    <!-- Additional CSS -->
    <?php if(isset($css_files)): ?>
        <?php foreach($css_files as $css): ?>
            <link rel="stylesheet" href="<?php echo base_url($css); ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-box">
            <div class="auth-logo">
                <img src="<?php echo base_url('assets/backend/images/logo_nube.png'); ?>" alt="NubeFlash Logo">
            </div>

            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>

            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <?php echo isset($content) ? $content : ''; ?>
        </div>
    </div>

    <!-- Core JavaScript -->
    <script src="<?php echo base_url('assets/backend/bower_components/jquery/dist/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/backend/bower_components/bootstrap/dist/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    
    <!-- Additional JavaScript -->
    <?php if(isset($js_files)): ?>
        <?php foreach($js_files as $js): ?>
            <script src="<?php echo base_url($js); ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Page Specific JavaScript -->
    <?php if(isset($script)): ?>
        <script>
            <?php echo $script; ?>
        </script>
    <?php endif; ?>
</body>
</html> 