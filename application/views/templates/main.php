<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' - ' : ''; ?>NubeFlash</title>
    
    <!-- Core CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/backend/bower_components/bootstrap/dist/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/backend/bower_components/font-awesome/css/all.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/backend/css/backend.css'); ?>">
    
    <!-- Additional CSS -->
    <?php if(isset($css_files)): ?>
        <?php foreach($css_files as $css): ?>
            <link rel="stylesheet" href="<?php echo base_url($css); ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body class="admin-wrapper">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="admin-logo-container">
            <img src="<?php echo base_url('assets/backend/images/logo_nube.png'); ?>" alt="NubeFlash Logo" class="admin-logo">
        </div>
        <nav class="admin-nav">
            <?php $this->load->view('templates/partials/sidebar'); ?>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="admin-content">
        <!-- Header -->
        <header class="admin-header">
            <?php $this->load->view('templates/partials/header'); ?>
        </header>

        <!-- Page Content -->
        <div class="admin-page-content">
            <?php if(isset($breadcrumbs)): ?>
                <div class="admin-breadcrumbs">
                    <?php echo $breadcrumbs; ?>
                </div>
            <?php endif; ?>

            <?php if($this->session->flashdata('success')): ?>
                <div class="admin-alert admin-alert-success">
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>

            <?php if($this->session->flashdata('error')): ?>
                <div class="admin-alert admin-alert-danger">
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <?php echo isset($content) ? $content : ''; ?>
        </div>

        <!-- Footer -->
        <footer class="admin-footer">
            <?php $this->load->view('templates/partials/footer'); ?>
        </footer>
    </main>

    <!-- Core JavaScript -->
    <script src="<?php echo base_url('assets/backend/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/backend/js/main.js'); ?>"></script>
    
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