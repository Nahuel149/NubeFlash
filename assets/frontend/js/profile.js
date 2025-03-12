
$(document).on('change', '#country',function(){
  var pais  = $('#country').val();

  var html ='',
      name = $(this).val();

  if (pais == '') {
      $('#provinces').html('<option value="">Seleccione su Ciudad</option>');
      $('#provinces').attr('disabled', '');

  } else {

    $.ajax({
        type: 'POST',
        url: base_url+'frontend/private/ajax_private/provinces',
        data: {
            data: pais
        },
        dataType: 'json',
        beforeSend: function(data) {
          $('#provinces').attr('disabled', '');
          $('#provinces').html('<option value="">Seleccione su Ciudad</option>');
        }
    }).done(function(response){
      for(var value of response){
        html += '<option value='+ value.CiudadID  +' >'+value.CiudadNombre+'</option>';
      }
      $('#provinces').html(html);
    }).always(function() {
        $('#provinces').removeAttr('disabled');

    });

  }

});

$(document).on('click', 'button[data-type="btnDominio"]', function(event) {
    var valor = 1;
    event.preventDefault();
    url_store = $('input[type="text"][data-type="url_store"]').val();
    texto = url_store.toLowerCase();
    for(i=0; i<texto.length; i++){
        if (letras.indexOf(texto.charAt(i),0)!=-1){
            valor = 0;
        }
    }

    if(valor == 0)
    {
        swal('Error','No puede ingresar caracteres especiales ['+letras+']','error')
    }else{
        $.fn.modUrl();
    }
});

$.fn.modUrl = function() {
    $.ajax({
        type: 'POST',
        url: base_url+'frontend/private/web_private/ModUrl',
        data: {
            url: url_store 
        },
        dataType: 'json',
        beforeSend: function(data) {
        }
    })
    .done(function(data) {
            if (data.success==true) {
            swal({
                title: "EXITO",
                text: "Se cambio con exito su URL.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: '#78cbf2',
                confirmButtonText: 'Aceptar',
                },
                function(){
                    location.reload();
            });
            }else {
                swal('Error',data.message,'error');
            }
    })
    .always(function(data) {

    });

}
$("#send").click(function (e) {
    e.preventDefault();
    $('#send').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Cargando</span>');
    $('#send').attr('disabled','')
    if($('input[name="email_store"]').val())
    {
        $("#sendSubmit").click();
    }else{
        swal('Error','EL campo email es obligatorio','error')
        $('#send').html('GUARDAR');
        $('#send').removeAttr('disabled')
    }
    if($('input[name="name"]').val())
    {
        $("#sendSubmit").click();
    }else{
        swal('Error','EL campo Nombre de su store es obligatorio','error')
        $('#send').html('GUARDAR');
        $('#send').removeAttr('disabled')
    }
});

$(document).ready(function() {
var anuncios = document.querySelector('input[name="anuncio"]')
if (anuncios.value == 1) {
    $('#anuncio').modal('show');
}

var advertisement = $("#advertisement");
advertisement.modal('show');
$('select[name="type_currency"]').trigger('change');
})

$(document).on('click', 'button[data-action="domain-submit"]', function(event) {
event.preventDefault();
var valor = 1;
domain_store = $('#domain_store').val();
    texto = domain_store.toLowerCase();
    for(i=0; i<texto.length; i++){
        if (letter_domain.indexOf(texto.charAt(i),0)!=-1){
        valor = 0;
        }
    }
    if(valor == 0)
    {
        swal('Error','No puede ingresar caracteres especiales ['+letras+']','error')
    }else{
        $.ajax({
        type: "POST",
        url: base_url + "frontend/private/ajax_private/domainStore",
        data: {domain:domain_store},
        dataType: "JSON",
        beforeSend:function () {
            $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Cargando</span>')
        }
        }).done(function (response) {
        if(response.success)
        {
            swal({
            title: "Exito",
            text: "Se actualizó su dominio correctamente.",
            type: "success",
            showCancelButton: false,
            confirmButtonColor: '#78cbf2',
            confirmButtonText: 'Aceptar',
            },
            function(){
            location.reload();
            });
        }else{
            swal('Error','Este dominio ya existe.','error');
        }
        }).fail(function () {
        console.log('error');
        });
    }
});

