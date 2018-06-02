<script type="text/javascript">
function confirma(){
 if (confirm("¿Realmente desea eliminarlo?")){ 
 alert("El agradecimiento ha sido eliminado.") }
 else { 
 return false
 }
}
</script>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Lista de agradecimientos: <?= $noticia['titulo']?></h1>
            <!-- Con esa sentencia de php delimitamos si es una búsqueda o una muestra de activos -->
        </div>
    </div>
    <div class= "row">

            <div class = "col-lg-2 col-lg-offset-10">
                <a href="<?= site_url() ?>Gestion/nuevo_agradecimiento/<?=$noticia['id']?>" class="btn btn-primary"  role="button">Añadir</a>
                  <a href="<?= site_url() ?>Gestion/ver_noticia" class="btn btn-danger" role="button">Atrás</a>
            </div>
    </div>
    <div class="row">
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Comentario</th>
                          <th scope="col">Nota</th>
                          <th scope="col">Agradecimiento</th>
                          <th scope="col">Fecha</th>
                          <th scope="col">Modificar</th>
                          <th scope="col">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                          $id = 0;
                          foreach ($agradecimientos as $agradecimiento){ $id++;?>
                          <tr>
                            <td data-label="#"><?= $id ?></td>
                            <td data-label="Comentario"><?= substr(($agradecimiento['comentario']), 0, 50)."..." ?></td>
                            <td data-label="Nota"><?= $agradecimiento['nota'] ?></td>
                            <td data-label="Agradecimiento"><?= substr(($agradecimiento['agradecimiento']), 0, 50)."..." ?></td>
                            <td data-label="Fecha"><?= $agradecimiento['fecha'] ?></td>
                            <td data-label="Modificar"><a href="<?php echo base_url('Gestion/modificar_agradecimiento/'.$agradecimiento['id'])?>"><span class="glyphicon glyphicon-pencil" style="color:light_blue"></span></a></td>
                            <td data-label="Eliminar"><a onclick="if(confirma() == false) return false" href="<?= base_url('Gestion/eliminar_agradecimiento/'.$agradecimiento['id'].'/'.$noticia['id'])?>"><span class="glyphicon glyphicon-remove" style="color:red"></span></a></td>
                          </tr>
                          <?php }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>