<!-- Define base URL for JavaScript -->
<script>
    var BASE_URL = '<?php echo base_url(); ?>';
    var csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
    
    // Handle require errors
    window.addEventListener('error', function(event) {
        if (event.message && event.message.indexOf('require is not defined') !== -1) {
            console.warn('Require error caught and suppressed');
            event.preventDefault();
            return true;
        }
    }, true);
</script>

<!-- Core Dependencies -->
<script src="<?php echo base_url(); ?>assets/backend/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/bower_components/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables Core and Extensions -->
<script src="<?php echo base_url(); ?>assets/backend/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/bower_components/datatables.net-bs/js/dataTables.bootstrap4.min.js"></script>

<!-- Other Libraries -->
<script src="<?php echo base_url(); ?>assets/backend/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/bower_components/chart.js/dist/Chart.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/bower_components/select2/dist/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/bower_components/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/bower_components/bootstrap-validator/dist/validator.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/bower_components/dropzone/dist/min/dropzone.min.js"></script>
<script src="<?php echo base_url() ?>assets/backend/bower_components/editable-table/mindmup-editabletable.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/bower_components/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/bower_components/tether/dist/js/tether.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/bower_components/fancybox/dist/jquery.fancybox.min.js"></script>

<!-- SweetAlert2 -->
<script src="<?php echo base_url(); ?>assets/backend/bower_components/sweetalert/dist/sweetalert.min.js"></script>

<!-- Custom Scripts -->
<script src="<?php echo base_url() ?>assets/backend/js/main.js?version=3.9.1"></script>
<script src="<?php echo base_url() ?>assets/frontend/js/functions.js?version=<?php echo time(); ?>"></script>

<?php if($this->uri->segment(1) == 'mis-pedidos'): ?>
<!-- Orders page specific scripts -->
<script src="<?php echo base_url('assets/frontend/js/orders.js'); ?>?v=<?php echo uniqid() ?>"></script>
<?php endif; ?>

<!-- Initialize Components -->
<script>
    // Define a PerfectScrollbar fallback if not available
    if (typeof $.fn.perfectScrollbar === 'undefined') {
        $.fn.perfectScrollbar = function(options) {
            console.log('PerfectScrollbar is not available, using fallback');
            return this;
        };
    }

    // Define a require fallback if not available
    if (typeof window.require === 'undefined') {
        window.require = function(module) {
            console.warn('Require called for module: ' + module + ', but require is not available');
            return {};
        };
    }
    
    // SweetAlert fallback
    if (typeof window.swal === 'undefined') {
        window.swal = function(title, message, type) {
            console.warn('SweetAlert called but not available, using fallback');
            if (type === 'error') {
                alert('Error: ' + message);
            } else if (type === 'success') {
                alert('Success: ' + message);
            } else {
                alert(message);
            }
        };
    }

    $(document).ready(function() {
        // Initialize Bootstrap components
        if (typeof $.fn.tooltip !== 'undefined') {
            $('[data-toggle="tooltip"]').tooltip();
        }
        
        // Initialize DataTables
        if (typeof $.fn.DataTable !== 'undefined') {
            $('.datatable').DataTable({
                responsive: true,
                language: {
                    url: "<?php echo base_url('assets/backend/bower_components/datatables.net/js/i18n/es-ES.json'); ?>"
                }
            });
        }
        
        // Fix for PerfectScrollbar
        if (typeof $.fn.perfectScrollbar === 'undefined') {
            $.fn.perfectScrollbar = function(options) {
                console.log('PerfectScrollbar is not available, using fallback');
                return this;
            };
        }
        
        // Initialize modals with proper configuration
        $('.modal').each(function() {
            $(this).on('show.bs.modal', function() {
                var $this = $(this);
                try {
                    var myModal = new bootstrap.Modal(document.getElementById($this.attr('id')));
                } catch (e) {
                    console.log('Using jQuery modal fallback');
                    $($this).modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                }
            });
        });
        
        // Password change modal trigger
        $('#cambiarPassBtn').on('click', function(e) {
            e.preventDefault();
            $('#cambiarpass').modal('show');
        });
        
        // Reset form when modal is closed
        $('#cambiarpass').on('hidden.bs.modal', function () {
            $('#password-change-form')[0].reset();
            $('#current-password-feedback').text('');
            $('#new-password-feedback').text('');
            $('#repeat-password-feedback').text('');
            $('#pass').prop('disabled', true);
            $('#pass2').prop('disabled', true);
        });
    });
</script>
