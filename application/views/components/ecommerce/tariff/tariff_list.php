<div class="col-lg-12">
    <div class="element-box">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <h5>Lista de Tarifas</h5>
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        <?php if($permisos_efectivos->insert==1) { ?> <a href="<?php echo base_url().'ecommerce/tariff/add/' ?>" class="btn btn-success"><i class="fa fa-plus"></i> Nueva Tarifa</a><?php } ?>
                    </div>
                </div>
                <hr>          
            </div>
        </div>
        <table id="dataTable1" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
            <thead>
                <tr>
                    <th><a href="#">ID</a></th>
                    <th><a href="#">País</a></th>
                    <th><a href="#">Departamento/Provincia</a></th>
                    <th><a href="#">Localidad</a></th>
                    <th><a href="#">Codigo Postal</a></th>
                    <th><a href="#">Tarifa Precio</a></th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($results as $result) { ?>
                    <tr>
                        <td><?php echo $result->tariff_id ?></td>
                        <td><?php echo $result->country ?></td>
                        <td><?php echo $result->display_province ?></td>
                        <td><?php echo $result->display_destination ?></td>
                        <td><?php echo $result->display_postal_code ?></td>
                        <td><?php echo '$ '.$result->tariff_price ?></td>
                        <td align="right" width="15%">
                          <div class="btn-group">
                            <a data-toggle="modal" href="<?php echo base_url().'ecommerce/tariff/view/'.$result->tariff_id ?>" data-target="#myModal" class="btn btn-info"><i class="fa fa-search"></i></a>
                            <?php if($permisos_efectivos->update==1) { ?><a href="<?php echo base_url().'ecommerce/tariff/edit/'.$result->tariff_id ?>" class="btn btn-success"><i class="fa fa-edit"></i></a><?php } ?>
                            <?php if($permisos_efectivos->delete==1) { ?><a onClick="eleminarRegistro('<?php echo base_url().'ecommerce/tariff/delete/'.$result->tariff_id ?>')" href="#" class="btn btn-danger"><i class="fa fa-trash"></i></a><?php } ?>
                          </div>
                        </td>
                    </tr>
              <?php } ?>
            </tbody>
        </table>
    </div>
</div>