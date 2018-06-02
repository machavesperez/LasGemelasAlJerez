<script type="text/javascript">
function confirma(){
 if (confirm("¿Realmente desea eliminarla?")){ 
 alert("La noticia ha sido eliminada.") }
 else { 
 return false
 }
}
</script>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php if(!empty($busqueda)) echo("Búsqueda"); else echo("Lista");?> de noticias</h1>
            <!-- Con esa sentencia de php delimitamos si es una búsqueda o una muestra de activos -->
        </div>
    </div>
    <div class= "row">
        <div class="col-lg-3 col-lg-offset-8">
            <form action="<?php echo base_url('Gestion/buscar_noticia/')?>" class="search-form" align='right' METHOD='POST'>
                <div class="form-group has-feedback">
                    <label for="search" class="sr-only">Buscar</label>
                    <input type="text" class="form-control" name="search_box" id="search_box" placeholder="Buscar por título...">
                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
            </form>
        </div>
            <div class = "col-lg-1">
                <a href="<?php echo site_url() ?>Gestion/nueva_noticia" class="btn btn-primary"  role="button">Añadir</a>
            </div>
    </div>
    <div class="row">
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Titulo</th>
                          <th scope="col">Descripción</th>
                          <th scope="col">Contenido</th>
                          <th scope="col">Fecha</th>
                          <th scope="col">Evento</th>
                          <th scope="col">Galería</th>
                          <th scope="col">Agradecimientos</th>
                          <th scope="col">Modificar</th>
                          <th scope="col">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                          $id = 0;
                          foreach ($clave as $noticia){ $id++;?>
                          <tr>
                            <td data-label="#"><?= $id ?></td>
                            <td data-label="Titulo"><?= $noticia['titulo'] ?></td>
                            <td data-label="Descripción"><?= substr(($noticia['descripcion']), 0, 50)."..." ?></td>
                            <td data-label="Contenido"><?= substr(($noticia['contenido']), 0, 50)."..." ?></td>
                            <td data-label="Fecha"><?= $noticia['fecha'] ?></td>
                            <td data-label="Evento"><?php if(is_null($noticia['evento'])) echo "-";
                            else echo $noticia['evento']; ?>
                            </td>
                            <td data-label="Galería"><a href="<?php echo base_url('Gestion/modificar_galeria/'.$noticia['id'])?>"><span class="glyphicon glyphicon-list fa-fw" style="color:light_blue"></span></a></td>
                            <td data-label="Agradecimientos"><a href="<?php echo base_url('Gestion/agradecimientos_noticia/'.$noticia['id'])?>"><span class="glyphicon glyphicon-list fa-fw" style="color:light_blue"></span></a></td>
                            <td data-label="Modificar"><a href="<?php echo base_url('Gestion/modificar_noticia/'.$noticia['id'])?>"><span class="glyphicon glyphicon-pencil" style="color:light_blue"></span></a></td>
                            <td data-label="Eliminar"><a onclick="if(confirma() == false) return false" href="<?= base_url('Gestion/eliminar_noticia/'.$noticia['id'])?>"><span class="glyphicon glyphicon-remove" style="color:red"></span></a></td>
                          </tr>
                          <?php }
                        ?>
                    </tbody>
                </table>
                <?php echo $this->pagination->create_links() ?>
            </div>
        </div>
    </div>
</div>