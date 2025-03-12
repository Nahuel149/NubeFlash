// Dashboard AJAX functionality
$(document).ready(function() {
    // Load direct access menu
    function loadDirectAccess() {
        $.ajax({
            url: BASE_URL + 'backend/dashboard/accesos_directos',
            type: 'GET',
            success: function(response) {
                $('#dashboard_accesos_directos').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Error loading direct access:', error);
                $('#dashboard_accesos_directos').html('<div class="alert alert-danger">Error loading direct access menu</div>');
            }
        });
    }

    // Load recent access logs
    function loadRecentAccess() {
        $.ajax({
            url: BASE_URL + 'backend/dashboard/ultimos_accesos',
            type: 'GET',
            success: function(response) {
                $('#dashboard_ultimos_accesos').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Error loading recent access:', error);
                $('#dashboard_ultimos_accesos').html('<div class="alert alert-danger">Error loading recent access</div>');
            }
        });
    }

    // Initial load
    loadDirectAccess();
    loadRecentAccess();

    // Refresh every 5 minutes
    setInterval(function() {
        loadRecentAccess();
    }, 300000); // 5 minutes in milliseconds
}); 