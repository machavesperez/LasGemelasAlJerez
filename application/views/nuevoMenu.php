<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Evento: <?php echo($clave_evento['titulo']) ?></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Añadir Menú/s 
                </div>
                <div class="panel-body">
                  <div class="contact1-pic js-tilt" data-tilt>
            <img align='left' src="<?php echo base_url() ?>/assets/img/bl.jpg" alt="IMG" style="max-width:100%;width:auto;height:auto;">
          </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <form class="contact1-form validate-form" action="<?php echo base_url('Gestion/insertar_menu_evento/'.$clave_evento['id'])?>" method="POST">
                                <div class="form-group"> 
                                     <select multiple name="tipo[]">
                                          <?php foreach ($clave_menu as $k => $v){ ?>
                                            <option value=<?php echo($clave_menu[$k]['id'])?>> <?php echo($clave_menu[$k]['nombre']) ?></option>
                                        <?php } ?>
                                    </select> 
                                </div>

                                <div class="form-group" data-validate = "Por favor, rellene el campo Cantidad">
                                  <input class="form-control" type="text" name="cantidad" placeholder="Cantidad" value=<?php echo(set_value('cantidad'))?> >
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
                  <a href="<?php echo base_url('Gestion/mostrar_menus/'.$clave_evento['id'])?>" class="btn btn-danger" role="button">Atrás</a>
                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