$(document).on('change', 'input[data-toggle="toggle"]', function(event) {
    var estadoStore = 0;    
    if($(this).prop('checked')){
        estadoStore = 1;
    }
    $.ajax({
        type: 'POST',
        url: base_url+'frontend/private/web_private/stateStore',
        data: {
        data: estadoStore
        },
        dataType: 'json',
        beforeSend: function(data) {
        }
    }).done(function(response){
        if(response.result){
        if(response.status == 1){
            swal("Activado","Su tienda ha sido publicada","success")
        }else{
            swal("Desactivado","Su tienda ha sido desactivada","warning")
        }
        }
    })
})

function countryAPI(name) { 
    var html = '',
        symbol;

    if (name == '') return;

    $.ajax({
        type: 'GET',
        url: base_url + 'frontend/private/ajax_private/countryAPI/'+name,
        data: {},
        dataType: 'json',
        beforeSend: function(data) {
        }
    })
    .done(function(data) {

        var code = '';
        var symbol = '';
        var currency_name = '';

        $.each(data[0].currencies, function(index, val) {
        code = index;
        currency_name = val.name;
        symbol = val.symbol;
        return;
        });

        if (symbol) {

        html = ''+
            '<option value="' + code + '" '+ (code_currency == code ? 'selected' : '' ) +'  >'+currency_name+' ('+ (symbol ? symbol  : 'sin simbolo') +')</option>'+
            '<option value="euro" '+ (code_currency == '2' ? 'selected' : '' ) +'>Euro (€)</option>'+
            '<option value="USD" '+ (code_currency == '3' ? 'selected' : '' ) +'> USD</option>'+
        '';

        } else {

        html = ''+
            '<option value="euro" '+ (code_currency == '2' ? 'selected' : '' ) +'>Euro (€)</option>'+
            '<option value="USD" '+ (code_currency == '3' ? 'selected' : '' ) +'>USD</option>'+
        '';

        }

        $('[name="type_currency"]').html(html);
    })
}

$(document).on('click','[data-modal="shopping-modal"]',function (e) {
    e.preventDefault();
    $('#shoppin-domain').modal('show');
    $('#response-domain-available').html('');
    $('[name="domain-available"]').val('');
    $('[data-action="shopping-domain"]').addClass('d-none');
    $('.method-shopping').addClass('d-none');
});

$(document).on('click','[data-action="domain-available"]',function (e) {
    e.preventDefault();
    var domain = $('input[name="domain-available"]').val(),
        button_this=$(this);
    var html = '', html_form = '';

    $.ajax({
        type: 'POST',
        url: base_url+'frontend/private/ajax_private/domainAvailable',
        data: {
        domain:domain
        },
        dataType: 'json',
        beforeSend: function(data) {
            button_this.attr('disabled','').prepend('<i class="fa fa-spin fa-spinner mr-1"></i>');
        }
    }).done(function(data) {
        button_this.removeAttr('disabled').find('i.fa').remove();
        if (data.available) {
            $('input[name="name_domain"]').val(data.domain);
            $('input[name="price_domain"]').val(data.price);
            html = ''+
                '<div class="alert alert-info" role="alert">'+
                    'Dominio: ' + data.domain +'<br>'+
                    'Moneda: ' + data.currency +'<br>'+
                    'Precio: ' + data.price +
                '</div>'+
            '';
            $('#response-domain-available').html(html);
            $('[data-action="shopping-domain"]').removeClass('d-none');
            $('[data-action="shopping-domain"]').removeAttr('disabled');
            $('.method-shopping').removeClass('d-none');
        } else {
            swal('Dominio','El dominio que ingresó no está disponible','warning');
        }
    })
});

