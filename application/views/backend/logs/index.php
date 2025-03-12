<div class="col-lg-12">
    <div class="element-box">
        <?php     
         echo form_open(base_url().'backend/logs/zip', array('class'=>"well"));
            echo form_hidden('enviar_form','1');
        ?>
        <h5>Filtro de descarga</h5>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="fecha_desde">Fecha desde<span class="required">*</span></label>
                    <input id="fecha_desde" required type="text" name="fecha_desde" value="<?php echo date('Y-m-d') ?>" class="form-control single-daterange" placeholder="<?php echo date('Y-m-d') ?>" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="fecha_hasta">Fecha hasta<span class="required">*</span></label>
                    <input id="fecha_hasta" required type="text" name="fecha_hasta" value="<?php echo date('Y-m-d') ?>" class="form-control single-daterange" placeholder="<?php echo date('Y-m-d') ?>" />
                </div>
            </div>
            <div class="col-md-4 text-right">
                <br>
                <div class="control-group">
                  <div class="controls">
                    <?php echo form_button(array('type'  =>'submit','value' =>'Guardar','name'  =>'submit','class' =>'btn btn-success'), "<i class='fa fa-floppy-o'></i> Descargar"); ?> 
                    <a class="btn btn-danger" href="<?php echo base_url().'backend/dashboard'; ?>"><i class="fa fa-arrow-circle-left"></i> Cancelar</a>
                  </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>

        <table id="dataTable1" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
            <thead>
                <tr>
                    <th><a href="#">Fecha del log</a></th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $f) { ?>
                    <?php if ($f != 'index.html') {?>                  
                        <tr>
                            <?php 
                                $array_breadcrumb = array('.php' => ''); 
                                $value = str_replace(array_keys($array_breadcrumb), array_values($array_breadcrumb), $f);
                            ?>
                            <td><?php echo $value ?></td>
                            <td width="10%" align="right">
                                <div class="btn-group">
                                    <a href="<?php echo base_url().'backend/logs/txt/'.$value ?>" class="btn btn-success btn-sm"><i class="fa fa-floppy-o"></i> Descargar</a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>

    </div>
</div>