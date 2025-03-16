<div class="col-lg-12">
    <div class="element-box">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <h5>Lista de Empresas/Clientes</h5>
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        <?php if($permisos_efectivos->insert==1) { ?> <a href="<?php echo base_url().'ecommerce/customers/add/' ?>" class="btn btn-success"><i class="fa fa-plus"></i> Nueva Empresa/Cliente</a><?php } ?>
                    </div>
                </div>
                <hr>          
            </div>
        </div>
        <table id="dataTable1" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
            <thead>
                <tr>
                    <th><a href="#">ID</a></th>
                    <th><a href="#">razón social</a></th>
                    <th><a href="#">identificador fiscal</a></th>
                    <th><a href="#">persona de contacto</a></th>
                    <th><a href="#">telefono</a></th>
                    <th><a href="#">correo electronico</a></th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($results as $result) { ?>
                    <tr>
                        <td><?php echo $result->customer_id ?></td>
                        <td><?php echo $result->social_reason ?></td>
                        <td><?php echo $result->fiscal_identifier ?></td>
                        <td><?php echo $result->person_contact ?></td>
                        <td><?php echo $result->telephone ?></td>
                        <td><?php echo $result->email ?></td>
                        <td align="right" width="15%">
                          <div class="btn-group">
                            <a data-toggle="modal" href="<?php echo base_url().'ecommerce/customers/view/'.$result->customer_id ?>" data-target="#myModal" class="btn btn-info"><i class="fa fa-search"></i></a>
                            <a title="Ver Envios" href="<?php echo base_url().'ecommerce/customers/shippingCustomer/'.$result->customer_id ?>" class="btn btn-warning"><i class="fa fa-eye"></i></a>
                            <a title="Ver Tokens" href="<?php echo base_url().'ecommerce/customers/view_tokens/'.$result->customer_id ?>" class="btn btn-primary"><i class="fas fa-key"></i></a>
                            <?php if($permisos_efectivos->update==1) { ?><a href="<?php echo base_url().'ecommerce/customers/edit/'.$result->customer_id ?>" class="btn btn-success"><i class="fa fa-edit"></i></a><?php } ?>
                            <?php if($permisos_efectivos->delete==1) { ?>
                              <a title="Eliminar" href="javascript:void(0);" class="btn btn-danger delete-btn" 
                                 data-customer-id="<?php echo $result->customer_id ?>"
                                 data-delete-url="<?php echo base_url().'ecommerce/customers/delete/'.$result->customer_id ?>">
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

<script>
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
            var customerId = this.getAttribute('data-customer-id');
            
            console.log("Delete button clicked for customer ID: " + customerId);
            
            if (deleteUrl) {
                console.log("Calling eleminarRegistro with URL: " + deleteUrl);
                try {
                    eleminarRegistro(deleteUrl);
                } catch (error) {
                    console.error("Error in eleminarRegistro:", error);
                    alert("Ocurrió un error al procesar la solicitud: " + error.message);
                }
            } else {
                console.error("No delete URL found for customer ID: " + customerId);
                alert("Error: No se pudo determinar la URL para eliminar este registro.");
            }
        });
    });
});
</script>