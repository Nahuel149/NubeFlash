<div class="col-lg-12">
  <div class="element-box">
    <div class="row">
        <div class="col-md-6">
            <h4>Login errors</h4>
        </div>
    </div><hr>
    <table id="dataTable1" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
        <thead>
            <tr>
                <th><a href="#">ID</a></th>
                <th><a href="#">Si</a></th>
                <th><a href="#">Password</a></th>
                <th><a href="#">Fecha</a></th>
                <th><a href="#">IP</a></th>
            </tr>
        </thead>
        <tbody>
          <?php 
          foreach ($results as $result) { ?>
          <tr>
            <td><?php echo $result->id_login ?></td>
            <td><?php echo $result->user ?></td>
            <td><?php echo $result->password ?></td>
            <td><?php echo $result->date ?></td>
            <td><?php echo $result->ip_address ?></td>
          </tr>
          <?php } ?>
        </tbody>
    </table>
  </div>
</div>