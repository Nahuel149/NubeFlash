<div class="modal-content">
    <div class="modal-header modal-header-primary">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
        <h3><i class="fa fa-search"></i> <?php echo form_hidden('id_audit',$result->id_audit) ?></h3>
    </div>
    <div class="modal-body">
        <div class="form-horizontal">       
            <?php echo form_hidden('id_audit',$result->id_audit) ?>
            
                <div class="form-group">
                    <b>Id_user:</b> <?php echo $result->id_user ?>
                </div>

                <div class="form-group">
                    <b>Query:</b> <?php echo $result->query ?>
                </div>

                <div class="form-group">
                    <b>Date:</b> <?php echo $result->date ?>
                </div>

                <div class="form-group">
                    <b>Active:</b> <?php echo $result->active ?>
                </div>

                <div class="form-group">
                    <b>Created_at:</b> <?php echo $result->created_at ?>
                </div>

                <div class="form-group">
                    <b>Updated_at:</b> <?php echo $result->updated_at ?>
                </div>

                <div class="form-group">
                    <b>Deleted_at:</b> <?php echo $result->deleted_at ?>
                </div>

                <div class="form-group">
                    <b>Create_by:</b> <?php echo $result->create_by ?>
                </div>

                <div class="form-group">
                    <b>Update_by:</b> <?php echo $result->update_by ?>
                </div>

                <div class="form-group">
                    <b>Delete_by:</b> <?php echo $result->delete_by ?>
                </div>                             
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Cerrar</button>
    </div>
</div>