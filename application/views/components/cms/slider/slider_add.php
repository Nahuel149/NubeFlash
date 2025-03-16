<div class="col-lg-12">
    <div class="element-box">
	<?php     
		echo form_open_multipart(current_url(), array('class'=>""));
		echo form_hidden('enviar_form','1');
    ?>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <h5>Nuevo de slider</h5>
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        <?php echo form_button(array('type'  =>'submit','value' =>'Guardar','name'  =>'submit','class' =>'btn btn-success'), "<i class='fa fa-floppy-o'></i> Guardar"); ?> 
		                <a class="btn btn-danger" href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>"><i class="fa fa-arrow-circle-left"></i> Volver</a>
                    </div>
                </div>
                <hr>          
            </div>
        </div>
        <div class="form-group">
            <label for="nombre">Nombre<span>*</span></label>
            <input  id="nombre" name="nombre" type="text" class="form-control" placeholder="Nombre" />
        </div>
        <div class="form-group">
            <label for="imagen">Imagen<span class="required">*</span></label>
            <input required id="imagen" accept="image/*" name="imagen" type="file" class="form-control" />
        </div>
		<?php echo form_close(); ?>
	</div>
</div>
