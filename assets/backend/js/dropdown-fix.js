// Dropdown Menu Fix for Responsive Views
$(document).ready(function() {
    // Add a click handler for the user menu toggle only (not the menu items)
    $('.logged-user-i').on('click', function(e) {
        // Get viewport width
        var viewportWidth = $(window).width();
        
        // Only apply special handling for smaller screens
        if (viewportWidth <= 1023) {
            // Check if the click was on a menu link or its children - if so, let it proceed
            if ($(e.target).closest('.logged-user-menu ul li a').length) {
                return true; // Allow the click to proceed normally
            }
            
            // Otherwise prevent default for toggle functionality
            e.preventDefault();
            e.stopPropagation();
            
            // Toggle visibility of dropdown menu
            var $menu = $(this).find('.logged-user-menu');
            
            if ($menu.hasClass('visible')) {
                $menu.removeClass('visible');
                $menu.css({
                    'visibility': 'hidden',
                    'opacity': '0',
                    'transform': 'translateY(20px)'
                });
            } else {
                // Close any other open menus
                $('.logged-user-menu').removeClass('visible').css({
                    'visibility': 'hidden',
                    'opacity': '0',
                    'transform': 'translateY(20px)'
                });
                
                // Open this menu
                $menu.addClass('visible');
                $menu.css({
                    'visibility': 'visible',
                    'opacity': '1',
                    'transform': 'translateY(0)'
                });
                
                // Position the menu correctly
                var buttonPos = $(this).offset();
                var menuHeight = $menu.outerHeight();
                var menuWidth = $menu.outerWidth();
                var windowHeight = $(window).height();
                var windowWidth = $(window).width();
                
                // Default position below the button
                var topPos = buttonPos.top + $(this).outerHeight();
                
                // Check if menu would go below viewport
                if (topPos + menuHeight > windowHeight) {
                    // Position above the button
                    topPos = buttonPos.top - menuHeight;
                }
                
                // Make sure menu stays within right edge of screen
                var rightPos = Math.min(buttonPos.left + menuWidth, windowWidth - 10);
                var leftPos = Math.max(rightPos - menuWidth, 10);
                
                $menu.css({
                    'top': topPos + 'px',
                    'left': leftPos + 'px'
                });
            }
        }
    });
    
    // Handle clicks specifically on menu links to ensure they work
    $('.logged-user-menu ul li a').on('click', function(e) {
        // Allow the default link behavior to work
        return true;
    });
    
    // Close menu when clicking outside
    $(document).on('click', function(e) {
        if ($(window).width() <= 1023) {
            if (!$(e.target).closest('.logged-user-i').length) {
                $('.logged-user-menu').removeClass('visible').css({
                    'visibility': 'hidden',
                    'opacity': '0',
                    'transform': 'translateY(20px)'
                });
            }
        }
    });
    
    // Reposition menu on window resize
    $(window).resize(function() {
        if ($(window).width() > 1023) {
            // Reset custom positioning for larger screens
            $('.logged-user-menu').css({
                'top': '',
                'left': '',
                'visibility': '',
                'opacity': '',
                'transform': ''
            }).removeClass('visible');
        }
    });
}); 