<div class="col-lg-12">
    <div class="element-box">
        <?php
            echo form_open_multipart(current_url(), array('class'=>""));
            echo form_hidden('enviar_form','1');
            ?>
            <div id="errores"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h5>Nuevo usuarios</h5>
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
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="group">Grupo<span class="required">*</span></label>
                        <select id="group" required name="group" class="chosen-select form-control">
                            <?php foreach ($grupos as $f) { ?>
                                <?php if($f->id_group == 1 || $f->id_group == 2) { ?> 
                                    <?php if($issa == 1) { ?>
                                        <option value="<?php echo $f->id_group ?>"><?php echo $f->name ?></option>
                                    <?php } ?>
                                <?php }else{ ?>
                                    <option value="<?php echo $f->id_group ?>"><?php echo $f->name ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="username">Usuario<span class="required">*</span></label>
                        <input id="username" required type="text" name="username" value="<?php echo set_value('username'); ?>" onChange="validarSi()" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="password">Password<span class="required">*</span></label>
                        <input id="password" required type="password" name="password" value="<?php echo set_value('password'); ?>" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="email">Email<span class="required">*</span></label>
                        <input id="email" required type="text" name="email" value="<?php echo set_value('email'); ?>"  onChange="validarEmail()" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre<span class="required">*</span></label>
                        <input id="nombre" required type="text" name="nombre" value="<?php echo set_value('nombre'); ?>" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido<span class="required">*</span></label>
                        <input id="apellido" required type="text" name="apellido" value="<?php echo set_value('apellido'); ?>" class="form-control" />
                    </div>                    
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input id="telefono" type="text" name="telefono" value="<?php echo set_value('telefono'); ?>" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="celular">Celular</label>
                        <input id="celular" type="text" name="celular" value="<?php echo set_value('celular'); ?>" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="template">Template</label>
                        <select id="template" name="template" class="form-control">
                            <?php for ($i=1; $i <= 4 ; $i++) { ?>
                                <option value="skin-<?php echo $i ?>">Template <?php echo $i ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <input id="foto" type="file" name="foto" value="" class="form-control" placeholder="foto" accept="image/*" />
                    </div>
                    <div class="form-group">
                        <label for="active">Estado</label>
                          <label class="radio-inline">
                            <input type="radio" name="active" id="active" value="1" checked /> Habilitado
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="active" id="active" value="0" /> Inhabilitado
                          </label>
                    </div>
                </div>
            </div>
                  
        <?php echo form_close(); ?>
    </div>
</div>
<?php $this->view('backend/users/users_js'); ?>