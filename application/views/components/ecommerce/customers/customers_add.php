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
			<label for="social_reason">Razón Social<span class="required">*</span></label>
			<input id="social_reason" required type="text" name="social_reason" value="" class="form-control" placeholder="Razón Social" />
		</div>
		<div class="form-group">
			<label for="fiscal_identifier">Identificador Fiscal<span class="required">*</span></label>
			<input id="fiscal_identifier" required type="text" name="fiscal_identifier" value="" class="form-control" placeholder="Identificador fiscal" />
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
		</div>
		<div class="form-group">
			<label for="destination">Localidad <span class="required">*</span></label>
			<select id="destination" disabled required name="destination" class="form-control">
				<option value="">Seleccione una Localidad</option>
			</select>
		</div>
		<div class="form-group">
			<label for="address">Dirección</label>
			<input id="address" type="text" name="address" value="" class="form-control" placeholder="Dirección" />
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
		<?php echo form_close(); ?>
	</div>
</div>
<script>
	$("#country").change(function(e) {
		e.preventDefault();
		var country_id = $(this).val();
		$.ajax({
			type: "POST",
			url: base_url + 'ecommerce/customers/getProvince',
			data: {
				country_id: country_id
			},
			dataType: "JSON",
			beforeSend: function() {
				$("#province").attr('disabled', '');
				$("#province").html('<option value="">Seleccione una Provincia</option>');
				$("#destination").html('<option value="">Seleccione una Localidad</option>');
				$("#postal_code").val('');
			},
		}).done(function(data) {
			var htm = "<option value=''>Seleccione una Provincia</option>";
			if (data.success) {
				$.each(data.provinces, function(index, value) {
					htm += "<option value='" + value.province_id + "'>" + value.name + "</option>";
				});
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
		$.ajax({
			type: "POST",
			url: base_url + 'ecommerce/customers/getDestination',
			data: {
				province_id: province_id
			},
			dataType: "JSON",
			beforeSend: function() {
				$("#destination").attr('disabled', '');
				$("#destination").html('<option value="">Seleccione una Localidad</option>');
				$("#postal_code").val('');
			},
		}).done(function(data) {
			var htm = "<option value=''>Seleccione una Localidad</option>";
			if (data.success) {
				$.each(data.destinations, function(index, value) {
					htm += "<option value='" + value.destination_id + "' data-code='" + value.postal_code + "'>" + value.name + "</option>";
				});
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
</script>