/**
 * Orders management functionality
 */
jQuery(document).ready(function($) {
    
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Store the element that had focus before opening a modal
    var lastFocusedElement;
    
    // Fix accessibility issues with modals
    $('.modal').on('show.bs.modal', function() {
        // Store the element that currently has focus
        lastFocusedElement = document.activeElement;
        
        // When the modal is shown, set focus on the first focusable element
        $(this).find('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])').first().focus();
    });
    
    // When modal is hidden, restore focus to the element that had it before
    $('.modal').on('hidden.bs.modal', function() {
        if (lastFocusedElement) {
            lastFocusedElement.focus();
        }
    });
    
    /**
     * Show order details
     */
    $(document).on('click', '.detalle', function(e) {
        e.preventDefault();
        
        var orderId = $(this).data('id');
        
        // Show modal
        $('#modalDetalle').modal('show');
        
        // Reset content
        $('#detalleContenido').html('<div class="text-center"><div class="spinner-border" role="status"><span class="sr-only">Cargando...</span></div></div>');
        
        // Fetch order details
        $.ajax({
            url: base_url + 'frontend/private/dashboard/get_order_details',
            type: 'POST',
            dataType: 'json',
            data: {
                order_id: orderId,
                [csrf_token_name]: csrf_hash
            },
            success: function(response) {
                // Update CSRF hash with new token if provided in the response headers
                var csrf_hash_name = csrf_token_name;
                if (response[csrf_hash_name]) {
                    csrf_hash = response[csrf_hash_name];
                }
                
                if (response.success) {
                    var order = response.data;
                    var html = '<div class="row">';
                    
                    // Order details
                    html += '<div class="col-md-6">';
                    html += '<h5>Información del Pedido</h5>';
                    html += '<table class="table table-bordered">';
                    html += '<tr><th>ID:</th><td>' + order.order_id + '</td></tr>';
                    html += '<tr><th>Número de Orden:</th><td>' + order.order_number + '</td></tr>';
                    html += '<tr><th>Cliente:</th><td>' + order.client + '</td></tr>';
                    html += '<tr><th>Referencia:</th><td>' + (order.reference || 'N/A') + '</td></tr>';
                    html += '<tr><th>Fecha:</th><td>' + order.created_at + '</td></tr>';
                    html += '<tr><th>Estado:</th><td>' + order.status + '</td></tr>';
                    html += '<tr><th>Tracking:</th><td>' + (order.tracking_number || 'N/A') + '</td></tr>';
                    html += '</table>';
                    html += '</div>';
                    
                    // Shipping details
                    html += '<div class="col-md-6">';
                    html += '<h5>Información de Envío</h5>';
                    html += '<table class="table table-bordered">';
                    html += '<tr><th>Destino:</th><td>' + order.destination + '</td></tr>';
                    html += '<tr><th>Código Postal:</th><td>' + (order.postal_code || 'N/A') + '</td></tr>';
                    html += '<tr><th>País:</th><td>' + order.country + '</td></tr>';
                    html += '<tr><th>Provincia:</th><td>' + order.province + '</td></tr>';
                    html += '<tr><th>Tarifa:</th><td>$' + order.price + '</td></tr>';
                    html += '<tr><th>Peso:</th><td>' + (order.weight || 'N/A') + '</td></tr>';
                    html += '<tr><th>Volumen:</th><td>' + (order.volume || 'N/A') + '</td></tr>';
                    html += '</table>';
                    html += '</div>';
                    
                    // Shipping data if available
                    if (order.shipping_data) {
                        html += '<div class="col-md-12 mt-3">';
                        html += '<h5>Datos de Envío Adicionales</h5>';
                        html += '<table class="table table-bordered">';
                        
                        if (order.shipping_data.store && order.shipping_data.store.name) {
                            html += '<tr><th>Tienda:</th><td>' + order.shipping_data.store.name + '</td></tr>';
                        }
                        
                        if (order.shipping_data.email) {
                            html += '<tr><th>Email:</th><td>' + order.shipping_data.email + '</td></tr>';
                        }
                        
                        if (order.shipping_data.address) {
                            html += '<tr><th>Dirección:</th><td>' + order.shipping_data.address + '</td></tr>';
                        }
                        
                        if (order.shipping_data.telephone) {
                            html += '<tr><th>Teléfono:</th><td>' + order.shipping_data.telephone + '</td></tr>';
                        }
                        
                        html += '</table>';
                        html += '</div>';
                    }
                    
                    // Items if available
                    if (order.items && order.items.length > 0) {
                        html += '<div class="col-md-12 mt-3">';
                        html += '<h5>Items</h5>';
                        html += '<table class="table table-bordered">';
                        html += '<thead><tr><th>Nombre</th><th>Cantidad</th><th>Precio</th></tr></thead>';
                        html += '<tbody>';
                        
                        for (var i = 0; i < order.items.length; i++) {
                            var item = order.items[i];
                            html += '<tr>';
                            html += '<td>' + (item.name || 'N/A') + '</td>';
                            html += '<td>' + (item.quantity || '1') + '</td>';
                            html += '<td>$' + (item.price || '0.00') + '</td>';
                            html += '</tr>';
                        }
                        
                        html += '</tbody>';
                        html += '</table>';
                        html += '</div>';
                    }
                    
                    html += '</div>'; // Close row
                    
                    $('#detalleContenido').html(html);
                    
                    // Set focus to the modal after content is loaded
                    $('#modalDetalle').find('.modal-title').focus();
                } else {
                    $('#detalleContenido').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                var errorMessage = 'Error al cargar los detalles del pedido.';
                
                if (xhr.status === 403) {
                    errorMessage = 'Error de seguridad. Por favor recargue la página e intente nuevamente.';
                }
                
                $('#detalleContenido').html('<div class="alert alert-danger">' + errorMessage + '</div>');
            }
        });
    });
    
    /**
     * Show edit form
     */
    $(document).on('click', '.editar', function(e) {
        e.preventDefault();
        
        var orderId = $(this).data('id');
        
        // Show modal
        $('#modalEditar').modal('show');
        
        // Reset form
        $('#formEditarPedido')[0].reset();
        $('#edit_order_id').val(orderId);
        
        // Fetch order details to populate form
        $.ajax({
            url: base_url + 'frontend/private/dashboard/get_order_details',
            type: 'POST',
            dataType: 'json',
            data: {
                order_id: orderId,
                [csrf_token_name]: csrf_hash
            },
            success: function(response) {
                // Update CSRF hash with new token if provided in the response headers
                var csrf_hash_name = csrf_token_name;
                if (response[csrf_hash_name]) {
                    csrf_hash = response[csrf_hash_name];
                }
                
                if (response.success) {
                    var order = response.data;
                    $('#edit_client').val(order.client);
                    $('#edit_reference').val(order.reference);
                    $('#edit_tracking_number').val(order.tracking_number);
                    
                    // Set focus to the first input field
                    $('#edit_client').focus();
                } else {
                    alert(response.message || 'Error al cargar los datos del pedido.');
                    $('#modalEditar').modal('hide');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                var errorMessage = 'Error al cargar los datos del pedido.';
                
                if (xhr.status === 403) {
                    errorMessage = 'Error de seguridad. Por favor recargue la página e intente nuevamente.';
                }
                
                alert(errorMessage);
                $('#modalEditar').modal('hide');
            }
        });
    });
    
    /**
     * Save order edits
     */
    $(document).on('click', '#btnGuardarEdicion', function() {
        var orderId = $('#edit_order_id').val();
        var client = $('#edit_client').val();
        var reference = $('#edit_reference').val();
        var trackingNumber = $('#edit_tracking_number').val();
        
        if (!client) {
            alert('El campo Cliente es obligatorio.');
            $('#edit_client').focus();
            return;
        }
        
        console.log('Saving order:', orderId, client, reference, trackingNumber);
        console.log('CSRF Token:', csrf_token_name, csrf_hash);
        
        // Save changes
        $.ajax({
            url: base_url + 'frontend/private/dashboard/update_order',
            type: 'POST',
            dataType: 'json',
            data: {
                order_id: orderId,
                client: client,
                reference: reference,
                tracking_number: trackingNumber,
                [csrf_token_name]: csrf_hash
            },
            beforeSend: function() {
                $('#btnGuardarEdicion').prop('disabled', true).text('Guardando...');
            },
            success: function(response) {
                console.log('Response:', response);
                
                // Update CSRF hash with new token if provided in the response headers
                var csrf_hash_name = csrf_token_name;
                if (response[csrf_hash_name]) {
                    csrf_hash = response[csrf_hash_name];
                }
                
                if (response.success) {
                    $('#modalEditar').modal('hide');
                    alert(response.message);
                    // Reload page to show updated data
                    location.reload();
                } else {
                    alert(response.message || 'Error al guardar los cambios.');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                console.error("Response:", xhr.responseText);
                
                var errorMessage = 'Error al guardar los cambios.';
                
                if (xhr.status === 403) {
                    errorMessage = 'Error de seguridad. Por favor recargue la página e intente nuevamente.';
                }
                
                alert(errorMessage);
            },
            complete: function() {
                $('#btnGuardarEdicion').prop('disabled', false).text('Guardar Cambios');
            }
        });
    });
    
    /**
     * Show delete confirmation
     */
    $(document).on('click', '.eliminar', function(e) {
        e.preventDefault();
        
        var orderId = $(this).data('id');
        
        // Show modal
        $('#modalEliminar').modal('show');
        $('#delete_order_id').val(orderId);
        
        // Set focus to the confirm button
        setTimeout(function() {
            $('#btnConfirmarEliminar').focus();
        }, 500);
    });
    
    /**
     * Confirm delete
     */
    $(document).on('click', '#btnConfirmarEliminar', function() {
        var orderId = $('#delete_order_id').val();
        
        // Delete order
        $.ajax({
            url: base_url + 'frontend/private/dashboard/delete_order',
            type: 'POST',
            dataType: 'json',
            data: {
                order_id: orderId,
                [csrf_token_name]: csrf_hash
            },
            success: function(response) {
                // Update CSRF hash with new token if provided in the response headers
                var csrf_hash_name = csrf_token_name;
                if (response[csrf_hash_name]) {
                    csrf_hash = response[csrf_hash_name];
                }
                
                if (response.success) {
                    $('#modalEliminar').modal('hide');
                    alert(response.message);
                    // Reload page to show updated data
                    location.reload();
                } else {
                    alert(response.message || 'Error al eliminar el pedido.');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                var errorMessage = 'Error al eliminar el pedido.';
                
                if (xhr.status === 403) {
                    errorMessage = 'Error de seguridad. Por favor recargue la página e intente nuevamente.';
                }
                
                alert(errorMessage);
            }
        });
    });
}); 