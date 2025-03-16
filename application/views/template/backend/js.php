<!-- Define base URL for JavaScript -->
<script>
    var BASE_URL = '<?php echo base_url(); ?>';
</script>

<!-- Core Dependencies -->
<script src="<?php echo base_url() ?>assets/backend/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/backend/bower_components/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables Core and Extensions -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs4/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs4/2.5.0/js/responsive.bootstrap4.min.js"></script>

<!-- Other Libraries -->
<script src="<?php echo base_url() ?>assets/backend/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/backend/bower_components/chart.js/dist/Chart.min.js"></script>
<script src="<?php echo base_url() ?>assets/backend/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url() ?>assets/backend/bower_components/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url() ?>assets/backend/bower_components/bootstrap-validator/dist/validator.min.js"></script>
<script src="<?php echo base_url() ?>assets/backend/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script src="<?php echo base_url() ?>assets/backend/bower_components/editable-table/mindmup-editabletable.js"></script>
<script src="<?php echo base_url() ?>assets/backend/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="<?php echo base_url() ?>assets/backend/bower_components/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/backend/bower_components/tether/dist/js/tether.min.js"></script>
<script src="<?php echo base_url() ?>assets/backend/bower_components/fancybox/dist/jquery.fancybox.min.js"></script>

<!-- Trumbowyg Editor and Plugins -->
<script src="<?php echo base_url() ?>assets/backend/bower_components/trumbowyg/dist/trumbowyg.min.js"></script>
<script src="<?php echo base_url() ?>assets/backend/bower_components/trumbowyg/dist/langs/es.min.js"></script>
<script src="<?php echo base_url() ?>assets/backend/bower_components/trumbowyg/dist/langs/fr.min.js"></script>
<script src="<?php echo base_url() ?>assets/backend/bower_components/trumbowyg/dist/plugins/base64/trumbowyg.base64.min.js"></script>
<script src="<?php echo base_url() ?>assets/backend/bower_components/trumbowyg/dist/plugins/colors/trumbowyg.colors.min.js"></script>
<script src="<?php echo base_url() ?>assets/backend/bower_components/trumbowyg/dist/plugins/noembed/trumbowyg.noembed.min.js"></script>
<script src="<?php echo base_url() ?>assets/backend/bower_components/trumbowyg/dist/plugins/pasteimage/trumbowyg.pasteimage.min.js"></script>
<script src="<?php echo base_url() ?>assets/backend/bower_components/trumbowyg/dist/plugins/template/trumbowyg.template.min.js"></script>
<script src="<?php echo base_url() ?>assets/backend/bower_components/trumbowyg/dist/plugins/preformatted/trumbowyg.preformatted.min.js"></script>
<script src="<?php echo base_url() ?>assets/backend/bower_components/trumbowyg/dist/plugins/ruby/trumbowyg.ruby.min.js"></script>
<script src="<?php echo base_url() ?>assets/backend/bower_components/trumbowyg/dist/plugins/upload/trumbowyg.upload.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

<!-- Custom Scripts -->
<script src="<?php echo base_url() ?>assets/backend/js/main.js"></script>

<!-- Initialize DataTables -->
<script>
    $(document).ready(function() {
        if ($.fn.DataTable) {
            $('.datatable').DataTable({
                responsive: true,
                language: {
                    url: "https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/i18n/Spanish.json"
                },
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                     "<'row'<'col-sm-12'tr>>" +
                     "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                pageLength: 10
            });
        }
    });
</script>

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
