<?php
$current_url = $this->uri->segment(2);

$menu_items = array(
    'dashboard' => array(
        'icon' => 'fas fa-tachometer-alt',
        'text' => 'Dashboard',
        'url' => 'backend/dashboard',
        'permission' => 'view_dashboard'
    ),
    'users' => array(
        'icon' => 'fas fa-users',
        'text' => 'Users',
        'url' => 'backend/users',
        'permission' => 'view_users'
    ),
    'groups' => array(
        'icon' => 'fas fa-user-tag',
        'text' => 'Groups',
        'url' => 'backend/groups',
        'permission' => 'view_groups'
    ),
    'customers' => array(
        'icon' => 'fas fa-user-friends',
        'text' => 'Customers',
        'url' => 'backend/customers',
        'permission' => 'view_customers'
    ),
    'orders' => array(
        'icon' => 'fas fa-shopping-cart',
        'text' => 'Orders',
        'url' => 'backend/orders',
        'permission' => 'view_orders'
    ),
    'settings' => array(
        'icon' => 'fas fa-cog',
        'text' => 'Settings',
        'url' => 'backend/settings',
        'permission' => 'view_settings',
        'submenu' => array(
            'general' => array(
                'text' => 'General Settings',
                'url' => 'backend/settings/general',
                'permission' => 'view_general_settings'
            ),
            'email' => array(
                'text' => 'Email Settings',
                'url' => 'backend/settings/email',
                'permission' => 'view_email_settings'
            ),
            'shipping' => array(
                'text' => 'Shipping Settings',
                'url' => 'backend/settings/shipping',
                'permission' => 'view_shipping_settings'
            )
        )
    )
);

foreach ($menu_items as $key => $item): 
    // Skip menu items user doesn't have permission to see
    if (isset($item['permission']) && !$this->ion_auth->has_permission($item['permission'])) continue;
    
    $active = ($current_url == $key) ? ' active' : '';
?>
    <div class="admin-nav-item-wrapper">
        <a href="<?php echo base_url($item['url']); ?>" class="admin-nav-item<?php echo $active; ?>">
            <i class="<?php echo $item['icon']; ?>"></i>
            <span><?php echo $item['text']; ?></span>
            <?php if(isset($item['submenu'])): ?>
                <i class="fas fa-chevron-down submenu-indicator"></i>
            <?php endif; ?>
        </a>
        
        <?php if(isset($item['submenu'])): ?>
            <div class="admin-nav-submenu<?php echo $active ? ' show' : ''; ?>">
                <?php foreach($item['submenu'] as $sub_key => $sub_item): ?>
                    <?php if (!isset($sub_item['permission']) || $this->ion_auth->has_permission($sub_item['permission'])): ?>
                        <a href="<?php echo base_url($sub_item['url']); ?>" class="admin-nav-submenu-item">
                            <span><?php echo $sub_item['text']; ?></span>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
<?php endforeach; ?> 