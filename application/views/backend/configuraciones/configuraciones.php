<div class="col-lg-12">
    <div class="element-wrapper">
        <h6 class="element-header">Configuraciones del Sistema</h6>
        <div class="element-box">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Valor</th>
                            <th>Descripción</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($configuraciones as $config): ?>
                        <tr>
                            <td>
                                <div class="user-with-avatar">
                                    <i class="fa <?php echo $config->icon; ?>"></i>
                                    <span><?php echo $config->name; ?></span>
                                </div>
                            </td>
                            <td>
                                <?php if($config->input == 'radio'): ?>
                                    <?php echo ($config->value == '1') ? 'Si' : 'No'; ?>
                                <?php else: ?>
                                    <?php echo $config->value; ?>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $config->description; ?></td>
                            <td class="text-right">
                                <a href="<?php echo base_url('backend/configuraciones/edit/'.$config->id_configuration); ?>" 
                                   class="btn btn-primary btn-sm">
                                    <i class="fa fa-edit"></i> Editar
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
