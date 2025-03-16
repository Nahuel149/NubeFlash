<div class="col-lg-12">
  <div class="element-box">
    <div class="row">
        <div class="col-md-6">
            <h4>Lista de login attempts</h4>
        </div>
    </div><hr>
    <table id="dataTable1" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
        <thead>
            <tr>
                <th><a href="#">ID</a></th>
                <th><a href="#">Usuario</a></th>
                <th><a href="#">IP</a></th>
                <th><a href="#">Fecha</a></th>
            </tr>
        </thead>
        <tbody>
          <?php 
          foreach ($results as $result) { ?>
          <tr>
            <td><?php echo $result->id ?></td>
            <td><?php echo $result->nombre_usuario ?></td>
            <td><?php echo $result->ip_address ?></td>
            <td><?php echo date('d/m/Y',strtotime($result->time)) ?></td>
          </tr>
          <?php } ?>
        </tbody>
    </table>
  </div>
</div>