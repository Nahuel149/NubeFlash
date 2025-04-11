<style>
    @media(max-width: 767px) {
        .navbar .logo-img {
            max-width: 195px;
        }
        
        /* Give better spacing to the hero section */
        #section_home {
            padding: 20px 0;
            overflow: hidden;
        }
        
        /* Center content on mobile */
        #section_home .col-md-6 {
            text-align: center;
        }
    }
</style>
<section id="section_home">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="simple-text text-weight-100 mb-0">Envía desde una pulsera</h4>
                <h4 class="simple-text mb-0">hasta una cama</h4>
                <h4 class="simple-text">King Size</h4>
                <br />
                <a class="btn btn-primary rounded-pill btn-boton" href="<?php echo base_url('registro') ?>">EMPIEZA HOY</a>
            </div>
            <div class="col-md-6 d-flex justify-content-center">
                <div class="hero-image-container">
                    <img src="<?php echo base_url('assets/public/tus-envios-vuelan.png') ?>" class="img-fluid flying-text" alt="Tus envíos vuelan">
                    <img src="<?php echo base_url('assets/public/SUPER FLASH.png') ?>" class="img-fluid hero-image" alt="Delivery superhero">
                </div>
            </div>
        </div>
    </div>
</section>
<section id="section_aboutus">
    <div class="container pb-5">
        <div class="row">
            <div class="col-md-6 pt-5 wow bounceInUp">
                <div class="row">
                    <div class="col-lg-1 col-md-1 col-sm-1 col-1">
                        <img src="<?php echo base_url('assets/public/rayos.png') ?>" height="43px">
                    </div>
                    <div class="col-lg-11 col-md-11 col-sm-11 col-11">
                        <p>Ofrecemos herramientas integradas de eCommerce. Desde su creación para la venta en línea, hasta el proceso de entrega de cualquier producto.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-1 col-md-1 col-sm-1 col-1">
                        <img src="<?php echo base_url('assets/public/rayos.png') ?>" height="43px">
                    </div>
                    <div class="col-lg-11 col-md-11 col-sm-11 col-11">
                        <p>Nuestro centro de distribución funciona también como nave de conexión entre importador, vendedor y comprador. Aquí es donde se desarrollan todas las actividades logísticas desde el Online al Offline.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-1 col-md-1 col-sm-1 col-1">
                        <img src="<?php echo base_url('assets/public/rayos.png') ?>" height="43px">
                    </div>
                    <div class="col-lg-11 col-md-11 col-sm-11 col-11">
                        <p>Aquí es donde se ejecutan todos los procesos de recepción de mercancías provenientes de los fabricantes hasta el domicilio del consumidor final.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 align-self-center text-center wow bounceInUp">
                <img class="img-fluid" src="<?php echo base_url('assets/public/enterprice.png') ?>" alt="">
            </div>
        </div>
        <br />
    </div>
</section>
<section id="section_mision" style="background-color: #f2d046; padding: 80px 0 100px 0; margin: 0; display: flex; align-items: center;">
    <div class="container wow bounceInUp">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-2 col-lg-2 d-flex justify-content-end align-items-center">
                <img src="<?php echo base_url('assets/public/flash_amarillo.png') ?>" class="img-fluid" style="max-height: 120px;">
            </div>
            <div class="col-md-10 col-lg-10">
                <h6 class="text-bold-nube text-center" style="font-size: 120%; letter-spacing: 5px;">NUESTRA MISIÓN</h6>
                <br>
                <h6 class="text-semibold-nube text-center" style="font-size: 120%; max-width: 90%; margin: 0 auto;">Ser la empresa de logística de eCommerce y distribución de paquetes, más eficiente de los últimos tiempos.</h6>
            </div>
        </div>
    </div>
