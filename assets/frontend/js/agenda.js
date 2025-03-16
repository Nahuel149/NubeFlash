function take(object) {
    var $element = $(object);

    $('.agenda .separate').each(function (index, element) {
        $(element).css('background','');
        $(element).removeClass('separate');
        $(element).addClass('disponible');    
    });
    
    if($element.hasClass('disponible'))
    {
        $element.css('background','green');
        $element.removeClass('disponible');
        $element.addClass('separate');
        var id = $element.attr('id');
        $('#service_hour').val(id);
    }else if($element.hasClass('separate')){
        $element.css('background','');
        $element.removeClass('separate');
        $element.addClass('disponible');
    }
    
}

function createAgenda(date,service) {
    var htm = '';
    $.ajax({
        type: "POST",
        url: base_url + "frontend/ajax/getAgenda",
        data: {date:date,service_id:service},
        dataType: "JSON",
        beforeSend:function () {
            $('.agenda').removeClass('table-responsive');
            $('.agenda').html('<div class="col-md-12 col-md-12 pb-5 pt-5 text-center"><i class="fas fa-circle-notch fa-spin fa-4x loading_agenda"></i></div>');
            $('button[data-action="add-product"]').attr('disabled','');
        }
    }).done(function (dataJson) {
        if(dataJson.success)
        {   
            $('.agenda').addClass('table-responsive');
            htm += `<table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center">${dataJson.day_name}</th>
                            </tr>
                    </thead>
                    <tbody class="row mr-0 ml-0">`;
            $.each(dataJson.lapsos, function (indexlapso, lapso) { 
                htm += `<tr class="d-flex w-50">
                            <td class="w-50">${lapso}</td>
                            <td id="${lapso}" class="disponible w-50"
                                onclick="take(this)"
                            ></td>
                        </tr>`;
            });
            htm += `</tbody>
            </table>`;
            $('.agenda').html(htm);
            $.each(dataJson.agendados, function (indexAgendado, agendado) { 
                $('.agenda').find('td[id="'+agendado.hour+'"]').css('background','red');
                $('.agenda').find('td[id="'+agendado.hour+'"]').removeClass('disponible');
                $('.agenda').find('td[id="'+agendado.hour+'"]').addClass('no-disponible');
            });
            $('button[data-action="add-product"]').removeAttr('disabled');
        }else{
            $('.agenda').html('<div class="col-md-12 col-md-12 pb-5 pt-5 text-center"><h5>El día seleccionado no esta disponible.</h5></div>');
            $('button[data-action="add-product"]').attr('disabled','');
        }
        console.log('success');
    }).always(function () {
        console.log('complete');
    }).fail(function () {
        console.log('error');
    });
}
$(document).on('click','button[data-action="add-service"]',function (e) {
	e.preventDefault();
	var service = $('input[name="id_product"]').val();
	var hour = $('input[name="service_hour"]').val();
	var date = $('input[name="date_agenda"]').val();

	if(hour)
	{
		window.location = url_navigation+'/'+service+'?hour='+hour+'&date='+date;
	}else{
		swal('Error','Debe escoger una hora en la agenda','error');
	}
});