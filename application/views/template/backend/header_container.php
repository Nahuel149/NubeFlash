
          <div class="top-menu-secondary">
            <ul>
              <li class="active">
                <a href="<?php echo current_url() ?>"><?php echo $title; ?></a>
              </li>
            </ul>
            <div class="top-menu-controls">
              <a class="messages-notifications os-dropdown-trigger os-dropdown-center" href="<?php echo base_url() ?>" target="_blank">
                <span style="font-size: 14px;vertical-align: 2px;">Previsualizar</span>
              </a>
              <!-- START - Settings Link in secondary top menu -->

              <div class="logged-user-w">
                <div class="logged-user-i">
                  <div class="avatar-w">
                    <?php if (!empty($user_row->image)): ?>
                      <img alt="" src="<?php echo base_url().'uploads/users/'.$user_row->image ?>">
                    <?php else: ?>
                      <img alt="" src="<?php echo base_url().'uploads/users/default.jpg' ?>">
                    <?php endif ?>
                  </div>
                  <div class="logged-user-menu">
                    <div class="logged-user-avatar-info">
                      <div class="avatar-w">
                        <?php if (!empty($user_row->avatar)): ?>
                          <img alt="" src="<?php echo base_url().'uploads/users/'.$user_row->avatar ?>">
                        <?php else: ?>
                          <img alt="" src="<?php echo base_url().'uploads/users/default.jpg' ?>">
                        <?php endif ?>
                      </div>
                      <div class="logged-user-info-w">
                        <div class="logged-user-name">
                         <?php echo $user_row->name?>, <?php echo $user_row->surname?> &nbsp;&nbsp;&nbsp;
                        </div>
                        <div class="logged-user-role">
                          <?php echo $user_row->username ?>
                        </div>
                      </div>
                    </div>
                    <div class="bg-icon">
                      <i class="os-icon os-icon-wallet-loaded"></i>
                    </div>
                    <ul>
                      <li>
                        <a href="<?php echo base_url().'backend/dashboard/micuenta' ?>"><i class="os-icon os-icon-ui-49"></i><span>Mi cuenta</span></a>
                      </li>
                      <li>
                        <a href="<?php echo site_url( "backend/auth/change_password" ) ?>"><i class="os-icon os-icon-mail-01"></i><span>Cambiar contraseña</span></a>
                      </li>
                      <li>
                        <a href="<?php echo site_url( "backend/auth/logout" ) ?>"><i class="os-icon os-icon-signs-11"></i><span>Logout</span></a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          