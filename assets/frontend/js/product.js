var containerFilters = $("div#productos_variations_select");
var stock_producto = 0;

if (containerFilters.length > 0) {
	if (typeof(variacion_producto) !== 'undefined') {
		if (variacion_producto.length > 0) {
			var variacion = variacion_producto[0];
			appendItemFilter(variacion, 0);
		}
	}
}

function appendItemFilter(variacion, numero) {
	var total_registros = containerFilters.find('.form-group').length;
	var items_delete = [];

	for (var i = numero; i < total_registros; i++) {
		items_delete.push("div.item_filtro_" + i);
	}

	$(items_delete.join(',')).remove();

	$("div.item_filtro_" + numero).remove();

	var htm = '<div class="form-group item_filtro_' + numero + '">'+
		'<label>'+ variacion.atributo +'</label>'+
		'<select onchange="handleChangeAtributo(event, \'' + numero + '\');" class="form-control" name="variaciones[' + variacion.id_atributo + ']" required="">'+
			'<option value="">Selecciona</option>';

			$.each(variacion.items, function(indexAtributo, atributo) {
				htm += '<option value="'+ atributo.id_atributo_valor +'">' + atributo.valor + '</option>';
			});

	htm +=	'</select>'+
	'</div>';

	containerFilters.append(htm);

}

function handleChangeAtributo(event, numero_variacion) {
	var atributo = event.target.value;
	numero_variacion = (parseInt(numero_variacion) + 1);
	hideMessageStock();

	if (atributo != '') {

		if (variacion_producto.length >= (numero_variacion + 1)) {
			var variacion = variacion_producto[numero_variacion];
			appendItemFilter(variacion, numero_variacion);

		} else {
			calcularVariacion();

		}

	} else {
		var total_registros = containerFilters.find('.form-group').length;
		var items_delete = [];

		for (var i = numero_variacion; i < total_registros; i++) {
			items_delete.push("div.item_filtro_" + i);
		}

		$(items_delete.join(',')).remove();

	}

}

function calcularVariacion() {

	var variacionesProducto = [];

	var filtros = containerFilters.find('div.form-group');
	var numeroFiltros = filtros.length;

	filtros.each(function(indexFiltro, elemento) {

		var variacion = $(elemento).find('select.form-control').val();
		variacionesProducto.push(variacion);

	});

	var variacionFiltros = [];

	$.each(variacion_producto, function(indexVariacion, valorVariacion) {

		var dataRequest = {
			id_atributo: valorVariacion.id_atributo,
			id_variacion: variacionesProducto[indexVariacion],
		};

		variacionFiltros.push(dataRequest);

	});

	var variacionesList = [];
	var variacionesId = [];

	$.each(variaciones, function(indexVariacion, variacionItem) {

		$.each(variacionFiltros, function(indexFiltro, filtro) {
			if (filtro.id_variacion == variacionItem.id_attribute_variation) {
				variacionesList.push(variacionItem);
				variacionesId.push(variacionItem.id_product_variation);
			}
		});

	});

	var repeticiones = [];

	for (var indiceId = 0; indiceId < variacionesId.length; indiceId++) {
		var contadorCoincidencias = 0;

		for (var indiceList = 0; indiceList < variacionesId.length; indiceList++) {

			if (variacionesId[indiceId] == variacionesId[indiceList]) {
				contadorCoincidencias++;
			}

		}

		repeticiones.push(contadorCoincidencias);

	}

	var variacionDetails = null;

	for (var indexRepeticiones = 0; indexRepeticiones < repeticiones.length; indexRepeticiones++) {

		if (repeticiones[indexRepeticiones] == numeroFiltros) {
			variacionDetails = variacionesList[indexRepeticiones];
		}

	}

	if (variacionDetails != null) {

		var precio = parseFloat(variacionDetails.price);
		var precio_oferta = parseFloat(variacionDetails.offer_price);
		var oferta = parseInt(variacionDetails.offer);
		var stock = variacionDetails.stock;
		var id_product_variation = variacionDetails.id_product_variation;

		var htm = '';

		if (oferta == 1) {

			htm = '<div class="d-flex justify-content-between">'+
			'<div class="d-flex justify-content-center">'+
				'<h4 class="price mb-0">$' + precio_oferta.toFixed(2) + '</h4>';

			htm +=	'<h5 class="price-offer ml-5 mb-0" data-price="price_product">$' + precio.toFixed(2) + '</h5>';

		} else {
			htm = '<div class="d-flex justify-content-between">'+
			'<div class="d-flex justify-content-center">'+
				'<h4 class="price mb-0">$' + precio.toFixed(2) + '</h4>';
		}

		htm +=	'</div>'+
		'</div>';

		$('div.product-price-box').html(htm);

		$('input[data-input="product_variation"]').val(id_product_variation);

		stock_producto = variacionDetails.stock;

	}

}