$(document).on('click','[data-action="shopping-domain"]',function (e) {
    e.preventDefault();
    var button_this = $(this),
        domain = $('[name="domain-available"]').val()
        price = $('[name="price_domain"]').val(),
        payment_method = $('[data-section="select-shhopin"]').val(),
        period = $('#period').val();

    if (payment_method == 6) {
        var banco = $('#banco').val();
        var htm = '<p style="white-space: pre-wrap;text-align: left;">'+banco+'</p><br><p style="font-size: 14px;text-align: left;">Tu dominio estará habilitado una vez se realice el pago</p><br><p>Si el pago es en efectivo (Transferencia Bancaria) debes enviar tu comprobante a <a href="mailto:ventas@lanube.cloud">ventas@lanube.cloud</a></p>';
        swal({
            title: "Información de transferencia",
            text: htm,
            type: "info",
            cancelButtonText: "Cancelar",
            cancelButtonColor: "#c9dae1",
            showCancelButton: true,
            confirmButtonColor: "#78cbf2",
            confirmButtonText: "Aceptar",
            closeOnConfirm: false,
            disableButtonsOnConfirm: true,
            showLoaderOnConfirm: true,
            confirmLoadingButtonColor: '#DD6B55',
            html:true,
        }, function(response) {
            if (response) {
                $.ajax({
                    type: "POST",
                    url: base_url + 'frontend/private/ajax_private/shoppingDomain',
                    data: {
                        country:country,
                        domain:domain,
                        price:price,
                        payment_method:payment_method,
                        period:period
                    },
                    dataType: "json",
                }).done(function(data) {
                    if(data.success) {
                        window.location = data.url;
                    } else {
                        swal({
                            title:data.title,
                            text:data.text,
                            type:data.type
                        }, function(response) {
                            window.location.reload();
                        });
                    }
                }).fail(function() {
                    console.log("error");
                })
            }
        });
    } else {
        swal({
            title: "Confirmar",
            text: "¿Confirmar compra del dominio?",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        }, function () {
            $.ajax({
                type: 'POST',
                url: base_url+'frontend/private/ajax_private/shoppingDomain',
                data: {
                    country:country,
                    domain:domain,
                    price:price,
                    payment_method:payment_method,
                    period:period,
                },
                dataType: 'json',
                beforeSend: function(data) {
                    button_this.attr('disabled', '').prepend('<i class="fa fa-spin fa-spinner mr-1"></i>');
                }
            }).done(function(data) {
                button_this.removeAttr('disabled').find('i.fa').remove();
                if (data.success) {
                    window.location = data.url;
                    $('#response-domain-available').html(html);
                } else {
                    swal(data.title,data.text,data.type);
                }
            })
        });
    }
});

$(document).on('keyup change','.text-domain',function () {

    var value = $(this).val();
    var array = [
        'https', '/', 'www'
    ];
    $.each(array, function (index, element) { 
        value = value.replace(element,''); 
    });
    $(this).val(value);
    $('[data-action="shopping-domain"]').attr('disabled', '');

});

function domainList() {
    var domain =[],
        split,
        html = '';
    $.ajax({
        type: 'GET',
        url: base_url+'frontend/private/ajax_private/domainList',
        data: {
        },
        dataType: 'json',
        beforeSend: function(data) {
            $('[data-section="select-domain"]').attr('disabled','');
        }
    }).done(function(data){
        $.each(data, function (index, element) { 
            split = element.domain.split('.');
            index = domain.indexOf(split[1]);
            if (index == -1) {
            domain.push(split[1]);

            html += ''+
                '<option value="'+split[1]+'">.'+split[1]+'</option>'
            '';
            }
        });
        $('[data-section="select-domain"]').html(html);
        $('[data-section="select-domain"]').removeAttr('disabled');
    })
}

