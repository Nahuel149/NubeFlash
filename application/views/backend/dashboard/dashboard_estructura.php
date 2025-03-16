<!-- Dashboard Structure -->
<style>
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: 1px solid rgba(0,0,0,0.125);
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .nav-tabs .nav-link {
        color: #495057;
    }
    .nav-tabs .nav-link.active {
        color: #007bff;
        border-bottom: 2px solid #007bff;
    }
    .tab-content {
        padding-top: 2rem;
    }
    .card-body i {
        color: #007bff;
    }
    .card-title {
        color: #495057;
        margin-bottom: 0;
        font-size: 1rem;
    }
</style>

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-8">
            <div class="element-box">
                <div class="ibox-content">
                    <div id="dashboard_accesos_directos">
                        <div class="text-center p-3">
                            <i class="fa fa-spinner fa-spin fa-2x"></i>
                            <p>Loading direct access menu...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="element-box">
                <div class="ibox-title">
                    <h5>Mis ultimos accesos</h5>
                </div>
                <div class="ibox-content">
                    <div id="dashboard_ultimos_accesos">
                        <div class="text-center p-3">
                            <i class="fa fa-spinner fa-spin fa-2x"></i>
                            <p>Loading recent access...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include dashboard specific JavaScript -->
<script src="<?php echo base_url('assets/backend/js/dashboard.js'); ?>"></script>