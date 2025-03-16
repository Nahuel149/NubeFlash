<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">

<!-- Core CSS -->
<link href="<?php echo base_url() ?>assets/backend/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer">

<!-- DataTables -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs4/2.5.0/responsive.bootstrap4.min.css" rel="stylesheet">

<!-- Additional Libraries -->
<link href="<?php echo base_url() ?>assets/backend/bower_components/select2/dist/css/select2.min.css" rel="stylesheet">
<link href="<?php echo base_url() ?>assets/backend/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" rel="stylesheet">
<link href="<?php echo base_url() ?>assets/backend/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css" rel="stylesheet">

<!-- SweetAlert2 -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="<?php echo base_url() ?>assets/backend/css/backend.css" rel="stylesheet">
<link href="<?php echo base_url() ?>assets/backend/css/main.css?version=4.1" rel="stylesheet">
<link href="<?php echo base_url() ?>assets/backend/css/custom-fixes.css?version=<?php echo time(); ?>" rel="stylesheet">

<!-- Additional CSS -->
<?php if(isset($css_files)): ?>
    <?php foreach($css_files as $css): ?>
        <link href="<?php echo base_url($css); ?>" rel="stylesheet">
    <?php endforeach; ?>
<?php endif; ?>

<script type="text/javascript">
	var base_url = "<?php echo base_url() ?>";
</script>
