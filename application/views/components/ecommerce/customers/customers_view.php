<div class="modal-content">
    <div class="modal-header modal-header-primary">
        <h6><i class="fa fa-search"></i> <?php echo form_hidden('id', $result->customer_id) ?></h6>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
    </div>
    <div class="modal-body">
        <div class="form-horizontal">
            <?php echo form_hidden('id', $result->customer_id) ?>
            <div class="form-group">
                <b>Razón Social:</b> <?php echo $result->social_reason ?>
            </div>
            <div class="form-group">
                <b>Identificador Fiscal:</b> <?php echo $result->fiscal_identifier ?>
            </div>
            <div class="form-group">
                <b>Persona de Contacto:</b> <?php echo $result->person_contact ?>
            </div>
            <div class="form-group">
                <b>Teléfono:</b> <?php echo $result->telephone ?>
            </div>
            <div class="form-group">
                <b>Correo electrónico:</b> <?php echo $result->email ?>
            </div>
            <div class="form-group">
                <b>Dirección:</b> <?php echo $result->address ?>
            </div>
            <div class="form-group">
                <b>Horarios de atención:</b> <?php echo $result->business_hours ?>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Cerrar</button>
    </div>
</div>