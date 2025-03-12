<div class="col-lg-12">
    <div class="element-box">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <h5>Lista de sliders</h5>
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        <?php if($permisos_efectivos->insert==1) { ?> <a href="<?php echo base_url().'cms/slider/add/' ?>" class="btn btn-success"><i class="fa fa-plus"></i> Nuevo Slider</a><?php } ?>
                    </div>
                </div>
                <hr>          
            </div>
        </div>
        <div class="table-responsive">
            <table id="dataTable1" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
                <thead>
                    <tr>
                        <th width="10%"><a href="#">ID</a></th>
                        <th><a href="#">Nombre</a></th>
                        <th width="10%"><a href="#">Imagen</a></th>
                        <th width="15%"><a href="#">Fecha</a></th>
                        <th width="15%">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $result) { ?>
                        <tr>
                            <td><?php echo $result->id_image ?></td>
                            <td><?php echo $result->name ?></td>
                            <td>
                                <?php if (!empty($result->image)): ?>
                                    <a href="<?php echo base_url('uploads/img_slider/'.$result->image) ?>" class="fancybox btn btn-primary"><i class="fa fa-picture-o"></i></a>
                                <?php endif ?>
                            </td>
                            <td><?php echo date('d/m/Y h:i a', strtotime($result->created_at)) ?></td>
                            <td align="right">
                                <div class="btn-group">
                                    <a data-toggle="modal" href="<?php echo base_url().'cms/slider/view/'.$result->id_image ?>" data-target="#myModal" class="btn btn-info"><i class="fa fa-search"></i></a>
                                    <?php if($permisos_efectivos->update==1) { ?><a href="<?php echo base_url().'cms/slider/edit/'.$result->id_image ?>" class="btn btn-success"><i class="fa fa-edit"></i></a><?php } ?>
                                    <?php if($permisos_efectivos->delete==1) { ?><a onClick="eleminarRegistro('<?php echo base_url('cms/slider/delete/'.$result->id_image) ?>')" href="#" class="btn btn-danger"><i class="fa fa-trash-o"></i></a><?php } ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>