</section>
<section id="section_service" style="margin-top: -1px; position: relative; padding-bottom: 220px;">
    <div class="container">
        <h2 class="simple-text text-center mb-5 wow bounceInUp" style="color: #4e7de9;">SERVICIOS</h2>
        <br />
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6 mb-4 wow bounceInUp">
                <div class="service-card">
                    <div style="position: absolute; top: 20px; left: 30px; z-index: 5;">
                        <img src="<?php echo base_url('assets/public/flash_naranja.png') ?>" style="width: 80px; height: auto; transform: rotate(-5deg);">
                    </div>
                    <h2 class="text-center" style="letter-spacing: 3px; margin-top: 30px;">ENVÍOS</h2>
                    <p>Entrega de paquetes a domicilio dentro de Montevideo</p>
                    <p>Una visita, con entrega bajo firma, presentando cédula de identidad de la persona responsable (mayor de edad).</p>
                    <p>Si no pudiera entregarse, se advertirá al receptor mediante un aviso de visita informando que dispone de 5 días corridos para recoger el envío en el centro logístico.</p>
                </div>
            </div>
            <div class="col-lg-5 col-md-6 mb-4 wow bounceInUp">
                <div class="service-card">
                    <div style="position: absolute; top: 20px; left: 30px; z-index: 5;">
                        <img src="<?php echo base_url('assets/public/flash_naranja.png') ?>" style="width: 80px; height: auto; transform: rotate(-5deg);">
                    </div>
                    <h2 class="text-center" style="letter-spacing: 3px; margin-top: 30px;">BOXES</h2>
                    <p>Bodegas para acopio de mercadería con la posibilidad de alquilar desde 10 m2</p>
                    <p>Control de stock</p>
                    <p>Con vigilancia 24hs. servicio interno de video vigilancia</p>
                    <p>Responsabilidad sobre mercadería</p>
                </div>
            </div>
        </div>
    </div>
    <div style="position: absolute; bottom: -30px; right: 4%; z-index: 10;" class="delivery-truck-container">
        <img src="<?php echo base_url('assets/public/ENTREGA_CAMION.png') ?>" style="max-width: 700px; height: auto;" class="delivery-truck-img">
    </div>
</section>
<section id="section_price">
    <div class="container">
        <h2 class="simple-text text-white text-center wow bounceInUp">PRECIOS</h2>
        <p>&nbsp;</p>
        <br>
        <h4 class="simple-text text-white text-center wow bounceInUp"><span>COSTOS DE</span> ENVÍOS</h4>
        <p class="text-white text-center wow bounceInUp">Precio por envío pago por remitente, por debajo de los 1000 envíos mensuales</p>
        <div class="col-md-12 table-responsive wow bounceInUp">
            <table class="table">
                <thead>
                    <tr class="color-secondary">
                        <th class="d-lg-block d-none">paquete estándar<br><span>&nbsp;</span></th>
                        <th class="d-lg-none d-block text-left">paquete<br><span class="text-secondary-size">estándar</span></th>
                        <th>precio <br><span>entrega normal</span></th>
                        <th>precio <br><span>entrega 24hs</span></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="color-primary text-white">
                        <td align="left">Hasta 2Kg. / 40 x 20 x 20 cm</td>
                        <td align="center">$130</td>
                        <td align="center">$160</td>
                    </tr>
                    <tr class="color-secondary text-warning">
                        <td align="left">De 2 a 5 Kg. / 40 x 30 x 30 cm</td>
                        <td align="center">$155</td>
                        <td align="center">$185</td>
                    </tr>
                    <tr class="color-primary text-white">
                        <td align="left">De 5 a 20 Kg. / 100 x 60 x 60 cm</td>
                        <td align="center">$200</td>
                        <td align="center">$230</td>
                    </tr>
                    <tr class="color-secondary text-warning">
                        <td align="left">De 20 a 30 Kg. / 100 x 60 x 60 cm</td>
                        <td align="center">$360</td>
                        <td align="center">$390</td>
                    </tr>
                    <tr class="color-primary text-white">
                        <td align="left">Paquetes de gran tamaño* sin restricciones</td>
                        <td align="center">$750</td>
                        <td align="center">$980</td>
                    </tr>
                    <tr class="color-secondary text-warning">
                        <td align="left">Retiro de Mercaderia</td>
                        <td align="center">$80</td>
                        <td align="center">$80</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p>&nbsp;</p>
        <h4 class="simple-text text-white text-center wow bounceInUp"><span>PRECIOS</span> BOXES</h4>
        <p class="text-white text-center wow bounceInUp">Valor de U$S g por m2, con bonificación por bodega total</p>
        <div class="col-md-12 table-responsive wow bounceInUp">
            <table class="table">
                <thead>
                    <tr class="color-secondary">
                        <th>espacio estándar</th>
                        <th>m2</th>
                        <th>precio U$S</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="color-primary text-white">
                        <td align="left">Bodega Minima</td>
                        <td align="center">10</td>
                        <td align="center">U$S 90</td>
                    </tr>
                    <tr class="color-secondary text-warning">
                        <td align="left">Bodega Completa</td>
                        <td align="center">50</td>
                        <td align="center">U$S 400</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
