<div class="col-lg-12">
    <div class="element-box">
      <?php     
          echo form_open(current_url(), array('class'=>""));
          echo form_hidden('enviar_form','1');
        ?>
            <div class="row">
              <div class="col-md-12">
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <h5>Nuevo permisos</h5>
                          </div>
                      </div>
                      <div class="col-md-6 text-right">
                          <?php echo form_button(array('type'  =>'submit','value' =>'Guardar','name'  =>'submit','class' =>'btn btn-success'), "<i class='fa fa-floppy-o'></i> Guardar"); ?> 
                          <a class="btn btn-danger" href="<?php echo base_url().'backend/'.$this->uri->segment(2); ?>"><i class="fa fa-arrow-circle-left"></i> Volver</a>
                      </div>
                  </div>
                  <hr>          
              </div>
            </div>
            <div class="form-group">
                <label for="menu_id">Menu<span class="required">*</span></label>                                        
                <select id="menu_id" required name="menu_id" class="chosen-select form-control">
                  <?php foreach ($menus as $f) { ?>
                    <option value="<?php echo $f->id_menu ?>"><?php echo $f->description ?></option>
                  <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="group_id">Grupo<span class="required">*</span></label>                                        
                <select id="group_id" required name="group_id" class="chosen-select form-control">
                  <?php foreach ($grupos as $f) { ?>
                    <option value="<?php echo $f->id_group ?>"><?php echo $f->name ?></option>
                  <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="read">Leer<span class="required">*</span></label>                                
                <label class="radio-inline">
                  <input type="radio" name="read" id="read" value="1" checked /> Si
                </label>
                <label class="radio-inline">
                  <input type="radio" name="read" id="read" value="0"  /> No
                </label>
            </div>
            <div class="form-group">
                <label for="insert">Insertar<span class="required">*</span></label>                                
                <label class="radio-inline">
                  <input type="radio" name="insert" id="insert" value="1" checked /> Si
                </label>
                <label class="radio-inline">
                  <input type="radio" name="insert" id="insert" value="0"  /> No
                </label>
            </div>
            <div class="form-group">
                <label for="update">Actualizar<span class="required">*</span></label>                                
                <label class="radio-inline">
                  <input type="radio" name="update" id="update" value="1" checked /> Si
                </label>
                <label class="radio-inline">
                  <input type="radio" name="update" id="update" value="0"  /> No
                </label>
            </div>
            <div class="form-group">
                <label for="delete">Eliminar<span class="required">*</span></label>                                
                <label class="radio-inline">
                  <input type="radio" name="delete" id="delete" value="1" checked /> Si
                </label>
                <label class="radio-inline">
                  <input type="radio" name="delete" id="delete" value="0"  /> No
                </label>
            </div>
            <div class="form-group">
                <label for="exportar">Exportar<span class="required">*</span></label>                                
                <label class="radio-inline">
                  <input type="radio" name="exportar" id="exportar" value="1" checked /> Si
                </label>
                <label class="radio-inline">
                  <input type="radio" name="exportar" id="exportar" value="0"  /> No
                </label>
            </div>
            <div class="form-group">
                <label for="imprimir">Imprimir<span class="required">*</span></label>                                
                <label class="radio-inline">
                  <input type="radio" name="imprimir" id="imprimir" value="1" checked /> Si
                </label>
                <label class="radio-inline">
                  <input type="radio" name="imprimir" id="imprimir" value="0"  /> No
                </label>
            </div>                      
            
        <?php echo form_close(); ?>
    </div>
</div>