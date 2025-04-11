// Menu Interactions for Responsive Behavior
$(document).ready(function() {
    // Initialize submenus - hide all except active ones
    $('.menu-mobile .main-menu > li.has-sub-menu:not(.active) .sub-menu').hide();
    
    // Toggle mobile menu (for mobile devices < 768px)
    $('.mobile-menu-trigger').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var $menuMobile = $('.menu-mobile');
        if ($menuMobile.hasClass('menu-active')) {
            $menuMobile.removeClass('menu-active');
        } else {
            $menuMobile.addClass('menu-active');
        }
    });

    // Submenu toggle functionality
    $('.menu-mobile .main-menu > li.has-sub-menu > a').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var $parent = $(this).parent();
        
        if ($parent.hasClass('active')) {
            // Close this submenu
            $parent.removeClass('active');
            $parent.find('.sub-menu').slideUp(200);
        } else {
            // Close other submenus at the same level
            $('.menu-mobile .main-menu > li.has-sub-menu.active').removeClass('active');
            $('.menu-mobile .main-menu > li.has-sub-menu .sub-menu').slideUp(200);
            
            // Open this submenu
            $parent.addClass('active');
            $parent.find('.sub-menu').slideDown(200);
        }
    });

    // Adjust menu functionality based on screen width
    function adjustMenuForScreenSize() {
        var windowWidth = $(window).width();
        
        if (windowWidth >= 1024) {
            // Desktop view
            $('.menu-mobile').removeClass('menu-active');
            
            // On desktop, keep original menu behavior
            // If there's an existing menu toggle, it might still work
        } 
        else if (windowWidth >= 768 && windowWidth < 1024) {
            // Tablet view - Show main menu items with dropdown functionality
            $('.menu-mobile').removeClass('menu-active');
            
            // Ensure proper submenu behavior
            $('.menu-mobile .main-menu > li.has-sub-menu:not(.active) .sub-menu').hide();
        } 
        else {
            // Mobile view - Menu is controlled by hamburger button
            
            // Keep submenus hidden by default unless they're active
            $('.menu-mobile .main-menu > li.has-sub-menu:not(.active) .sub-menu').hide();
        }
    }

    // Handle clicks outside the menu to close it on mobile
    $(document).on('click', function(e) {
        if ($(window).width() < 768) {
            if (!$(e.target).closest('.menu-mobile').length && !$(e.target).closest('.mobile-menu-trigger').length) {
                $('.menu-mobile').removeClass('menu-active');
            }
        }
    });

    // Run on page load
    adjustMenuForScreenSize();
    
    // Run on window resize
    $(window).on('resize', function() {
        adjustMenuForScreenSize();
    });
}); 