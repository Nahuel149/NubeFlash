<div class="modal-content">
    <div class="modal-header modal-header-primary">
        <h6><i class="fa fa-search"></i> <?php echo form_hidden('id',$result->order_id) ?></h6>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
    </div>
    <div class="modal-body">
        <?php echo form_hidden('id',$result->order_id) ?>
        <div class="form-group row">
            <div class="col-12">
                <p style="border-bottom: 1px solid;padding-bottom: 0px;font-size: larger;margin-bottom: 8px;">Datos store</p>
            </div>
            <div class="col-6">
                <b>Store:</b> <?php echo isset($shipping_data['store']['name']) ? $shipping_data['store']['name'] : (isset($customer->social_reason) ? $customer->social_reason : '-') ?>
            </div>
            <div class="col-6">
                <b>Email:</b> <?php echo isset($shipping_data['store']['email']) ? $shipping_data['store']['email'] : (isset($customer->email) ? $customer->email : '-') ?>
            </div>
            <div class="col-6">
                <b>País:</b> <?php echo isset($shipping_data['store']['country']) ? $shipping_data['store']['country'] : '-' ?>
            </div>
            <div class="col-6">
                <b>Teléfono:</b> <?php echo isset($shipping_data['store']['telephone']) ? $shipping_data['store']['telephone'] : (isset($customer->telephone) ? $customer->telephone : '-') ?>
            </div>
            <div class="col-6">
                <b>URL:</b> <?php 
                    $domain = isset($shipping_data['store']['domain']) ? $shipping_data['store']['domain'] : '#';
                    echo $domain !== '#' ? "<a href=\"{$domain}\" target=\"_blank\">{$domain}</a>" : '-';
                ?>
            </div>
            <div class="col-6">
                <b>Dirección:</b> <?php echo isset($shipping_data['address']) ? $shipping_data['address'] : (isset($customer->address) ? $customer->address : '-') ?>
            </div>
            <div class="col-6">
                <b>Horario de atención:</b> <?php echo isset($customer->business_hours) ? $customer->business_hours : '-' ?>
            </div>
        </div>
        <div class="form-group row mt-3">
            <div class="col-12">
                <p style="border-bottom: 1px solid;padding-bottom: 0px;font-size: larger;margin-bottom: 8px;">Datos pedido</p>
            </div>
            <div class="col-6">
                <b>Cliente:</b> <?php echo $result->client ?>
            </div>
            <div class="col-6">
                <b>Email:</b> <?php echo isset($shipping_data['email']) ? $shipping_data['email'] : (isset($customer->email) ? $customer->email : '-') ?>
            </div>
            <div class="col-6">
                <b>Provincia:</b> <?php echo $result->province ?>
            </div>
            <div class="col-6">
                <b>Ciudad:</b> <?php echo $result->destination ?>
            </div>
            <div class="col-6">
                <b>Código postal:</b> <?php echo $result->postal_code ?>
            </div>
            <div class="col-6">
                <b>Dirección:</b> <?php echo isset($shipping_data['address']) ? $shipping_data['address'] : (isset($customer->address) ? $customer->address : '-') ?>
            </div>
            <div class="col-6">
                <b>Teléfono:</b> <?php echo isset($shipping_data['telephone']) ? $shipping_data['telephone'] : (isset($customer->telephone) ? $customer->telephone : '-') ?>
            </div>
            <div class="col-6">
                <b>Peso:</b> <?php echo $result->weight . ' kg' ?>
            </div>
            <div class="col-6">
                <b>Volumen:</b> <?php echo $result->volume . ' cm3' ?>
            </div>
            <div class="col-6">
                <b>Tarifa:</b> <?php echo '$ '.$result->price ?>
            </div>
            <div class="col-6">
                <b>Fecha:</b> <?php echo date('d/m/Y H:i:s', strtotime($result->created_at)) ?>
            </div>
            <div class="col-6">
                <b>Estado:</b> <?php echo $result->status ?>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Cerrar</button>
    </div>
</div>