$(document).on('change keyup', '[data-domain="change-text"]', function() {
    var text = $(this).val();
    text = text.replace("http://", "");
    text = text.replace("http//", "");
    text = text.replace("https://", "");
    text = text.replace("https//", "");
    $(this).val(text);
});

$(document).on('click', 'a[data-modal="add-domain"]',function (e) {
    e.preventDefault();
    let domain_modal = $('#domain');
    let input_domain = $('#domain_store');
    let button_validate = $('a.button-validate-domain');
    let info_response = $('#info-response');
    let dns_vinculation = $('#dns-vinculation');
    let button_submit = $('button.button-submit-domain');
    let htm = '';
    $.ajax({
        type: "POST",
        url: base_url + "frontend/private/ajax_private/validateDnsDB",
        dataType: "Json",
        beforeSend: function () {
            dns_vinculation.html('');
            info_response.html('');
            input_domain.val('');
        },
    }).done(function (dataJson) {
        // Mostrar mensaje para comprar dominio
        $('#dominio-message').show();

        if(dataJson.success) {
            // Verificar tipo de validación de dominio
            if(dataJson.type == 'dns') {
                // Verificar estado del dominio
                if(dataJson.validate_button_certificate == 'finish') {
                    // Verificar si aun esta siendo validado
                    if (dataJson.validate_submit) {
                        info_response.html('<div class="col-md-12 alert alert-success fade show">La vinculación del dominio puede tardar 72 horas aprox.<span class="fas fa-check-circle float-right mt-1"></span></div>');
                        button_submit.attr('data-action','domain-submit');
                        dns_vinculation.html('');
                        input_domain.val(dataJson.data.domain_name.substr(0, dataJson.data.domain_name.length - 1));
                    } else {
                        info_response.html('<div class="col-md-12 alert alert-success fade show">Validación de certificado exitosa<span class="fas fa-sync-alt float-right mt-1"></span></div>');
                        button_submit.attr('data-action','domain-disabled');
                        dns_vinculation.html('');
                        input_domain.val(dataJson.data.domain_name.substr(0, dataJson.data.domain_name.length - 1));
                    }

                    // Habilitar boton
                    button_validate.html('Validar');
                    button_validate.attr('data-action','validate-domain-exists');
                    input_domain.removeAttr('disabled');

                    // Ocultar mensaje para comprar dominio
                    $('#dominio-message').hide();
                }else if (dataJson.validate_button_certificate == 'await') {
                    info_response.html('<div class="col-md-12 alert alert-success fade show"><span class="fas fa-check-circle float-right mt-1"></span><p class="mb-1">Validación de DNS exitosa</p><p class="mb-1">por favor verifique la certificación</p></div>');
                    button_submit.attr('data-action','domain-disabled');
                    htm = '<button type="button" class="btn btn-primary rounded-pill btn-private" data-action="validate-certificate">Validar certificado <span class="fas fa-sync-alt"></span></button>';
                    dns_vinculation.html(htm);
                    input_domain.val(dataJson.data.domain_name.substr(0, dataJson.data.domain_name.length - 1));

                    // Habilitar boton
                    button_validate.html('Validar');
                    button_validate.attr('data-action','validate-domain-exists');
                    input_domain.removeAttr('disabled');

                    // Ocultar mensaje para comprar dominio
                    $('#dominio-message').hide();
                } else if (dataJson.validate_button_certificate == 'no-used') {
                    info_response.html('<div class="col-md-12 alert alert-info fade show">Validación exitosa, su dominio debe apuntar a las siguientes DNS:</div>');
                    htm = '<div class="col-md-12">'+
                            '<ul>'+
                                '<li>'+dataJson.data.dns.dns_1+'</li>'+
                                '<li>'+dataJson.data.dns.dns_2+'</li>'+
                                '<li>'+dataJson.data.dns.dns_3+'</li>'+
                                '<li>'+dataJson.data.dns.dns_4+'</li>'+
                            '</ul>'+
                        '</div>' +
                        '<div class="col-md-12 alert alert-info fade show">Si realizaste la compra de tu dominio desde tu store, envía los 4 DNS que figuran a <strong>domino@lanube.cloud</strong></div>';
                    dns_vinculation.html(htm);
                    input_domain.val(dataJson.data.domain_name.substr(0, dataJson.data.domain_name.length - 1));

                    if (dataJson.input_domain) {
                        button_validate.html('Validar');
                        button_validate.attr('data-action','validate-domain-exists');
                        input_domain.removeAttr('disabled');
                    } else {
                        input_domain.attr('disabled','');
                        button_validate.attr('data-action','domain-validate-disabled');
                        button_validate.html('Validar');
                    }
                    button_submit.attr('data-action','domain-disabled');
                    if(dataJson.validate_dns) {
                        dns_vinculation.append('<div class="col-md-12 alert alert-warning fade show dns-validation">Nos encontramos validando los DNS, éste proceso puede demorar hasta 72 horas. Cumplido el plazo, ingrese nuevamente a Verificar Certificado para terminar la operación.</div>');
                    }

                    // Ocultar mensaje para comprar dominio
                    $('#dominio-message').hide();
                }
            } else if(dataJson.type == 'cname') {
                input_domain.val(dataJson.domain);
                if(dataJson.input_domain) {
                    input_domain.removeAttr('disabled');
                    button_validate.attr('data-action','validate-domain-exists');
                    button_validate.html('Validar');
                } else {
                    input_domain.attr('disabled','');
                    button_validate.attr('data-action','domain-validate-disabled');
                    button_validate.html('Validar');
                }
                if (!dataJson.validate_hosting_success) {
                    if (dataJson.send_mail_certificate) {
                        info_response.html('<div class="col-md-12 alert alert-warning fade show">Recuerde seguir los pasos para finalizar la vinculación con su servicio de hosting.</div>');

                        htm = '<div class="col-md-12">'+
                                '<p>El correo electrónico de validación del dominio se enviará a tres direcciones de contacto especificadas en WHOIS y a cinco direcciones administrativas comunes:</p>'+
                                '<ul>'+dataJson.mails+'</ul>'+
                                '<p> para continuar con el proceso debe validar el correo enviado.</p>'+
                        '</div>';
                        dns_vinculation.html(htm);
                      
                        dns_vinculation.append('<div class="text-center"><a href="#" data-action="resend-valitadte-Certificate" class="btn btn-primary rounded-pill btn-private">Reenviar mail de validación</a></div>');
                    } else {
                        info_response.html('<div class="col-md-12 alert alert-warning fade show">Recuerde seguir los pasos para finalizar la vinculación con su servicio de hosting.</div>');
                        dns_vinculation.html('<div>Crear un registro TXT apuntando al subdominio: '+
                            dataJson.subdomain +
                        '</div>'+
                        '<ul>'+
                            '<li>Crear un registro de tipo CNAME que vincule tu dominio propio (www) con el de su tienda subdominio</li>'+
                            '<li> Crear un registro de tipo A que vincule tu dominio sin www a la IP de Lanube ('+dataJson.ip+')</li>'+
                            '<li>TTL o tiempo de vida: ingresar el número 21600. Si esta opción no aparece, podés colocar la primera que aparezca</li>'+
                            '<li>La vinculación del dominio puede tardar 72 horas aprox.</li>'+
                        '</ul>');
                        if(dataJson.create_certificate)
                        {
                            dns_vinculation.append('<div class="text-center"><a href="#" data-action="generate-certificate" class="btn btn-primary rounded-pill btn-private">Generar certificado</a></div>');
                        }
                    }
                } else {
                    dns_vinculation.html('');
                    info_response.html('');
                    $('a[data-modal="add-domain"]').html('MI&nbsp;DOMINIO');
                    $('.msg-validate-domain').html('<a class="link-store button-profile" href="https://'+dataJson.domain+'/index" target="_blank"><span>https://'+dataJson.domain+'</span></a>');
                }
            }
        } else {
            button_validate.html('Validar');
            button_validate.attr('data-action','validate-domain-exists');
            info_response.html('');
            input_domain.removeAttr('disabled');
            button_submit.attr('data-action','domain-disabled');
            dns_vinculation.html('');
        }
    }).fail(function () {
        console.log('error');
    }).always(function () {
        domain_modal.modal('show');
    });
});

