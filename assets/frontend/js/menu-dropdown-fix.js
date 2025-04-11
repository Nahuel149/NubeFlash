// Enhance dropdown menu behavior
$(document).ready(function() {
    // Close hamburger dropdown when clicking outside
    $(document).on('click', function(e) {
        // If the click is outside the navbar and the menu is open
        if (
            !$(e.target).closest('#navbarNav').length && 
            !$(e.target).closest('.navbar-toggler').length && 
            $('#navbarNav').hasClass('show')
        ) {
            // Toggle the navbar
            $('.navbar-toggler').click();
        }
        
        // If the click is outside the user dropdown and the dropdown is open
        if (
            !$(e.target).closest('.custom-dropdown').length && 
            !$(e.target).closest('.dropdown-toggle').length && 
            $('.custom-dropdown').hasClass('show')
        ) {
            // Close the dropdown manually
            $('.custom-dropdown').removeClass('show');
        }
    });

    // Add smooth transition for the hamburger dropdown
    $('.navbar-toggler').on('click', function() {
        // When toggling, make sure menu is properly positioned
        setTimeout(function() {
            if ($('#navbarNav').hasClass('show')) {
                $('#navbarNav').css('transform', 'translateY(0)');
                $('#navbarNav').css('opacity', '1');
            } else {
                $('#navbarNav').css('transform', 'translateY(-10px)');
                $('#navbarNav').css('opacity', '0');
            }
        }, 10);
    });
    
    // Custom behavior for the user dropdown
    $('.dropdown-toggle').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var $dropdownMenu = $(this).next('.custom-dropdown');
        
        // Toggle show class
        if ($dropdownMenu.hasClass('show')) {
            $dropdownMenu.removeClass('show');
        } else {
            // Close any other open dropdowns first
            $('.custom-dropdown.show').removeClass('show');
            
            // Show this dropdown
            $dropdownMenu.addClass('show');
        }
    });
    
    // Ensure dropdown items work properly
    $('.custom-dropdown .dropdown-item').on('click', function(e) {
        if ($(this).attr('id') === 'cambiarPassBtn') {
            // Let the default handler work
            return true;
        }
        
        // For regular links, follow the href
        var href = $(this).attr('href');
        if (href && href !== '#') {
            window.location.href = href;
        }
    });
}); 