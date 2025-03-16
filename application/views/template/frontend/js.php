<!-- Core Dependencies -->
<script src="<?php echo base_url() ?>assets/frontend/js/bootstrap.min.js"></script>

<!-- DataTables Core and Extensions -->
<script src="<?php echo base_url() ?>assets/frontend/plugins/dataTables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/frontend/plugins/dataTables/js/dataTables.bootstrap.min.js"></script>

<!-- Additional Libraries -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url() ?>assets/frontend/js/wow.js"></script>

<!-- Custom Scripts -->
<script src="<?php echo base_url() ?>assets/frontend/js/functions.js?v=<?php echo uniqid() ?>"></script>
<script src="<?php echo base_url() ?>assets/frontend/js/script.js?v=<?php echo uniqid() ?>"></script>

<!-- reCAPTCHA -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<!-- Initialize Components -->
<script>
    $(document).ready(function() {
        // Initialize tooltips
        if (typeof $.fn.tooltip !== 'undefined') {
            $('[data-toggle="tooltip"]').tooltip();
        }

        // Initialize DataTables
        if (typeof $.fn.DataTable !== 'undefined') {
            $('.datatable').DataTable({
                responsive: true,
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                }
            });
        }
    });
</script>