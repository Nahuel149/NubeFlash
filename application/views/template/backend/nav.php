        <!-- START - Mobile Menu -->
        <div class="menu-mobile menu-activated-on-click color-scheme-dark">
          <div class="mm-logo-buttons-w">
            <a class="mm-logo" href="#"><img src="<?php echo base_url('assets/backend/img/logo.png') ?>"><span>MENSAJERÍA</span></a>
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
              <?php $this->backend_lib->getMenu($user_row->id_user, true); ?>
            </ul>
            <!-- END - Mobile Menu List -->
          </div>
        </div>
        <!-- END - Mobile Menu -->
        <div class="desktop-menu menu-top-image-w menu-activated-on-hover" style="background: url('<?php echo base_url('assets/backend/img/bg_panle_nube.jpg') ?>');background-size: cover; background-position: center 500px;">
          <div class="top-part-w">
            <div class="logo-w">
              <a class="logo" href="<?php echo base_url('backend/dashboard') ?>"><img src="<?php echo base_url('assets/public/logo_analisis_del_sur.png') ?>"><span>Dashboard</span></a>
            </div>
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
          </div>
          <h2 class="page-menu-header">
            <?php echo $title ?>
          </h2>
        </div>
        <!--START - Menu side compact -->