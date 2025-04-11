// Fix menu links in dropdown
$(document).ready(function() {
    // Special handling for menu links in the dropdown
    $('.logged-user-menu ul li a').on('click', function(e) {
        // Store the href
        var href = $(this).attr('href');
        
        // If we're on a small screen, do special handling
        if ($(window).width() <= 1023) {
            // Prevent the parent handlers from capturing this event
            e.stopPropagation();
            
            // Navigate to the link
            window.location.href = href;
            
            return false; // Prevent default to use our custom navigation
        }
        
        // Otherwise, let the default link behavior work
        return true;
    });
}); 