<div class="modal-content">
    <div class="modal-header modal-header-primary">
        <h6><i class="fa fa-search"></i> <?php echo form_hidden('id',$result->destination_id) ?></h6>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
    </div>
    <div class="modal-body">
        <div class="form-horizontal">       
            <?php echo form_hidden('id',$result->destination_id) ?>
            <div class="form-group">
                <b>Nombre:</b> <?php echo $result->name ?>
            </div>
            <div class="form-group">
                <b>Codigo Postal:</b> <?php echo $result->postal_code ?>
            </div>
            <div class="form-group">
                <b>Departamento/Provincia:</b> <?php echo $result->province ?>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Cerrar</button>
    </div>
</div>