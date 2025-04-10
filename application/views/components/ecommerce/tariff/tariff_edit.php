<div class="col-lg-12">
    <div class="element-box">
		<?php     
			echo form_open(current_url(), array('class'=>""));
			echo form_hidden('enviar_form','1');
		?>
			<?php echo form_hidden('id',$result->tariff_id) ?>
			
			<div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h5>Editar Tarifa</h5>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <?php echo form_button(array('type'  =>'submit','value' =>'Guardar Cambios','name'  =>'submit','class' =>'btn btn-success'), "<i class='fa fa-floppy-o'></i> Guardar"); ?>
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
						<option <?php echo $country->country_id == $result->country_id ? "selected":"" ?> value="<?php echo $country->country_id ?>"><?php echo $country->name ?></option>
					<?php } ?> 
				</select>
	        </div>
	        <div class="form-group">
	            <label for="province">Departamento/Provincia <span class="required">*</span></label>
	            <select id="province" disabled required name="province" class="form-control">
					<option value="">Seleccione una Provincia</option>
				</select>
                <input type="text" id="province_manual" class="form-control mt-2" placeholder="Ingrese Provincia Manualmente" style="display: none;" value="<?php echo $result->province_name_manual ?>">
	        </div>
			<div class="form-group">
	            <label for="destination">Localidad <span class="required">*</span></label>
	            <select id="destination" disabled required name="destination" class="form-control">
					<option value="">Seleccione una Localidad</option>
				</select>
                <input type="text" id="destination_manual" class="form-control mt-2" placeholder="Ingrese Localidad Manualmente" style="display: none;" value="<?php echo $result->destination_name_manual ?>">
	        </div>
			<div class="form-group">
	            <label for="postal_code">Codigo Postal</label>
	            <input id="postal_code" type="text" name="postal_code_manual" value="<?php echo $result->postal_code_manual ?>" class="form-control" />
	        </div>
			<div class="form-group">
	            <label for="weight">Peso en kilogramos <span class="required">*</span></label>
	            <input id="weight" required type="number"  step=".01" name="weight" value="<?php echo $result->weight ?>" class="form-control" />
	        </div>
			<div class="form-group">
	            <label for="volume">Volumen (cm³) <span class="required">*</span></label>
	            <input id="volume" required type="number" step=".01" name="volume" value="<?php echo $result->volume ?>" class="form-control" />
	        </div>
			<div class="form-group">
	            <label for="tariff_price">Tarifa precio <span class="required">*</span></label>
	            <input id="tariff_price" required type="number" step=".01" name="tariff_price" value="<?php echo $result->tariff_price ?>" class="form-control" />
	        </div>
		<?php echo form_close(); ?>
	</div>
</div>
<script>
// Get CSRF token name and hash
var csrfTokenName = '<?php echo $this->security->get_csrf_token_name(); ?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

// Check if we have manual province or destination entries
var hasManualProvince = <?php echo (!empty($result->province_name_manual)) ? "true" : "false" ?>;
var hasManualDestination = <?php echo (!empty($result->destination_name_manual)) ? "true" : "false" ?>;

$(document).ready(function () {
	var country = '<?php echo $result->country_id ?>';
	if(country > 0) {
		$("#country").val(country).trigger('change');
	}
    
    // If we have manual values, show the appropriate fields after ajax completes
    setTimeout(function() {
        if (hasManualProvince) {
            $("#province").val('other').trigger('change');
            $("#province_manual").val('<?php echo $result->province_name_manual ?>');
        }
    }, 1000);
});

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
			// Remove postal code clearing to preserve manual value
            $("#province_manual").hide().removeAttr('required').removeAttr('name').val('<?php echo $result->province_name_manual ?>');
            $("#province").prop('required', true).attr('name', 'province');
            $("#destination_manual").hide().removeAttr('required').removeAttr('name').val('<?php echo $result->destination_name_manual ?>');
            $("#destination").prop('required', true).attr('name', 'destination');
		},
	}).done(function (data) {
		// Update CSRF hash if provided
		if (data.csrf_hash) {
			csrfHash = data.csrf_hash;
			$('input[name="' + csrfTokenName + '"]').val(csrfHash);
		}

		var htm = "<option value=''>Seleccione una Provincia</option>";
		var province = '<?php echo $result->province_id ?>';
		if(data.success)
		{
			$.each(data.provinces, function (index, value) { 
				 htm += "<option "+(province == value.province_id ? 'selected':'')+" value='"+value.province_id+"'>"+value.name+"</option>";
			});
            htm += "<option value='other'>-- Otro --</option>";
			$("#province").html(htm);
			$("#province").removeAttr('disabled');
			
            if(hasManualProvince) {
                // Set 'Other' option and show the manual field
                $("#province").val('other').trigger('change');
            } else if(province > 0) {
                $("#province").val(province).trigger('change');
            }
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
        
        // Clear destination and set to 'other' and hide (instead of disabling)
        $("#destination").html('<option value="other">-- Otro --</option>');
        $("#destination").val('other').hide();
        
        // Enable destination manual field by default
        $("#destination_manual").show().attr('required', true).attr('name', 'destination_manual');
        
        // Keep the existing postal code value
        return;
    } else {
        // Hide manual input, restore dropdown functionality
        $("#province_manual").hide().removeAttr('required').removeAttr('name').val('');
        
        // Hide destination manual if not selected
        if (!hasManualDestination) {
            $("#destination_manual").hide().removeAttr('required').removeAttr('name').val('');
        }
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
			// Keep existing postal code value instead of overwriting
		},
	}).done(function (data) {
		// Update CSRF hash if provided
		if (data.csrf_hash) {
			csrfHash = data.csrf_hash;
			$('input[name="' + csrfTokenName + '"]').val(csrfHash);
		}

		var htm = "<option value=''>Seleccione una Localidad</option>";
		var destination = '<?php echo $result->destination_id ?>';
		if(data.success)
		{
			$.each(data.destinations, function (index, value) { 
				 htm += "<option "+(destination == value.destination_id ? 'selected':'')+" value='"+value.destination_id+"' data-code='"+value.postal_code+"'>"+value.name+"</option>";
			});
            htm += "<option value='other'>-- Otro --</option>";
			$("#destination").html(htm);
			$("#destination").removeAttr('disabled');
			
            if(hasManualDestination) {
                // Set 'Other' option and show the manual field
                $("#destination").val('other').trigger('change');
            } else if(destination > 0) {
                $("#destination").val(destination).trigger('change');
            }
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
        
        // Keep postal code as is - user can edit manually
        return;
    } else {
        // Hide manual input, restore dropdown functionality
        $("#destination_manual").hide().removeAttr('required').removeAttr('name').val('');
    }
    
	var postal_code = $("#destination option[value='"+destination_id+"']").data("code");
	// Only update postal code if a new one is available from the destination
	if(postal_code && postal_code !== $("#postal_code").val())
	{
		$("#postal_code").val(postal_code);
	}
});
</script>