<section class="documentacion mt-3 mt-md-0">
    <div class="container">
        <div class="row">
            <div class="col-md-3 mb-4">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Token</a>
                <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Cotización de envios</a>
                <a class="nav-link d-none" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Envios de pedidos</a>
            </div>
            <img class="img-fluid" src="<?php echo base_url('assets/public/camion-nf.png') ?>" alt="Camión">
            </div>
            <div class="col-md-9">
                <div class="row">
                <div class="tab-content w-100" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <div class="container">
                            <div class="mb-3"><strong class="title-api-docs">Token</strong></div>
                            <p>Para obtener el token debe crearse su cuenta a través de esta plataforma, llenando los campos necesarios en los registros.</p>
                            <p>Luego de registrarse, le brindaremos dos token que se utilizara para integrar las APIs  de la nube.</p>
                        </div>
                        <div class="text-center mt-4 mb-4">
                            <a href="<?php echo base_url('registro') ?>" title="Regístrate ahora">
                                <img class="img-fluid delivery-img" src="<?php echo base_url('assets/public/DELIVERY_NF.png') ?>" alt="Delivery Illustration" style="max-width: 75%; /* This makes it 1.5x bigger than 50% */">
                            </a>
                        </div> 
                    </div>
                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                        <div class="container">
                            <div class="mb-3"><strong class="title-api-docs">Cotización</strong></div>
                            <p>
                                Enviar el siguiente formato (JSON) a la siguiente url: "<?php echo base_url('api/get-shippingCost')  ?>"
                            </p>
                            <pre><code data-lang="html">{
    "token":"*******************************",
    "data_client": {
        "postal_code":"client_postal_code",
        "client":"client_name",
        "reference":"client_address"
    },
    "weight":"10",
    "depth":"5",
    "width":"1",
    "height":"2"
}</code></pre>
                            <p>Después de enviar los datos correctamente, la API retornara un mensaje de éxito y la respectiva cotización del envío. </p>
                            <p>Note: El parámetro `weight` debe proporcionarse en gramos (g), y los parámetros `depth`, `width`, `height` deben proporcionarse en centímetros (cm).</p>
<pre>{
    "status": "success",
    "data": {
        "price_item": "20.00",
        "calculated_volume_cm3": 10
    }
}</pre>
                            <p>La respuesta incluye el `price_item` (precio del envío) y el `calculated_volume_cm3`, que es el volumen calculado automáticamente a partir de las dimensiones (depth * width * height) en centímetros cúbicos (cm³).</p>
                            <p>Aquí una representacion de los posibles errores retornados de la API.</p>
                            <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="title-api-docs">RESPUESTA</th>
                                        <th class="title-api-docs">DESCRIPCION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>
<pre>{
    "status": "error",
    "data": {
        "message": "Country doesn't match"
    }
}</pre>
                                        </th>
                                        <th>
                                            <p>
                                                En este caso, el error indica que el codigo postal consultado no coincide con el pais de la empresa/cliente.
                                            </p>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
<pre>{
    "status": "error",
    "data": {
        "message": "Tariff no Exists"
    }
}</pre>
                                        </th>
                                        <th>
                                            <p>
                                                En este caso, el error indica que no encontro una tarifa para las dimensiones del paquete o pedido.
                                            </p>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
<pre>{
    "status": "error",
    "data": {
        "message": "Undifined weight"
    }
}</pre>
                                        </th>
                                        <th>
                                            <p>
                                                En este caso, el error indica que recibio el campo "weight" vacio, en las dimensiones del paquete.
                                            </p>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
<pre>{
    "status": "error",
    "data": {
        "message": "Volume Invalid"
    }
}</pre>
                                        </th>
                                        <th>
                                            <p>
                                                En este caso, el error indica que el volumen enviado no coincide con la operacion de las dimensiones enviadas del paquete. El volumen se calcula automáticamente a partir de las dimensiones.
                                            </p>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
<pre>{
    "status": "error",
    "data": {
        "message": "Undifined volume"
    }
}</pre>
                                        </th>
                                        <th>
                                            <p>
                                                En este caso, el error indica que no se pudo calcular el volumen a partir de las dimensiones. Asegúrese de que los valores de depth, width y height sean numéricos y mayores que cero.
                                            </p>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
<pre>{
    "status": "error",
    "data": {
        "message": "Token is invalid"
    }
}</pre>
                                        </th>
                                        <th>
                                            <p>
                                                En este caso, el error indica que el token enviado, no es correcto y no existe en nuestra base de datos, lo cual no permitira interactuar con nuestra API.
                                            </p>
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade d-none" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                    <div class="container">
                            <div class="mb-3"><strong class="title-api-docs">Envios</strong></div>
                            <p>Enviar el siguiente formato (JSON) a la siguiente url: "<?php echo base_url('api/send-order')  ?>"</p>
<pre>{
    "token":"****************************",
    "data_client": {
        "postal_code":"client_postal_code",
        "client":"client_name",
        "reference":"client_address"
    },
    "weight":"10",
    "depth":"5",
    "width":"1",
    "height":"2"
}</pre>
                            
                            <p>Después de enviar los datos correctamente, la API retornara un mensaje de exito y el codigo del envío para su respectivo seguimiento.</p>
                            <p>Note: El parámetro `weight` debe proporcionarse en gramos (g), y los parámetros `depth`, `width`, `height` deben proporcionarse en centímetros (cm).</p> 
<pre>{
    "status": "Success",
    "data": {
        "code_tracking": "*****************************"
    }
}</pre>  
                            <p>Aquí una representacion de los posibles errores retornados de la API.</p>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="title-api-docs">RESPUESTA</th>
                                            <th class="title-api-docs">DESCRIPCION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>
<pre>{
    "status": "error",
    "data": {
        "message": "Tariff no Exists"
    }
}</pre>
                                            </th>
                                            <th>
                                                <p>
                                                    En este caso, el error indica que no encontro una tarifa para las dimensiones del paquete o pedido.
                                                </p>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
<pre>{
    "status": "error",
    "data": {
        "message": "Undifined weight"
    }
}</pre>
                                            </th>
                                            <th>
                                                <p>
                                                    En este caso, el error indica que recibio el campo "weight" vacio, en las dimensiones del paquete.
                                                </p>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
<pre>{
    "status": "error",
    "data": {
        "message": "Volume Invalid"
    }
}</pre>
                                            </th>
                                            <th>
                                                <p>
                                                    En este caso, el error indica que el volumen enviado no coincide con la operacion de las dimensiones enviadas del paquete.
                                                </p>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class=" align-self-center">
<pre>{
    "status": "error",
    "data": {
        "message": "Undifined volume"
    }
}</pre>
                                            </th>
                                            <th>
                                                <p>
                                                    En este caso, el error indica que no se pudo calcular el volumen a partir de las dimensiones. Asegúrese de que los valores de depth, width y height sean numéricos y mayores que cero.
                                                </p>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
<pre>{
    "status": "error",
    "data": {
        "message": "Token is invalid"
    }
}</pre>
                                            </th>
                                            <th>
                                                <p>
                                                    En este caso, el error indica que el token enviado, no es correcto y no existe en nuestra base de datos, lo cual no permitira interactuar con nuestra API.
                                                </p>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>               
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>
