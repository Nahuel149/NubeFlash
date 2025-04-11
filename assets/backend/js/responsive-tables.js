// Responsive Tables JavaScript
$(document).ready(function() {
    // Function to wrap tables that aren't already in table-responsive
    function makeTablesResponsive() {
        // Check viewport width
        if ($(window).width() <= 1200) {
            // Find tables that are not already wrapped in .table-responsive
            $('.content-box table.table, .element-box table.table').each(function() {
                var $table = $(this);
                
                // Only if not already wrapped
                if (!$table.parent().hasClass('table-responsive')) {
                    // Wrap it in a table-responsive div
                    $table.wrap('<div class="table-responsive"></div>');
                }
            });
        }
    }
    
    // Run on page load
    makeTablesResponsive();
    
    // Also run on window resize
    $(window).resize(function() {
        makeTablesResponsive();
    });
}); 