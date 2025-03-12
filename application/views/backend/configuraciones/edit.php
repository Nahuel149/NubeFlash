<div class="col-lg-12">
    <div class="element-wrapper">
        <h6 class="element-header">Editar Configuración</h6>
        <div class="element-box">
            <?php echo form_open(current_url(), array('class' => 'form-horizontal')); ?>
            <?php echo form_hidden('enviar_form', '1'); ?>
            
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" class="form-control" value="<?php echo $configuracion->name; ?>" readonly>
            </div>

            <div class="form-group">
                <label>Descripción</label>
                <input type="text" class="form-control" value="<?php echo $configuracion->description; ?>" readonly>
            </div>

            <div class="form-group">
                <label>Valor</label>
                <?php if($configuracion->input == 'textarea'): ?>
                    <textarea name="value" class="form-control" rows="5"><?php echo $configuracion->value; ?></textarea>
                <?php elseif($configuracion->input == 'radio'): ?>
                    <div>
                        <label class="radio-inline">
                            <input type="radio" name="value" value="1" <?php echo ($configuracion->value == '1') ? 'checked' : ''; ?>> Si
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="value" value="2" <?php echo ($configuracion->value == '2') ? 'checked' : ''; ?>> No
                        </label>
                    </div>
                <?php else: ?>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa <?php echo $configuracion->icon; ?>"></i>
                        </div>
                        <input type="<?php echo $configuracion->input; ?>" name="value" class="form-control" value="<?php echo $configuracion->value; ?>">
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-buttons-w">
                <button class="btn btn-primary" type="submit">
                    <i class="fa fa-save"></i> Guardar Cambios
                </button>
                <a href="<?php echo base_url('backend/configuraciones'); ?>" class="btn btn-default">
                    <i class="fa fa-times"></i> Cancelar
                </a>
            </div>

            <?php echo form_close(); ?>
        </div>
    </div>
</div> 