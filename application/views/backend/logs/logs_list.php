<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Registros del Sistema</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?php echo base_url('backend/dashboard'); ?>">Inicio</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Registros del Sistema</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Filtros de Búsqueda</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form method="post" action="<?php echo current_url(); ?>">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Desde</label>
                                    <input type="date" name="date_from" class="form-control" value="<?php echo $filters['date_from']; ?>">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Hasta</label>
                                    <input type="date" name="date_to" class="form-control" value="<?php echo $filters['date_to']; ?>">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Tipo de Registro</label>
                                    <select name="log_type" class="form-control">
                                        <option value="activity_logs" <?php echo ($filters['log_type'] == 'activity_logs') ? 'selected' : ''; ?>>
                                            Registros de Actividad
                                        </option>
                                        <option value="login_attempts" <?php echo ($filters['log_type'] == 'login_attempts') ? 'selected' : ''; ?>>
                                            Intentos de Inicio de Sesión
                                        </option>
                                        <option value="login_errors" <?php echo ($filters['log_type'] == 'login_errors') ? 'selected' : ''; ?>>
                                            Errores de Inicio de Sesión
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-search"></i> Filtrar
                                        </button>
                                        <?php if ($permisos_efectivos->export): ?>
                                            <a href="<?php echo base_url('backend/logs/export?' . http_build_query($filters)); ?>" class="btn btn-success">
                                                <i class="fa fa-file-excel"></i> Exportar a Excel
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="ibox">
                <div class="ibox-title">
                    <h5>
                        <?php echo ($filters['log_type'] == 'login_attempts') ? 'Intentos de Inicio de Sesión' : ($filters['log_type'] == 'login_errors') ? 'Errores de Inicio de Sesión' : 'Registros de Actividad'; ?>
                    </h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <?php if ($filters['log_type'] == 'activity_logs'): ?>
                            <table class="table table-striped table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Acción</th>
                                        <th>Descripción</th>
                                        <th>IP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($activity_logs as $log): ?>
                                        <tr>
                                            <td><?php echo date('d/m/Y H:i:s', strtotime($log->created_at)); ?></td>
                                            <td><?php echo $log->action; ?></td>
                                            <td><?php echo $log->description; ?></td>
                                            <td><?php echo $log->ip_address; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php elseif ($filters['log_type'] == 'login_attempts'): ?>
                            <table class="table table-striped table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>IP</th>
                                        <th>Usuario</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($login_attempts as $log): ?>
                                        <tr>
                                            <td><?php echo $log->id; ?></td>
                                            <td><?php echo $log->ip_address; ?></td>
                                            <td><?php echo $log->login; ?></td>
                                            <td><?php echo date('d/m/Y H:i:s', $log->time); ?></td>
                                            <td>
                                                <span class="label <?php echo $log->active ? 'label-primary' : 'label-danger'; ?>">
                                                    <?php echo $log->active ? 'Activo' : 'Inactivo'; ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <table class="table table-striped table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Usuario</th>
                                        <th>IP</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($login_errors as $log): ?>
                                        <tr>
                                            <td><?php echo $log->id_login; ?></td>
                                            <td><?php echo $log->user; ?></td>
                                            <td><?php echo $log->ip_address; ?></td>
                                            <td><?php echo $log->date; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.dataTables-example').DataTable({
        pageLength: 25,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            {extend: 'copy'},
            {extend: 'csv'},
            {extend: 'print',
             customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');
                    $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
            }
            }
        ]
    });
});
</script> 