<div class="col-lg-12">
    <div class="ibox-content">
        <div class="text-right">            
            <?php if($permisos_efectivos->insert==1) { ?> <a href="<?php echo base_url().'audits/add/' ?>" class="btn btn-success"><i class="fa fa-plus"></i> Nueva Categoria</a><?php } ?><hr>
        </div>
        <table id="results" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
            <thead>
                <tr>
                    <th class="col-md-1"><a href="#">ID</a></th>
                    <th><a href="#">Id_audit</a></th>
<th><a href="#">Id_user</a></th>
<th><a href="#">Query</a></th>
<th><a href="#">Date</a></th>
<th><a href="#">Active</a></th>
<th><a href="#">Created_at</a></th>
<th><a href="#">Updated_at</a></th>
<th><a href="#">Deleted_at</a></th>
<th><a href="#">Create_by</a></th>
<th><a href="#">Update_by</a></th>
<th><a href="#">Delete_by</a></th>
                    <th class="col-md-2">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($results as $result) { ?>
                  <tr>
                    <td><?php echo $result->id ?></td>
                    <td><?php echo $result->id_audit ?></td>
<td><?php echo $result->id_user ?></td>
<td><?php echo $result->query ?></td>
<td><?php echo $result->date ?></td>
<td><?php echo $result->active ?></td>
<td><?php echo $result->created_at ?></td>
<td><?php echo $result->updated_at ?></td>
<td><?php echo $result->deleted_at ?></td>
<td><?php echo $result->create_by ?></td>
<td><?php echo $result->update_by ?></td>
<td><?php echo $result->delete_by ?></td>
                    <td>
                      <div class="btn-group">
                        <a data-toggle="modal" href="<?php echo base_url().'audits/view/'.$result->id ?>" data-target="#myModal" class="btn btn-info"><i class="fa fa-search"></i></a>
                        <?php if($permisos_efectivos->update==1) { ?><a href="<?php echo base_url().'audits/edit/'.$result->id ?>" class="btn btn-success"><i class="fa fa-edit"></i></a><?php } ?>
                        <?php if($permisos_efectivos->delete==1) { ?><a onClick="eleminarRegistro('<?php echo base_url().'audits/delete/'.$result->id ?>')" href="#" class="btn btn-danger"><i class="fa fa-trash-o"></i></a><?php } ?>
                      </div>
                    </td>
                  </tr>
              <?php } ?>
            </tbody>
        </table>
    </div>
</div>