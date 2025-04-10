<div class="col-lg-12">
	<div class="element-box">
		<?php
		echo form_open(current_url(), array('class' => ""));
		echo form_hidden('enviar_form', '1');
		?>
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<h5>Nueva Empresa/Cliente</h5>
						</div>
					</div>
					<div class="col-md-6 text-right">
						<?php echo form_button(array('type'  => 'submit', 'value' => 'Guardar', 'name'  => 'submit', 'class' => 'btn btn-success'), "<i class='fa fa-floppy-o'></i> Guardar"); ?>
						<a class="btn btn-danger" href="<?php echo base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2); ?>"><i class="fa fa-arrow-circle-left"></i> Volver</a>
					</div>
				</div>
				<hr>
			</div>
		</div>
		<div class="form-group">
			<label for="social_reason">Razón Social</label>
			<input id="social_reason" type="text" name="social_reason" value="" class="form-control" placeholder="Razón Social" />
		</div>
		<div class="form-group">
			<label for="fiscal_identifier">Identificador Fiscal</label>
			<input id="fiscal_identifier" type="text" name="fiscal_identifier" value="" class="form-control" placeholder="Identificador fiscal" />
		</div>
		<div class="form-group">
			<label for="Pais">País <span class="required">*</span></label>
			<select class="form-control" id="country" required name="country">
				<option value="">Seleccione un País</option>
				<?php foreach ($countries as $country) { ?>
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
			<label for="address">Dirección<span class="required">*</span></label>
			<input id="address" required type="text" name="address" value="" class="form-control" placeholder="Dirección" />
		</div>
		<div class="form-group">
			<label for="business_hours">Horario de atención</label>
			<input id="business_hours" type="text" name="business_hours" value="" class="form-control" placeholder="Horario de atneción" />
		</div>
		<div class="form-group">
			<label for="person_contact">Persona de Contacto<span class="required">*</span></label>
			<input id="person_contact" required type="person_contact" name="person_contact" value="" class="form-control" placeholder="Persona de contacto" />
		</div>
		<div class="form-group">
			<label for="telephone">Telefono<span class="required">*</span></label>
			<input id="telephone" required type="text" name="telephone" value="" class="form-control" placeholder="Telefono" />
		</div>
		<div class="form-group">
			<label for="email">Correo electronico<span class="required">*</span></label>
			<input id="email" required type="text" name="email" value="" class="form-control" placeholder="Correo electronico" />
		</div>
		<div class="form-group">
			<label for="password">Contraseña<span class="required">*</span></label>
			<input id="password" required type="password" name="password" value="" class="form-control" placeholder="contraseña" />
		</div>
		<div class="form-group">
			<label for="postal_code">Código Postal<span class="required">*</span></label>
			<input id="postal_code" required type="text" name="postal_code_manual" value="" class="form-control" placeholder="Código Postal" />
			<div class="invalid-feedback postal-code-error">
				El código postal es obligatorio
			</div>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>
<script>
	// Get CSRF token name and hash
	var csrfTokenName = '<?php echo $this->security->get_csrf_token_name(); ?>';
	var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

	// Form submission validation
	$('form').on('submit', function(e) {
		// If destination is "other", ensure postal code is not empty
		if ($('#destination').val() === 'other') {
			const postalCode = $('#postal_code').val().trim();
			if (!postalCode) {
				e.preventDefault();
				$('#postal_code').addClass('is-invalid');
				$('.postal-code-error').show();
				return false;
			}
			
			// Ensure destination field has the name attribute
			if ($('#destination').attr('name') !== 'destination') {
				console.log('Adding missing name attribute to destination field');
				$('#destination').attr('name', 'destination');
			}
		}
	});

	$("#country").change(function(e) {
		e.preventDefault();
		var country_id = $(this).val();
		$.ajax({
			type: "POST",
			url: base_url + 'ecommerce/customers/getProvince',
			data: {
				country_id: country_id,
				[csrfTokenName]: csrfHash
			},
			dataType: "JSON",
			beforeSend: function() {
				$("#province").attr('disabled', '');
				$("#province").html('<option value="">Seleccione una Provincia</option>');
				$("#destination").html('<option value="">Seleccione una Localidad</option>');
				$("#postal_code").val('');
			},
		}).done(function(data) {
			// Update CSRF hash if provided
			if (data.csrf_hash) {
				csrfHash = data.csrf_hash;
				$('input[name="' + csrfTokenName + '"]').val(csrfHash);
			}
			
			var htm = "<option value=''>Seleccione una Provincia</option>";
			if (data.success) {
				$.each(data.provinces, function(index, value) {
					htm += "<option value='" + value.province_id + "'>" + value.name + "</option>";
				});
				htm += "<option value='other'>-- Otro --</option>";
				$("#province").html(htm);
				$("#province").removeAttr('disabled');
			}
			console.log("success")
		}).fail(function() {
			console.log("error")
		}).always(function() {
			console.log("complete")
		});
	});

	$("#province").change(function(e) {
		e.preventDefault();
		var province_id = $(this).val();
		
		// Handle "Other" option
		if (province_id === 'other') {
			// Show manual input
			$("#province_manual").show().attr('required', true).attr('name', 'province_manual');
			
			// Set destination to "other" and ensure it's correctly set up for form submission
			$("#destination").html('<option value="other">-- Otro --</option>');
			$("#destination").val('other');
			$("#destination").attr('name', 'destination').attr('required', true);
			
			// Make destination dropdown visible but readonly
			$("#destination").removeAttr('disabled').css({
				'position': 'absolute',
				'opacity': '0',
				'pointer-events': 'none',
				'z-index': '-1'
			});
			
			// Show destination manual field
			$("#destination_manual").show().attr('required', true).attr('name', 'destination_manual');
			
			// Ensure postal code is required
			$("#postal_code").attr('required', true);
			
			console.log('Changed to manual province mode. Destination value:', $("#destination").val());
			console.log('Destination has name attribute:', $("#destination").attr('name') === 'destination');
			
			return;
		}
		
		// Hide manual inputs for normal selection
		$("#province_manual").hide().removeAttr('required').removeAttr('name');
		$("#destination_manual").hide().removeAttr('required').removeAttr('name');
		
		$.ajax({
			type: "POST",
			url: base_url + 'ecommerce/customers/getDestination',
			data: {
				province_id: province_id,
				[csrfTokenName]: csrfHash
			},
			dataType: "JSON",
			beforeSend: function() {
				$("#destination").attr('disabled', '');
				$("#destination").html('<option value="">Seleccione una Localidad</option>');
				$("#postal_code").val('');
			},
		}).done(function(data) {
			// Update CSRF hash if provided
			if (data.csrf_hash) {
				csrfHash = data.csrf_hash;
				$('input[name="' + csrfTokenName + '"]').val(csrfHash);
			}
			
			var htm = "<option value=''>Seleccione una Localidad</option>";
			if (data.success) {
				$.each(data.destinations, function(index, value) {
					htm += "<option value='" + value.destination_id + "' data-code='" + value.postal_code + "'>" + value.name + "</option>";
				});
				htm += "<option value='other'>-- Otro --</option>";
				$("#destination").html(htm);
				$("#destination").removeAttr('disabled');
			}
			console.log("success")
		}).fail(function() {
			console.log("error")
		}).always(function() {
			console.log("complete")
		});
	});

	// Destination change handler
	$("#destination").change(function(e) {
		e.preventDefault();
		var destination_id = $(this).val();
		
		// Handle "Other" option for destination
		if (destination_id === 'other') {
			// Show manual input
			$("#destination_manual").show().attr('required', true).attr('name', 'destination_manual');
			
			// Ensure destination dropdown retains its name
			$(this).attr('name', 'destination').attr('required', true);
			
			// Ensure postal code field is required (it is already, but let's be extra clear)
			$("#postal_code").attr('required', true);
			
			console.log('Changed to manual destination mode. Dropdown name:', $(this).attr('name'));
			console.log('Dropdown value:', $(this).val());
			
			return;
		} else {
			// Hide manual input, restore dropdown functionality
			$("#destination_manual").hide().removeAttr('required').removeAttr('name');
		}
		
		// Set postal code if available
		var postal_code = $("#destination option[value='"+destination_id+"']").data("code");
		if(postal_code) {
			$("#postal_code").val(postal_code);
		} else {
			$("#postal_code").val('');
		}
	});
</script>