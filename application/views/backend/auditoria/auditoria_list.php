<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Registros de Actividad</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?php echo base_url('backend/dashboard'); ?>">Inicio</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Registros de Actividad</strong>
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
                                    <label>Usuario</label>
                                    <select name="user_id" class="form-control">
                                        <option value="">Todos</option>
                                        <?php foreach ($users as $user): ?>
                                            <option value="<?php echo $user->id_user; ?>" <?php echo ($filters['user_id'] == $user->id_user) ? 'selected' : ''; ?>>
                                                <?php echo $user->username; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Acción</label>
                                    <select name="action" class="form-control">
                                        <option value="">Todas</option>
                                        <option value="LOGIN" <?php echo ($filters['action'] == 'LOGIN') ? 'selected' : ''; ?>>Inicio de Sesión</option>
                                        <option value="LOGOUT" <?php echo ($filters['action'] == 'LOGOUT') ? 'selected' : ''; ?>>Cierre de Sesión</option>
                                        <option value="CREATE" <?php echo ($filters['action'] == 'CREATE') ? 'selected' : ''; ?>>Crear</option>
                                        <option value="UPDATE" <?php echo ($filters['action'] == 'UPDATE') ? 'selected' : ''; ?>>Actualizar</option>
                                        <option value="DELETE" <?php echo ($filters['action'] == 'DELETE') ? 'selected' : ''; ?>>Eliminar</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Filtrar</button>
                                    <?php if ($permisos_efectivos->export): ?>
                                        <a href="<?php echo base_url('backend/auditoria/export?' . http_build_query($filters)); ?>" class="btn btn-success">
                                            <i class="fa fa-file-excel"></i> Exportar a Excel
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="ibox">
                <div class="ibox-title">
                    <h5>Listado de Actividades</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Usuario</th>
                                    <th>Acción</th>
                                    <th>Descripción</th>
                                    <th>IP</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($logs as $log): ?>
                                    <tr>
                                        <td><?php echo $log->activity_id; ?></td>
                                        <td><?php echo $log->username; ?></td>
                                        <td>
                                            <span class="label <?php 
                                                switch($log->action) {
                                                    case 'LOGIN': echo 'label-primary'; break;
                                                    case 'LOGOUT': echo 'label-default'; break;
                                                    case 'CREATE': echo 'label-success'; break;
                                                    case 'UPDATE': echo 'label-warning'; break;
                                                    case 'DELETE': echo 'label-danger'; break;
                                                    default: echo 'label-info';
                                                }
                                            ?>">
                                                <?php echo $log->action; ?>
                                            </span>
                                        </td>
                                        <td><?php echo $log->description; ?></td>
                                        <td><?php echo $log->ip_address; ?></td>
                                        <td><?php echo date('d/m/Y H:i:s', strtotime($log->created_at)); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
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