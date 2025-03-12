<?php if (!empty($accesos)): ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Acción</th>
                    <th>Descripción</th>
                    <th>IP</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($accesos as $acceso): ?>
                    <tr>
                        <td><?php echo date('d/m/Y H:i:s', strtotime($acceso->created_at)); ?></td>
                        <td><?php echo $acceso->action; ?></td>
                        <td><?php echo $acceso->description; ?></td>
                        <td><?php echo $acceso->ip_address; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> No hay registros de acceso recientes.
    </div>
<?php endif; ?>
