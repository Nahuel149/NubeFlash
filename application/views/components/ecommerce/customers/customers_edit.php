<style>
	.element-box {
		position: relative;
		z-index: 1;
	}
	.form-control {
		position: relative;
		z-index: 2;
		pointer-events: auto !important;
		user-select: auto !important;
		-webkit-user-select: auto !important;
	}
	.form-group {
		position: relative;
		z-index: 2;
	}
	.password-requirements {
		font-size: 0.85em;
		color: #666;
		margin-top: 5px;
	}
	.invalid-feedback {
		display: none;
		color: #dc3545;
		font-size: 0.85em;
	}
</style>
<div class="col-lg-12">
	<div class="element-box">
		<?php
		echo form_open(current_url(), array(
			'class' => 'form',
			'id' => 'customer-edit-form',
			'method' => 'post'
		));
		echo form_hidden('enviar_form', '1');
		echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash());
		?>
		<?php echo form_hidden('id', $result->customer_id) ?>

		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<h5>Editar Empresa/Cliente</h5>
						</div>
					</div>
					<div class="col-md-6 text-right">
						<button type="submit" class="btn btn-success">
							<i class="fa fa-floppy-o"></i> Guardar
						</button>
						<a class="btn btn-danger" href="<?php echo base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2); ?>">
							<i class="fa fa-arrow-circle-left"></i> Volver
						</a>
					</div>
				</div>
				<hr>
			</div>
		</div>
		<div class="form-group">
			<label for="social_reason">Razón Social<span class="required">*</span></label>
			<input id="social_reason" required type="text" name="social_reason" value="<?php echo $result->social_reason ?>" class="form-control" placeholder="Razón Social" />
		</div>
		<div class="form-group">
			<label for="fiscal_identifier">Identificador Fiscal<span class="required">*</span></label>
			<input id="fiscal_identifier" required type="text" name="fiscal_identifier" value="<?php echo $result->fiscal_identifier ?>" class="form-control" placeholder="Identificador fiscal" />
		</div>
		<div class="form-group">
			<label for="Pais">País <span class="required">*</span></label>
			<select class="form-control" id="country" required name="country">
				<option value="">Seleccione un País</option>
				<?php foreach ($countries as $country) { ?>
					<option <?php echo $country->country_id == $result->country_id ? "selected" : "" ?> value="<?php echo $country->country_id ?>"><?php echo $country->name ?></option>
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
			<label for="address">Dirección</label>
			<input id="address" type="text" name="address" value="<?php echo $result->address ?>" class="form-control" placeholder="Dirección" />
		</div>
		<div class="form-group">
			<label for="business_hours">Horario de atención</label>
			<input id="business_hours" type="text" name="business_hours" value="<?php echo $result->business_hours ?>" class="form-control" placeholder="Horario de atneción" />
		</div>
		<div class="form-group">
			<label for="person_contact">Persona de Contacto<span class="required">*</span></label>
			<input id="person_contact" required type="person_contact" name="person_contact" value="<?php echo $result->person_contact ?>" class="form-control" placeholder="Persona de contacto" />
		</div>
		<div class="form-group">
			<label for="telephone">Teléfono<span class="required">*</span></label>
			<input id="telephone" required type="text" name="telephone" value="<?php echo $result->telephone ?>" class="form-control" placeholder="Telefono" />
		</div>
		<div class="form-group">
			<label for="email">Correo electrónico<span class="required">*</span></label>
			<input id="email" required type="text" name="email" value="<?php echo $result->email ?>" class="form-control" placeholder="Correo electronico" />
		</div>
		<div class="form-group">
			<label for="password">Contraseña</label>
			<input id="password" type="password" name="password" value="" class="form-control" placeholder="contraseña" />
			<div class="password-requirements">
				La contraseña debe tener al menos:
				<ul>
					<li id="length-check">8 caracteres</li>
					<li id="uppercase-check">1 mayúscula</li>
					<li id="symbol-check">1 símbolo (!@#$%^&*)</li>
				</ul>
			</div>
			<div class="invalid-feedback">
				La contraseña no cumple con los requisitos mínimos
			</div>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>
<script>
	$(document).ready(function() {
		var country = '<?php echo $result->country_id ?>';
		if (country > 0) {
			$("#country").val(country).trigger('change');
		}

		// Setup CSRF token for all AJAX requests
		var csrfTokenName = '<?php echo $this->security->get_csrf_token_name(); ?>';
		var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

		// Add CSRF token to all AJAX requests
		$.ajaxSetup({
			beforeSend: function(xhr, settings) {
				if (!/^(GET|HEAD|OPTIONS|TRACE)$/i.test(settings.type)) {
					xhr.setRequestHeader('X-CSRF-Token', csrfHash);
				}
			}
		});

		// Password validation function
		function validatePassword(password) {
			if (!password) return true; // Empty password is valid (not changing password)
			
			const minLength = password.length >= 8;
			const hasUpperCase = /[A-Z]/.test(password);
			const hasSymbol = /[!@#$%^&*]/.test(password);

			$('#length-check').css('color', minLength ? 'green' : '#666');
			$('#uppercase-check').css('color', hasUpperCase ? 'green' : '#666');
			$('#symbol-check').css('color', hasSymbol ? 'green' : '#666');

			return !password || (minLength && hasUpperCase && hasSymbol);
		}

		// Password input event handler
		$('#password').on('input', function() {
			const password = $(this).val();
			if (password) {
				const isValid = validatePassword(password);
				$(this).siblings('.invalid-feedback').toggle(!isValid);
				$(this).toggleClass('is-invalid', !isValid);
			} else {
				// Reset colors if password is empty
				$('#length-check, #uppercase-check, #symbol-check').css('color', '#666');
				$(this).siblings('.invalid-feedback').hide();
				$(this).removeClass('is-invalid');
			}
		});

		// Form submission handling
		$('#customer-edit-form').on('submit', function(e) {
			e.preventDefault();
			
			// Validate password if it's not empty
			const password = $('#password').val();
			const isPasswordValid = validatePassword(password);
			
			if (!isPasswordValid) {
				$('#password').addClass('is-invalid');
				$('#password').siblings('.invalid-feedback').show();
				return false;
			}
			
			// Get the form data and add CSRF token
			var formData = $(this).serializeArray();
			
			// Submit form via AJAX
			$.ajax({
				type: "POST",
				url: $(this).attr('action'),
				data: formData,
				dataType: 'json',
				success: function(response) {
					if (response.success) {
						// Update CSRF hash if provided
						if (response.csrf_hash) {
							csrfHash = response.csrf_hash;
							$('input[name="' + csrfTokenName + '"]').val(csrfHash);
						}
						window.location.href = base_url + 'ecommerce/customers';
					} else {
						// Update CSRF hash if provided
						if (response.csrf_hash) {
							csrfHash = response.csrf_hash;
							$('input[name="' + csrfTokenName + '"]').val(csrfHash);
						}
						alert(response.message || 'Error al guardar los cambios');
					}
				},
				error: function(xhr, status, error) {
					console.error('Error:', error);
					console.log('Status:', status);
					console.log('Response:', xhr.responseText);
					alert('Error al guardar los cambios. Por favor, intente nuevamente.');
				}
			});
		});

		// Country change handler
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
					$("#destination").attr('disabled', '');
					$("#province").html('<option value="">Seleccione una Provincia</option>');
					$("#destination").html('<option value="">Seleccione una Localidad</option>');
				}
			}).done(function(data) {
				// Update CSRF hash if provided
				if (data.csrf_hash) {
					csrfHash = data.csrf_hash;
					$('input[name="' + csrfTokenName + '"]').val(csrfHash);
				}

				var htm = "<option value=''>Seleccione una Provincia</option>";
				var province = '<?php echo $result->province_id ?>';
				if (data.success) {
					$.each(data.provinces, function(index, value) {
						htm += "<option " + (province == value.province_id ? 'selected' : '') + " value='" + value.province_id + "'>" + value.name + "</option>";
					});
					$("#province").html(htm);
					$("#province").removeAttr('disabled');
					if (province > 0) {
						$("#province").val(province).trigger('change');
					}
				}
				console.log("success");
			}).fail(function(xhr, status, error) {
				console.error("Error:", error);
				console.log("Status:", status);
				console.log("Response:", xhr.responseText);
			}).always(function() {
				console.log("complete");
			});
		});

		// Province change handler
		$("#province").change(function(e) {
			e.preventDefault();
			var province_id = $(this).val();
			
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
				}
			}).done(function(data) {
				// Update CSRF hash if provided
				if (data.csrf_hash) {
					csrfHash = data.csrf_hash;
					$('input[name="' + csrfTokenName + '"]').val(csrfHash);
				}

				var htm = "<option value=''>Seleccione una Localidad</option>";
				var destination = '<?php echo $result->destination_id ?>';
				if (data.success) {
					$.each(data.destinations, function(index, value) {
						htm += "<option " + (destination == value.destination_id ? 'selected' : '') + " value='" + value.destination_id + "' data-code='" + value.postal_code + "'>" + value.name + "</option>";
					});
					$("#destination").html(htm);
					$("#destination").removeAttr('disabled');
					if (destination > 0) {
						$("#destination").val(destination).trigger('change');
					}
				}
				console.log("success");
			}).fail(function(xhr, status, error) {
				console.error("Error:", error);
				console.log("Status:", status);
				console.log("Response:", xhr.responseText);
			}).always(function() {
				console.log("complete");
			});
		});
	});
</script>