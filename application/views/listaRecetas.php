<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php if(!empty($busqueda)) echo("Búsqueda"); else echo("Lista");?> de recetas</h1>
            <!-- Con esa sentencia de php delimitamos si es una búsqueda o una muestra de activos -->
        </div>
    </div>
    <div class= "row">
        <div class="col-lg-3 col-lg-offset-8">
            <form action="<?php echo base_url('Gestion/buscar_receta/')?>" class="search-form" align='right' METHOD='POST'>
                <div class="form-group has-feedback">
                    <label for="search" class="sr-only">Buscar</label>
                    <input type="text" class="form-control" name="search_box" id="search_box" placeholder="Buscar por nombre...">
                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
            </form>
        </div>
            <div class = "col-lg-1">
                <a href="<?php echo site_url() ?>Gestion/nueva_receta" class="btn btn-primary"  role="button">Añadir</a>
            </div>
    </div>
    <div class="row">
        <div class="panel-body">
          	<div class="col-lg-8">
                    <div class="panel panel-default">
                    	<div class="panel-heading" style="font-weight:bold;">
	                    <i class="glyphicon glyphicon-list-alt"></i> Todas las recetas
	                </div>
                        <div class="panel-body">
                        	          		<?php
					$cuenta = 0;
					foreach ($recetas as $receta_id => $receta) { $cuenta = $cuenta + 1; ?>
                        	<div class="col-lg-4">
                        		<div class="panel panel-default">
				                    <div class="panel-body">
				                    	<a href="<?= site_url() ?>Gestion/receta/<?= $receta_id?>"><img class="img-responsive" src="<?php $img = ( count( $receta['fotos'] ) == 0 ? site_url().'/assets/img/default.jpg' : site_url().reset($receta['fotos']) ) ?><?= $img ?>" alt=" "></a>
				                        <h4><a href="<?= site_url() ?>Gestion/receta/<?= $receta_id?>" style="text-decoration:none; color:black" align="left"><?= $receta['nombre'] ?></a></h4>
										<div class="date">
											<span class="date-in"><i class="glyphicon glyphicon-time"> </i> <?php if($receta['horas'] > 0) 								echo $receta['horas'].'h';?> <?= $receta['minutos'] ?>m</span> <br>
											<span class="date-in"><i class="glyphicon glyphicon-save-file" style="color:blue"></i>
                                                <a href="<?php echo base_url('Gestion/generar_pdf_listaCompraReceta/'.$receta_id)?>">Lista compra</a></span>
                                                <br>
                                            <span class="date-in"><i class="glyphicon glyphicon-save-file" style="color:blue"></i>
                                                <a href="<?php echo base_url('Gestion/generar_pdf_listaCompraReceta/'.$receta_id)?>">Beneficio</a></span>
											<div class="clearfix"> </div>
										</div>
										<br>
										<p align="center"><?= $receta['descripcion'] ?></p>
				                    </div>
				                    <div class="panel-footer">
				                        <a type="button" class="btn btn-outline btn-primary btn-lg btn-block" href="<?= site_url() ?>Gestion/receta/<?= $receta_id?>">Ver receta</a>
				                    </div>
				                </div>
		                    </div>
		                    <?php 
							if($cuenta == 3) { $cuenta = 0; ?>
								<div class="clearfix"> </div>
								<br>

							<?php }} ?>
                    	</div>
                    	<div class = "col-lg-5">
                    	<?php echo $this->pagination->create_links() ?>
                    	</div>
            		</div>
            </div>
            <div class="col-lg-4">
	            <div class="panel panel-default">
	                <div class="panel-heading" style="font-weight:bold;">
	                    <i class="glyphicon glyphicon-list-alt"></i> Últimas recetas
	                </div>

	                <div class="panel-body">
                        <?php foreach ($ultimas_recetas as $receta_id => $receta) {  ?>
        	                    <div class="row"> <!-- Cada div de row será una receta -->
        	                    	<div class="col-lg-4">
        	                    		<a href="<?= site_url() ?>Gestion/receta/<?= $receta_id?>" class="fashion"><img class="img-responsive " src="<?php $img = ( count( $receta['fotos'] ) == 0 ? site_url().'/assets/img/default.jpg' : site_url().reset($receta['fotos']) ) ?><?= $img ?>" alt="" style="float:left; margin:10px;"></a>
        	                    	</div>
        	                    	<div class="col-lg-8">
        									<a href="<?= site_url() ?>Gestion/receta/<?= $receta_id?>" class="elit"><?= $receta['nombre'] ?></a>
        									<p><?= $receta['descripcion'] ?></p>
        							</div>
        	                    </div>
                        <?php } ?>
	                </div>
	            </div>
            </div>
            <!-- <div class="col-lg-4 col-md-6">
                    <div class="panel panel-default responsive">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-reorder fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo($tiposreceta[0]['cantidad'])?></div>
                                    <div>Tipos de receta</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo site_url() ?>Gestion/ver_tiporeceta">
                            <div class="panel-footer">
                                <span class="pull-left">Ver detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div> -->
        </div>       
    </div>
</div>