$(document).on('submit', 'form[data-form="form-product"]', function(event) {
    event.preventDefault();

    var form = $(this);
    var datos = form.serializeArray();

    var cantidadCompra = form.find('input[name="qty"]').val();

    if (!$("#productos_variations_select div.form-group").length) {
    	stock_producto = form.find('input[name="stock_available"]').val();
    }

    if ($("div#modalItemCart").length && !$("#productos_variations_select div.form-group").length) {
    	stock_producto = form.find('input[name="stock_available"]').val();
    }

    if (stock_producto == '' || stock_producto == null) {
    	stock_producto = form.find('input[name="stock_available"]').val();
    }

    if (parseInt(cantidadCompra) <= parseInt(stock_producto)) {

	    $.ajax({
	        url: base_url + 'frontend/ajax/agregarCarrito',
	        type: 'POST',
	        dataType: 'json',
	        data: datos,
	        beforeSend: function() {
	            $('button[data-action="add-product"]').attr('disabled', '');
	        },
	    })
	    .done(function(data) {
	        if (data.success) {
				var symbol = $('[name="symbol"]').val();
	            $('div.modal-message-shopping-cart').modal('show');
	            $(".cart-items-total").text(symbol + parseFloat(data.data.total).toFixed(2));
	            $(".cart-items-badge").text(data.data.num_items);

	            hideMessageStock();

	            $("div#modalItemCart").modal('hide');

	        } else {
	        	showMessageStock();
	        }
	        console.log("success");
	    })
	    .fail(function() {
	    	hideMessageStock();
	        console.log("error");
	    })
	    .always(function() {
	        $('button[data-action="add-product"]').removeAttr('disabled');
	        setTimeout(function() {
	            $('div.modal-message-shopping-cart').modal('hide');
	        }, 1500);
	        console.log("complete");
	        
	    });

	} else {
		showMessageStock();
	}

});

function showMessageStock() {
	var message = '<label style="color: red;">Sin stock.<label>';
	if ($("div.message-error").length > 0) {
		$("div.message-error").html(message);
	} else {
		var htm = '<div class="row"><div class="col-md-12"><div class="message-error">' + message + '</div></div></div>';
		$('div.product-stock-box').append(htm);
	}
}

function hideMessageStock() {
	$("div.message-error").html('');
}

function generacionCarritoModal() {
	$('div#modalItemCart').modal('show');
}

$(document).on('click', 'a[data-action="add-product"]', function(event) {
	event.preventDefault();

	var producto_id = $(this).attr('data-id');
	var stock = $(this).attr('data-stock');
	
	hideMessageStock();

	$('form[data-form="form-product"]').find('input[name="id_product"]').val(producto_id);
	$('div#modalItemCart').find('input[name="stock_available"]').val(stock);

	$.ajax({
		url: base_url + 'frontend/private/ajax_private/product_variations',
		type: 'POST',
		dataType: 'json',
		data: {
			enviar_form: '1',
			producto_id: producto_id,
		},
		beforeSend: function() {
			generacionCarritoModal();
			$("#productos_variations_select").html('<p align="center" class="pt-3 pb-2"><i class="fa fa-spin fa-spinner"></i></p>');
		}
	})
	.done(function(dataJson) {
		if (dataJson.success) {
			$('div#modalItemCart').find('.form-group-variations').html('');
			$('div#modalItemCart').find('button[type="submit"]').removeAttr('disabled');
			variacion_producto = dataJson.data.atributos;
			variaciones = dataJson.data.variaciones;
			if (variacion_producto.length > 0) {
				var variacion = variacion_producto[0];
				appendItemFilter(variacion, 0);
			}
		}
		console.log("success");
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});

});
$(document).on('click','#favorite',function(e){
	var producto = $('[name="id_product"]').val();
	$.ajax({
		url: base_url + 'frontend/private/ajax_private/favorites' ,
		type: 'POST',
		dataType: 'JSON',
		data:{
			data: producto
		} ,
	})
	.done(function(response){
		if(response.success){
			swal({
                title: "¡Éxito!",
                text: "Se agregó correctamente a su lista de favoritos.",
                type: "success"
            }, function() {
                location.reload();
            });
		}
	})
	.fail(function(){
		swal('Error','No se pudo guardar','error')
	})
});
