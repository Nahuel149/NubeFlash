$(document).on('click','a[data-action="session-login"]',function (e) {
    e.preventDefault();
    $('#modalLogin').modal('show');
});
$(document).on('change','[data-action="password-compare"]',function () {
    var password = $('#password').val(),
        password_re =$(this).val();
    if (password!=password_re) {
        swal('Informativo','Las contraseñas son diferentes','warning');
        $(this).val('');
    }
});
$(document).on('change','[data-action="password-profile"]',function () {
    var password = $('#password_profile').val(),
        password_re =$(this).val();
    if (password!=password_re) {
        swal('Informativo','Las contraseñas son diferentes','warning');
        $(this).val('');
    }
});
$(document).on('click','a[data-action="store-register"]',function (e) {
    e.preventDefault();
    var value = $(this).attr('data-value');
    switch (value) {
        case '1':
                $('[data-section="show-hide"]').addClass('d-none');
                $('#store-register').removeClass('d-none');
                $('#title-modal').text('Registrar');
                $('[data-section="inpt-required"] input').attr('required', '');
            break;
    
        case '2':
                $('[data-section="show-hide"]').addClass('d-none');
                $('#store-session').removeClass('d-none');
                $('[data-section="inpt-required"] input').removeAttr('required');
                $('#title-modal').text('Ingresar');
            break;
        case '3':
                $('[data-section="show-hide"]').addClass('d-none');
                $('#recover-session').removeClass('d-none');
                $('[data-section="inpt-required"] input').removeAttr('required');
                $('#title-modal').text('Recuperar contraseña');
            break;
    }
});
$(document).on('submit','form[data-section="show-hide"]',function (e) {
    e.preventDefault();
    var value = $(this).attr('data-value'),
        data;
        data = $(this).serialize();
    switch (value) {
        case '1':
                storeSession(data);
            break;
    
        case '2':
                storeRegister(data);
            break;
        case '3':
                storeRecover(data);
            break;
    }
    
});
function storeRegister(data) {
    $.ajax({
		url: base_url + 'frontend/private/store/registerUserStore',
		type: 'POST',
		dataType: 'json',
		data: data,
		beforeSend: function() {
		}
	})
	.done(function(Json) {
        if (Json.success) {
            swal('Existe', Json.message, 'warning');
        } else {
            location.reload(); 
        }
	})
}
function storeSession(data) {
    $.ajax({
		url: base_url + 'frontend/private/store/loginUserStore',
		type: 'POST',
		dataType: 'json',
		data: data,
		beforeSend: function() {
		}
	})
	.done(function(Json) {
        if (Json.success) {
            location.reload();   
            console.log('exito');
        }else{
            swal('Informativo',Json.message,'warning');
        }
	})
}
function storeRecover(data) {
    $.ajax({
		url: base_url + 'frontend/private/store/recoverSession',
		type: 'POST',
		dataType: 'json',
		data: data,
		beforeSend: function() {
		}
	})
	.done(function(Json) {
        if (Json.success) {
            swal(Json.type,Json.message,Json.status);
        }
	})
}
$(document).on('submit','[data-action="store-exclusives"]',function (e) {
    e.preventDefault();
    var data = $(this).serialize();

    $.ajax({
		url: base_url + 'frontend/private/store/editUserStore',
		type: 'POST',
		dataType: 'json',
		data: data,
		beforeSend: function() {
		}
	})
	.done(function(Json) {
        if (Json.success) {
            swal({
                title: "Exito",
                text: "Se guardo con exito",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: '#78cbf2',
                confirmButtonText: 'Aceptar',
                },
                function(){
                    location.reload();
                }
            );
        }
	})
});


