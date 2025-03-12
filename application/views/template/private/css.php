<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

<!-- Core CSS -->
<link href="<?php echo base_url() ?>assets/backend/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link href="<?php echo base_url() ?>assets/frontend/style.css" rel="stylesheet">
<link href="<?php echo base_url() ?>assets/frontend/extras/dashboard.css?v=<?php echo uniqid() ?>" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet">
<link href="<?php echo base_url() ?>assets/backend/css/backend.css" rel="stylesheet">
<link href="<?php echo base_url() ?>assets/frontend/extras/Linearicons-Free/Web Font/style.css" rel="stylesheet">

<!-- DataTables -->
<link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css" rel="stylesheet">

<!-- Dropzone -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" rel="stylesheet">

<?php if($this->uri->segment(1) == 'mis-pedidos'): ?>
<!-- Orders page specific CSS for accessibility -->
<link href="<?php echo base_url() ?>assets/frontend/css/orders-accessibility.css?v=<?php echo uniqid() ?>" rel="stylesheet">
<?php endif; ?>

<script type="text/javascript">
    var base_url = "<?php echo base_url() ?>";
    var csrf_token_name = "<?php echo $this->security->get_csrf_token_name(); ?>";
    var csrf_hash = "<?php echo $this->security->get_csrf_hash(); ?>";
</script>

