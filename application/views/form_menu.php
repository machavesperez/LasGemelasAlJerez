<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Formulario de menú</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Nuevo menú
                </div>
                <div class="panel-body">
                	<div class="contact1-pic js-tilt" data-tilt>
						<img align='left' src="<?php echo base_url() ?>/assets/img/bl.jpg" alt="IMG" style="max-width:100%;width:auto;height:auto;">
					</div>
                    <div class="row">
                        <div class="col-lg-5">
                            <form class="contact1-form validate-form" action="<?php echo base_url('Gestion/crear_menu/')?>" method="POST">

                                <div class="form-group" data-validate = "Por favor, rellene el campo Nombre">
                                    <input class="form-control" type="text" name="nombre" placeholder="Nombre del menú" value="<?php echo(set_value('nombre'))?>">
                                </div>

                                <div class="form-group" data-validate = "Por favor, rellene el campo Descripción">
                                    <input class="form-control" type="text" name="descripcion" placeholder="Descripción del menú" value="<?php echo(set_value('descripcion'))?>">
                                </div>	

								<div class="form-group" data-validate = "Por favor, rellene el campo Coste">
                                    <input class="form-control" type="text" name="coste" placeholder="Coste del menú" value="<?php echo(set_value('coste'))?>">
                                </div>

                                <div class="form-group" data-validate = "Por favor, rellene el campo Precio">
									<input class="form-control" type="text" name="precio" placeholder="Precio del menú" value="<?php echo(set_value('precio'))?>">
								</div>	

                                <div class="form-group" data-validate = "Por favor, rellene el campo Comensales">
                                    <input class="form-control" type="text" name="comensales" placeholder="Comensales" value="<?php echo(set_value('comensales'))?>">
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
									<a href="<?php echo site_url() ?>Gestion/ver_menu" class="btn btn-danger" role="button">Atrás</a>
								</div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>