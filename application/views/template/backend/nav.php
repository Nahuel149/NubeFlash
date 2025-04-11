        <!-- START - Mobile Menu -->
        <div class="menu-mobile menu-activated-on-click color-scheme-dark">
          <div class="mm-logo-buttons-w">
            <a class="mm-logo" href="<?php echo base_url('backend/dashboard') ?>"><img src="<?php echo base_url('assets/backend/img/logo.png') ?>"><span>MENSAJERÍA</span></a>
            <div class="mm-buttons">
              <div class="content-panel-open">
                <div class="os-icon os-icon-grid-circles"></div>
              </div>
              <div class="mobile-menu-trigger">
                <div class="os-icon os-icon-hamburger-menu-1"></div>
              </div>
            </div>
          </div>
          <div class="menu-and-user">
            <div class="logged-user-w">
              <div class="avatar-w">
                <?php if (!empty($user_row->image)): ?>
                  <img alt="" src="<?php echo base_url().'uploads/users/'.$user_row->image ?>">
                <?php else: ?>
                  <img alt="" src="<?php echo base_url().'uploads/users/default.jpg' ?>">
                <?php endif ?>
              </div>
              <div class="logged-user-info-w">
                <div class="logged-user-name">
                  <?php echo $user_row->name ?>, <?php echo $user_row->surname ?>
                </div>
                <div class="logged-user-role">
                  <?php echo $user_row->username ?>
                </div>
              </div>
            </div>
            
            <!-- START - Mobile Menu List -->
            <ul class="main-menu">
              <li class="has-sub-menu">
                <a href="#">
                  <div class="icon-w">
                    <div class="os-icon os-icon-users"></div>
                  </div>
                  <span>Gestión de Clientes</span>
                </a>
                <ul class="sub-menu">
                  <li><a href="<?php echo base_url('backend/customers') ?>">Listar Clientes</a></li>
                  <li><a href="<?php echo base_url('backend/customers/add') ?>">Agregar Cliente</a></li>
                  <li><a href="<?php echo base_url('backend/customers/tokens') ?>">Revocar Token</a></li>
                </ul>
              </li>
              
              <li class="has-sub-menu">
                <a href="#">
                  <div class="icon-w">
                    <div class="os-icon os-icon-shopping-cart"></div>
                  </div>
                  <span>Gestión de Pedidos</span>
                </a>
                <ul class="sub-menu">
                  <li><a href="<?php echo base_url('backend/orders') ?>">Listar Pedidos</a></li>
                  <li><a href="<?php echo base_url('backend/orders/status') ?>">Actualizar Estado</a></li>
                </ul>
              </li>
              
              <li class="has-sub-menu">
                <a href="#">
                  <div class="icon-w">
                    <div class="os-icon os-icon-dollar-sign"></div>
                  </div>
                  <span>Gestión de Tarifas</span>
                </a>
                <ul class="sub-menu">
                  <li><a href="<?php echo base_url('backend/tariffs') ?>">Listar Tarifas</a></li>
                  <li><a href="<?php echo base_url('backend/tariffs/add') ?>">Agregar Tarifa</a></li>
                </ul>
              </li>
              
              <li class="has-sub-menu">
                <a href="#">
                  <div class="icon-w">
                    <div class="os-icon os-icon-map-marker"></div>
                  </div>
                  <span>Gestión de Ubicaciones</span>
                </a>
                <ul class="sub-menu">
                  <li><a href="<?php echo base_url('backend/locations/countries') ?>">Países</a></li>
                  <li><a href="<?php echo base_url('backend/locations/provinces') ?>">Provincias</a></li>
                  <li><a href="<?php echo base_url('backend/locations/cities') ?>">Ciudades</a></li>
                </ul>
              </li>
              
              <li class="has-sub-menu">
                <a href="#">
                  <div class="icon-w">
                    <div class="os-icon os-icon-user-shield"></div>
                  </div>
                  <span>Gestión de Usuarios</span>
                </a>
                <ul class="sub-menu">
                  <li><a href="<?php echo base_url('backend/users') ?>">Listar Usuarios</a></li>
                  <li><a href="<?php echo base_url('backend/users/add') ?>">Agregar Usuario</a></li>
                </ul>
              </li>
              
              <li class="has-sub-menu">
                <a href="#">
                  <div class="icon-w">
                    <div class="os-icon os-icon-cogs"></div>
                  </div>
                  <span>Configuración del Sistema</span>
                </a>
                <ul class="sub-menu">
                  <li><a href="<?php echo base_url('backend/settings') ?>">Configuración General</a></li>
                  <li><a href="<?php echo base_url('backend/settings/email') ?>">Configuración de Email</a></li>
                </ul>
              </li>
              
              <li class="has-sub-menu">
                <a href="#">
                  <div class="icon-w">
                    <div class="os-icon os-icon-lock"></div>
                  </div>
                  <span>Autenticación</span>
                </a>
                <ul class="sub-menu">
                  <li><a href="<?php echo base_url('backend/auth/login') ?>">Iniciar Sesión</a></li>
                  <li><a href="<?php echo base_url('backend/auth/logout') ?>">Cerrar Sesión</a></li>
                </ul>
              </li>
              
              <li class="has-sub-menu">
                <a href="#">
                  <div class="icon-w">
                    <div class="os-icon os-icon-tools"></div>
                  </div>
                  <span>Otras Utilidades</span>
                </a>
                <ul class="sub-menu">
                  <li><a href="<?php echo base_url('backend/utilities/logs') ?>">Registros del Sistema</a></li>
                  <li><a href="<?php echo base_url('backend/utilities/backup') ?>">Respaldo del Sistema</a></li>
                </ul>
              </li>
            </ul>
            <!-- END - Mobile Menu List -->
          </div>
        </div>
        <!-- END - Mobile Menu -->

        <div class="desktop-menu menu-top-image-w menu-activated-on-hover">
          <div class="top-part-w">
            <div class="logo-w">
              <a class="logo" href="<?php echo base_url('backend/dashboard') ?>"><img src="<?php echo base_url('assets/public/logo_analisis_del_sur.png') ?>"><span>Dashboard</span></a>
            </div>
            <!--
            <div class="user-and-search">
              <div class="logged-user-w">
                <div class="avatar-w">
                  <?php if (!empty($user_row->image)): ?>
                  <img alt="" src="<?php echo base_url().'uploads/users/'.$user_row->image ?>">
                  <?php else: ?>
                    <img alt="" src="<?php echo base_url().'uploads/users/default.jpg' ?>">
                  <?php endif ?>
                </div>
              </div>
            </div>
            -->
          </div>
          <h2 class="page-menu-header">
            <?php echo $title ?>
          </h2>
        </div>
        <!--START - Menu side compact -->