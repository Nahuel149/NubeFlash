<div class="accordion" id="accordion">
  <div class="card">
    <div class="col-md-12 text-center pt-2">
      <div class="menu-left">
        <a class="logo-lanube" href="<?php echo(base_url('dashboard')); ?>">
          <img class="img-fluid" src="<?php echo(base_url('assets/public/logo_nube.png')); ?>" alt="La nube">
        </a>
      </div>
    </div>
    <p></p>
  </div>
  <div class="card">
    <div class="card-header <?php echo($this->uri->segment(1) == 'dashboard' ? 'active':''); ?>">
      <a class="card-link text-menu" href="<?php echo(base_url('dashboard')); ?>">
        <img src="<?php echo(base_url('assets/public/dashboard/icons/color/174-star.png')); ?>" class="tam-icon icon-plan"/>&nbsp;&nbsp; Dashboard
      </a>
    </div>
  </div>
  <div class="card">
    <div class="card-header <?php echo($this->uri->segment(1) == 'mi-perfil' ? 'active':''); ?>">
      <a class="card-link text-menu" href="<?php echo(base_url('mi-perfil')); ?>">
        <img src="<?php echo(base_url('assets/public/dashboard/icons/color/099-medal.png')); ?>" class="tam-icon icon-perfil"/>&nbsp;&nbsp; Perfil
      </a>
    </div>
  </div>
  <div class="card">
    <div class="card-header <?php echo($this->uri->segment(1) == 'mis-pedidos' ? 'active':''); ?>">
      <a class="card-link text-menu" href="<?php echo(base_url('mis-pedidos')); ?>">
        <img src="<?php echo(base_url('assets/public/dashboard/icons/color/073-dollar-symbol-2.png')); ?>" class="tam-icon icon-venta"/>&nbsp;&nbsp; Pedidos
      </a>
    </div>
  </div>
  <div class="card">
    <div class="card-header <?php echo($this->uri->segment(1) == 'mi-token' ? 'active':''); ?>">
      <a class="card-link text-menu" href="<?php echo(base_url('mi-token')); ?>">
        <img src="<?php echo(base_url('assets/public/dashboard/icons/color/confi.png')); ?>" class="tam-icon icon-config"/>&nbsp;&nbsp; Token
      </a>
    </div>
  </div>
</div>
