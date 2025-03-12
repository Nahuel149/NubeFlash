<div class="col-lg-12">
  <div class="element-box">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <h5>Lista de grupos</h5>
                    </div>
                </div>
                <div class="col-md-6 text-right">
                  <?php if($permisos_efectivos->insert==1) { ?> <a href="<?php echo base_url().'backend/groups/add/' ?>" class="btn btn-success"><i class="fa fa-plus"></i> Nuevo Grupo</a><?php } ?>
                </div>
            </div>
            <hr>          
        </div>
    </div>
    <div class="table-responsive">
      <table id="dataTable1" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
          <thead>
              <tr>
                  <th width="10%">ID</th>
                  <th>Nombre</th>
                  <th>Descripcion</th>
                  <th width="15%">&nbsp;</th>
              </tr>
          </thead>
          <tbody>
            <?php 
            foreach ($results as $result) { ?>
              <?php if ($issa == 1): ?>
                
              <tr>
                <td><?php echo $result->id_group ?></td>
                <td><?php echo $result->name ?></td>
                <td><?php echo $result->description ?></td>
                <td align="right">
                  <div class="btn-group">
                    <?php if($result->id_group !=1){ ?>
                      <a data-toggle="modal" href="<?php echo base_url().'backend/groups/view/'.$result->id_group ?>" data-target="#myModal" class="btn btn-info"><i class="fa fa-search"></i></a>
                      <?php if($permisos_efectivos->update == 1) { ?><a href="<?php echo base_url().'backend/groups/edit/'.$result->id_group ?>" class="btn btn-success"><i class="fa fa-edit"></i></a><?php } ?>
                      <?php if($permisos_efectivos->delete == 1) { ?><a onClick="eleminarRegistro('<?php echo base_url().'backend/groups/delete/'.$result->id_group ?>')" href="#" class="btn btn-danger"><i class="fa fa-trash-o"></i></a><?php } ?>
                    <?php } ?>
                  </div>
                </td>
              </tr>
              <?php else: ?>
                <?php if ($result->id_group != 1 && $result->id_group != 2): ?>
                  <tr>
                    <td><?php echo $result->id_group ?></td>
                    <td><?php echo $result->name ?></td>
                    <td><?php echo $result->description ?></td>
                    <td align="right">
                      <div class="btn-group">
                        <?php if($result->id_group !=1){ ?>
                          <a data-toggle="modal" href="<?php echo base_url().'backend/groups/view/'.$result->id_group ?>" data-target="#myModal" class="btn btn-info"><i class="fa fa-search"></i></a>
                          <?php if($permisos_efectivos->update == 1) { ?><a href="<?php echo base_url().'backend/groups/edit/'.$result->id_group ?>" class="btn btn-success"><i class="fa fa-edit"></i></a><?php } ?>
                          <?php if($permisos_efectivos->delete == 1) { ?><a onClick="eleminarRegistro('<?php echo base_url().'backend/groups/delete/'.$result->id_group ?>')" href="#" class="btn btn-danger"><i class="fa fa-trash-o"></i></a><?php } ?>
                        <?php } ?>
                      </div>
                    </td>
                  </tr>
                <?php endif ?>
              <?php endif ?>
            <?php } ?>
          </tbody>
      </table>
    </div>
  </div>
</div>