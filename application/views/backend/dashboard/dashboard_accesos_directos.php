<?php if (isset($menu_categories) && !empty($menu_categories)): ?>
<div class="ibox-title">
    <h5>Menú de Administración</h5>
</div>
<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs" role="tablist" id="adminMenuTabs">
            <?php $i = 0; foreach ($menu_categories as $category_key => $category): ?>
                <li class="nav-item">
                    <a href="#tab_<?php echo $category_key; ?>" 
                       class="nav-link <?php echo ($i == 0) ? 'active' : ''; ?>" 
                       role="tab" 
                       data-toggle="tab">
                        <i class="<?php echo $category['icon']; ?>"></i> 
                        <?php echo $category['title']; ?>
                    </a>
                </li>
            <?php $i++; endforeach; ?>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="tab-content p-3">
            <?php $i = 0; foreach ($menu_categories as $category_key => $category): ?>
                <div class="tab-pane <?php echo ($i == 0) ? 'active' : ''; ?>" 
                     id="tab_<?php echo $category_key; ?>">
                    <div class="row">
                        <?php foreach ($category['items'] as $item): ?>
                            <div class="col-md-3 col-sm-6 mb-4">
                                <?php if ($item['implemented']): ?>
                                    <a href="<?php echo $item['url']; ?>" class="card h-100 text-decoration-none">
                                        <div class="card-body text-center">
                                            <i class="<?php echo $item['icon']; ?> fa-2x mb-3 text-primary"></i>
                                            <h5 class="card-title"><?php echo $item['title']; ?></h5>
                                            <?php if (isset($item['note'])): ?>
                                                <p class="card-text text-muted small mt-2"><?php echo $item['note']; ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                <?php else: ?>
                                    <div class="card h-100 text-decoration-none bg-light">
                                        <div class="card-body text-center">
                                            <i class="<?php echo $item['icon']; ?> fa-2x mb-3 text-secondary"></i>
                                            <h5 class="card-title text-muted"><?php echo $item['title']; ?></h5>
                                            <?php if (isset($item['note'])): ?>
                                                <p class="card-text text-muted small mt-2"><?php echo $item['note']; ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php $i++; endforeach; ?>
        </div>
    </div>
</div>
<?php elseif (!empty($padres)): ?>
<div class="row">
	<div class="col-md-12">
		<ul class="nav nav-tabs" role="tablist" id="myTab">
			<?php $i = 0; foreach ($padres as $padre): ?>
				<li class="nav-item">
					<a href="#tabAccesoDirecto_<?php echo $padre->id_menu?>" 
					   class="nav-link <?php echo ($i == 0) ? 'active' : ''; ?>" 
					   role="tab" 
					   data-toggle="tab">
						<i class="<?php echo $padre->iconpath ?>"></i> 
						<?php echo $padre->description ?>
					</a>
				</li>
			<?php $i++; endforeach; ?>
		</ul>
	</div>
	<div class="col-md-12">
		<div class="tab-content p-3">
			<?php $i = 0; foreach ($padres as $padre): ?>
				<div class="tab-pane <?php echo ($i == 0) ? 'active' : ''; ?>" 
					 id="tabAccesoDirecto_<?php echo $padre->id_menu?>">
					<div class="row">
						<?php foreach ($hijos as $hijo): ?>
							<?php if($hijo->parent == $padre->id_menu): ?>
								<div class="col-md-3 col-sm-6 mb-4">
									<a href="<?php echo base_url($hijo->link) ?>" 
									   class="card h-100 text-decoration-none">
										<div class="card-body text-center">
											<i class="<?php echo $hijo->iconpath ?> fa-3x mb-3 text-primary"></i>
											<h5 class="card-title"><?php echo $hijo->description ?></h5>
										</div>
									</a>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
			<?php $i++; endforeach; ?>
		</div>
	</div>
</div>
<?php else: ?>
<div class="alert alert-info">
	<i class="fas fa-info-circle"></i> No hay menús disponibles para mostrar.
</div>
<?php endif; ?>
