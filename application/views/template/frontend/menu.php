<nav class="navbar navbar-expand-lg navbar-light navbar-fondo" role="navigation">
    <div class="container-fluid">
        <a class="logo-img" href="<?php echo(base_url('index')); ?>">
            <img class="img-fluid" src="<?php echo base_url('assets/public/logo_nube.png') ?>" alt="LaNube" style="max-height: 75px;">
        </a>
      <span class="navbar-brand d-block d-sm-block d-md-block d-lg-none d-xl-none">&nbsp;</span>
     
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav order-1 list-left">
          <li <?php if($this->uri->segment(1) == '#') echo 'class="active"'; ?>>
            <a id="button_enterprise" class="nav-link" href="<?php echo $this->uri->segment(1) == 'index' ? '#section_aboutus':base_url('index#section_aboutus') ?>">Empresa</a>
          </li>
          <li <?php if($this->uri->segment(1) == '#' || $this->uri->segment(1) == '#') echo 'class="active"'; ?>>
            <a id="button_service" class="nav-link" href="<?php echo $this->uri->segment(1) == 'inicio' ? '#section_service':base_url('index#section_service') ?>">servicios</a>
          </li>
          <li <?php if($this->uri->segment(1) == '#' || $this->uri->segment(1) == '#') echo 'class="active"'; ?>>
            <a id="button_prices" class="nav-link" href="<?php echo $this->uri->segment(1) == 'inicio' ? '#section_price':base_url('index#section_price') ?>">precios</a>
          </li>
          <li <?php if($this->uri->segment(1) == '#') echo 'class="active"'; ?>>
            <a id="button_location" class="nav-link" href="<?php echo $this->uri->segment(1) == 'index' ? '#section_location':base_url('index#section_location') ?>">ubicación</a>
          </li>
          <li <?php if($this->uri->segment(1) == '#' || $this->uri->segment(1) == '#') echo 'class="active"'; ?>>
            <a id="button_delivery" class="nav-link" href="<?php echo $this->uri->segment(1) == 'inicio' ? '#section_delivery_time':base_url('index#section_delivery_time') ?>">entregas</a>
          </li>
          <li <?php if($this->uri->segment(1) == '#' || $this->uri->segment(1) == '#') echo 'class="active"'; ?>>
            <a id="button_faqs" class="nav-link" href="<?php echo $this->uri->segment(1) == 'inicio' ? '#section_faqs':base_url('index#section_faqs') ?>">faqs</a>
          </li>
          <li <?php if($this->uri->segment(1) == '#' || $this->uri->segment(1) == '#') echo 'class="active"'; ?>>
            <a id="button_contact" class="nav-link" href="<?php echo $this->uri->segment(1) == 'inicio' ? '#section_contacto':base_url('index#section_contacto') ?>">contacto</a>
          </li>
          <li <?php if($this->uri->segment(1) == '#' || $this->uri->segment(1) == '#') echo 'class="active"'; ?>>
            <a class="nav-link" href="<?php echo base_url('apis-documentacion') ?>">APIDocs</a>
          </li>
          <!-- Login/Register button for mobile -->
          <li class="d-block d-lg-none mt-2">
          <?php if($this->session->userdata('customer_id')){ ?>
            <div class="d-flex flex-column">
              <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-primary rounded-pill mb-2"><?php echo $this->session->userdata('name'); ?></a>
              <a href="<?php echo base_url('logout'); ?>" class="btn btn-danger rounded-pill">Log out</a>
            </div>
          <?php }else{ ?>
            <div class="">
              <button data-target="#modalLogin" data-toggle="modal" class="btn btn-primary btn-login rounded-pill">LOGIN&nbsp;/&nbsp;REGISTRATE</button>
            </div>
          <?php } ?>
          </li>
        </ul>
      </div>
      <div class="autentication d-none d-lg-flex align-items-center mr-2">
        <?php if($this->session->userdata('customer_id')){ ?>
          <div class="">
            <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-primary rounded-pill"><?php echo $this->session->userdata('name'); ?></a>
          </div>
          <div class="pl-2">
            <a href="<?php echo base_url('logout'); ?>" class="btn btn-danger rounded-pill">Log out</a>
          </div>
        <?php }else{ ?>
          <div class="">
            <button data-target="#modalLogin" data-toggle="modal" class="btn btn-primary btn-login rounded-pill">LOGIN&nbsp;/&nbsp;REGISTRATE</button>
          </div>
        <?php } ?>
      </div>
    </div>
   
  </nav>

