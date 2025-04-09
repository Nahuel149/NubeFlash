<div class="modal-content">
    <div class="modal-header modal-header-primary">
        <h6><i class="fa fa-search"></i> <?php echo form_hidden('id',$result->tariff_id) ?></h6>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
    </div>
    <div class="modal-body">
        <div class="form-horizontal">       
            <?php echo form_hidden('id',$result->tariff_id) ?>
            <div class="form-group">
                <b>País:</b> <?php echo $result->country ?>
            </div>
            <div class="form-group">
                <b>Departamento/Provincia:</b> 
                <?php 
                if (!empty($result->province_name_manual)) {
                    echo $result->province_name_manual . ' <small class="text-muted">(manual)</small>';
                } else {
                    echo $result->province;
                }
                ?>
            </div>
            <div class="form-group">
                <b>Localidad:</b> 
                <?php 
                if (!empty($result->destination_name_manual)) {
                    echo $result->destination_name_manual . ' <small class="text-muted">(manual)</small>';
                } else {
                    echo $result->destination;
                }
                ?>
            </div>
            <div class="form-group">
                <b>Codigo Postal:</b> 
                <?php 
                if (!empty($result->postal_code_manual)) {
                    echo $result->postal_code_manual . ' <small class="text-muted">(manual)</small>';
                } else {
                    echo $result->postal_code;
                }
                ?>
            </div>
            <div class="form-group">
                <b>Tarifa Precio:</b> <?php echo '$ '.$result->tariff_price ?>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Cerrar</button>
    </div>
</div>