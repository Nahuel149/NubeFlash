<div class="col-lg-12">
    <div class="element-box">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <h5>Lista de Pedidos</h5>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="<?php echo base_url('ecommerce/orders') ?>">Pedidos</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <hr>          
            </div>
        </div>
        <table id="dataTable1" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
            <thead>
                <tr>
                    <th><a href="#">ID</a></th>
                    <th><a href="#">CLIENTE</a></th>
                    <th><a href="#">FECHA</a></th>
                    <th><a href="#">DESTINO</a></th>
                    <th><a href="#">TARIFA</a></th>
                    <th><a href="#">ESTADO</a></th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $result) { ?>
                    <tr>
                        <td><?php echo $result->order_id ?></td>
                        <td><?php echo $result->client ?></td>
                        <td><?php echo date('d/m/Y H:i:s', strtotime($result->created_at)); ?></td>
                        <td><?php echo $result->destination ?></td>
                        <td><?php echo '$ '.$result->price ?></td>
                        <td><?php echo $result->status ?></td>
                        <td align="center" width="15%">
                            <div class="d-flex justify-content-center" style="gap: 2px;">
                                <a data-toggle="modal" href="<?php echo base_url().'ecommerce/customers/viewShippingCustomer/'.$result->order_id ?>" data-target="#myModal" class="btn btn-info"><i class="fa fa-search"></i></a>
                                <a href="<?php echo base_url().'ecommerce/orders/edit/'.$result->order_id ?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pedido</button>
                                    <div class="dropdown-menu dropdown-menu-right" style="overflow: hidden;">
                                        <?php foreach ($statuses as $status) { ?>
                                            <button type="button" class="dropdown-item" data-type="estado" 
                                                data-order_id="<?= $result->order_id ?>" 
                                                data-status="<?= $result->status ?>" 
                                                data-newstatus="<?= $status->name ?>" 
                                                data-newstatus_id="<?= $status->status_id ?>">
                                                <?= $status->name ?>
                                            </button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Hidden form for status changes -->
<form id="status-change-form" method="POST" action="<?php echo base_url(); ?>ecommerce/orders/changeStatus" style="display: none;">
    <input type="hidden" name="status_id" id="status_id_input" value="">
    <input type="hidden" name="order_id" id="order_id_input" value="">
    <?php 
    // Include CSRF token
    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
    );
    ?>
    <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>">
</form>

<script>
    // Wait for the document to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Set up dropdown buttons for status changes
        var statusButtons = document.querySelectorAll('button[data-type="estado"]');
        var form = document.getElementById('status-change-form');
        var statusIdInput = document.getElementById('status_id_input');
        var orderIdInput = document.getElementById('order_id_input');
        
        statusButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var status = this.getAttribute('data-status');
                var newStatus = this.getAttribute('data-newstatus');
                var newStatusId = this.getAttribute('data-newstatus_id');
                var orderId = this.getAttribute('data-order_id');
                
                // Confirm before changing status
                if (confirm('¿Seguro que quiere cambiar el pedido de ' + status + ' a ' + newStatus + '?')) {
                    // Set form values
                    statusIdInput.value = newStatusId;
                    orderIdInput.value = orderId;
                    
                    // Submit the form
                    form.submit();
                }
            });
        });
    });
</script>