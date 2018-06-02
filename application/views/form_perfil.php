<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Perfil de usuario</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    
                </div>
                <div class="panel-body">
                	
                    <div class="row">
                        <div class="col-lg-5">

							            <?php if (validation_errors() or isset($error)): ?>
													<div class="col-lg-14">
						                    <div class="panel panel-red">
						                        <div class="panel-heading">
						                            Errores en el formulario
						                        </div>
						                        <div class="panel-body">
						                            <?php echo validation_errors(); ?>
						                            <?=@$error?>
						                        </div>
					                    	</div>
					                	</div>
					                <?php endif; ?>

					                <?php if (isset($correcto)): ?>
													<div class="col-lg-14">
						                    <div class="panel panel-green">
						                        <div class="panel-heading">
						                            Mensaje del sistema
						                        </div>
						                        <div class="panel-body">
						                            <?=@$correcto?>
						                        </div>
					                    	</div>
					                	</div>
					                <?php endif; ?>

							            <form  class="contact1-form validate-form" action="<?php echo base_url('Gestion/cambiar_nombre_usuario')?>" method="POST">
							                <label>Nombre</label>
							                
							                <div class="form-group" data-validate = "Por favor, rellene el campo Nombre">
							                    <input class="form-control" type="text" name="nombre" placeholder="Nombre" value="<?= $_SESSION['username'] ?>">
							                </div>

															<div class="container-contact1-form-btn">
																<button class="contact1-form-btn btn btn-primary" aria-hidden="true">Cambiar</button>
															</div>
							            </form>
							            <br>
							            <form  class="contact1-form validate-form" action="<?php echo base_url('Gestion/cambiar_pass_usuario')?>" method="POST">
							                <label>Contraseña</label>
							                
							                <div class="form-group" data-validate = "Por favor, rellene el campo Nombre">
							                    <input class="form-control" type="password" name="pass1" placeholder="antigua contraseña" value="">
							                </div>

							                <div class="form-group" data-validate = "Por favor, rellene el campo Nombre">
							                    <input class="form-control" type="password" name="pass2" placeholder="nueva contraseña" value="">
							                </div>

															<div class="container-contact1-form-btn">
																<button class="contact1-form-btn btn btn-primary" aria-hidden="true">Cambiar</button>
															</div>
							            </form>
							            <br>
							            <form  class="contact1-form validate-form" action="<?php echo base_url('Gestion/cambiar_email_usuario')?>" method="POST">
							                <label>Email</label>
							                
							                <div class="form-group" data-validate = "Por favor, rellene el campo Nombre">
							                    <input class="form-control" type="email" name="email" placeholder="email" value="<?= $_SESSION['email'] ?>">
							                </div>

															<div class="container-contact1-form-btn">
																<button class="contact1-form-btn btn btn-primary" aria-hidden="true">Cambiar</button>
															</div>
							            </form>

							            <br><br>
							            <a href="<?php echo site_url() ?>Gestion" class="btn btn-danger" role="button">Atrás</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>