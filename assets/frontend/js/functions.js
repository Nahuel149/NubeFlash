// fuctions -------------------------------------------------
var code_city='';
function metodopagoActivar(elemento) { 
    event.preventDefault();
    var id_payment_method = elemento.attr('data-id');
    var name = elemento.html();
    $.ajax({
        url: base_url + 'frontend/private/ajax_private/metodo_pago_activar',
        type: 'POST',
        dataType: 'json',
        data: {id_payment_method:id_payment_method},
        beforeSend: function()
        {
            elemento.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Cargando</span>');
            elemento.attr('disabled','');
            elemento.removeClass('activar');
            elemento.closest('div.card').removeClass('border-0')
        },
    })
    .done(function(data)
    {
        if (data.success)
        {
            elemento.html(name);
            elemento.removeAttr('disabled');
            elemento.addClass('desactivar');
            elemento.closest('div.card').addClass('border-active')
            if(id_payment_method != 5 && id_payment_method != 7)
            {
                elemento.parent().append('<a href="#" data-id="'+id_payment_method+'" class="credentials">Actualizar credenciales</a>')
            }
            if(id_payment_method == 1)
            {
                $('#modal_mercadopago').modal('show');
            }
            if(id_payment_method == 4)
            {
                $('#modal_paypal').modal('show');
            }
        }
    })
    .fail(function() {
        elemento.html(name);
        elemento.removeAttr('disabled');
        elemento.addClass('activar');
        elemento.closest('div.card').addClass('border-0')

        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}

function metodopagoDesactivar(elemento) { 
    event.preventDefault();
    var id_payment_method = elemento.attr('data-id');
    var name = elemento.html();
    $.ajax({
        url: base_url + 'frontend/private/ajax_private/metodo_pago_desactivar',
        type: 'POST',
        dataType: 'json',
        data: {id_payment_method:id_payment_method},
        beforeSend: function()
        {
            elemento.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Cargando</span>');
            elemento.attr('disabled','');
            elemento.removeClass('desactivar');
            elemento.closest('div.card').removeClass('border-active')
        },
    })
    .done(function(data)
    {
        if (data.success)
        {
            elemento.html(name);
            elemento.removeAttr('disabled');
            elemento.addClass('activar');
            elemento.closest('div.card').addClass('border-0')
            elemento.parent().find('a.credentials').remove();
        }
    })
    .fail(function() {
        elemento.html(name);
        elemento.removeAttr('disabled');
        elemento.addClass('desactivar');
        elemento.closest('div.card').addClass('border-active')
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}

function metodoenvioActivar(elemento) { 
    event.preventDefault();
    var id_shipping = elemento.attr('data-id');
    var name = elemento.html();
    if (id_shipping == 7) {
        $('#aex').removeClass('color-aex');
    }else if (id_shipping == 8){
        $('#moto').removeClass('color-aex');
    }else if (id_shipping == 10){
        $('#uber').removeClass('color-aex');
    }
    if (id_shipping==2) {
        $.ajax({
            url: base_url + 'frontend/private/ajax_private/metodo_envio_desactivar',
            type: 'POST',
            dataType: 'json',
            data: {id_shipping:6},
            beforeSend: function()
            {
                elemento.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Cargando</span>');
                elemento.attr('disabled','');
                elemento.removeClass('desactivar');
                elemento.closest('div.card').removeClass('border-active');
                elemento.parent().find('a.credentials').remove();
    
            },
        })
        .done(function(data)
        {
            if (data.success)
            {
                elemento.html(name);
                elemento.removeAttr('disabled');
                elemento.addClass('activar');
                elemento.closest('div.card').addClass('border-0');

                
            }
        })
        .fail(function() {
            elemento.html(name);
            elemento.removeAttr('disabled');
            elemento.addClass('desactivar');
            elemento.closest('div.card').addClass('border-active')
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    }else{
        $.ajax({
            url: base_url + 'frontend/private/ajax_private/metodo_envio_desactivar',
            type: 'POST',
            dataType: 'json',
            data: {id_shipping:2},
            beforeSend: function()
            {
                elemento.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Cargando</span>');
                elemento.attr('disabled','');
                elemento.removeClass('desactivar');
                elemento.closest('div.card').removeClass('border-active');
                elemento.parent().find('a.credentials').remove();
    
            },
        })
        .done(function(data)
        {
            if (data.success)
            {
                elemento.html(name);
                elemento.removeAttr('disabled');
                elemento.addClass('activar');
                elemento.closest('div.card').addClass('border-0')
            }
        })
        .fail(function() {
            elemento.html(name);
            elemento.removeAttr('disabled');
            elemento.addClass('desactivar');
            elemento.closest('div.card').addClass('border-active')
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    }
    $.ajax({
        url: base_url + 'frontend/private/ajax_private/metodo_envio_activar',
        type: 'POST',
        dataType: 'json',
        data: {id_shipping:id_shipping},
        beforeSend: function()
        {
            elemento.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Cargando</span>');
            elemento.attr('disabled','');
            elemento.removeClass('activar');
            elemento.closest('div.card').removeClass('border-0')
        },
    })
    .done(function(data)
    {
        if (data.success)
        {
            elemento.html(name);
            elemento.removeAttr('disabled');
            elemento.addClass('desactivar');
            elemento.closest('div.card').addClass('border-active');
            elemento.parent().append('<a href="#" data-id="'+id_shipping+'" class="credentials">Actualizar credenciales</a>')

            if(id_shipping == 3)
            {
                $('#modal_fedex').modal('show');
            }
            if(id_shipping == 4)
            {
                $('#modal_dhl').modal('show');
            }   
            if(id_shipping == 5)
            {
                $('#modal_ups').modal('show');
            }
            
        }
    })
    .fail(function() {
        elemento.html(name);
        elemento.removeAttr('disabled');
        elemento.addClass('activar');
        elemento.closest('div.card').addClass('border-0')
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}

function metodoenvioDesactivar(elemento) { 
    event.preventDefault();
    var id_shipping = elemento.attr('data-id');
    var name = elemento.html();
    if (id_shipping == 7) {
        $('#aex').addClass('color-aex');
    }else if (id_shipping == 8){
        $('#moto').addClass('color-aex');
    }else if (id_shipping == 10){
        $('#uber').addClass('color-aex');
    }
    $.ajax({
        url: base_url + 'frontend/private/ajax_private/metodo_envio_desactivar',
        type: 'POST',
        dataType: 'json',
        data: {id_shipping:id_shipping},
        beforeSend: function()
        {
            elemento.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Cargando</span>');
            elemento.attr('disabled','');
            elemento.removeClass('desactivar');
            elemento.closest('div.card').removeClass('border-active');
            elemento.parent().find('a.credentials').remove();

        },
    })
    .done(function(data)
    {
        if (data.success)
        {
            elemento.html(name);
            elemento.removeAttr('disabled');
            elemento.addClass('activar');
            elemento.closest('div.card').addClass('border-0');
        }
    })
    .fail(function() {
        elemento.html(name);
        elemento.removeAttr('disabled');
        elemento.addClass('desactivar');
        elemento.closest('div.card').addClass('border-active')
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}
function credenciales(elemento) {
    event.preventDefault();
    var id_payment_method = elemento.attr('data-id');
    $.ajax({
            url: base_url + 'frontend/private/ajax_private/get_credenciales_pago',
            type: 'POST',
            dataType: 'json',
            data: {id_payment_method:id_payment_method},
        })
        .done(function(data)
        {
            if (data.success)
            {   
                switch (id_payment_method) {
                    case '1':
                        var title = "Mercadopago";
                        var htm ='<input type="hidden" name="id_payment_method" value="'+id_payment_method+'">'+
                        '<div class="form-group"><label>Cliente_id</label><input type="text" name="client_id" class="form-control" value="'+(data.credendiales.client_id ? data.credendiales.client_id:'')+'" required></div>'+
                        '<div class="form-group"><label>Cliente_secret</label><input type="text" name="secret_key" class="form-control" value="'+(data.credendiales.secret_key ? data.credendiales.secret_key:'')+'" required></div>';
                    break;
                    case '2':
                        var title = "Todopago";
                        var htm ='<input type="hidden" name="id_payment_method" value="'+id_payment_method+'">'+
                        '<div class="form-group"><label>Cliente_id</label><input type="text" name="client_id" class="form-control" value="'+(data.credendiales.client_id ? data.credendiales.client_id:'')+'" required></div>'+
                        '<div class="form-group"><label>Secret_key</label><input type="text" name="secret_key" class="form-control" value="'+(data.credendiales.secret_key ? data.credendiales.secret_key:'')+'" required></div>';
                    break;
                    case '3':
                        var title = "Payu";
                        var htm ='<input type="hidden" name="id_payment_method" value="'+id_payment_method+'">'+
                        '<div class="form-group"><label>Cliente_id</label><input type="text" name="client_id" class="form-control" value="'+(data.credendiales.client_id ? data.credendiales.client_id:'')+'" required></div>'+
                        '<div class="form-group"><label>Secret_key</label><input type="text" name="secret_key" class="form-control" value="'+(data.credendiales.secret_key ? data.credendiales.secret_key:'')+'" required></div>';
                    break;
                    case '4':
                        var title = "Paypal";
                        var htm ='<input type="hidden" name="id_payment_method" value="'+id_payment_method+'">'+
                        '<div class="form-group"><label>Email</label><input type="text" name="email_paypal" class="form-control" value="'+(data.credendiales.email_paypal ? data.credendiales.email_paypal:'')+'" required></div>';
                    break;
                    case '6':
                        var title = "Credenciales por Datos Bancarios";
                        var htm ='<input type="hidden" name="id_payment_method" value="'+id_payment_method+'">'+
                        '<div class="form-group"><label>Nombre del titular/Banco/ Numero de cuenta/Sucursal</label><textarea rows="3" name="name_banca" class="form-control" required>'+(data.credendiales.name_banca ? data.credendiales.name_banca:'')+'</textarea></div>';
                    break;
                    case '8':
                        var title = "Credenciales de pagopar";
                        var htm ='<input type="hidden" name="id_payment_method" value="'+id_payment_method+'">'+
                        '<div class="form-group">'+
                            '<label>TOKEN PÚBLICO</label>'+
                            '<input type="text" name="token_public" class="form-control" value="'+(data.credendiales.token_public ? data.credendiales.token_public:'')+'" required>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label>TOKEN PRIVADO</label>'+
                            '<input type="text" name="token_private" class="form-control" value="'+(data.credendiales.token_private ? data.credendiales.token_private:'')+'" required>'+
                        '</div>'+
                        '';
                    break;
                }
                 
                $('#modal_credential_pago').find('#title').html(title);
                $('#modal_credential_pago').find('#form_credentials_pago').html(htm);
            }else{
                switch (id_payment_method) {
                    case '1':
                        var title = "Mercadopago";
                        var htm ='<input type="hidden" name="id_payment_method" value="'+id_payment_method+'">'+
                        '<div class="form-group"><label>Cliente_id</label><input type="text" name="client_id" class="form-control" required></div>'+
                        '<div class="form-group"><label>Cliente_secret</label><input type="text" name="secret_key" class="form-control" required></div>';
                    break;
                    case '2':
                        var title = "Todopago";
                        var htm ='<input type="hidden" name="id_payment_method" value="'+id_payment_method+'">'+
                        '<div class="form-group"><label>Cliente_id</label><input type="text" name="client_id" class="form-control" required></div>'+
                        '<div class="form-group"><label>Secret_key</label><input type="text" name="secret_key" class="form-control" required></div>';
                    break;
                    case '3':
                        var title = "Payu";
                        var htm ='<input type="hidden" name="id_payment_method" value="'+id_payment_method+'">'+
                        '<div class="form-group"><label>Cliente_id</label><input type="text" name="client_id" class="form-control" required></div>'+
                        '<div class="form-group"><label>Secret_key</label><input type="text" name="secret_key" class="form-control" required></div>';
                    break;
                    case '4':
                        var title = "Paypal";
                        var htm ='<input type="hidden" name="id_payment_method" value="'+id_payment_method+'">'+
                        '<div class="form-group"><label>Correo de paypal</label><input type="email" name="email_paypal" class="form-control" required></div>';
                    break;
                    case '6':
                        var title = "Credenciales por Datos Bancarios";
                        var htm ='<input type="hidden" name="id_payment_method" value="'+id_payment_method+'">'+
                        '<div class="form-group"><label>Nombre de Banco / N° de CBU o N° Cuenta</label><textarea rows="3" name="name_banca" class="form-control" required></textarea></div>';
                    break;
                }
                 
                $('#modal_credential_pago').find('#title').html(title);
                $('#modal_credential_pago').find('#form_credentials_pago').html(htm);
            }
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        }); 
   
    $('#modal_credential_pago').modal('show');
}
function actualizar_credenciales_pago() { 
    event.preventDefault();
    var form_credentials = $('#form_credentials_pago').serialize();

    $.ajax({
    url: base_url + 'frontend/private/ajax_private/actualizar_credenciales_pago',
    type: 'POST',
    dataType: 'json',
    data: form_credentials,
    beforeSend: function()
    {
        $('#modal_credential_pago #send').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Cargando</span>');
        $('#modal_credential_pago #send').attr('disabled','')
    },
    })
    .done(function(data)
    {
        if (data.success)
        {   
            $('#modal_credential_pago #send').html('Actualizar');
            $('#modal_credential_pago #send').removeAttr('disabled');
            $('#modal_credential_pago').modal('hide');
        }else{
            $('#modal_credential_pago #send').html('Actualizar');
            $('#modal_credential_pago #send').removeAttr('disabled');
            $('#modal_credential_pago #errorFrom').html('<div class="alert alert-block alert-danger fadeIn"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button> No deje campos vacios</div>');
        }
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });        
}

function credenciales_envio(elemento) {
    event.preventDefault();
    var id_shipping = elemento.attr('data-id'),
        code = elemento.attr('data-code');
        store = elemento.attr('data-store');
        $('#modal_credential_envio').find('#form_credentials_envio').html('');
        $('[data-section="tolpit-moto"]').addClass('d-none');
    $.ajax({
        url: base_url + 'frontend/private/ajax_private/get_credenciales_envio',
        type: 'POST',
        dataType: 'json',
        data: {id_shipping:id_shipping},
        beforeSend: function()
        {
            $('#modal_credential_envio').find('#form_credentials_envio').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Cargando</span>');
            $('#modal_credential_envio').find('#form_credentials_envio').addClass('text-center');
        },
        })
        .done(function(data)
        {
            $('#modal_credential_envio').find('#send').removeClass('d-none');
            $('#modal_credential_envio').find('#form_credentials_envio').find('span.spinner-border').remove();
            $('#modal_credential_envio').find('#form_credentials_envio').removeClass('text-center');
            if (data.success)
            {   
                switch (id_shipping) {
                    case '1':
                        var title = "Oca";
                        var htm ='<input type="hidden" name="id_shipping" value="'+id_shipping+'">'+
                        '<div class="form-group"><label>Cliente_id</label><input type="text" name="client_id" class="form-control" value="'+(data.credendiales.client_id ? data.credendiales.client_id:'')+'" required></div>'+
                        '<div class="form-group"><label>Secret_key</label><input type="text" name="secret_key" class="form-control" value="'+(data.credendiales.secret_key ? data.credendiales.secret_key:'')+'" required></div>';
                    break;
                    case '2':
                        var title = "Whatsapp uruguay";
                        var htm ='<input type="hidden" name="id_shipping" value="'+id_shipping+'">'+
                        '<div class="form-group"><label>Whatsapp uruguay</label><input type="number" name="whatsapp_arg" class="form-control" placeholder="59891678854" value="'+(data.credendiales.whatsapp_arg ? data.credendiales.whatsapp_arg:'')+'" required></div>';
                    break;
                    case '3':
                        var title = "FedEx";
                        var htm ='<input type="hidden" name="id_shipping" value="'+id_shipping+'">'+
                        '<div class="form-group"><label>Key</label><input type="text" name="fedex_key" class="form-control" placeholder="Key FedEx Api" value="'+(data.credendiales.fedex_key ? data.credendiales.fedex_key:'')+'" required></div>'+
                        '<div class="form-group"><label>Account Number</label><input type="text" name="account_number" class="form-control" placeholder="Numero de cuenta FedEx" value="'+(data.credendiales.account_number ? data.credendiales.account_number:'')+'" required></div>'+
                        '<div class="form-group"><label>Meter Number</label><input type="text" name="meter_number" class="form-control" placeholder="únmero de Medidor FedEx" value="'+(data.credendiales.meter_number ? data.credendiales.meter_number:'')+'" required></div>'+
                        '<label>Password FedEX</label><div class="input-group"><input id="txtPassword" type="password" name="password" class="form-control" placeholder="Contraseña de FedEx" value="'+(data.credendiales.password ? data.credendiales.password:'')+'" required><div class="input-group-append"><button id="show_password" class="btn btn-primary btn-private p-2" type="button" onclick="mostrarPassword()"><span class="fa fa-eye-slash icon"></span> </button></div></div><hr><h6 class="font-weight-bold">Datos de origen para el envío</h6>'+
                        '<div class="form-group"><label>Calle</label><input type="text" name="street" class="form-control" placeholder="Calle" value="'+(data.credendiales.street ? data.credendiales.street:'')+'" required></div>'+
                        '<div class="form-group"><label>Ciudad</label><input type="text" name="city" class="form-control" placeholder="Ciudad" value="'+(data.credendiales.city ? data.credendiales.city:'')+'" required></div>'+
                        '<div class="form-group"><label>Codigo de provincia</label><input type="text" name="province_code" class="form-control" placeholder="Codigo de provincia ejemplo: VA" value="'+(data.credendiales.province_code ? data.credendiales.province_code:'')+'" required></div>'+
                        '<div class="form-group"><label>Codigo de país</label><input type="text" name="country_code" class="form-control" placeholder="Codigo de país ejemplo: US" value="'+(data.credendiales.country_code ? data.credendiales.country_code:'')+'" required></div>'+
                        '<div class="form-group"><label>Codigo de postal</label><input type="text" name="code_postal" class="form-control" placeholder="Codigo de postal" value="'+(data.credendiales.code_postal ? data.credendiales.code_postal:'')+'" required></div>';
                    break;
                    case '4':
                        var title = "Dhl";
                        var htm ='<p>No disponible</p>';
                        $('#modal_credential_envio').find('#send').addClass('d-none');
                    break;
                    case '5':
                        var title = "Ups";
                        var htm ='<p>No disponible</p>';
                        $('#modal_credential_envio').find('#send').addClass('d-none');
                    break;
                    case '6':
                        var title = "Whatsapp resto del mundo";
                        var htm ='<input type="hidden" name="id_shipping" value="'+id_shipping+'">'+
                        '<div class="form-group"><label>Whatsapp mundo</label><input type="number" name="whatsapp_mun" class="form-control" placeholder="código y numero sin espacios ni simbolos" value="'+(data.credendiales.whatsapp_mun ? data.credendiales.whatsapp_mun:'')+'" required></div>';
                    break;
                    case '7':
                        var title = "AEX";
                        $('#errorFrom').html('');
                        code_city = (data.credendiales.codigo_ciudad ? data.credendiales.codigo_ciudad:'');
                        var type_currenci_id= (data.credendiales.type_currency_id ? data.credendiales.type_currency_id:'');
                        
                        var htm =
                            '<input type="hidden" name="id_shipping" value="'+id_shipping+'">'+
                            '<div class="form-group">'+
                                '<label>clave_publica</label>'+
                                '<input type="text" data-action="sear-city" id="clave_publica" name="clave_publica" class="form-control" placeholder="Ingrese su clave publica" value="'+(data.credendiales.clave_publica ? data.credendiales.clave_publica:'')+'" required>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label>clave_privada</label>'+
                                '<input type="text" data-action="sear-city" id="clave_privada" name="clave_privada" class="form-control" placeholder="Ingrese su clave privada" value="'+(data.credendiales.clave_privada ? data.credendiales.clave_privada:'')+'" required>'+
                            '</div>'+
                            '<hr>'+
                            '<h6 class="font-weight-bold">Remitente</h6>'+
                            '<div class="row">'+
                                '<div class="col-md-6">'+
                                    '<div class="form-group">'+
                                        '<input class="form-control" type="hidden" name="code_client" value="'+code+'">'+
                                        '<label>Personeria </label>'+
                                        '<select class="form-control" name="personeria">'+
                                            '<option value="">Seleccione...</option>'+
                                            '<option value="F" '+(data.credendiales.personality =='F' ? 'selected':'')+' >Física</option>'+
                                            '<option value="J" '+(data.credendiales.personality =='J' ? 'selected':'')+' >Jurídica</option>'+
                                        '</select>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-6">'+
                                    '<div class="form-group">'+
                                        '<label>Tipo de documento </label>'+
                                        '<select class="form-control" name="type_document">'+
                                            '<option value="">Seleccione...</option>'+
                                            '<option value="RUC" '+(data.credendiales.document_type =='RUC' ? 'selected':'')+' >RUC</option>'+
                                            '<option value="CIP" '+(data.credendiales.document_type =='CIP' ? 'selected':'')+'>Cédula de identidad personal</option>'+
                                            '<option value="PAS" '+(data.credendiales.document_type =='PAS' ? 'selected':'')+'>Pasaporte</option>'+
                                        '</select>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-md-6">'+
                                    '<div class="form-group">'+
                                        '<label>N° de documento </label>'+
                                        '<input class="form-control" type="text" name="document_number" value="'+(data.credendiales.document_number ? data.credendiales.document_number:'')+'" >'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-6">'+
                                    '<div class="form-group">'+
                                        '<label>Fecha de nacimiento </label>'+
                                        '<input class="form-control" type="date" name="birth_date" value="'+(data.credendiales.birth_date ? data.credendiales.birth_date:'')+'">'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<hr>'+
                            '<h6 class="font-weight-bold">Pickup</h6>'+
                            '<div class="row d-none" data-section="section-pickup" >'+
                                '<div class="col-md-6">'+
                                    '<div class="form-group">'+
                                        '<input class="form-control" type="hidden" name="code_pickup" value="'+store+'" >'+
                                        '<label>Calle principal</label>'+
                                        '<input class="form-control" type="text" name="calle_principal" value="'+(data.credendiales.calle_principal ? data.credendiales.calle_principal:'')+'" >'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-6">'+
                                    '<div class="form-group">'+
                                        '<label>Numero casa </label>'+
                                        '<input class="form-control" type="number" name="numero_casa" value="'+(data.credendiales.numero_casa ? data.credendiales.numero_casa:'')+'">'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row d-none" data-section="section-pickup">'+
                                '<div class="col-md-6">'+
                                    '<div class="form-group">'+
                                        '<label>Calle transversal </label>'+
                                        '<textarea class="form-control" name="calle_transversal">'+(data.credendiales.calle_transversal ? data.credendiales.calle_transversal:'')+'</textarea>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-6">'+
                                    '<div class="form-group">'+
                                        '<label>Ciudad </label>'+
                                        '<select class="form-control" name="city_code" id="select-city">'+
                                        '</select>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '';
                        coin(type_currenci_id);
                    break;
                    case '8':
                        var title = 'Envío propio';
                        var html = '';
                        $('#errorFrom').html('');
                        $('[data-section="tolpit-moto"]').removeClass('d-none');
                        htm =''+
                        '<div class="row">'+
                            '<div class="col-md-12">'+
                                '<input type="hidden" name="id_shipping" value="'+id_shipping+'">'+
                                '<div class="form-group">'+
                                    '<label>Carga todos los códigos postales de tu zona de reparto</label>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div id="cod_post_price"></div>'+
                        '<div class="row">'+
                            '<div class="col-md-12">'+
                                '<div class="form-group">'+
                                    '<a href="#" name="whatsapp_mun" data-action="cod-price" ><i class="fa fa-plus"></i> Nuevo registro</a>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '';
                    break;
                    case '10':
                        var title = "Uber";
                        var html = '';
                        $('#errorFrom').html('');
                        htm =''+
                        '<div class="row">'+
                            '<div class="col-md-12">'+
                                '<input type="hidden" name="id_shipping" value="'+id_shipping+'">'+
                                '<div class="form-group">'+
                                    '<label>Agregar por lo menos un código postal</label>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div id="uber_cod"></div>'+
                        '<div class="row">'+
                            '<div class="col-md-12">'+
                                '<div class="form-group">'+
                                    '<a href="#" name="whatsapp_mun" data-uber="cod-price" ><i class="fa fa-plus"></i> Nuevo registro</a>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+  
                        '';
                    break;
                }
                 
                $('#modal_credential_envio').find('#title').html(title);
                $('#modal_credential_envio').find('#form_credentials_envio').html(htm);
                $('[data-action="sear-city"]').click();
            }else{
                switch (id_shipping) {
                    case '1':
                        var title = "Oca";
                        var htm ='<input type="hidden" name="id_shipping" value="'+id_shipping+'">'+
                        '<div class="form-group"><label>Cliente_id</label><input type="text" name="client_id" class="form-control" required></div>'+
                        '<div class="form-group"><label>Secret_key</label><input type="text" name="secret_key" class="form-control" required></div>';
                    break;
                    case '2':
                        var title = "Whatsapp uruguay";
                        var htm ='<input type="hidden" name="id_shipping" value="'+id_shipping+'">'+
                        '<div class="form-group"><label>Whatsapp uruguay</label><input type="text" name="whatsapp_arg" class="form-control" required></div>';
                    break;
                    case '6': 
                        var title = "Whatsapp resto del mundo";
                        var htm ='<input type="hidden" name="id_shipping" value="'+id_shipping+'">'+
                        '<div class="form-group"><label>Whatsapp mundo</label><input type="text" name="whatsapp_mun" class="form-control" required></div>';
                    break;
                    case '8':
                        var title = "Envío propio";
                        var html = '';
                        $('#errorFrom').html('');
                        $('[data-section="tolpit-moto"]').removeClass('d-none');
                        htm =''+
                        '<div class="row">'+
                            '<div class="col-md-12">'+
                                '<input type="hidden" name="id_shipping" value="'+id_shipping+'">'+
                                '<div class="form-group">'+
                                    '<label>Carga todos los códigos postales de tu zona de reparto</label>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div id="cod_post_price"></div>'+
                        '<div class="row">'+
                            '<div class="col-md-12">'+
                                '<div class="form-group">'+
                                    '<a href="#" name="whatsapp_mun" data-action="cod-price" >Nuevo registro</a>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '';
                    break;
                    case '10':
                        var title = "Uber";
                        var html = '';
                        $('#errorFrom').html('');
                        htm =''+
                        '<div class="row">'+
                            '<div class="col-md-12">'+
                                '<input type="hidden" name="id_shipping" value="'+id_shipping+'">'+
                                '<div class="form-group">'+
                                    '<label>Agregar por lo menos un código postal</label>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div id="uber_cod"></div>'+
                        '<div class="row">'+
                            '<div class="col-md-12">'+
                                '<div class="form-group">'+
                                    '<a href="#" name="whatsapp_mun" data-uber="cod-price" ><i class="fa fa-plus"></i> Nuevo registro</a>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+  
                        '';
                    break;
                }
                 
                $('#modal_credential_envio').find('#title').html(title);
                $('#modal_credential_envio').find('#form_credentials_envio').html(htm);
                
            }
            if (id_shipping == '8') {
                if (data.credendiales) {
                    motoPropia(data.credendiales);
                }
            }else if (id_shipping == '10') {
                if (data.credendiales) {
                    uberFlash(data.credendiales);
                }
            }
            
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        }); 
   
    $('#modal_credential_envio').modal('show');
}
function coin(type_currenci_id) {
    $.ajax({
        url: base_url + 'frontend/private/ajax_private/coin',
        type: 'POST',
        dataType: 'json',
        data: {
            
        },
        beforeSend: function()
        {
            $('select#type_currency').attr('disabled','');
        },
    })
    
    .done(function(data)
    {
        $('#type_currency').removeAttr('disabled');
        var html_currency='';
        $.each(data, function (index, Element) { 
            html_currency +='<option value="'+Element.type_currency_id+'" '+(type_currenci_id == Element.type_currency_id ? 'selected':'')+' >'+Element.name+'</option>';
        });
        $('#type_currency').html(html_currency);
    })  
  }
$(document).on('click change','[data-action="sear-city"]',function () {
    var clave_publica = $('#clave_publica').val(),
        clave_privada = $('#clave_privada').val(),
        codigo_sesion = 'elfiko2020';
    if (clave_publica && clave_privada && codigo_sesion) {
        $.ajax({
            url: base_url + 'frontend/private/ajax_private/AEXCity',
            type: 'POST',
            dataType: 'json',
            data: {
                value:2,
                clave_publica:clave_publica,
                clave_privada:clave_privada,
                codigo_sesion:codigo_sesion,
            },
        })
        .done(function(data)
        {
            if (data.codigo == 0) {

                html_select='';
                html_select +='<option value=""> Seleccione..</option>';
                $.each(data.datos, function (index, Element) { 
                    html_select +='<option value="'+Element.codigo_ciudad+'" '+(code_city == Element.codigo_ciudad ? 'selected':'')+'>'+Element.departamento_denominacion+' ('+Element.pais_denominacion+')</option>';
                });
                $('#select-city').html(html_select);
                $('[data-section="section-pickup"]').removeClass('d-none');
            }
        })   
    }

});
function actualizar_credenciales_envios() { 
    event.preventDefault();
    var form_credentials = $('#form_credentials_envio').serialize();

    $.ajax({
    url: base_url + 'frontend/private/ajax_private/actualizar_credenciales_envios',
    type: 'POST',
    dataType: 'json',
    data: form_credentials,
    beforeSend: function()
    {
        $('#modal_credential_envio #send').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Cargando</span>');
        $('#modal_credential_envio #send').attr('disabled','')
    },
    })
    .done(function(data)
    {
        if (data.success)
        {   
            $('#modal_credential_envio #send').html('Actualizar');
            $('#modal_credential_envio #send').removeAttr('disabled');
            $('#modal_credential_envio').modal('hide');
        }else{
            $('#modal_credential_envio #send').html('Actualizar');
            $('#modal_credential_envio #send').removeAttr('disabled');
            $('#modal_credential_envio #errorFrom').html('<div class="alert alert-block alert-danger fadeIn"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button> No deje campos vacios</div>');
        }
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });        
}
$(document).on('change','#paso-1 .form-control',function () {
    if($(this).val() !='')
    {
            $(this).closest('.form-group').removeClass('has-error');
    }else{
            $(this).closest('.form-group').addClass('has-error');
    }
});
$(document).on('change','#paso-2 .form-control',function () {
    if($(this).val() !='')
    {
        $(this).closest('.form-group').removeClass('has-error');
    }else{
        $(this).closest('.form-group').addClass('has-error');
    }
});
$(document).on('change','#paso-3 .form-control',function () {
    if($(this).val() !='')
    {
        $(this).closest('.form-group').removeClass('has-error');
    }else{
        $(this).closest('.form-group').addClass('has-error');
    }
});
 
 
$(document).on('click', '.btn-paso-1', function(event) {
    event.preventDefault();
    var status = true;
    var buton = $(this).attr('data-target');
    var status_email = false;
    var email = $('#paso-1 input[name="email"]').val();
    var password = $('#paso-1 input[name="password"]').val();
    var re_password = $('#paso-1 input[name="re_password"]').val();
    var terms = $('#paso-1 input[name="terms"]');
    var token = $('#g-recaptcha-response').val();
    if(token){
        $('#token').val(token);
    }
    var email_valid = false;
    
    $("#paso-1 .form-control").each(function(index) {
        var attr = $(this).attr('required');
        if (typeof attr !== typeof undefined && attr !== false) {
            if ($(this).val()=="" || $(this).val() == null) {
                $(this).closest('.form-group').addClass('has-error');
                status = false;
            }
        }
    });
    if(status)
    {
        $.ajax({
            type: "POST",
            url: base_url + 'frontend/ajax/validationEmail',
            data: {email:email},
            dataType: "json",
        }).done(function (data) 
        {
            if(data.success){
                status_email = false;
            }else{
                status_email = true;
            }

                if(!status_email)
                {
                    $("#errorForm").html('<div class="alert alert-danger text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Este email ya esta en uso</div>');
                    $('#paso-1 input[name="email"]').closest('.form-group').addClass('has-error');
        
                }else{
                    emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
                    if (emailRegex.test(email)) {
                        email_valid = true;
                    } else {
                        email_valid = false;
                    }

                    if(email_valid)
                    {
                        if(password == re_password)
                        {   
                            
                            if($(terms).is(':checked'))
                            {
                                $("fieldset").hide();
                                $(buton).show();
                                $('#errorForm').html('');
                                $('#steps').text($('[name="paso_2_title"]').val());
                            }else{
                                $("#errorForm").html('<div class="alert alert-danger text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Acepter los Términos y Condiciones</div>');
                            }
                            
                        }else{
                            $("#errorForm").html('<div class="alert alert-danger text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Las contraseñas no coinciden</div>');
                            $('#paso-1 input[name="password"]').closest('.form-group').addClass('has-error');
                            $('#paso-1 input[name="re_password"]').closest('.form-group').addClass('has-error');
                            $('#paso-1 input[name="password"]').val('');
                            $('#paso-1 input[name="re_password"]').val('');

                        }
                    }else{
                        $("#errorForm").html('<div class="alert alert-danger text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Ingrese un correo valido</div>');
                        $('#paso-1 input[name="email"]').closest('.form-group').addClass('has-error');

                    }
                   
                   
                }
            
        }).fail(function () {
            console.log('error');
        });
    }else{
        $("#errorForm").html('<div class="alert alert-danger text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Debe completar todos los campos obligatorios</div>');
    }
   
});
 
$(document).on('click', '.btn-paso-2', function(event) {
    event.preventDefault();
    var buton = $(this).attr('data-target');
    var status_selected = false;
    if($("#paso-2 .button_plan").hasClass('selected-plan')){
        status_selected = true;
    }

    if (status_selected) {
        $("fieldset").hide();
        $(buton).show();
        $('#errorForm').html('');
        $('#steps').text( $('[name="paso_3_title"]').val());
    }else{
        $("#errorForm").html('<div class="alert alert-danger text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Debes seleccionar un plan</div>');
    }
});
$(document).on('click', '.btn-submit', function(event) {
    event.preventDefault();
    var status = true;
    
    $("#paso-3 .form-control").each(function(index) {
        var attr = $(this).attr('required');
        if (typeof attr !== typeof undefined && attr !== false) {
            if ($(this).val()=="" || $(this).val() == null) {
                $(this).closest('.form-group').addClass('has-error');
                status = false;
            }
        }
    });
    if (status) {
        $('#errorForm').html('');
        $('button#case_new').click();
    }else{
        $("#errorForm").html('<div class="alert alert-danger text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Debe completar todos los campos obligatorios</div>');
    }
});

$(document).on('click', '.btn-previous', function(event) {
    event.preventDefault();
    var buton = $(this).attr('data-target');
    $('#errorForm').html('');

    if(buton == '#paso-1'){
        $('#steps').text('REGISTRA TU STORE');
    }
    if(buton == '#paso-2')
    {
        $('#steps').text($('[name="paso_2_title"]').val());
    }
    $("fieldset").hide();
    $(buton).show();
});

function mostrarPassword(){
    var cambio = $('#txtPassword').attr('type');
    if(cambio == "password"){
        $('#txtPassword').attr('type','text')
        $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
    }else{
        $('#txtPassword').attr('type','password')
        $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
    }
} 

function changeShippingMethod(shipping,whatsapp = 0) {
    var html='';
    $('#numberWhatsapp').html(html);
    $('#calcularEnvios').html(html);
    $("#form-solicitar").html('');
    switch (shipping) {
        case '2':
            if (whatsapp) {
                html = '<div class="alert alert-warning" role="alert" style="display:none;">Whatsapp de contacto: '+whatsapp+'</div>';
                $('#numberWhatsapp').html(html);
                $('#numberWhatsapp div.alert').fadeIn();
            }
            break;
        case '6':
            if (whatsapp) {
                html = '<div class="alert alert-warning" role="alert" style="display:none;">Whatsapp de contacto: '+whatsapp+'</div>';
                $('#numberWhatsapp').html(html);
                $('#numberWhatsapp div.alert').fadeIn();
            }
            break;
        case '3':
                html += 
                        '<div class="form-group"><input placeholder="Codigo postal" id="postal_code" class="form-control" value="" name="postal_code"/></div>'+
                        '<div class="form-group"><input placeholder="Codigo de estado o provincia ejemplo: VA" class="form-control" value="" id="province_code" name="province_code"/></div>'+
                        '<div class="form-group"><input id="country_code" placeholder="Codigo del país ejemplo: US" class="form-control" value="" name="country_code"/></div>'+
                        '<div id="selectService"></div>'+
                        '<button type="button" onClick="calcularFedex(event,this);" class="btn angulo-item-button">Calcular</button>';
                $('#calcularEnvios').html(html);
            break;
        case '4':
                html += ''
                $('#calcularEnvios').html(html);
            break;
        case '5':
                html += ''
                $('#calcularEnvios').html(html);
            break;
        case '7':
                aexCity(shipping,whatsapp);
            break;
        case '8':
                $('.confirmar').attr('disabled','');
                html = ''+
                '<div class="input-group">'+
                    '<input type="text" class="form-control inpt-searchpost" name="cod_postal" placeholder="Ingrese el codigo postal">'+
                    '<div class="input-group-append">'+
                        '<button data-action="quote-shipping" data-shipping="'+shipping+'" class="btn angulo-item-button" type="button" id="button-addon2" style="padding-bottom: 2px;padding-top: 2px;">Calcular</button>'+
                    '</div>'+
                '</div>'+
                '';
                $('#numberWhatsapp').html(html);
            break;
        case '10':
                $('.confirmar').attr('disabled','');
                html = ''+
                '<div class="input-group">'+
                    '<input type="text" class="form-control inpt-searchpost" name="cod_postal" placeholder="Ingrese el codigo postal">'+
                    '<div class="input-group-append">'+
                        '<button data-action="quote-shipping" data-shipping="'+shipping+'" class="btn angulo-item-button" type="button" style="padding-bottom: 2px;padding-top: 2px;">Calcular</button>'+
                    '</div>'+
                '</div>'+
                '';
                $('#numberWhatsapp').html(html);
            break;
    }
}

function calcularFedex(event,element)
{   
    event.preventDefault();
    var street = $('#direccion').val();
    var city = $('#ciudad').val();
    var postal_code = $('#postal_code').val();
    var province_code = $('#province_code').val();
    var country_code = $('#country_code').val();
    var store = $('#store').val();
    var metodo_pago = $('#metodo_pago').val();
    data = {
        street:street,
        city:city,
        postal_code:postal_code,
        province_code:province_code,
        country_code:country_code,
        store:store,
        metodo_pago:metodo_pago,
    }
    var htm = '';
    $.ajax({
        type: "POST",
        url: base_url + "frontend/ajax/apiFedexCotizacion",
        data: data,
        dataType: "JSON",
        beforeSend:function () {
            $(element).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Cargando</span>');
            $(element).attr('disabled','');
            $('#selectService').html('');
        }
    }).done(function (response) {
        if(response.success)
        {
            htm += '<input type="hidden" id="costo_envio" name="costo_envio" value=""/>'+
                    '<div class="form-group"><select name="select_service_fedex" class="form-control">';
            htm += '<option value="">Seleccione un Tipo de servico</option>'
            $.each(response.result, function (index, value) { 
                htm += '<option data-price="'+value.TotalNetCharge+'" value="'+value.ServiceType+'">'+value.ServiceType+'</option>';
            }); 
            htm +='</select></div>';
            $('#selectService').html(htm);
        }else{
            swal('!Info¡','Para usar fedEx cague como minimo 2 productos','warning');
        }
        $(element).html('Calcular');
        $(element).removeAttr('disabled');
    }).fail(function () {
        swal('!Error¡','Revise que sus codigos sean correctos al codigo postal','error');
        $(element).html('Calcular');
        $(element).removeAttr('disabled');
    });
}
$(document).on('change','select[name="select_service_fedex"]',function (e) {
    var price_shipping = $(this).find('option:selected').data('price');
    var total_payed = $('#total_pagar').text();
    $('#costo_envio').val(parseFloat(price_shipping));
    totalPedido(parseFloat(total_payed), parseFloat(price_shipping));

})
$(document).on('change','#metodoEntrega',function () {
    var method = $(this).val();
    // console.log(method);
    // $.ajax({
    //     url: base_url + 'frontend/private/ajax_private/methodUPS',
    //     type: 'POST',
    //     dataType: 'json',
    //     data: {method:method},
    // })
    // .done(function(data)
    // {
    //     console.log(data);
        
    // })
    
});
$(document).on('change','input[name="codigo_sku"]',function (e) {
	e.preventDefault();
    var code = $(this).val();
    var product = $(this).attr('data-id');
    var input = $(this);
    if(code != ''){
        $.ajax({
            type: "POST",
            url: base_url + "frontend/private/ajax_private/findCode",
            data: {code:code,product:product},
            dataType: "JSON",
        }).done(function(response){
            if(response.success)
            {
                input.val('');
                swal('error','Este código ya existe','error');
            }
        }).fail(function () {
            console.log('error')
        });
    }
});

$(document).on('click','input[type="radio"][name="estrellas"]',function(e){
	e.preventDefault();
	var vote = $(this).val()
    var store_id = $(this).attr('data-id');
	$('input[type="radio"]').attr('disabled','');
	$.ajax({
		url: base_url + 'frontend/private/store/valoracionProduct',
		type: 'POST',
		dataType: 'json',
		data: {
			calificacion: vote,
			store_id: store_id
		},
		beforeSend:function(){
			
		}
	})
	.done(function(dataJson) {
		if(dataJson.success){        
            swal({
                title: "Exitoso!",
                text: "La valoracion ha sido realizada!",
                type: "success"
            }, function() {
                location.reload();
            });
	
		}
	})
	.fail(function(){
		console.log('error')
	})
});


function aexCity(shipping,store) {
    var html = '', 
        html_select ='';
    $('#calcularEnvios').html(html);
    $.ajax({
        url: base_url + 'frontend/private/ajax_private/AEXCity',
        type: 'POST',
        dataType: 'json',
        data: {
            shipping_id:shipping,
            store:store
        },
    })
    .done(function(data)
    {
        if (data.codigo == 0) {
            html_select='';
            html_select +='<option value=""> Ciudad de destino..</option>';
            $.each(data.datos, function (index, Element) { 
                // console.log(Element);
                html_select +='<option value="'+Element.codigo_ciudad+'">'+Element.departamento_denominacion+' ('+Element.pais_denominacion+')</option>';
            });

            html += '' +
            '<div class="form-group">'+
                '<select class="form-control" id="aex_city_destination" name="aex_city_destination" data-shipping="'+shipping+'" data-store="'+store+'" required>'+
                    html_select+
                '</select>'+
            '</div>'+
            '<div class="form-group text-right">'+
                '<p> Tipo de moneda '+$('#type_currency').val()+' </p>'+
            '</div>'+
            '<div id="response_exclude"></div>'+
            '<div id="response_caculate"></div>';
            $('#calcularEnvios').html(html);
        }else{
            console.log('error');
        }
        
    })
}
// $(document).on('change','select#aex_type_package',function () {
//     var value = $(this).val();
//     $('[data-action="shipping-calculate"]').attr('data-package',value);
//     $('[data-action="request-service"]').attr('data-package',value);
// });
$(document).on('change','select#aex_city_destination',function () {
    $('[data-action="shipping-calculate"]').attr('data-destination',value);
    $('[data-action="request-service"]').attr('data-destination',value);
    var value = $(this).val();
    $('.confirmar').attr('disabled','');
    var destination = $(this).val(),
        package     = 'P',
        total_pagar =   parseFloat($('input[name="total_pago"]').val()),
        shipping    = $(this).attr('data-shipping'),
        store       = $(this).attr('data-store'),
        inpt_this   = $(this);
        code        = '',
        html        = '',
        html_exclude= '';
        total_pagar=parseFloat(total_pagar);
        $.ajax({
            url: base_url + 'frontend/private/ajax_private/shippingCalculate',
            type: 'POST',
            dataType: 'json',
            data: {
                shipping_id :shipping,
                store       :store,
                destination :destination,
                package     :package
            },
            beforeSend: function()
            {
                inpt_this.attr('disabled','').prepend('<i class="fa fa-spin fa-spinner"></i>');
            },
        })
        .done(function(data)
        {
            inpt_this.removeAttr('disabled').find('i.fa').remove();
            value ='';        
            if (data.codigo == 0) {
                html_list = '';
                if (data.product_exclude.length > 0) {
                    html_li='';
                    $.each(data.product_exclude, function (indexInArray, valueOfElement) { 
                        html_li +='<li>'+valueOfElement.codigo+'</li>'
                    });
                    html_list = 'Codigos de los productos que no se calcularon: '+
                    '<ul>'+
                        html_li+
                    '</ul>';
                    
                }
                html_exclude += ''+
                '<div class="alert alert-warning text-left mt-2"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+ 
                    ''+data.datos[0].denominacion+' '+data.datos[0].descripcion+'<br>'+
                    '<p>Tiempo de entrega: '+data.datos[0].tiempo_entrega+'H</p>'+
                    html_list+
                '</div>';
                $("#response_exclude").html(html_exclude);
                $("#symbol").val();
                total_pagar = total_pagar + parseFloat(data.datos[0].costo_servicio);
                $("#section-costo-envio").html('Costo de envio:<br>'+$("#symbol").val()+' '+data.datos[0].costo_servicio);
                $("#section-costo-total").html('Costo total con envio:<br>'+$("#symbol").val()+' '+total_pagar);
                $("#section-costo-envio").addClass('text-right');
                $("#section-costo-total").addClass('text-right');
                $("#calcule_aex").html($("#symbol").val()+' '+total_pagar);

                // $('[data-action="request-service"]').removeClass('d-none');
                $('.confirmar').removeAttr('disabled');
                formRequestService(
                    destination,
                    store
                );

            }else{
                swal('Informativo','La lista de productos no se pudo calcular','warning');
            }
        })
});
$(document).on('click','.confirmar',function () {
    // e.preventDefault();
    var status = true;
    $('#formCarrito .form-control').each(function(index) {
        var attr = $(this).attr('required');
        if (typeof attr !== typeof undefined && attr !== false) {
            if ($(this).val()=="" || $(this).val() == null) {
                $(this).closest('.form-group').addClass('has-error');
                status = false;
            }
        }
    });
    if (!status) {
        swal('Error','Complete todos los campos del formulario','error');
    }
});
$(document).on('change','#metodo_pago',function () {
    var metodo_pago = $(this).val();
        store_id = $('#store').val();
        $('#inpNumber').html('');
    if (metodo_pago == 8) {
        
        $.ajax({
            url: base_url + 'frontend/private/ajax_private/totalCar',
            type: 'POST',
            dataType: 'json',
            data: {
                store_id:store_id,
            },
            beforeSend: function()
            {
               
            },
        })
        .done(function(data)
        {
            if (data<1000) {
                swal('Informativo', ' El total de su compra debe ser mínimo de '+$('#symbol').val()+'1000 para pagar con Pagar','warning');
                $("#metodo_pago option[value='']").attr("selected",true);
            }
        })  
    }
    if(metodo_pago == 6){
        var banco = $('#banco').val();
        var html = '<div class="alert alert-warning" style="display:none;"><p style="white-space:pre-wrap;text-align:left;margin:0px">'+banco+'</p></div>';
        $('#inpNumber').html(html);
        $('#inpNumber div.alert').fadeIn();
    }
});
function formRequestService(destination_city,store) {
    var html            = '',
        html_sender     ='',
        html_pickup     ='',
        html_delivery   ='';

    html = ''+
    '<nav>'+
        '<div class="nav nav-tabs" id="nav-tab" role="tablist">'+
            '<a class="nav-link active" id="nav-destinatario-tab" data-toggle="tab" href="#nav-destinatario" role="tab" aria-controls="nav-destinatario" aria-selected="true">Destinatario</a>'+
            '<a class="nav-link" id="nav-entrega-tab" data-toggle="tab" href="#nav-entrega" role="tab" aria-controls="nav-entrega" aria-selected="false">Entrega</a>'+
        '</div>'+
    '</nav>'+
    '<div class="tab-content pt-3" id="nav-tabContent">'+
        '<div class="tab-pane fade show active" id="nav-destinatario" role="tabpanel" aria-labelledby="nav-destinatario-tab">'+

            '<div class="row">'+
                '<div class="col-md-6">'+
                    '<div class="form-group">'+
                        '<label>Personeria </label>'+
                        '<select class="form-control" name="destinatario_personeria" required>'+
                            '<option value="">Seleccione...</option>'+
                            '<option value="F">Física</option>'+
                            '<option value="J">Jurídica</option>'+
                        '</select>'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-6">'+
                    '<div class="form-group">'+
                        '<label>Tipo de documento </label>'+
                        '<select class="form-control" name="destinatario_type_document" required>'+
                            '<option value="">Seleccione...</option>'+
                            '<option value="RUC">RUC</option>'+
                            '<option value="CIP">Cédula de identidad personal</option>'+
                            '<option value="PAS">Pasaporte</option>'+
                        '</select>'+
                    '</div>'+
                '</div>'+
            '</div>'+
            '<div class="row">'+
                '<div class="col-md-6">'+
                    '<div class="form-group">'+
                        '<label>Fecha de nacimiento </label>'+
                        '<input class="form-control" type="date" name="destinatario_date" required>'+
                    '</div>'+
                '</div>'+
            '</div>'+

        '</div>'+
        '<div class="tab-pane fade" id="nav-entrega" role="tabpanel" aria-labelledby="nav-entrega-tab">'+

            '<div class="row">'+
                '<div class="col-md-6">'+
                    '<div class="form-group">'+
                        '<input class="form-control" type="hidden" name="entrega_code" value="'+store+'">'+
                        '<input class="form-control" type="hidden" name="destinatario_city" value="'+destination_city+'">'+
                        '<label>Número de casa </label>'+
                        '<input class="form-control" type="number" name="entrega_numero_casa" placeholder="Número de casa" required>'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-6">'+
                    '<div class="form-group">'+
                        '<label>Calle transversal </label>'+
                        '<input class="form-control" placeholder="Calle transversal" type="text" name="entrega_calle_transversal_1" required>'+
                    '</div>'+
                '</div>'+
            '</div>'+
            '<div class="row">'+
                '<div class="col-md-6">'+
                    '<div class="form-group">'+
                        '<label>Referencias </label>'+
                        '<textarea class="form-control" type="text" name="entrega_referencias" placeholder="Referencias" required></textarea>'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-6">'+
                    '<div class="form-group">'+
                        '<label>Comentario </label>'+
                        '<textarea class="form-control" type="text" name="entrega_comentario" placeholder="Comentario" required></textarea>'+
                    '</div>'+
                '</div>'+
            '</div>'+
        '</div>'+
    '</div>'+
    '<div class="row">'+
        '<div class="col-md-12" id="response-condirmation">'+
        '</div>'+
    '</div>'+
    '';
    $("#form-solicitar").html(html);
}
$(document).on('click','[data-action="form-confirm"]',function () {
    var status = true ,
        inpt_this        = $(this),
        id_solicitud     = $('[name="id_solicitud"]').val(),
        id_tipo_servicio = $('[name="id_tipo_servicio"]').val(),

        shipping         = $('[data-action="shipping-calculate"]').attr('data-shipping'),
        store            = $('[data-action="shipping-calculate"]').attr('data-store'),

        destinatario_code           = $('#destinatario_code').val(),
        destinatario_type_document  = $('[name="destinatario_type_document"]').val(),
        destinatario_number_document= $('#dni').val(),
        destinatario_name           = $('#name').val(),
        destinatario_last_name      = $('#last_name').val(),
        destinatario_email          = $('#email').val(),
        destinatario_personeria     = $('[name="destinatario_personeria"]').val(),
        destinatario_date           = $('[name="destinatario_date"]').val(),
        destinatario_telephone      = $('#telephone').val();


    var entrega_codigo              = $('[name="entrega_code"]').val(),
        entrega_calle_principal     = $('#ciudad').val(),
        entrega_numero_casa         = $('[name="entrega_numero_casa"]').val(),
        entrega_calle_trasnversal   = $('[name="entrega_calle_transversal_1"]').val(),
        entrega_city                = $('[name="destinatario_city"]').val(),    
        entrega_referencias         = $('[name="entrega_referencias"]').val(),
        entrega_comentario          = $('[name="entrega_comentario"]').val(),



    destinatario={
        "codigo": destinatario_code,
        "tipo_documento": destinatario_type_document,
        "numero_documento": destinatario_number_document,
        "nombre":destinatario_name,
        "apellido":destinatario_last_name,
        "email":destinatario_email,
        "personeria":destinatario_personeria,
        "fecha_nacimiento":destinatario_date,
        "telefonos":destinatario_telephone
    };
    entrega={
        "codigo":entrega_codigo,
        "calle_principal": entrega_calle_principal,
        "numero_casa": entrega_numero_casa,
        "calle_transversal_1": entrega_calle_trasnversal,
        "calle_transversal_2": "",
        "codigo_ciudad": entrega_city,
        "referencias": entrega_referencias,
        "Comentario": entrega_comentario,
    };
    confirmar = {
        "id_solicitud":id_solicitud,
        "id_tipo_servicio":id_tipo_servicio
    };
    $('#formCarrito .form-control').each(function(index) {
        var attr = $(this).attr('required');
        if (typeof attr !== typeof undefined && attr !== false) {
            if ($(this).val()=="" || $(this).val() == null) {
                $(this).closest('.form-group').addClass('has-error');
                status = false;
            }
        }
    });
    if (status) {
        $.ajax({
            url: base_url + 'frontend/private/ajax_private/confirmService',
            type: 'POST',
            dataType: 'json',
            data: {
                shipping_id :shipping,
                store       :store,
                destinatario    :destinatario,
                entrega         :entrega,
                confirmar       :confirmar
            },
            beforeSend: function()
            {
                inpt_this.attr('disabled','').prepend('<i class="fa fa-spin fa-spinner"></i>');
            },
        })
        .done(function(data)
        {
            inpt_this.removeAttr('disabled').find('i.fa').remove();
            value ='';     
            if (data.codigo == 0) {
                html = '<div class="alert alert-warning text-left mt-2"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+ 
                    ''+data.datos[0].tipo_evento+'<br> Estado del envio: '+data.datos[0].estado+'<br>'+
                    value+
                '</div>';
                $('#response-condirmation').html(html);
                $('.confirmar').removeAttr('disabled');
            }
        })
    }else{
        swal('Error','Rellene los formularios','error');
    }
 
    
});
$(document).on('click','[data-action="cod-price"]',function (e) {
    e.preventDefault();
    var input_moto = $('#cod_post_price'),
        html_input = '',
        uniqueId = uniqid();
    html_input = ''+
    '<div class="row" data-id="'+uniqueId+'">'+
        '<div class="col-md-5">'+
            '<div class="form-group">'+
                '<input placeholder="Código postal" class="form-control" type="number" name="number_post['+uniqueId+'][]" >'+
            '</div>'+
        '</div>'+
        '<div class="col-md-5">'+
            '<div class="form-group">'+
                '<input placeholder="Precio de envío" class="form-control" type="number" name="price['+uniqueId+'][]" >'+
            '</div>'+
        '</div>'+
        '<div class="col-md-2">'+
            '<div class="form-group">'+
                '<a href="#" data-id="'+uniqueId+'" title="Eliminar" data-action="delete-codprice">'+
                    '<i class="fa fa-trash-alt icon-categories pt-2"></i>'+
                '</a>'+
            '</div>'+ 
        '</div>'+  
    '</div>'+     
    '';
    input_moto.append(html_input);
    
});
$(document).on('click','[data-action="delete-codprice"]',function (e) {
    e.preventDefault();
    var data_id = $(this).attr('data-id');
    $('div[data-id="'+data_id+'"]').remove();
});
function uniqid() {
	var n = Math.floor(Math.random() * 11);
	var k = Math.floor(Math.random() * 1000000);
	var uniqueId = k;
	return uniqueId;
}
function motoPropia(data) { 
    var input_moto = $('#cod_post_price'),
        html_input = '',
        contar     = 0;

    $('#cod_post_price div.row').each(function() {
        contar = contar + 1;
    });
    if (contar==0) {
        // console.log('vacio');
    }else{
        // console.log('lleno');
    }
    
    $.each(data, function (index, Element) { 
        var uniqueId = uniqid();
        html_input = ''+
            '<div class="row" data-id="'+uniqueId+'">'+
                '<div class="col-md-5">'+
                    '<div class="form-group">'+
                        '<input placeholder="Código postal" class="form-control" type="number" name="number_post['+uniqueId+'][]" value="'+Element.postal_code+'" >'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-5">'+
                    '<div class="form-group">'+
                        '<input placeholder="Precio de envío" class="form-control" type="number" name="price['+uniqueId+'][]" value="'+Element.price+'" >'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-2">'+
                    '<div class="form-group">'+
                        '<a href="#" data-id="'+uniqueId+'" title="Eliminar" data-action="delete-codprice">'+
                            '<i class="fa fa-trash-alt icon-categories pt-2"></i>'+
                        '</a>'+
                    '</div>'+ 
                '</div>'+  
            '</div>'+     
        '';
        $('#cod_post_price').append(html_input);
    });
}

    function uberFlash(data) {
        
        var input_moto = $('#uber_cod'),
            html_input = '',
            contar     = 0;

        $('#uber_cod div.row').each(function() {
            contar = contar + 1;
        });
        if (contar==0) {
            // console.log('vacio');
        }else{
            // console.log('lleno');
        }
        
        $.each(data, function (index, Element) { 
            var uniqueId = uniqid();
            html_input = ''+
                '<div class="row" data-id="'+uniqueId+'">'+
                    '<div class="col-md-5">'+
                        '<div class="form-group">'+
                            '<input placeholder="Código postal" class="form-control" type="number" name="uber_post['+uniqueId+'][]" value="'+Element.postal_code+'" >'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-md-5">'+
                        '<div class="form-group">'+
                            '<input placeholder="Precio de envío" class="form-control" type="number" name="uber_price['+uniqueId+'][]" value="'+Element.price+'" >'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-md-2">'+
                        '<div class="form-group">'+
                            '<a href="#" data-id="'+uniqueId+'" title="Eliminar" data-action="delete-codprice">'+
                                '<i class="fa fa-trash-alt icon-categories pt-2"></i>'+
                            '</a>'+
                        '</div>'+ 
                    '</div>'+  
                '</div>'+     
            '';
            $('#uber_cod').append(html_input);
        });

    }


    $(document).on('click','[data-uber="cod-price"]',function (e) {
        e.preventDefault();
        var input_moto = $('#uber_cod'),
            html_input = '',
            uniqueId = uniqid();
        html_input = ''+
            '<div class="row" data-id="'+uniqueId+'">'+
                '<div class="col-md-5">'+
                    '<div class="form-group">'+
                        '<input placeholder="Código postal" class="form-control" type="number" name="uber_post['+uniqueId+'][]" >'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-5">'+
                    '<div class="form-group">'+
                        '<input placeholder="Precio de envío" class="form-control" type="number" name="uber_price['+uniqueId+'][]" >'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-2">'+
                    '<div class="form-group">'+
                        '<a href="#" data-id="'+uniqueId+'" title="Eliminar" data-delete="uber-codprice>'+
                            '<i class="fa fa-trash-alt icon-categories pt-2"></i>'+
                        '</a>'+
                    '</div>'+ 
                '</div>'+  
            '</div>'+     
        '';
        input_moto.append(html_input);
        
    });
    $(document).on('click','[data-delete="uber-codprice"]',function (e) {
        e.preventDefault();
        var data_id = $(this).attr('data-id');
        $('div[data-id="'+data_id+'"]').remove();
    });
// api-nube
function submitLogin(event, elemento)
{
    event.preventDefault();
    var datos = $(elemento).serialize();

    $.ajax({
        url: base_url + 'frontend/ajax/login',
        type: 'POST',
        dataType: 'json',
        data: datos,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function()
        {
            $(elemento).find('button').attr('disabled', '');
            $(elemento).find('.section-message').html('');
        },
    })
    .done(function(data)
    {
        $(elemento).find('button').removeAttr('disabled');
        $(elemento)[0].reset();
        if (data.success)
        {
            window.location.href = base_url + 'mi-perfil';
        } else {
            var htm = '<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a> '+ data.message + '</div>';
            $(elemento).find('#modalLoginMessage').html(htm);
        }
        console.log("success");
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
    
}
function cambioPassword(element) {
    var currentPass = $('#current_pass').val();
    var pass = $('#pass').val();
    var pass2 = $('#pass2').val();
    
    // Password validation regex
    var passwordRegex = /^(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/;
    
    if (!currentPass) {
        swal('Error', 'Por favor, ingrese su contraseña actual.', 'error');
        return;
    }
    
    if (!passwordRegex.test(pass)) {
        swal('Error', 'La nueva contraseña debe tener al menos 8 caracteres, 1 letra mayúscula y 1 símbolo (por ejemplo, !@#$%^&*).', 'error');
        return;
    }
    
    if(pass == pass2){
        // First validate the current password
        jQuery.ajax({
            type: "POST",
            url: base_url + 'frontend/ajax/validateCurrentPassword',
            data: {
                current_password: currentPass,
                [csrf_token_name]: csrf_hash
            },
            dataType: "JSON",
            beforeSend: function () {
                jQuery(element).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Cargando</span>');
                jQuery(element).attr('disabled','');
            },
            success: function(response) {
                if (response.valid) {
                    // Current password is valid, proceed with changing the password
                    changePasswordAjax(pass, element);
                } else {
                    // Current password is invalid
                    swal('Error', 'La contraseña actual es incorrecta.', 'error');
                    jQuery(element).html('Guardar');
                    jQuery(element).removeAttr('disabled');
                }
            },
            error: function(xhr, status, error) {
                console.error("Error validating password:", error, xhr.responseText);
                swal('Error', 'Ha ocurrido un error al validar la contraseña actual.', 'error');
                jQuery(element).html('Guardar');
                jQuery(element).removeAttr('disabled');
            }
        });
    } else {
        swal('Error','Las contraseñas no coinciden.','error')
    }
}

function changePasswordAjax(password, element) {
    jQuery.ajax({
        type: "POST",
        url: base_url + 'frontend/ajax/changePassword',
        data: {
            contraseña: password,
            [csrf_token_name]: csrf_hash
        },
        dataType: "JSON"
    })
    .done(function(response){
        if(response.success){
            jQuery('#cambiarpass').modal('hide');
            swal('Completado!','Su contraseña fue cambiada correctamente.','success')
        } else {
            swal('Error', response.message || 'Ha ocurrido un error al cambiar la contraseña.', 'error');
        }
    })
    .fail(function(xhr, status, error) {
        console.error("Error changing password:", error, xhr.responseText);
        swal('Error', 'Ha ocurrido un error al cambiar la contraseña.', 'error');
    })
    .always(function () {
        jQuery(element).html('Guardar');
        jQuery(element).removeAttr('disabled');
    });
}

function Send(event) {
    event.preventDefault();
    var formData = $('#form-perfil').serialize();
    
    $.ajax({
        url: base_url + 'mi-perfil',
        type: 'POST',
        dataType: 'json',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            $('#loader').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Cargando</span>');
            $('#loader').attr('disabled', '');
        },
    })
    .done(function(response) {
        if (response.success) {
            swal('¡Éxito!', 'Los datos han sido actualizados correctamente.', 'success');
        } else {
            swal('Error', response.message || 'Ha ocurrido un error al actualizar los datos.', 'error');
        }
    })
    .fail(function(xhr) {
        swal('Error', 'Ha ocurrido un error al actualizar los datos.', 'error');
    })
    .always(function() {
        $('#loader').html('GUARDAR');
        $('#loader').removeAttr('disabled');
    });
}