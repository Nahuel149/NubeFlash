<div class="col-lg-12">
    <div class="element-box">
		<?php     
			echo form_open(current_url(), array('class'=>""));
			echo form_hidden('enviar_form','1');
		?>
			<?php echo form_hidden('id',$result->country_id) ?>
			
			<div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h5>Editar País</h5>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <?php echo form_button(array('type'  =>'submit','value' =>'Guardar Cambios','name'  =>'submit','class' =>'btn btn-success'), "<i class='fa fa-floppy-o'></i> Guardar"); ?>
                            <a class="btn btn-danger" href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>"><i class="fa fa-arrow-circle-left"></i> Volver</a>
                        </div>
                    </div>
                    <hr>          
                </div>
            </div>
            <div class="form-group">
                <label for="name">Nombre<span class="required">*</span></label>
                <input id="name" required type="text" name="name" value="<?php echo $result->name ?>" class="form-control" placeholder="nombre" />
            </div>
		<?php echo form_close(); ?>
	</div>
</div>