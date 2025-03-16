<section class="dashboard">
    <div class="container">
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>CLIENTE</th>
                            <th>FECHA</th>
                            <th>DESTINO</th>
                            <th>TARIFA</th>
                            <th>TRACKING</th>
                            <th>ESTADO</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($orders as $order) { ?>
                        <tr>
                            <td><?php echo $order->order_id ?></td>
                            <td><?php echo $order->client ?></td>
                            <td><?php echo date('d/m/Y H:i:s', strtotime($order->created_at)); ?></td>
                            <td><?php echo $order->destination ?></td>
                            <td><?php echo '$ '.$order->price ?></td>
                            <td><?php echo $order->tracking_number ? $order->tracking_number : 'N/A'; ?></td>
                            <td><?php echo $order->status ?></td>
                            <td class="pt-0" align="right">
                                <div class="btn-group">
                                    <a data-toggle="tooltip" data-placement="bottom" data-id="<?php echo $order->order_id ?>" href="#" title="Detalle" class="btn btn-link detalle"><i class="far fa-eye icon-categories"></i></a>
                                    <a data-toggle="tooltip" data-placement="bottom" data-id="<?php echo $order->order_id ?>" href="#" title="Editar" class="btn btn-link editar"><i class="fas fa-edit icon-categories"></i></a>
                                    <a data-toggle="tooltip" data-placement="bottom" data-id="<?php echo $order->order_id ?>" href="#" title="Eliminar" class="btn btn-link eliminar"><i class="fas fa-trash-alt icon-categories"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>   
</section>

<!-- Modal para detalles del pedido -->
<div class="modal fade" id="modalDetalle" tabindex="-1" role="dialog" aria-labelledby="modalDetalleLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetalleLabel" tabindex="-1">Detalle del Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="detalleContenido">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Cargando...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar pedido -->
<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarLabel" tabindex="-1">Editar Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEditarPedido">
                    <input type="hidden" id="edit_order_id" name="order_id">
                    <div class="form-group">
                        <label for="edit_client">Cliente</label>
                        <input type="text" class="form-control" id="edit_client" name="client" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_reference">Referencia</label>
                        <input type="text" class="form-control" id="edit_reference" name="reference">
                    </div>
                    <div class="form-group">
                        <label for="edit_tracking_number">Número de Tracking</label>
                        <input type="text" class="form-control" id="edit_tracking_number" name="tracking_number">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarEdicion">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación para eliminar -->
<div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="modalEliminarLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEliminarLabel" tabindex="-1">Confirmar Eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro que desea eliminar este pedido?</p>
                <input type="hidden" id="delete_order_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">Eliminar</button>
            </div>
        </div>
    </div>
</div>