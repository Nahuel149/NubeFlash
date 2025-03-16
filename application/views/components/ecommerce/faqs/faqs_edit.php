<div class="col-lg-12">
    <div class="element-box">
		<?php     
			echo form_open(current_url(), array('class'=>""));
			echo form_hidden('enviar_form','1');
		?>
			<?php echo form_hidden('id', $result->id_faq) ?>

            <div class="form-group">
                <label class="control-label" for="nombre">Pregunta<span class="required">*</span></label>
                <input id="pregunta" required type="text" name="pregunta" value="<?php echo $result->question ?>" class="form-control" placeholder="pregunta" />
            </div>

            <div class="form-group">
                <label for="respuesta">Respuesta</label>
                <textarea id="respuesta" name="respuesta" class="form-control"><?php echo $result->answer ?></textarea>
            </div>

			<div class="control-group">
				<div class="controls">
					<?php echo form_button(array('type'  =>'submit','value' =>'Guardar Cambios','name'  =>'submit','class' =>'btn btn-success'), "<i class='fa fa-floppy-o'></i> Guardar"); ?>
					<a class="btn btn-danger" href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>"><i class="fa fa-arrow-circle-left"></i> Volver</a>
				</div>
			</div>

		<?php echo form_close(); ?>
	</div>
</div>
