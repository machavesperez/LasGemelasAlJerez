<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Formulario de producto</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Modificar producto <?php echo($clave['nombre']) ?>
                </div>
                <div class="panel-body">
                	<div class="contact1-pic js-tilt" data-tilt>
						<img align='left' src="<?php echo base_url() ?>/assets/img/me1.jpg" alt="IMG" style="max-width:100%;width:auto;height:auto;">
					</div>
                    <div class="row">
                        <div class="col-lg-5">
                            <form class="contact1-form validate-form" action="<?php echo base_url('Gestion/cambio_producto/'.$clave['id'])?>" method="POST">
                                <div class="form-group" data-validate = "Por favor, rellene el campo Nombre">
                                	<?php form_error('nombre');?>
                                    <input class="form-control" type="text" name="nombre" placeholder="Nombre del producto" value="<?php if(!empty($nombre)) echo($nombre); else echo($clave['nombre'])?>">
                                </div>

                                <div class="form-group" data-validate = "Por favor, rellene el campo Precio de compra unitario">
									<input class="form-control" type="text" name="precio_unitario" placeholder="Precio de compra unitario" value=<?php if(!empty($precio_unitario)) echo($precio_unitario); else echo($clave['precio_unitario'])?> >
								</div>	
								<div class="form-group" data-validate = "Por favor, rellene el campo Precio de venta unitario">
									<input class="form-control" type="text" name="precio_total" placeholder="Precio de venta unitario" value=<?php if(!empty($precio_total)) echo($precio_total); else echo($clave['precio_total'])?> >
								</div>	

								<div class="row">
									<div class="col-lg-5 col-xs-6 form-group">
									<Label>Unidad de medida: </Label>
									</div>	
									<div class="col-lg-4 col-xs-6 form-group">
	                                    <select class="form-control" name="unidad" placeholder="Unidad">  
	                                    		<option value="kg" 
	                                    		<?php if(!empty($unidad)) { 
	                                    			if($unidad == "kg") {?> selected
	                                    		<?php } }else { if($clave['unidad'] == "kg"){ ?> selected <?php } }?>>kg</option>
	                                    		<option value="g" 
	                                    		<?php if(!empty($unidad)) { if($unidad == "g") { ?> selected
	                                    		<?php } }else { if($clave['unidad'] == "g"){ ?> selected <?php } }?>>gramos</option>
	                                    		<option value="l" 
	                                    		<?php if(!empty($unidad)) { if($unidad == "l") { ?> selected
	                                    		<?php } }else { if($clave['unidad'] == "l"){ ?> selected <?php } } ?>>litros</option>
	                                    		<option value="ml" 
	                                    		<?php 
	                                    		if(!empty($unidad)) { if($unidad == "ml") { ?> selected
	                                    		<?php } }else { if($clave['unidad'] == "ml"){ ?> selected <?php } }?>>ml</option>
	                                    		<option value="unidad" 
	                                    		<?php if(!empty($unidad)) { if($unidad == "unidad") { ?> selected
	                                    		<?php } }else { if($clave['unidad'] == "unidad"){ ?> selected <?php } }?>>unidades</option>
									    </select>
                                	</div>
                           		</div>

								<br></br>

								<?php if (validation_errors()): ?>
									<div class="col-lg-14">
					                    <div class="panel panel-red">
					                        <div class="panel-heading">
					                            Errores en el formulario
					                        </div>
					                        <div class="panel-body">
					                            <?php echo validation_errors(); ?>
					                        </div>
				                    	</div>
				                	</div>
				                <?php endif; ?>

								<div class="container-contact1-form-btn">
									<button class="contact1-form-btn btn btn-primary" aria-hidden="true">Confirmar</button>
									<a href="<?php echo site_url() ?>Gestion/ver_producto" class="btn btn-danger" role="button">Atrás</a>
								</div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>