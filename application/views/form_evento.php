<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Formulario de evento</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Nuevo Evento
                </div>
                <div class="panel-body">
                	<div class="contact1-pic js-tilt" data-tilt>
						<img align='left' src="<?php echo base_url() ?>/assets/img/12.png" alt="IMG" style="max-width:100%;width:auto;height:auto;">
					</div>
                    <div class="row">
                        <div class="col-lg-5">
                            <form class="contact1-form validate-form" action="<?php echo base_url('Gestion/crear_evento/')?>" method="POST">

                                <div class="form-group" data-validate = "Por favor, rellene el campo Título">
                                    <input class="form-control" type="text" name="titulo" placeholder="Título del evento" value="<?php echo(set_value('evento'))?>">
                                </div>

<!--                                 <div class="form-group">
                                    <label>Noticia asociada</label>
                                    <select class="form-control" name="evento" placeholder="Noticia asociado">    
								       <option value="0" selected="selected">Ninguno</option>
								    </select>
                                </div>
 -->
                                <div class="form-group" data-validate = "Por favor, rellene el campo Descripción">
									<textarea class="form-control"  name="descripcion"  rows="5" cols="55" placeholder="Descripción del evento" value=<?php echo(set_value('descripcion'))?> ></textarea>
								</div>	

                                <div class="form-group" data-validate = "Por favor, rellene el campo Lugar">
                                    <textarea class="form-control" name="lugar" rows="1" cols="55" placeholder="Lugar del evento" value=<?php echo(set_value('lugar'))?> ></textarea>
                                </div>

                                <div class="form-group" data-validate = "Por favor, rellene el campo Personas">
                                    <input class="form-control" type="text" name="persona" placeholder="Número de personas que asistirán al evento" value="<?php echo(set_value('persona'))?>">
                                </div>  

                                <div class="form-group" data-validate = "Por favor, rellene el campo Fecha">
                                    <label>Fecha: </label>
                                    <input class="form-control" type="date" name="fecha" placeholder="Fecha del evento" value="<?php echo(set_value('fecha'))?>">
                                </div> 

                                <div class="form-group" data-validate = "Por favor, indique si quiere mostrarlo en Últimos eventos">
                                    <label>¿Mostrar como evento público?</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="es_visible" value="0" checked>No
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="es_visible" value="1">Sí
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
									<a href="<?php echo site_url() ?>Gestion/ver_evento" class="btn btn-danger" role="button">Atrás</a>
								</div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>