$(document).on('click','.detalle',function (e) { 
    e.preventDefault();
    var id_store_order = $(this).data('id');
    var htm = '';
    $.ajax({
        url: base_url + 'frontend/private/web_private/detalle_orden',
        type: 'POST',
        dataType: 'json',
        data: {id_store_order:id_store_order},
    })
    .done(function(data) {

        if (data.success) {

            var dataJSON = data.orden.response_ahiva;
            var htmCorreoUruguayo = '';

            if (dataJSON != null && dataJSON != '' && dataJSON != "0") {

                htmCorreoUruguayo = '<div class="col-md-6">' +
                    '<b>Correo Uruguayo:</b><br />';

                dataJSON = eval(dataJSON);

                $.each(dataJSON, function(index, item) {
                    var partsJSON = item.reportes[0].pdf.split('/');
                    var pdfName = partsJSON[partsJSON.length - 1];
                    htmCorreoUruguayo += '<a href="' + data.ahiva_url + pdfName + '" target="_blank" class="btn btn-sm btn-secondary mb-3"><i class="fa fa-download"></i> Documento de envío N° 0'+ (index + 1) +'</a>';
                });

                htmCorreoUruguayo += '</div>';

            }

            $('#num_orden').html(data.orden.id_store_order);

            htm += '<div class="col-md-12"><div class="row"><div class="col-md-6"><div class="form-group"><b>Cliente: '+data.orden.name+' '+data.orden.last_name+'</b></div></div>'+
            '<div class="col-md-6"><div class="form-group"><b>Email: '+data.orden.email+'</b></div></div>'+
            '<div class="col-md-6"><div class="form-group"><b>Teléfono: '+data.orden.telephone+'</b></div></div>'+
            '<div class="col-md-6"><div class="form-group"><b>Método de Pago: '+data.orden.payment_method+'</b></div></div>'+
            '<div class="col-md-6"><div class="form-group"><b>Estado del pedido: '+data.orden.status+'</b></div></div>'+
            '<div class="col-md-6"><div class="form-group"><b>Fecha del pedido: '+data.orden.fecha+'</b></div></div>';
            if(data.orden.hour_service)
            {
                htm += '<div class="col-md-6"><div class="form-group"><b>Fecha de cita: '+(data.orden.date_service+' '+data.orden.hour_service)+'</b></div></div>';
            }else{
                htm += '<div class="col-md-6"><div class="form-group"><b>Método de Envío: '+(data.orden.shipping ? data.orden.shipping:'')+'</b></div></div>';
            }

            if (data.orden.preparation_time != null && data.orden.preparation_time != '') {
                htm += '<div class="col-md-6"><div class="form-group"><b>Tiempo de preparación: </b>' + data.orden.preparation_time + '</div></div>';
            }

            if(data.orden.clarification)
            {
                htm += '<div class="col-md-6"><div class="form-group"><b>Aclaraciones: '+data.orden.clarification+'</b></div></div>';
            } else {
                htm += '<div class="col-md-6"><div class="form-group"><b>No hay aclaraciones</b></div></div>'
            }

            htm += htmCorreoUruguayo + '</div></div>';

            if (data.orden.id_cupon > 0) {
                htm += '<div class="col-md-6"><div class="form-group"><b>Cupón de descuento: '+data.orden.cupon+'</b></div></div></div></div>';
            }

            var tipoProducto = $('input[data-name="type_product"]').val();

            htm += '<div class="col-md-12 table-responsive">'+
                '<table class="table">'+
                '<thead>'+
                '<tr>';
                if(!data.orden.hour_service){
                    htm += '<th>CÓDIGO</th>'+
                            '<th>' + tipoProducto + '</th>';
                }else{
                    htm +=  '<th>SERVICIO</th>';
                }
            htm  += '<th>PRECIO</th>'+
                    '<th>CANTIDAD</th>'+
                    '<th>IMPORTE</th>'+
                '</tr>'+
            '</thead>'+
            '<tbody>';

            $.each(data.products, function (index, value) { 

                htm += ''+
                    '<tr>';
                if(!data.orden.hour_service){
                    htm += '<td>' + (value.code ? value.code:'');

                            if (value.variaciones != '' && value.variaciones != null) {
                                $.each(value.variaciones.split('*|*'), function(indexVariacion, variacion) {
                                    htm += '<br/>' + variacion;
                                });
                            }

                    htm += '</td>';
                }
                        

                htm +=  '<td>' + value.name;

                htm +=  '</td><td>' + data.symbol + ' ' + value.price + '</td>'+
                        '<td class="text-center">' + value.qty + '</td>'+
                        '<td>' + data.symbol + ' '+parseFloat(value.price * value.qty).toFixed(2)+'</td>'+
                    '</tr>';

            });

            htm += '</tbody>';
            htm += '</table>' +
            '</div>' +

            '<div class="col-md-12">' +
                '<div class="form-group text-right">';

            if (data.orden.cost_shipping > 0) {

                htm += '<b>Sub Total:</b> ' + data.symbol + ' '+data.orden.subtotal+'<br>'+
                '<b>Costo de envío:</b> ' + data.symbol + ' '+data.orden.cost_shipping+'<br>';

                if (data.commission != '0') {
                    htm +='<b>Comisión:</b>' + data.symbol + ' '+data.commission+'<br>';
                }

                if (data.orden.discount > 0)
                {
                    htm += '<b>Descuento:</b> ' + data.symbol + ' '+data.orden.discount+'<br>'+
                    '<b>Total:</b> ' + data.symbol + ' ' + (parseFloat(data.orden.subtotal) + parseFloat(data.orden.cost_shipping) - parseFloat(data.orden.discount)).toFixed(2) + '<br>';

                } else {
                    htm +='<b>Total:</b> ' + data.symbol + ' ' + (parseFloat(data.orden.subtotal) + parseFloat(data.orden.cost_shipping)).toFixed(2) + '<br>';

                }

            } else {

                if(data.orden.discount > 0)
                {
                    htm += '<b>Sub Total:</b> ' + data.symbol + ' '+data.orden.subtotal+'<br>'+ 
                    '<b>Descuento:</b> ' + data.symbol + ' '+data.orden.discount+'<br>'+
                    '<b>Total:</b> ' + data.symbol + ' ' + (parseFloat(data.orden.subtotal) - parseFloat(data.orden.discount)).toFixed(2) + '<br>';

                } else {
                    htm += '<b>Total:</b> ' + data.symbol + ' ' + data.orden.subtotal + '<br>';

                }

            }

            $('#detalle_orden .form-horizontal').html(htm);
            $('#detalle_orden').modal('show');

        }

    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });

});