$(document).on('click', 'a[data-action="validate-domain-exists"]', function(e) {
    e.preventDefault();
    
    let input_domain = $('#domain_store');
    let domain = input_domain.val();
    let button_validate = $(this);
    let dns_vinculation = $('#dns-vinculation');
    let info_response = $('#info-response');
    let htm = '';
    if(domain) {
        $.ajax({
            type: "POST",
            url: base_url + "frontend/private/ajax_private/validateExists",
            data: {
                domain:domain
            },
            dataType: "Json",
            beforeSend: function () {
                info_response.html('<div class="col-md-4 alert alert-warning fade show">Validando...<span class="spinner-border spinner-border-sm float-right mt-1" role="status" aria-hidden="true"></span></div>');
                button_validate.attr('data-action','domain-validate-disabled');
                button_validate.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                input_domain.attr('disabled','');
            }
        }).done(function (dataJson) {
            if(dataJson.success) {
                button_validate.html('Validar');
                info_response.html('<div class="col-md-12 alert alert-info fade show">Con cual de los siguientes métodos desea validar su dominio:</div>');
                htm = '<div class="col-md-12">'+
                        '<ul class="nav nav-tabs" role="tablist">'+
                            '<li class="nav-item"><a class="nav-link active" href="#validate-dns" role="tab" data-toggle="tab">Validar con DNS</a></li>'+
                            '<li class="nav-item"><a class="nav-link" href="#validate-hosting" role="tab" data-toggle="tab">Tengo mi propio hosting</a></li>'+
                        '</ul>'+
                        '<br>'+
                        '<div class="tab-content">'+
                            '<div role="tablist" class="tab-pane fade show active" id="validate-dns">'+
                                '<div class="text-center">'+
                                    '<a href="#" data-action="validate-domain" data-type="dns" class="btn btn-primary rounded-pill btn-private button-validate-domain">Validar con DNS</a>'+
                                '</div>'+
                            '</div>'+
                            '<div role="tablist" class="tab-pane fade" id="validate-hosting">'+
                                '<div>Crear un registro TXT apuntando al subdominio: '+
                                    dataJson.subdomain +
                                '</div>'+
                                '<ul>'+
                                    '<li>Crear un registro de tipo CNAME que vincule su dominio propio (www) con el de su tienda subdominio</li>'+
                                    '<li> Crear un registro de tipo A que vincule tu dominio sin www a la IP de Lanube ('+dataJson.ip+')</li>'+
                                '</ul>'+
                                '<div class="text-center">'+
                                    '<a href="#" data-action="validate-domain"  data-type="cname" class="btn btn-primary rounded-pill btn-private button-validate-domain">Validar con hosting</a>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>';
                dns_vinculation.html(htm);
            } else {
                swal({
                    title: "Error",
                    text: dataJson.message,
                    type: "error",
                    showCancelButton: false,
                    confirmButtonColor: '#78cbf2',
                    confirmButtonText: 'Aceptar',
                }, function() {
                    button_validate.html('Validar');
                    button_validate.attr('data-action','validate-domain-exists');
                    info_response.html('');
                    input_domain.removeAttr('disabled');
                });
            }
        }).fail(function (error) {
            console.log('error');
        })
    } else {
        swal('Error','Ingrese un dominio!','error')
    }
});

