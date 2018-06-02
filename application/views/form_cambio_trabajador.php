<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Formulario de trabajador</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Modificar trabajador <?php echo($clave['nombre']) ?> <?php echo($clave['apellidos']) ?>
                </div>
                <div class="panel-body">
                	<div class="contact1-pic js-tilt" data-tilt>
						<img align='left' src="<?php echo base_url() ?>/assets/img/trabajadores.jpg" alt="IMG" style="max-width:100%;width:auto;height:auto;">
					</div>
                    <div class="row">
                        <div class="col-lg-5">
                            <form class="contact1-form validate-form" action="<?php echo base_url('Gestion/cambio_trabajador/'.$clave['id'])?>" method="POST">

                            	<div class="form-group" data-validate = "Por favor, rellene el campo Nombre">
									<input class="form-control" type="text" name="nombre" placeholder="Nombre" value="<?php echo($clave['nombre'])?>">
								</div>
							

								<div class="form-group" data-validate = "Por favor, rellene el campo Apellidos">
									<input class="form-control" type="text" name="apellidos" placeholder="Apellidos" value="<?php echo($clave['apellidos'])?>">
								</div>

							    <div class="form-group" data-validate = "Por favor, rellene el campo Cantidad">
									<select class="form-control" name="tipo" placeholder="Rol del trabajador"> 
								    	<?php foreach ($clave_tipotrabajador as $k => $v){ ?>
								       		<option value="<?php echo($clave_tipotrabajador[$k]['nombre']) ?>" <?php if(!empty($tipo)) { if($tipo == $clave_tipotrabajador[$k]['nombre']) { ?> selected <?php } } else { if($clave_tipotrabajador[$k]['id'] == $clave['id_tipo']) { ?> selected <?php } } ?>><?php echo($clave_tipotrabajador[$k]['nombre']) ?></option>
								        <?php } ?>
								    </select>
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
									<a href="<?php echo site_url() ?>Gestion/ver_trabajador" class="btn btn-danger" role="button">Atrás</a>
								</div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>