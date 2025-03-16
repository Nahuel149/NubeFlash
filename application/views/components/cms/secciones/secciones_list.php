<div class="col-lg-12">
    <div class="element-box">
      <div class="row">
          <div class="col-md-12">
              <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <h5>Listado de secciones</h5>
                      </div>
                  </div>
              </div><hr>          
          </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive">
            <table id="results" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
                <thead>
                    <tr>
                        <th><a href="#">ID</a></th>
                        <th><a href="#">Nombre</a></th>
                        <th width="10%">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                  <?php foreach ($results as $result) { ?>
                      <tr>
                        <td><?php echo $result->id_section ?></td>
                        <td><?php echo $result->name ?></td>
                        <td align="right">
                            <div class="btn-group">
                                <a data-toggle="modal" href="<?php echo base_url().'cms/secciones/view/'.$result->id_section ?>" data-target="#myModal" class="btn btn-info"><i class="fa fa-search"></i></a>
                                <?php if($permisos_efectivos->update==1) { ?><a href="<?php echo base_url().'cms/secciones/edit/'.$result->id_section ?>" class="btn btn-success"><i class="fa fa-edit"></i></a><?php } ?>
                            </div>
                        </td>
                      </tr>
                  <?php } ?>
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</div>