$(document).on('click', 'a[data-action="validate-domain"]', function(e) {
    e.preventDefault();
    let button_validate = $(this);
    let type = $(this).attr('data-type');
    let input_domain = $('#domain_store');
    let domain = input_domain.val(); 
    let dns_vinculation = $('#dns-vinculation');
    let info_response = $('#info-response');
    let htm = '';
    if(domain) {
        $.ajax({
            type: "POST",
            url: base_url + "frontend/private/ajax_private/validateAWSDomain",
            data: {domain:domain,type:type},
            dataType: "Json",
            beforeSend: function () {
                info_response.html('<div class="col-md-4 alert alert-warning fade show">Validando...<span class="spinner-border spinner-border-sm float-right mt-1" role="status" aria-hidden="true"></span></div>');
                button_validate.attr('data-action','domain-validate-disabled');
                button_validate.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                input_domain.attr('disabled','');
            }
        }).done(function (dataJson) {
            if(dataJson.success) {
                if(dataJson.url) {
                    $('a[data-modal="add-domain"]').html('MI&nbsp;DOMINIO');
                    $('.msg-validate-domain').html('<a class="link-store button-profile" href="'+dataJson.url+'/index" target="_blank"><span>'+dataJson.url+'</span></a>');
                        button_validate.html('Validado');
                        info_response.html('<div class="col-md-12 alert alert-success fade show">Se registro el dominio a su tienda, recuerde seguir los pasos para finalizar la vinculación con su servicio de hosting.</div>');
                        dns_vinculation.html('<div>Crear un registro TXT apuntando al subdominio: '+
                        dataJson.subdomain +
                    '</div>'+
                    '<ul>'+
                        '<li>Crear un registro de tipo CNAME que vincule tu dominio propio (www) con el de su tienda subdominio</li>'+
                        '<li> Crear un registro de tipo A que vincule tu dominio sin www a la IP de Lanube ('+dataJson.ip+')</li>'+
                        '<li>TTL o tiempo de vida: ingresar el número 21600. Si esta opción no aparece, podés colocar la primera que aparezca</li>'+
                        '<li>La vinculación del dominio puede tardar 72 horas aprox.</li>'+
                    '</ul>');
                    $('.msg-validate-domain').html('Validando dominio');
                    $('a[data-modal="add-domain"]').html('VALIDANDO&nbsp;DOMINIO');
                } else {
                    button_validate.html('Validar');
                    info_response.html('<div class="col-md-12 alert alert-info fade show">Validación exitosa, su dominio debe apuntar a las siguientes DNS:</div>');
                    htm = '<div class="col-md-12">'+
                            '<ul>'+
                                '<li>'+dataJson.dns.dns_1+'</li>'+
                                '<li>'+dataJson.dns.dns_2+'</li>'+
                                '<li>'+dataJson.dns.dns_3+'</li>'+
                                '<li>'+dataJson.dns.dns_4+'</li>'+
                            '</ul>'+
                        '</div>' +
                        '<div class="col-md-12 alert alert-info fade show">Si realizaste la compra de tu dominio desde tu store, envía los 4 DNS que figuran a <strong>domino@lanube.cloud</strong></div>';
                    dns_vinculation.html(htm);
                    $('.msg-validate-domain').html('Validando dominio');
                    $('a[data-modal="add-domain"]').html('VALIDANDO&nbsp;DOMINIO');
                }
            } else {
                swal({
                    title: "Error",
                    text: dataJson.message,
                    type: "error",
                    showCancelButton: false,
                    confirmButtonColor: '#78cbf2',
                    confirmButtonText: 'Aceptar',
                }, function(){
                    button_validate.html('Validar');
                    button_validate.attr('data-action','validate-domain');
                    info_response.html('');
                    input_domain.removeAttr('disabled');
                });
            }
        }).fail(function () {
            console.log('error');
        });
    } else {
        swal('Error','Ingrese un dominio!','error')
    }
});
$(document).on('click','button[data-action="validate-certificate"]', function (e) {
    e.preventDefault();
    let button_validate_certificate = $(this);
    let info_response = $('#info-response');
    let dns_vinculation = $('#dns-vinculation');
    dns_vinculation
    $.ajax({
        type: "POST",
        url: base_url + "frontend/private/ajax_private/getCertificateAWS",
        dataType: "Json",
        beforeSend: function () {
            button_validate_certificate.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')
        }
    }).done(function (dataJson) {
        if(dataJson.success)
        {
            button_validate_certificate.html('<span class="fas fa-check-circle"></span>');
            button_validate_certificate.attr('data-action','validate-disabled-certificate');
            info_response.html('<div class="col-md-12 alert alert-success fade show">Validación de certificado exitosa <span class="fas fa-check-circle float-right mt-1"></span></div>');
            $('a[data-modal="add-domain"]').html('MI&nbsp;DOMINIO');
            $('.msg-validate-domain').html('<a class="link-store button-profile" href="'+dataJson.url+'/index" target="_blank"><span>'+dataJson.url+'</span></a>');
        }else{
            button_validate_certificate.html('Validar certificado <span class="fas fa-sync-alt"></span>');
            if(!dns_vinculation.find('span').hasClass('text-info'))
            {
                dns_vinculation.append('<br/><span class="text-info btn-private-danger">Generando certificados, espere un momento...</span>');
            }
        }
        console.log('success');
    }).fail(function () {
        console.log('error');
    }).always(function () {
        console.log('complete');
    });
});