<section id="section_location">
    <div class="location">
        <div class="container">
            <div class="row">
                <div class="col-md-6 pr-5 wow bounceInLeft">
                    <h2 class="simple-text">DONDE ESTAMOS</h2>
                    <br />
                    <h5>CENTRO LOGÍSTICO</h5>
                    <p style="font-size: 16px;">Centro de distribución ubicado en el centro geográfico de Montevideo (Damaso Antonio Larrañaga 3581 esq. Rep. De Corea), será el lugar de entrada y salida de los vehículos, centro tecnológico de atención a clientes y lugar de acopio.</p>
                    <h5>NAVES</h5>
                    <p style="font-size: 16px;">Espacios de 50 m2 para acopio de pedidos y posibilidad alquiler de espacio. Con vigilancia 24hs, servicio interno de video vigilancia.</p>
                </div>
                <div class="col-md-6 align-self-center text-center wow bounceInRight">
                    <img class="img-fluid" src="<?php echo base_url('assets/public/location.png') ?>" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
<section id="section_delivery_time">
    <div class="delivery_time">
        <div class="container">
            <div class="row">
                <div class="col-md-6 d-lg-block d-md-block d-sm-none d-none align-self-center text-center wow bounceInRight">
                    <img class="img-fluid" src="<?php echo base_url('assets/public/delivery.png') ?>">
                </div>
                <div class="col-md-6 wow bounceInRight">
                    <h2 class="simple-text">TIEMPO DE ENTREGA</h2>
                    <br />
                    <div class="row">
                        <div class="col-lg-1 col-md-1 col-sm-1 col-1">
                            <img src="<?php echo base_url('assets/public/rayos.png') ?>" height="43px">
                        </div>
                        <div class="col-lg-11 col-md-11 col-sm-11 col-11">
                            <h5 class="mb-0 text-bold-nube">24 o 48hs.</h5>
                            <p class="text-medium-nube">Dependiendo del destino y las cantidades.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-1 col-md-1 col-sm-1 col-1">
                            <img src="<?php echo base_url('assets/public/rayos.png') ?>" height="43px">
                        </div>
                        <div class="col-lg-11 col-md-11 col-sm-11 col-11">
                            <h5 class="mb-0 text-bold-nube">Franjas horarias optativas para clientes</h5>
                            <p class="text-medium-nube">De lunes a viernes 9 a 12hs / 13 a 17hs / 18 a 21hs</p>
                            <p class="text-medium-nube">Sábados 9 a 12hs</p>
                            <p class="text-second">El cliente puede optar por una entrega en 24hs a un costo mayor</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-1 col-md-1 col-sm-1 col-1">
                            <img src="<?php echo base_url('assets/public/rayos.png') ?>" height="43px">
                        </div>
                        <div class="col-lg-11 col-md-11 col-sm-11 col-11">
                            <p class="text-bold-nube-second">EN CUALQUIERA DE LOS CASOS, SI EL RETIRO NO SE EFECTÚA EN EL PLAZO DE LOS 5 DÍAS CORRIDOS, EL PAQUETE ES DEVUELTO AL REMITENTE</p>
                        </div>
                    </div>
                    <div class="col-md-6 d-lg-none d-md-none d-sm-block d-block align-self-center text-center">
                        <img class="img-fluid" src="<?php echo base_url('assets/public/delivery.png') ?>">
                    </div>
                    <br />
                    <div class="text-center wow bounceInRight">
                        <a href="<?php echo base_url('registro') ?>" class="btn btn-primary rounded-pill btn-boton">REGISTRARME &#8594;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- <section id="section_tracking">
    <div class="container">
        <h2 class="simple-text text-white">tracking</h2>
        <div class="row">
            <div class="col-md-6 align-self-end">
                <h5 class="text-white">busca el codigo del pediod y lorem ipsum lorem</h5>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control rounded-pill position-relative" value=""/>
                <button class="btn btn-warning rounded-pill btn-search">BUSCAR</button>
            </div>
        </div>
    </div>   
