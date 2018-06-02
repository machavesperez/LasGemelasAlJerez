<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Menú: <?php echo($clave_menu['nombre']) ?></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Añadir Receta/s 
                </div>
                <div class="panel-body">
                	<div class="contact1-pic js-tilt" data-tilt>
						<img align='left' src="<?php echo base_url() ?>/assets/img/bl1.jpg" alt="IMG" style="max-width:100%;width:auto;height:auto;">
					</div>
                    <div class="row">
                        <div class="col-lg-5">
                            <form class="contact1-form validate-form" action="<?php echo base_url('Gestion/insertar_receta_menu/'.$clave_menu['id'])?>" method="POST">
                                <div class="form-group"> 
                                     <select multiple name="tipo[]">
                                          <?php foreach ($clave_receta as $k => $v){ ?>
                                            <option value=<?php echo($clave_receta[$k]['id'])?>> <?php echo($clave_receta[$k]['nombre']) ?></option>
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
									<a href="<?php echo base_url('Gestion/mostrar_recetas/'.$clave_menu['id'])?>" class="btn btn-danger" role="button">Atrás</a>
								</div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
