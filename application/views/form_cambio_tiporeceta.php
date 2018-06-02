<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Formulario de tipo de receta</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Modificar tipo de receta <?php echo($clave['nombre']) ?>
                </div>
                <div class="panel-body"> 
                	<div class="contact1-pic js-tilt" data-tilt>
						<img align='left' src="<?php echo base_url() ?>/assets/img/tiporeceta.jpg" alt="IMG" style="max-width:100%;width:auto;height:auto;">
					</div>
                    <div class="row">
                        <div class="col-lg-5">
                            <form class="contact1-form validate-form" action="<?php echo base_url('Gestion/cambio_tiporeceta/'.$clave['id'])?>" method="POST">
                                <div class="form-group" data-validate = "Por favor, rellene el campo Nombre">
                                	<?php form_error('nombre');?>
                                    <input class="form-control" type="text" name="nombre" placeholder="Nombre del producto" value="<?php echo($clave['nombre'])?>">
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
									<a href="<?php echo site_url() ?>Gestion/ver_tiporeceta" class="btn btn-danger" role="button">Atrás</a>
								</div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>