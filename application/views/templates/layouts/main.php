<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view('shared/meta'); ?>
    
    <!-- Core CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/backend/bower_components/bootstrap/dist/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/backend/bower_components/font-awesome/css/all.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/backend/css/backend.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/backend/js/livevalidation/livevalidation.css'); ?>">
    
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
            <?php echo load_partial('sidebar'); ?>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="admin-content">
        <!-- Header -->
        <header class="admin-header">
            <?php echo load_partial('header'); ?>
        </header>

        <!-- Page Content -->
        <div class="admin-page-content">
            <?php if(isset($breadcrumbs)): ?>
                <div class="admin-breadcrumbs">
                    <?php foreach($breadcrumbs as $crumb): ?>
                        <?php if(!empty($crumb['url'])): ?>
                            <a href="<?php echo base_url($crumb['url']); ?>" class="admin-breadcrumb-item"><?php echo $crumb['title']; ?></a>
                        <?php else: ?>
                            <span class="admin-breadcrumb-item active"><?php echo $crumb['title']; ?></span>
                        <?php endif; ?>
                    <?php endforeach; ?>
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
            <?php echo load_partial('footer'); ?>
        </footer>
    </main>

    <!-- Core JavaScript -->
    <script src="<?php echo base_url('assets/backend/bower_components/jquery/dist/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/backend/bower_components/bootstrap/dist/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/backend/js/main.js'); ?>"></script>
    <script src="<?php echo base_url('assets/backend/js/livevalidation/livevalidation.js'); ?>"></script>
    
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