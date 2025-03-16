<!DOCTYPE html>
<html>
<head>
    <title>System Diagnostics</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px;
            background: #f5f5f5;
        }
        .section { 
            margin-bottom: 20px; 
            padding: 15px; 
            border: 1px solid #ddd;
            border-radius: 4px;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .section h2 { 
            margin-top: 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .section h2:after {
            content: '▼';
            font-size: 12px;
            transition: transform 0.3s;
        }
        .section.collapsed h2:after {
            transform: rotate(-90deg);
        }
        .status-ok { 
            color: #4CAF50;
            font-weight: bold;
        }
        .status-warning { 
            color: #FF9800;
            font-weight: bold;
        }
        .status-error { 
            color: #F44336;
            font-weight: bold;
        }
        .detail-item { 
            margin: 5px 0; 
            padding: 8px; 
            background: #f9f9f9;
            border-left: 3px solid #ddd;
        }
        .detail-item.error {
            border-left-color: #F44336;
            background: #FFEBEE;
        }
        .detail-item.warning {
            border-left-color: #FF9800;
            background: #FFF3E0;
        }
        .detail-item.success {
            border-left-color: #4CAF50;
            background: #E8F5E9;
        }
        .debug-actions { 
            margin-top: 20px;
            text-align: center;
        }
        .debug-actions button { 
            padding: 10px 20px;
            margin: 0 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }
        .debug-actions button:hover {
            opacity: 0.9;
        }
        .run-again {
            background: #2196F3;
            color: white;
        }
        .auto-fix {
            background: #4CAF50;
            color: white;
        }
        .summary {
            margin-bottom: 20px;
            padding: 15px;
            background: white;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .timestamp {
            color: #666;
            font-size: 12px;
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>System Diagnostics Results</h1>

    <div class="summary">
        <?php
        $total_errors = 0;
        $total_warnings = 0;
        foreach ($results as $data) {
            if ($data['status'] === 'error') $total_errors++;
            if ($data['status'] === 'warning') $total_warnings++;
        }
        ?>
        <strong>Summary:</strong>
        <span class="status-<?php echo $total_errors ? 'error' : ($total_warnings ? 'warning' : 'ok'); ?>">
            <?php echo $total_errors ? "{$total_errors} errors" : ($total_warnings ? "{$total_warnings} warnings" : "All checks passed"); ?>
        </span>
    </div>
    
    <?php foreach ($results as $section => $data): ?>
    <div class="section <?php echo $data['status'] === 'ok' ? 'collapsed' : ''; ?>">
        <h2 onclick="toggleSection(this)"><?php echo ucfirst($section); ?> Check</h2>
        <div class="status-<?php echo $data['status']; ?>">
            Status: <?php echo strtoupper($data['status']); ?>
        </div>
        <div class="details" <?php echo $data['status'] === 'ok' ? 'style="display:none;"' : ''; ?>>
            <?php foreach ($data['details'] as $detail): ?>
            <div class="detail-item <?php 
                echo strpos(strtolower($detail), 'missing') !== false || strpos(strtolower($detail), 'failed') !== false ? 'error' : 
                    (strpos(strtolower($detail), 'warning') !== false ? 'warning' : 'success'); 
            ?>">
                <?php echo $detail; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>

    <div class="debug-actions">
        <button class="run-again" onclick="window.location.reload()">Run Diagnostics Again</button>
        <button class="auto-fix" onclick="window.location='<?php echo site_url('debug/fix_all'); ?>'">Attempt Auto-Fix</button>
    </div>

    <div class="timestamp">
        Last check: <?php echo date('Y-m-d H:i:s'); ?>
    </div>

    <script>
        function toggleSection(header) {
            const section = header.parentElement;
            const details = section.querySelector('.details');
            section.classList.toggle('collapsed');
            details.style.display = details.style.display === 'none' ? 'block' : 'none';
        }

        // Auto-expand sections with errors or warnings
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('.section');
            sections.forEach(section => {
                const status = section.querySelector('[class^="status-"]').textContent;
                if (status.includes('ERROR') || status.includes('WARNING')) {
                    const details = section.querySelector('.details');
                    section.classList.remove('collapsed');
                    details.style.display = 'block';
                }
            });
        });
    </script>
</body>
</html> 