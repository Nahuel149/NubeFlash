<div class="col-lg-12">
    <div class="element-box">
		<?php     
			echo form_open(current_url(), array('class'=>""));
			echo form_hidden('enviar_form','1');
		?>
			<div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h5>Nueva Tarifa</h5>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
							<?php echo form_button(array('type'  =>'submit','value' =>'Guardar','name'  =>'submit','class' =>'btn btn-success'), "<i class='fa fa-floppy-o'></i> Guardar"); ?> 
							<a class="btn btn-danger" href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>"><i class="fa fa-arrow-circle-left"></i> Volver</a>
                        </div>
                    </div>
                    <hr>          
                </div>
            </div>
			<div class="form-group">
	            <label for="Pais">País <span class="required">*</span></label>
				<select class="form-control" id="country" required name="country">
					<option value="">Seleccione un País</option>
					<?php foreach($countries as $country){ ?>
						<option value="<?php echo $country->country_id ?>"><?php echo $country->name ?></option>
					<?php } ?> 
				</select>
	        </div>
	        <div class="form-group">
	            <label for="province">Departamento/Provincia <span class="required">*</span></label>
	            <select id="province" disabled required name="province" class="form-control">
					<option value="">Seleccione una Provincia</option>
					
				</select>
	        </div>
			<div class="form-group">
	            <label for="destination">Localidad <span class="required">*</span></label>
	            <select id="destination" disabled required name="destination" class="form-control">
					<option value="">Seleccione una Localidad</option>
				</select>
	        </div>
			<div class="form-group">
	            <label for="postal_code">Codigo Postal</label>
	            <input id="postal_code" readonly type="text" name="postal_code" value="" class="form-control" />
	        </div>
			<div class="form-group">
	            <label for="weight">Peso en kilogramos <span class="required">*</span></label>
	            <input id="weight" required type="number" step=".01" name="weight" value="" class="form-control" />
	        </div>
			<div class="form-group">
	            <label for="volume">Volumen en cm3 <span class="required">*</span></label>
	            <input id="volume" required type="number" step=".01" name="volume" value="" class="form-control" />
	        </div>
			<div class="form-group">
	            <label for="tariff_price">Tarifa precio <span class="required">*</span></label>
	            <input id="tariff_price" required type="number" step=".01" name="tariff_price" value="" class="form-control" />
	        </div>
		<?php echo form_close(); ?>
	</div>
</div>
<script>
// Get CSRF token name and hash
var csrfTokenName = '<?php echo $this->security->get_csrf_token_name(); ?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

$("#country").change(function (e) { 
	e.preventDefault();
	var country_id = $(this).val();
	$.ajax({
		type: "POST",
		url: base_url + 'ecommerce/tariff/getProvince',
		data: {
			country_id: country_id,
			[csrfTokenName]: csrfHash
		},
		dataType: "JSON",
		beforeSend: function () {
			$("#province").attr('disabled','');
			$("#province").html('<option value="">Seleccione una Provincia</option>');
			$("#destination").html('<option value="">Seleccione una Localidad</option>');
			$("#postal_code").val('');
		},
	}).done(function (data) {
		// Update CSRF hash if provided
		if (data.csrf_hash) {
			csrfHash = data.csrf_hash;
			$('input[name="' + csrfTokenName + '"]').val(csrfHash);
		}

		var htm = "<option value=''>Seleccione una Provincia</option>";
		if(data.success)
		{
			$.each(data.provinces, function (index, value) { 
				 htm += "<option value='"+value.province_id+"'>"+value.name+"</option>";
			});
			$("#province").html(htm);
			$("#province").removeAttr('disabled');
		}
		console.log("success")
	}).fail(function (xhr, status, error) {
		console.error("Error:", error);
		console.log("Status:", status);
		console.log("Response:", xhr.responseText);
	}).always(function () {
		console.log("complete")
	});
});

$("#province").change(function (e) { 
	e.preventDefault();
	var province_id = $(this).val();
	$.ajax({
		type: "POST",
		url: base_url + 'ecommerce/tariff/getDestination',
		data: {
			province_id: province_id,
			[csrfTokenName]: csrfHash
		},
		dataType: "JSON",
		beforeSend: function () {
			$("#destination").attr('disabled','');
			$("#destination").html('<option value="">Seleccione una Localidad</option>');
			$("#postal_code").val('');
		},
	}).done(function (data) {
		// Update CSRF hash if provided
		if (data.csrf_hash) {
			csrfHash = data.csrf_hash;
			$('input[name="' + csrfTokenName + '"]').val(csrfHash);
		}

		var htm = "<option value=''>Seleccione una Localidad</option>";
		if(data.success)
		{
			$.each(data.destinations, function (index, value) { 
				 htm += "<option value='"+value.destination_id+"' data-code='"+value.postal_code+"'>"+value.name+"</option>";
			});
			$("#destination").html(htm);
			$("#destination").removeAttr('disabled');
		}
		console.log("success")
	}).fail(function (xhr, status, error) {
		console.error("Error:", error);
		console.log("Status:", status);
		console.log("Response:", xhr.responseText);
	}).always(function () {
		console.log("complete")
	});
});

$("#destination").change(function (e) { 
	e.preventDefault();
	var destination_id = $(this).val();
	var postal_code = $("#destination option[value='"+destination_id+"']").data("code");
	if(postal_code)
	{
		$("#postal_code").val(postal_code);
	}else{
		$("#postal_code").val('');
	}
});
</script>