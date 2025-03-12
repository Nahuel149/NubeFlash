<div class="col-lg-12">
    <div class="ibox-content">
	<?php     
		echo form_open(current_url(), array('class'=>""));
		echo form_hidden('enviar_form','1');
	?>
		<div class="text-right">
            <?php echo form_button(array('type'  =>'submit','value' =>'Guardar','name'  =>'submit','class' =>'btn btn-success'), "<i class='fa fa-floppy-o'></i> Guardar"); ?> 
		    <a class="btn btn-danger" href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>"><i class="fa fa-arrow-circle-left"></i> Volver</a><hr>
        </div>

		
                        <div class="form-group">
                            <label for="id_user">Id_user</label>
                            <input  id="id_user" name="id_user" type="text" class="form-control" placeholder="Id_user" />
                        </div>

                        <div class="form-group">
                            <label for="query">Query</label>
                            <textarea  id="query" name="query" class="summernote form-control" placeholder="Query"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="date">Date</label>
                            <input  id="date" name="date" type="text" class="form-control" placeholder="Date" />
                        </div>

                        <div class="form-group">
                            <label for="active">Active</label>
                            <input  id="active" name="active" type="text" class="form-control" placeholder="Active" />
                        </div>

                        <div class="form-group">
                            <label for="created_at">Created_at</label>
                            <input  id="created_at" name="created_at" type="text" class="form-control" placeholder="Created_at" />
                        </div>

                        <div class="form-group">
                            <label for="updated_at">Updated_at</label>
                            <input  id="updated_at" name="updated_at" type="text" class="form-control" placeholder="Updated_at" />
                        </div>

                        <div class="form-group">
                            <label for="deleted_at">Deleted_at</label>
                            <input  id="deleted_at" name="deleted_at" type="text" class="form-control" placeholder="Deleted_at" />
                        </div>

                        <div class="form-group">
                            <label for="create_by">Create_by</label>
                            <input  id="create_by" name="create_by" type="text" class="form-control" placeholder="Create_by" />
                        </div>

                        <div class="form-group">
                            <label for="update_by">Update_by</label>
                            <input  id="update_by" name="update_by" type="text" class="form-control" placeholder="Update_by" />
                        </div>

                        <div class="form-group">
                            <label for="delete_by">Delete_by</label>
                            <input  id="delete_by" name="delete_by" type="text" class="form-control" placeholder="Delete_by" />
                        </div>
		<?php echo form_close(); ?>
	</div>
</div>
