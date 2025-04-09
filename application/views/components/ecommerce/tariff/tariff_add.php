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
                <input type="text" id="province_manual" class="form-control mt-2" placeholder="Ingrese Provincia Manualmente" style="display: none;">
	        </div>
			<div class="form-group">
	            <label for="destination">Localidad <span class="required">*</span></label>
	            <select id="destination" disabled required name="destination" class="form-control">
					<option value="">Seleccione una Localidad</option>
				</select>
                <input type="text" id="destination_manual" class="form-control mt-2" placeholder="Ingrese Localidad Manualmente" style="display: none;">
	        </div>
			<div class="form-group">
	            <label for="postal_code">Codigo Postal</label>
	            <input id="postal_code" type="text" name="postal_code_manual" value="" class="form-control" />
	        </div>
			<div class="form-group">
	            <label for="weight">Peso en gramos <span class="required">*</span></label>
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
            $("#province_manual").hide().removeAttr('required').removeAttr('name').val('');
            $("#province").prop('required', true).attr('name', 'province');
            $("#destination_manual").hide().removeAttr('required').removeAttr('name').val('');
            $("#destination").prop('required', true).attr('name', 'destination');
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
            htm += "<option value='other'>-- Otro --</option>";
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
    
    // Handle "Other" option
    if (province_id === 'other') {
        // Show manual input, hide dropdown functionality
        $("#province_manual").show().attr('required', true).attr('name', 'province_manual');
        $(this).removeAttr('required').removeAttr('name');
        
        // Clear destination and enable manual destination
        $("#destination").html('<option value="">Seleccione una Localidad</option>');
        $("#destination").attr('disabled', 'disabled');
        
        // Enable destination manual field by default
        $("#destination_manual").show().attr('required', true).attr('name', 'destination_manual');
        $("#destination").removeAttr('required').removeAttr('name');
        
        return;
    } else {
        // Hide manual input, restore dropdown functionality
        $("#province_manual").hide().removeAttr('required').removeAttr('name').val('');
        $(this).attr('required', true).attr('name', 'province');
        
        // Hide destination manual if not selected
        $("#destination_manual").hide().removeAttr('required').removeAttr('name').val('');
        $("#destination").attr('required', true).attr('name', 'destination');
    }
    
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
            htm += "<option value='other'>-- Otro --</option>";
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
    
    // Handle "Other" option for destination
    if (destination_id === 'other') {
        // Show manual input, hide dropdown functionality
        $("#destination_manual").show().attr('required', true).attr('name', 'destination_manual');
        $(this).removeAttr('required').removeAttr('name');
        
        // Clear postal code, user will enter it manually
        $("#postal_code").val('');
        return;
    } else {
        // Hide manual input, restore dropdown functionality
        $("#destination_manual").hide().removeAttr('required').removeAttr('name').val('');
        $(this).attr('required', true).attr('name', 'destination');
    }
    
	var postal_code = $("#destination option[value='"+destination_id+"']").data("code");
	if(postal_code)
	{
		$("#postal_code").val(postal_code);
	}else{
		$("#postal_code").val('');
	}
});
</script>