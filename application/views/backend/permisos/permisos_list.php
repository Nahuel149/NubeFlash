<div class="col-lg-12">
  <div class="element-box">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <h5>Lista de permisos</h5>
                    </div>
                </div>
                <div class="col-md-6 text-right">
                    <?php if($permisos_efectivos->insert==1) { ?> <a href="<?php echo base_url().'backend/permisos/add/' ?>" class="btn btn-success"><i class="fa fa-plus"></i> Nuevo Permiso</a><?php } ?>
                </div>
            </div>
            <hr>          
        </div>
    </div>
    <div class="table-responsive">
        <table id="dataTable1" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
            <thead>
                <tr>
                    <th><a href="#">ID</a></th>
                    <th><a href="#">Menu</a></th>
                    <th><a href="#">Grupo</a></th>
                    <th><a href="#">Leer</a></th>
                    <th><a href="#">Insertar</a></th>
                    <th><a href="#">Actualizar</a></th>
                    <th><a href="#">Eliminar</a></th>
                    <th><a href="#">Exportar</a></th>
                    <th><a href="#">Imprimir</a></th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
              <?php 
              foreach ($results as $result) { ?>
              <tr>
                <td><?php echo $result->id_permission ?></td>
                <td><?php echo $result->menu ?></td>
                <td><?php echo $result->grupo ?></td>
                <td><?php if($result->read==1){?><i class="fa fa-check"></i><?php } else {?><i class="fa fa-times"></i><?php }?></td>
                <td><?php if($result->insert==1){?><i class="fa fa-check"></i><?php } else {?><i class="fa fa-times"></i><?php }?></td>
                <td><?php if($result->update==1){?><i class="fa fa-check"></i><?php } else {?><i class="fa fa-times"></i><?php }?></td>
                <td><?php if($result->delete==1){?><i class="fa fa-check"></i><?php } else {?><i class="fa fa-times"></i><?php }?></td>
                <td><?php if($result->export==1){?><i class="fa fa-check"></i><?php } else {?><i class="fa fa-times"></i><?php }?></td>
                <td><?php if($result->print==1){?><i class="fa fa-check"></i><?php } else {?><i class="fa fa-times"></i><?php }?></td>
                <td align="right">
                    <div class="btn-group">
                        <a data-toggle="modal" href="<?php echo base_url().'backend/permisos/view/'.$result->id_permission ?>" data-target="#myModal" class="btn btn-info"><i class="fa fa-search"></i></a>
                        <?php if($permisos_efectivos->update==1) { ?><a href="<?php echo base_url().'backend/permisos/edit/'.$result->id_permission ?>" class="btn btn-success"><i class="fa fa-edit"></i></a><?php } ?>
                        <?php if($permisos_efectivos->delete==1) { ?><a onClick="eleminarRegistro('<?php echo base_url().'backend/permisos/delete/'.$result->id_permission ?>')" href="#" class="btn btn-danger"><i class="fa fa-trash-o"></i></a><?php } ?>
                    </div>
                </td>
              </tr>
              <?php } ?>
            </tbody>
        </table>
    </div>
  </div>
</div>