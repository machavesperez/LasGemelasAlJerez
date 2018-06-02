<script type="text/javascript">
function confirma(){
 if (confirm("¿Realmente desea eliminarlo?")){ 
 alert("El trabajador ha sido eliminado.") }
 else { 
 return false
 }
}
</script>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php if(!empty($busqueda)) echo("Búsqueda"); else echo("Lista");?> de trabajadores</h1>
            <!-- Con esa sentencia de php delimitamos si es una búsqueda o una muestra de activos -->
        </div>
    </div>
    <div class= "row">
        <div class="col-lg-3 col-lg-offset-8">
            <form action="<?php echo base_url('Gestion/buscar_trabajador/')?>" class="search-form" align='right' METHOD='POST'>
                <div class="form-group has-feedback">
                    <label for="search" class="sr-only">Buscar</label>
                    <input type="text" class="form-control" name="search_box" id="search_box" placeholder="Buscar...">
                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
            </form>
        </div>
            <div class = "col-lg-1">
                <a href="<?php echo site_url() ?>Gestion/nuevo_trabajador" class="btn btn-primary"  role="button">Añadir</a>
            </div>
    </div>
    <div class="row">
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Nombre</th>
                      <th scope="col">Apellidos</th>
                      <th scope="col">Rol</th>
                      <th scope="col">Modificar</th>
                      <th scope="col">Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $id = 0;
                    foreach ($clave as $k => $v){ $id=$id+1;?>
                    <tr>
                      <td data-label="ID"><?php echo($id) ?></td>
                      <td data-label="Nombre"><?php echo($clave[$k]['nombre']) ?></td>
                      <td data-label="Apellidos"><?php echo($clave[$k]['apellidos']) ?></td>
                      <td data-label="Rol"><?php echo($clave[$k]['tipo']) ?></td>
                      <td data-label="Modificar"><a href="<?php echo base_url('Gestion/modificar_trabajador/'.$clave[$k]['id'])?>"><span class="glyphicon glyphicon-pencil" style="color:light_blue"></span></a></td>
                      <td data-label="Eliminar"><a onclick="if(confirma() == false) return false" href="<?php echo base_url('Gestion/eliminar_trabajador/'.$clave[$k]['id'])?>"><span class="glyphicon glyphicon-remove" style="color:red"></span></a></td>
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
