<style>
	.modal-backdrop.in {
		display: none !important;
	}
</style>
<div class="col-lg-12">
    <div class="element-box">
		<?php     
			echo form_open_multipart(current_url(), array('class'=>""));
			echo form_hidden('enviar_form','1');
		?>
			<?php echo form_hidden('id',$result->id_section) ?>
			<div class="text-right">
                <?php echo form_button(array('type'  =>'submit','value' =>'Guardar Cambios','name'  =>'submit','class' =>'btn btn-success'), "<i class='fa fa-floppy-o'></i> Guardar"); ?>
				<a class="btn btn-danger" href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>"><i class="fa fa-arrow-circle-left"></i> Volver</a><hr>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input  id="nombre" name="nombre" type="text" class="form-control" placeholder="Nombre" value="<?php echo $result->name ?>" />
            </div>

            <div class="form-group">
                <label for="descripcion">Descripcion<span class="required">*</span></label>
                <textarea id="descripcion" rows="4" name="descripcion" class="form-control summernote" placeholder="Descripcion"><?php echo $result->description ?></textarea>
            </div>
		<?php echo form_close(); ?>
	</div>
</div>