$(document).on('click','[data-action="logout-session"]',function (e) {
    e.preventDefault();
    $.ajax({
        url: base_url + 'frontend/private/store/logoutUserStore',
        type: 'POST',
        dataType: 'json',
        data: {
            
        },
    })
    .done(function(dataJson) {
        if (dataJson.success) {
            location.reload();
        }else{

        }
    })
    
});
$(document).on('click','.re-order',function (e) {
    e.preventDefault();
    var id_store_order = $(this).data('id');
    swal ({
		title: "Confirmación",
		text: "Esta acción limpiará todos los productos cargados en el carrito de compras. ¿Está seguro(a) de comprar?",
		type: "warning",
		showCancelButton: true,
		confirmButtonText: "Si",
		closeOnConfirm: false,
		disableButtonsOnConfirm: true,
        showLoaderOnConfirm: true,
		html: false,
	}, function(response) {

		if (response) {

			$.ajax({
                url: base_url + 'frontend/ajax/buyReOrder',
                type: 'POST',
                dataType: 'json',
                data: {
                    id_store_order:id_store_order
                },
            })
            .done(function(dataJson) {
                if (dataJson.success) {
                    var url = $(document).find('a.item-cart-menu i.fa.fa-shopping-cart.fa-2x').closest('a').attr('href');
                    window.location = url;
                }
            })
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});

		}
	});
});