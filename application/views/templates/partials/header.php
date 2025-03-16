<?php
$user = $this->ion_auth->user()->row();
?>
<div class="admin-header-content">
    <div class="admin-header-left">
        <h1 class="admin-page-title"><?php echo isset($title) ? $title : 'Dashboard'; ?></h1>
        <?php if(isset($breadcrumbs)): ?>
            <div class="admin-breadcrumbs">
                <?php echo $breadcrumbs; ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="admin-header-right">
        <!-- Notifications -->
        <div class="admin-notifications">
            <a href="#" class="admin-notifications-toggle">
                <i class="fas fa-bell"></i>
                <?php if(isset($notification_count) && $notification_count > 0): ?>
                    <span class="admin-notifications-badge"><?php echo $notification_count; ?></span>
                <?php endif; ?>
            </a>
            <div class="admin-notifications-dropdown">
                <?php if(isset($notifications) && !empty($notifications)): ?>
                    <?php foreach($notifications as $notification): ?>
                        <a href="<?php echo $notification['url']; ?>" class="admin-notification-item">
                            <div class="admin-notification-icon">
                                <i class="<?php echo $notification['icon']; ?>"></i>
                            </div>
                            <div class="admin-notification-content">
                                <div class="admin-notification-title"><?php echo $notification['title']; ?></div>
                                <div class="admin-notification-time"><?php echo $notification['time']; ?></div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="admin-notification-empty">No new notifications</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- User Menu -->
        <div class="admin-user-menu">
            <div class="admin-user-info">
                <?php if($user->avatar && file_exists(FCPATH . 'assets/backend/images/avatars/' . $user->avatar)): ?>
                    <img src="<?php echo base_url('assets/backend/images/avatars/' . $user->avatar); ?>" alt="User Avatar" class="admin-user-avatar">
                <?php else: ?>
                    <img src="<?php echo base_url('assets/backend/images/default-avatar.png'); ?>" alt="Default Avatar" class="admin-user-avatar">
                <?php endif; ?>
                <span class="admin-user-name"><?php echo $user->username; ?></span>
            </div>
            <div class="admin-user-dropdown">
                <a href="<?php echo base_url('backend/users/profile'); ?>" class="admin-dropdown-item">
                    <i class="fas fa-user"></i> My Profile
                </a>
                <a href="<?php echo base_url('backend/users/account'); ?>" class="admin-dropdown-item">
                    <i class="fas fa-cog"></i> Account Settings
                </a>
                <div class="admin-dropdown-divider"></div>
                <a href="<?php echo base_url('backend/auth/logout'); ?>" class="admin-dropdown-item">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>
</div> 