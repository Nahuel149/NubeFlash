<!DOCTYPE html>
<html>
<head>
    <title>System Auto-Fix Results</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .fix-item { margin: 5px 0; padding: 10px; background: #f0f0f0; border-left: 4px solid #4CAF50; }
        .actions { margin-top: 20px; }
        .actions button { padding: 5px 10px; margin-right: 5px; }
    </style>
</head>
<body>
    <h1>Auto-Fix Results</h1>
    
    <?php if (empty($fixes)): ?>
        <div class="fix-item">
            No issues were found that required fixing.
        </div>
    <?php else: ?>
        <?php foreach ($fixes as $fix): ?>
            <div class="fix-item">
                <?php echo $fix; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="actions">
        <button onclick="window.location='<?php echo site_url('debug'); ?>'">Run Diagnostics Again</button>
        <button onclick="window.location='<?php echo site_url(); ?>'">Return to Homepage</button>
    </div>
</body>
</html> 