<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Formulario de bebida</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Nueva bebida
                </div>
                <div class="panel-body">
                	<div class="contact1-pic js-tilt" data-tilt>
						<img align='left' src="<?php echo base_url() ?>/assets/img/bebidaForm.png" alt="IMG" style="max-width:100%;width:auto;height:auto;">
					</div>
                    <div class="row">
                        <div class="col-lg-5">
                            <form class="contact1-form validate-form" action="<?php echo base_url('Gestion/crear_bebida/')?>" method="POST">

                                <div class="form-group" data-validate = "Por favor, rellene el campo Nombre">
                                    <input class="form-control" type="text" name="nombre" placeholder="Nombre de la bebida" value="<?php echo(set_value('nombre'))?>">
                                </div>

                                <div class="form-group" data-validate = "Por favor, rellene el campo Precio de compra unitario">
									<input class="form-control" type="text" name="precio_unitario" placeholder="Precio de compra unitario" value=<?php echo(set_value('precio_unitario'))?> >
								</div>	

								<div class="form-group" data-validate = "Por favor, rellene el campo Precio de venta unitario">
									<input class="form-control" type="text" name="precio_total" placeholder="Precio de venta unitario" value=<?php echo(set_value('precio_total'))?>>
								</div>	

								<div class="form-group" data-validate = "Por favor, indique si contiene alcohol">
                                    <label>¿Contiene alcohol?</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="alcohol" value="0" checked>No
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="alcohol" value="1">Sí
                                    </label>
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
									<a href="<?php echo site_url() ?>Gestion/ver_bebida" class="btn btn-danger" role="button">Atrás</a>
								</div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>