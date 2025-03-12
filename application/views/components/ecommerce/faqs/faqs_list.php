<div class="col-lg-12">
    <div class="element-box">
        <div class="table-responsive">
            <div class="text-right">            
                <?php if($permisos_efectivos->insert==1) { ?> <a href="<?php echo base_url().'ecommerce/faqs/add/' ?>" class="btn btn-success"><i class="fa fa-plus"></i> Nueva Pregunta</a><?php } ?><hr>
            </div>
            <table id="dataTable1" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
                <thead>
                    <tr>
                        <th><a href="#">ID</a></th>
                        <th><a href="#">Pregunta</a></th>
                        <th><a href="#">Respuesta</a></th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                  <?php foreach ($results as $result) { ?>
                        <tr>
                            <td><?php echo $result->id_faq ?></td>
                            <td><?php echo $result->question ?></td>
                            <td><?php echo $result->answer ?></td>
                            <td align="right" width="15%">
                              <div class="btn-group">
                                <a data-toggle="modal" href="<?php echo base_url().'ecommerce/faqs/view/'.$result->id_faq ?>" data-target="#myModal" class="btn btn-info"><i class="fa fa-search"></i></a>
                                <?php if($permisos_efectivos->update==1) { ?><a href="<?php echo base_url().'ecommerce/faqs/edit/'.$result->id_faq ?>" class="btn btn-success"><i class="fa fa-edit"></i></a><?php } ?>
                                <?php if($permisos_efectivos->delete==1) { ?><a onClick="eleminarRegistro('<?php echo base_url().'ecommerce/faqs/delete/'.$result->id_faq ?>')" href="#" class="btn btn-danger"><i class="fa fa-trash-o"></i></a><?php } ?>
                              </div>
                            </td>
                        </tr>
                  <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>