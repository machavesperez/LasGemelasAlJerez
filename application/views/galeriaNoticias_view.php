<script type="text/javascript">
function confirma(){
 if (confirm("¿Realmente desea eliminarla?")){ 
 alert("La imagen ha sido eliminada.") }
 else { 
 return false
 }
}
</script>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Galería de noticia: <?= $noticia['titulo']?></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Modificar galería
                </div>


                <div class="panel-body">

                    <!--<div class="container">-->
                        <div class="row">
                            <div class="col-lg-12">
                            <p><?php echo $this->session->flashdata('statusMsg'); ?></p>
                            <form enctype="multipart/form-data" action="" method="post">
                                <div class="form-group">
                                    <label>Pulse en examinar o arrastre las imágenes directamente</label>
                                    <input type="file" class="form-control" name="userFiles[]" multiple />
                                </div>
                                <div class="form-group">
                                    <input class="form-control btn btn-primary" type="submit" name="fileSubmit" value="CARGAR IMÁGENES"/>
                                </div>
                            </form>
                        

                        
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                              <th scope="col">#</th>
                                              <th scope="col">Imagen</th>
                                              <th scope="col">Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                              $id = 0;
                                              foreach ($files as $file){ $id++;?>
                                              <tr>
                                                <td data-label="#"><?= $id ?></td>
                                                <td data-label="Imagen"><img src="<?php echo base_url($file['ruta']); ?>" alt="" height="150" ></td>
                                                <td data-label="Eliminar"><a onclick="if(confirma() == false) return false" href="<?= base_url('Gestion/eliminar_foto_galeria/'.$noticia['id'].'/'.$file['id'])?>"><span class="glyphicon glyphicon-remove" style="color:red"></span></a></td>
                                              </tr>
                                              <?php }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            
                            <div class="container-contact1-form-btn">
                                <a href="<?= site_url() ?>Gestion/ver_noticia" class="btn btn-danger" role="button">Atrás</a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
