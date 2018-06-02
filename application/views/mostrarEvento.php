<script type="text/javascript">
function confirma(){
 if (confirm("¿Realmente desea eliminarlo?")){ 
 alert("El evento ha sido eliminado.") }
 else { 
 return false
 }
}
</script>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Menú: <?php echo($clave_menu['nombre']) ?></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class= "row">
        <div class="col-md-3 col-md-offset-9">
            <form action="" class="search-form" align='right'>
                <div class="form-group has-feedback">
                    <label for="search" class="sr-only">Buscar</label>
                    <input type="text" class="form-control" name="search_box" id="search_box" placeholder="Buscar...">
                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
            </form>
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
                          <th scope="col">Descripcion</th>
                          <th scope="col">Fecha</th>
                          <th scope="col">Lugar</th>
                          <th scope="col">Visible</th>   
                          <th scope="col">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                          $id = 0;
                          foreach ($clave_evento as $k => $v){ $id=$id+1;?>
                          <tr>
                            <td data-label="#"><?php echo($id) ?></td>
                            <td data-label="Titulo"><?php echo($clave_evento[$k]['titulo']) ?></td>
                            <td data-label="Descripcion"><?php echo(substr(($clave_evento[$k]['descripcion']), 0, 50)."...") ?></td>
                            <td data-label="Fecha"><?php echo($clave_evento[$k]['fecha']) ?></td>
                            <td data-label="Lugar"><?php echo($clave_evento[$k]['lugar']) ?></td>
                            
                            <td data-label="Visible"><?php if($clave_evento[$k]['es_visible']==0) echo("No"); else echo("Sí"); ?></td>

                            <td data-label="Eliminar"><a onclick="if(confirma() == false) return false" href="<?php echo base_url('Gestion/eliminar_evento_menu/'.$clave_evento[$k]['id'].'/'.$clave_menu['id'])?>"><span class="glyphicon glyphicon-remove" style="color:red"></span></a></td>
                            </tr>                          
                          <?php }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        <div class= "row">
        <div class="col-md-1 col-md-offset-11">
            <a href="<?php echo base_url('Gestion/insertar_evento/'.$clave_menu['id'])?>" class="btn btn-primary" role="button">Añadir</a>
        </div>
    </div>
</div>