function shoppingDomain(e) {
    e.preventDefault();
    $('#domain').modal('hide');
    $('#shoppin-domain').modal('show');
}

$(document).on('click','a[data-action="generate-certificate"]',function (e) {
    e.preventDefault();
    let button_certificate = $(this);
    let dns_vinculation = $('#dns-vinculation');
    let htm = '';
    $.ajax({
        type: "POST",
        url: base_url + "frontend/private/ajax_private/createCertificationAWSHosting",
        dataType: "Json",
        beforeSend: function () {
            button_certificate.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            button_certificate.attr('disabled','');
        }
    }).done(function (dataJson) {
        if(dataJson.success)
        {   
            htm = '<div class="col-md-12">'+
                    '<p>El correo electrónico de validación del dominio se enviará a tres direcciones de contacto especificadas en WHOIS y a cinco direcciones administrativas comunes.:</p>'+
                    '<ul>'+dataJson.mails+'</ul>'+
            '</div>';
            dns_vinculation.html(htm);
            button_certificate.html('Reenviar mail de validación');
            button_certificate.removeAttr('data-action');
            button_certificate.attr('data-action','resend-valitadte-Certificate');
            $('.msg-validate-domain').html('Validando dominio');
            $('a[data-modal="add-domain"]').html('VALIDANDO&nbsp;DOMINIO');
        }else{
            button_certificate.html('Generar certificado');
        }
        console.log('success');
    }).fail(function () {
        console.log('error');
    }).always(function () {
        console.log('complete');
        button_certificate.removeAttr('disabled');
    });
});

$(document).on('click','a[data-action="resend-valitadte-Certificate"]',function (e) {
    e.preventDefault();
    let button_certificate = $(this);
    let dns_vinculation = $('#dns-vinculation');
    let info_response = $('#info-response');
    let htm = '';
    $.ajax({
        type: "POST",
        url: base_url + "frontend/private/ajax_private/resendValitadteCertificate",
        dataType: "Json",
        beforeSend: function () {
            button_certificate.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            button_certificate.attr('disabled','');
        }
    }).done(function (dataJson) {
        if(dataJson.success)
        {   
            info_response.html('<div class="col-md-12 alert alert-success fade show">Se reenvío el mail de validación<span class="fas fa-sync-alt float-right mt-1"></span></div>');
            button_certificate.html('Se reenvío el mail de validación');
            button_certificate.attr('disabled','');
        }else{
            button_certificate.html('Reenviar mail de validación');
            button_certificate.removeAttr('disabled');
        }
        console.log('success');
    }).fail(function () {
        console.log('error');
    }).always(function () {
        console.log('complete');
    });
});