</section> -->
<section id="section_faqs" class="faq-section py-5">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <h2 class="simple-text mb-4">PREGUNTAS FRECUENTES</h2>
                <p class="text-muted">Encuentra respuestas a las dudas más comunes sobre nuestros servicios de envío y almacenamiento.</p>
            </div>
        </div>
        
        <!-- Desktop/Tablet FAQ Accordion -->
        <div class="row justify-content-center d-none d-md-flex">
            <div class="col-lg-10">
                <div class="accordion faq-accordion" id="accordionLanding">
                    <?php foreach ($preguntas_frecuentes as $key => $pregunta) { ?>
                        <div class="faq-item">
                            <div class="faq-header" id="heading<?php echo $pregunta->id_faq ?>">
                                <button class="faq-button collapsed" type="button" data-toggle="collapse" data-target="#collapse<?php echo $pregunta->id_faq ?>" aria-expanded="false" aria-controls="collapse<?php echo $pregunta->id_faq ?>">
                                    <div class="faq-number"><?php echo $key + 1 ?></div>
                                    <span class="faq-question"><?php echo $pregunta->question ?></span>
                                    <i class="fas fa-chevron-down faq-icon"></i>
                                </button>
                            </div>
                            <div id="collapse<?php echo $pregunta->id_faq ?>" class="collapse faq-collapse" aria-labelledby="heading<?php echo $pregunta->id_faq ?>" data-parent="#accordionLanding">
                                <div class="faq-body">
                                    <?php echo $pregunta->answer ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        
        <!-- Mobile FAQ Accordion -->
        <div class="row justify-content-center d-md-none">
            <div class="col-12">
                <div class="accordion faq-accordion" id="accordionLandingMovil">
                    <?php 
                    $visible_count = 5; // Show first 5 FAQs on mobile
                    foreach ($preguntas_frecuentes as $key => $pregunta) { 
                        $hidden = ($key >= $visible_count) ? 'faq-hidden' : '';
                    ?>
                        <div class="faq-item <?php echo $hidden; ?>">
                            <div class="faq-header" id="headingMobile<?php echo $pregunta->id_faq ?>">
                                <button class="faq-button collapsed" type="button" data-toggle="collapse" data-target="#collapseMobile<?php echo $pregunta->id_faq ?>" aria-expanded="false" aria-controls="collapseMobile<?php echo $pregunta->id_faq ?>">
                                    <div class="faq-number"><?php echo $key + 1 ?></div>
                                    <span class="faq-question"><?php echo $pregunta->question ?></span>
                                    <i class="fas fa-chevron-down faq-icon"></i>
                                </button>
                            </div>
                            <div id="collapseMobile<?php echo $pregunta->id_faq ?>" class="collapse faq-collapse" aria-labelledby="headingMobile<?php echo $pregunta->id_faq ?>" data-parent="#accordionLandingMovil">
                                <div class="faq-body">
                                    <?php echo $pregunta->answer ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    
                    <?php if (count($preguntas_frecuentes) > $visible_count): ?>
                        <div class="text-center mt-4">
                            <button id="faq-show-more" class="btn btn-outline-primary rounded-pill">
                                <span class="show-text">Ver más preguntas <i class="fas fa-chevron-down ml-2"></i></span>
                                <span class="hide-text d-none">Ver menos preguntas <i class="fas fa-chevron-up ml-2"></i></span>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* FAQ Section Styling */
.faq-section {
    background-color: #f8f9fa;
    position: relative;
    overflow: hidden;
}

.faq-section::before {
    content: '';
    position: absolute;
    top: -50px;
    right: -50px;
    width: 200px;
    height: 200px;
    background-color: rgba(78, 125, 233, 0.1);
    border-radius: 50%;
    z-index: 0;
}

.faq-section::after {
    content: '';
    position: absolute;
    bottom: -100px;
    left: -100px;
    width: 300px;
    height: 300px;
    background-color: rgba(242, 208, 70, 0.1);
    border-radius: 50%;
    z-index: 0;
}

.faq-accordion {
    position: relative;
    z-index: 1;
}

.faq-item {
    margin-bottom: 16px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    background-color: #fff;
    overflow: hidden;
    transition: all 0.3s ease;
}

.faq-item:hover {
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

.faq-header {
    position: relative;
}

.faq-button {
    display: flex;
    align-items: center;
    width: 100%;
    padding: 20px;
    text-align: left;
    background-color: #ffffff;
    border: none;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
}

.faq-button:hover {
    background-color: #f8f9fa;
}

.faq-button:focus {
    outline: none;
}

.faq-button.collapsed .faq-icon {
    transform: rotate(0deg);
}

.faq-button:not(.collapsed) {
    background-color: #f8f9fa;
}

.faq-button:not(.collapsed) .faq-icon {
    transform: rotate(180deg);
    color: #4e7de9;
}

.faq-number {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background-color: #4e7de9;
    color: #ffffff;
    font-weight: bold;
    margin-right: 15px;
    flex-shrink: 0;
}

.faq-question {
    color: #333;
    font-size: 16px;
    padding-right: 30px;
}

.faq-icon {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    transition: transform 0.3s ease;
    color: #adb5bd;
}

.faq-body {
    padding: 0 20px 20px 65px;
    color: #6c757d;
    line-height: 1.6;
}

.faq-hidden {
    display: none;
}

/* Mobile adjustments */
@media (max-width: 767px) {
    .faq-button {
        padding: 15px;
    }
    
    .faq-number {
        width: 25px;
        height: 25px;
        font-size: 14px;
        margin-right: 10px;
    }
    
    .faq-question {
        font-size: 14px;
    }
    
    .faq-body {
        padding: 0 15px 15px 50px;
    }
}
</style>

<script>
$(document).ready(function() {
    // Toggle show more/less FAQs on mobile
    $('#faq-show-more').on('click', function() {
        $('.faq-hidden').toggle();
        $('.show-text, .hide-text').toggleClass('d-none');
        
        if ($('.faq-hidden').is(':visible')) {
            // Scroll to the first hidden item that's now visible
            $('html, body').animate({
                scrollTop: $('.faq-hidden:first').offset().top - 100
            }, 500);
        }
    });
});
</script>

<section id="section_contacto">
    <div class="header-nube"></div>
    <div class="complement_contactos">
        <div class="container wow bounceInUp">
            <h2 class="text-center simple-text text-white">CONTACTO</h2>
            <form class="pt-5" action="<?php echo base_url('contacto') ?>" method="POST">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                <div class="row">
                    <?php if ($this->session->flashdata('contactoProcesado')) { ?>
                        <div class="col-md-12">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo $this->session->flashdata('contactoProcesado') ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($this->session->flashdata('error')) { ?>
                        <div class="col-md-12">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $this->session->flashdata('error') ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="name" id="contact-name" placeholder="NOMBRE " class="form-control input-contact" required autocomplete="name" maxlength="50">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="enterprise" id="contact-enterprise" placeholder="EMPRESA " class="form-control input-contact" required autocomplete="organization" maxlength="50">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="email" name="email" id="contact-email" placeholder="EMAIL" class="form-control input-contact" required autocomplete="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Por favor ingrese un email válido que contenga @ y un dominio (.com, .org, etc.)">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="tel" name="telephone" id="contact-telephone" placeholder="TELÉFONO" class="form-control input-contact" required autocomplete="tel" pattern="^\+?[0-9]+$" title="Por favor ingrese un número de teléfono válido (puede comenzar con + seguido de números)" maxlength="25">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea rows="3" name="message" id="contact-message" placeholder="MENSAJE" class="form-control input-contact" required maxlength="1000"></textarea>
                        </div>
                    </div>
                </div>
                <br>
                <div class="form-group d-flex justify-content-center">
					<div class="g-recaptcha" data-sitekey="<?php echo CAPTCHA_KEY ?>" data-callback="recaptcha_callback"></div>
				</div>
                <div class="text-center padding-top-10">
                    <button class="btn btn-warning btn-send-contanct rounded-pill" id="enviar" disabled>ENVIAR </button>
                </div>
            </form>
        </div>
    </div>
</section>
<script type="text/javascript">
    function recaptcha_callback() {  
		$('#enviar').prop("disabled", false);
    }

    // Validación de los campos del formulario
    $(document).ready(function() {
        // Contador de caracteres para el mensaje
        $('#contact-message').on('input', function() {
            var maxLength = 1000;
            var currentLength = $(this).val().length;
            
            if (currentLength > maxLength) {
                $(this).val($(this).val().substring(0, maxLength));
            }
        });
        
        // Validación del teléfono (solo + al inicio y números)
        $('#contact-telephone').on('input', function() {
            var input = $(this).val();
            // Si hay algún carácter que no sea número o + al inicio, lo eliminamos
            if (input.length > 0) {
                // Permitir + solo al inicio
                if (input.charAt(0) === '+') {
                    // Comprobar el resto de caracteres (solo números)
                    var restOfInput = input.substring(1);
                    if (!/^\d*$/.test(restOfInput)) {
                        $(this).val('+' + restOfInput.replace(/[^\d]/g, ''));
                    }
                } else {
                    // Si no empieza con +, solo permitir números
                    $(this).val(input.replace(/[^\d]/g, ''));
                }
            }
        });
        
        // Validación de email
        $('#contact-email').on('input', function() {
            var email = $(this).val();
            var validEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email);
            
            if (email.length > 0 && !validEmail) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
    });

    $("#button_enterprise").click(function(e) {
        // e.preventDefault();
        $('html, body').animate({
            scrollTop: $("#section_aboutus").offset().top - 50
        }, 1000);
    });
    $("#button_service").click(function(e) {
        // e.preventDefault();
        $('html, body').animate({
            scrollTop: $("#section_service").offset().top + 50
        }, 1000);
    });
    $("#button_prices").click(function(e) {
        // e.preventDefault();
        $('html, body').animate({
            scrollTop: $("#section_price").offset().top + 50
        }, 1000);
    });
    $("#button_location").click(function(e) {
        // e.preventDefault();
        $('html, body').animate({
            scrollTop: $("#section_location").offset().top + 50
        }, 1000);
    });
    $("#button_delivery").click(function(e) {
        // e.preventDefault();
        $('html, body').animate({
            scrollTop: $("#section_delivery_time").offset().top + 50
        }, 1000);
    });
    $("#button_faqs").click(function(e) {
        // e.preventDefault();
        $('html, body').animate({
            scrollTop: $("#section_faqs").offset().top + 50
        }, 1000);
    });
    $("#button_contact").click(function(e) {
        // e.preventDefault();
        $('html, body').animate({
            scrollTop: $("#section_contacto").offset().top - 110
        }, 1000);
    });
    $(document).on('click', '#more', function(e) {
        e.preventDefault();
        $('.question-mobile').fadeIn();
        $('.no-more').show();
        $('.more').hide();
    });

    $(document).on('click', '#minus', function(e) {
        e.preventDefault();
        $('.question-mobile').fadeOut();
        $('.more').show();
        $('.no-more').hide();
    });

    $(document).on('click', '.question-toggle', function(e) {
        e.preventDefault();
        $('.question-toggle-content').fadeIn();
        $(this).addClass('in');
    });

    $(document).on('click', '.question-toggle.in', function(e) {
        e.preventDefault();
        $('.question-toggle-content').fadeOut();
        $(this).removeClass('in');
    });
    $(document).on('click', 'button.btn.btn-link', function(event) {
        event.preventDefault();
        if ($(this).closest('.card-header').hasClass('active')) {
            $(this).closest('.card-header').removeClass('active')

            $($('#accordionLanding').find('.card-header.active')).each(function(index, element) {
                $(element).removeClass('active');
            });
            $($('#accordionLandingMovil').find('.card-header.active')).each(function(index, element) {
                $(element).removeClass('active');
            });
        } else {
            $($('#accordionLanding').find('.card-header.active')).each(function(index, element) {
                $(element).removeClass('active');
            });
            $($('#accordionLandingMovil').find('.card-header.active')).each(function(index, element) {
                $(element).removeClass('active');
            });
            $(this).closest('.card-header').addClass('active')

        }
    });
</script>