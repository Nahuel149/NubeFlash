<div class="col-lg-12">
  <div class="element-box">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <h5>Lista de usuarios</h5>
                    </div>
                </div>
                <div class="col-md-6 text-right">
                    <?php if($permisos_efectivos->insert==1) { ?> <a href="<?php echo base_url().'backend/users/add/' ?>" class="btn btn-success"><i class="fa fa-plus"></i> Nuevo Usuario</a><?php } ?>
                </div>
            </div>
            <hr>          
        </div>
    </div>
    <div class="table-responsive">
        <table id="dataTable1" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Apellido, Nombre</th>
                    <th>Grupo</th>
                    <th>Estado</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            foreach ($results as $result) { ?>
            <tr>
                <td><?php echo $result->id_user ?></td>
                <td><?php echo $result->username ?></td>
                <td><?php echo $result->email ?></td>
                <td><?php echo $result->surname.", ".$result->name ?></td>
                <td><?php echo $result->nombre_grupo ?></td>
                <td><?php if($result->active==1){?><i class="fa fa-check"></i><?php } else {?><i class="fa fa-times"></i><?php }?></td>
                <td align="right">
                    <div class="btn-group">
                        <a data-toggle="modal" href="<?php echo base_url().'backend/users/view/'.$result->id_user ?>" data-target="#myModal" class="btn btn-info"><i class="fa fa-search"></i></a>
                        <?php if($permisos_efectivos->update==1) { ?><a href="<?php echo base_url().'backend/users/edit/'.$result->id_user ?>" class="btn btn-success"><i class="fa fa-edit"></i></a><?php } ?>
                        <a href="<?php echo base_url().'backend/users/cambiar_password/'.$result->id_user ?>" class="btn btn-primary"><i class="fa fa-key"></i></a>
                        <?php if($permisos_efectivos->delete==1) { ?>
                            <a title="Eliminar" href="javascript:void(0);" class="btn btn-danger delete-btn" 
                               data-user-id="<?php echo $result->id_user ?>"
                               data-delete-url="<?php echo base_url().'backend/users/delete/'.$result->id_user ?>">
                                <i class="fa fa-trash"></i>
                            </a>
                        <?php } ?>
                    </div>
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
  </div>
</div>
<script type="text/javascript">
function eleminarRegistro(deleteUrl) {
    if (confirm('¿Está seguro que desea eliminar este registro?')) {
        $.ajax({
            type: "POST",  // Changed to POST
            url: deleteUrl,
            data: {
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    window.location.reload();
                } else {
                    alert(response.message || 'Error al eliminar el registro');
                }
            },
            error: function(xhr, status, error) {
                console.error("Error in delete request:", error);
                alert("Ocurrió un error al eliminar el registro. Por favor, inténtelo de nuevo.");
            }
        });
    }
    return false;
}

// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM loaded, initializing delete buttons");
    
    // Find all delete buttons
    var deleteButtons = document.querySelectorAll('.delete-btn');
    console.log("Found " + deleteButtons.length + " delete buttons");
    
    // Add click event listener to each delete button
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            var deleteUrl = this.getAttribute('data-delete-url');
            var userId = this.getAttribute('data-user-id');
            
            console.log("Delete button clicked for user ID: " + userId);
            
            if (deleteUrl) {
                console.log("Calling eleminarRegistro with URL: " + deleteUrl);
                try {
                    eleminarRegistro(deleteUrl);
                } catch (error) {
                    console.error("Error in eleminarRegistro:", error);
                    alert("Ocurrió un error al procesar la solicitud: " + error.message);
                }
            } else {
                console.error("No delete URL found for user ID: " + userId);
                alert("Error: No se pudo determinar la URL para eliminar este registro.");
            }
        });
    });
});
</script>