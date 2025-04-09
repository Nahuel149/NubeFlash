<div class="col-lg-12">
    <div class="element-box">
        <h5 class="form-header">Agregar Pedido</h5>
        <hr>
        <form action="<?php echo base_url() ?>ecommerce/orders/add" method="post" id="formAdd">
            <div class="form-group row">
                <div class="col-sm-6">
                    <label for="customer_id">Cliente</label>
                    <select class="form-control" id="customer_id" name="customer_id" required>
                        <option value="">Seleccione un cliente</option>
                        <?php foreach ($customers as $customer) { ?>
                            <option value="<?php echo $customer->customer_id ?>"><?php echo $customer->social_reason ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-6">
                    <label for="status_id">Estado</label>
                    <select class="form-control" id="status_id" name="status_id" required>
                        <option value="">Seleccione un estado</option>
                        <?php foreach ($statuses as $status) { ?>
                            <option value="<?php echo $status->status_id ?>"><?php echo $status->name ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <label for="order_number">Número de Orden</label>
                    <input class="form-control" id="order_number" name="order_number" placeholder="Número de Orden" type="text" required>
                </div>
                <div class="col-sm-6">
                    <label for="tracking_number">Número de Seguimiento</label>
                    <input class="form-control" id="tracking_number" name="tracking_number" placeholder="Número de Seguimiento" type="text">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <label for="client">Cliente</label>
                    <input class="form-control" id="client" name="client" placeholder="Nombre del Cliente" type="text" required>
                </div>
                <div class="col-sm-6">
                    <label for="reference">Referencia</label>
                    <input class="form-control" id="reference" name="reference" placeholder="Referencia" type="text">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <label for="postal_code">Código Postal</label>
                    <input class="form-control" id="postal_code" name="postal_code" placeholder="Código Postal" type="text" required>
                </div>
                <div class="col-sm-6">
                    <label for="tariff_id">Tarifa</label>
                    <input class="form-control" id="tariff_id" name="tariff_id" placeholder="ID de Tarifa" type="number" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-4">
                    <label for="weight">Peso (g)</label>
                    <input class="form-control" id="weight" name="weight" placeholder="Peso en gramos" type="number" step="0.01" required>
                </div>
                <div class="col-sm-4">
                    <label for="volume">Volumen (cm³)</label>
                    <input class="form-control" id="volume" name="volume" placeholder="Volumen en cm³" type="number" step="0.001" required>
                </div>
                <div class="col-sm-4">
                    <label for="total_amount">Monto Total</label>
                    <input class="form-control" id="total_amount" name="total_amount" placeholder="Monto Total" type="number" step="0.01" required>
                </div>
            </div>
            <div class="form-group">
                <label for="shipping_data">Datos de Envío (JSON)</label>
                <textarea class="form-control" id="shipping_data" name="shipping_data" rows="5" placeholder='{"store":{"name":"Nombre de la Tienda","email":"email@tienda.com","country":"País","telephone":"Teléfono","domain":"dominio.com"},"email":"cliente@email.com","province":"Provincia","city":"Ciudad","address":"Dirección","telephone":"Teléfono"}'></textarea>
            </div>
            <div class="form-group">
                <label for="items">Items (JSON)</label>
                <textarea class="form-control" id="items" name="items" rows="3" placeholder='[{"product_id":1,"name":"Producto 1","quantity":1,"price":100},{"product_id":2,"name":"Producto 2","quantity":2,"price":200}]'></textarea>
            </div>
            <div class="form-buttons-w">
                <button class="btn btn-primary" type="submit" name="enviar_form"> Guardar</button>
                <a class="btn btn-default" href="<?php echo base_url() ?>ecommerce/orders">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#formAdd').submit(function(e) {
            // Basic validation
            if ($('#customer_id').val() === '') {
                e.preventDefault();
                alert('Por favor seleccione un cliente');
                return false;
            }
            
            if ($('#status_id').val() === '') {
                e.preventDefault();
                alert('Por favor seleccione un estado');
                return false;
            }
            
            // Validate JSON fields
            try {
                if ($('#shipping_data').val() !== '') {
                    JSON.parse($('#shipping_data').val());
                }
                
                if ($('#items').val() !== '') {
                    JSON.parse($('#items').val());
                }
            } catch (error) {
                e.preventDefault();
                alert('Error en formato JSON: ' + error.message);
                return false;
            }
        });
    });
</script> 