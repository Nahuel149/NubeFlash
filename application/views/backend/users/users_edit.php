<div class="col-lg-12">

    <div class="element-box">
        <?php     
            echo form_open_multipart(current_url(), array('class'=>""));
            echo form_hidden('enviar_form','1');
            echo form_hidden('id',$result->id_user);
        ?>
            <div id="errores"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h5>Editar usuarios</h5>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <?php echo form_button(array('type'  =>'submit','value' =>'Guardar Cambios','name'  =>'submit','class' =>'btn btn-success'), 'Guardar'); ?>
                            <a class="btn btn-danger" href="<?php echo base_url().'backend/'.$this->uri->segment(2); ?>"><i class="icon-circle-arrow-left icon-white"></i> Volver</a>
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
                                        <option value="<?php echo $f->id_group ?>" <?php echo ($f->id_group == $group_user->id_group)? 'selected' : '' ?>><?php echo $f->name ?></option>
                                    <?php } ?>
                                <?php }
                                else{ ?>
                                    <option value="<?php echo $f->id_group ?>" <?php echo ($f->id_group == $group_user->id_group)? 'selected' : '' ?>><?php echo $f->name ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="username">Usuario<span class="required">*</span></label>
                        <input id="username" required type="text" name="username" value="<?php echo $result->username ?>" disabled class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="email">Email<span class="required">*</span></label>
                        <input id="email" required type="text" name="email" value="<?php echo $result->email ?>"  disabled class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre<span class="required">*</span></label>
                        <input id="nombre" required type="text" name="nombre" value="<?php echo $result->name ?>" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido<span class="required">*</span></label>
                        <input id="apellido" required type="text" name="apellido" value="<?php echo $result->surname ?>" class="form-control" />
                    </div>                    
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input id="telefono" type="text" name="telefono" value="<?php echo $result->telefono ?>" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="celular">Celular</label>
                        <input id="celular" type="text" name="celular" value="<?php echo $result->phone ?>" class="form-control" />
                    </div>
                    <input id="template" name="template" type="hidden" value="1" class="form-control"/>
                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <?php if ($result->foto == "" || $result->foto == "0") { ?>
                            <input type="file" name="foto" id="foto" size="20" accept="image/*" class="form-control" />
                        <?php }else { ?>
                            <div style="width: 100%; height: 250px; background: url(<?php echo base_url().'uploads/users/'.$result->foto ?>) 100%/cover;">
                                <a class="btn btn-mini btn-danger pull-right" href="#" rel="tooltip" title="Eliminar Imagen" onClick="deleteFoto('<?php echo $result->id_user ?>', '1');"><i class="fa fa-trash-o"></i> Eliminar</a>
                            </div> 
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label for="active">Estado</label>
                        <label class="radio-inline">
                            <input type="radio" name="active" id="active" value="1" <?php if ($result->active == 1) echo 'checked' ?> /> Habilitado
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="active" id="active" value="0" <?php if ($result->active == 0) echo 'checked' ?> /> Inhabilitado
                        </label>
                    </div>
                </div>
            </div> 
        <?php echo form_close(); ?>
    </div>
</div>
<?php $this->view('backend/users/users_js'); ?>