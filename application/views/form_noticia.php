<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Formulario de noticia</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php if(isset($noticia['id'])) echo "Modificar Noticia";
                    else echo "Nueva Noticia"; ?>
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
                    

                	<div class="contact1-pic js-tilt" data-tilt>
                        <?php if(isset($noticia['foto'])){?><img align='left' src="<?= base_url().$noticia['foto']?>" alt="IMG" style="max-width:50%;width:auto;height:auto;">
                        <?php }else {?>
                        <i class="fa fa-newspaper-o fa-5x"></i>
                        <?php }?>
                    </div>

                    <div class="row">
                        <div class="col-lg-5">
                            <?php if(!isset($noticia['id'])) echo form_open_multipart(base_url()."Gestion/crear_noticia");
                            else echo form_open_multipart(base_url()."Gestion/cambio_noticia/".$noticia['id']);?>

                                <label>Foto de portada:</label>
                                <input class="form-control" type="file" name="userfile" /><br>

                                <label><?php if(isset($noticia['fecha'])) echo $noticia['fecha']?></label>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="titulo" placeholder="Título de la noticia" value="<?php if(isset($noticia['titulo'])) echo $noticia['titulo'];?>">
                                </div>

                                <div class="form-group">
                                    <label>Evento asociado</label>
                                    <select class="form-control" name="evento" placeholder="Evento asociado">  
                                    <?php if(isset($noticia['id_evento'])) { ?>  
                                    <option value="0">Ninguno</option>
                                    <?php foreach ($eventos as $evento) {
                                       echo("<option value=\"");
                                       echo $evento['id'];
                                       if($noticia['id_evento'] == $evento['id']) echo("\" selected=\"selected\">");
                                       else echo("\">");
                                       echo $evento['titulo'];
                                       echo("</option>"); 
                                    }} else {?>
								       <option value="0" selected="selected">Ninguno</option>
                                       <?php foreach ($eventos as $evento) {
                                           echo("<option value=\"");
                                           echo $evento['id'];
                                           echo("\">");
                                           echo $evento['titulo'];
                                           echo("</option>"); 
                                       }}?>
								    </select>
                                </div>

                                <div class="form-group">
                                    <textarea class="form-control" name="descripcion" rows="5" cols="55" placeholder="Descripcion de la noticia"><?php if(isset($noticia['descripcion'])) echo $noticia['descripcion']?></textarea>
                                </div>  

                                <div class="form-group" data-validate = "Por favor, rellene el campo Contenido">
                                    <textarea class="form-control" name="contenido" rows="20" cols="55" placeholder="Contenido de la noticia"><?php if(isset($noticia['contenido'])) echo $noticia['contenido']?></textarea>
                                </div>	


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