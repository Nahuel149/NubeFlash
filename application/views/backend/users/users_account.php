<div class="col-lg-12">
    <div class="element-box">
        <?php     
            $attributes = array(
                'id' => 'userForm',
                'autocomplete' => 'off',
                'class' => 'needs-validation',
                'novalidate' => ''
            );
            echo form_open_multipart(current_url(), $attributes);
            echo form_hidden('enviar_form','1');
            echo form_hidden('id', $result->id_user);
        ?>
            <div id="errores"></div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="username">Usuario<span class="required">*</span></label>
                        <input id="username" required type="text" name="username" value="<?php echo $result->username ?>" disabled class="form-control" autocomplete="username" />
                    </div>
                    <div class="form-group">
                        <label for="email">Email<span class="required">*</span></label>
                        <input id="email" required type="email" name="email" value="<?php echo $result->email ?>" disabled class="form-control" autocomplete="email" />
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre<span class="required">*</span></label>
                        <input id="nombre" required type="text" name="nombre" value="<?php echo $result->name ?>" class="form-control" autocomplete="given-name" />
                        <div class="invalid-feedback">Por favor ingrese su nombre</div>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido<span class="required">*</span></label>
                        <input id="apellido" required type="text" name="apellido" value="<?php echo $result->surname ?>" class="form-control" autocomplete="family-name" />
                        <div class="invalid-feedback">Por favor ingrese su apellido</div>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono Fijo/Compañía</label>
                        <input id="telefono" type="text" name="telefono" value="<?php echo $result->telefono ?>" class="form-control" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="celular">Celular</label>
                        <input id="celular" type="tel" name="celular" value="<?php echo $result->phone ?>" class="form-control" autocomplete="tel-mobile" pattern="[0-9]*" />
                        <div class="invalid-feedback">Por favor ingrese solo números</div>
                    </div>
                    <input id="template" value="1" type="hidden" name="template" />
                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <?php if ($result->avatar == "" || $result->avatar == "0") { ?>
                            <input type="file" name="foto" id="foto" accept="image/*" class="form-control" aria-label="Seleccionar foto" />
                        <?php }else { ?>
                            <div style="width: 100%; height: 250px; background: url(<?php echo base_url().'uploads/users/'.$result->avatar ?>) 100%/cover;" role="img" aria-label="Foto de perfil">
                                <button type="button" class="btn btn-danger float-right" data-toggle="tooltip" title="Eliminar Imagen" onClick="deleteFoto('<?php echo $result->id_user ?>', '1');">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar
                                </button>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="controls">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save" aria-hidden="true"></i> Guardar
                    </button>
                    <a class="btn btn-danger" href="<?php echo base_url().'backend/dashboard' ?>" role="button">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Volver
                    </a>
                </div>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php $this->view('backend/users/users_js'); ?>