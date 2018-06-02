<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Formulario de agradecimiento</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php if(isset($agradecimiento['id'])) echo "Modificar Agradecimiento";
                    else echo "Nuevo Agradecimiento"; ?>
                </div>


                <div class="panel-body">

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
                    

                    <div class="row">
                        <div class="col-lg-5">
                            <?php if(!isset($agradecimiento['id'])) echo form_open_multipart(base_url()."Gestion/crear_agradecimiento");
                            else echo form_open_multipart(base_url()."Gestion/cambio_agradecimiento/".$agradecimiento['id']);?>

                                <label><?php if(isset($agradecimiento['fecha'])) echo $agradecimiento['fecha']?></label>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="nota" placeholder="Nota del comentario" value="<?php if(isset($agradecimiento['nota'])) echo $agradecimiento['nota'];?>">
                                </div>

                                <div class="form-group">
                                    <textarea class="form-control" name="comentario" rows="5" cols="55" placeholder="Comentario"><?php if(isset($agradecimiento['comentario'])) echo $agradecimiento['comentario']?></textarea>
                                </div>  

                                <div class="form-group">
                                    <textarea class="form-control" name="agradecimiento" rows="20" cols="55" placeholder="Agradecimiento"><?php if(isset($agradecimiento['agradecimiento'])) echo $agradecimiento['agradecimiento']?></textarea>
                                </div>	

                                <input type="hidden" name="id_noticia" value="<?=$id_noticia?>">


								<br></br>

								<div class="container-contact1-form-btn">
									<button class="contact1-form-btn btn btn-primary" aria-hidden="true">Confirmar</button>
									<a href="<?php echo site_url() ?>Gestion/ver_noticia" class="btn btn-danger" role="button">Atrás</a>
								</div>
                            <?=form_close()?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>