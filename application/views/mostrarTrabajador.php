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
            <h1 class="page-header"><?php if(!empty($busqueda)) echo("Búsqueda"); else echo("Lista");?> trabajadores | Evento: <?php echo($clave_evento['titulo']) ?> </h1>
            <!-- Con esa sentencia de php delimitamos si es una búsqueda o una muestra de activos -->
        </div>
    </div>
    <div class= "row">
        <div class="col-lg-3 col-lg-offset-7">
            <form action="<?php echo base_url('Gestion/buscar_trabajador_evento/'.$clave_evento['id'])?>" class="search-form" align='right' METHOD='POST'>
                <div class="form-group has-feedback">
                    <label for="search" class="sr-only">Buscar</label>
                    <input type="text" class="form-control" name="search_box" id="search_box" placeholder="Buscar por nombre...">
                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
            </form>
        </div>
            <div class = "col-lg-2">
                <a href="<?php echo base_url('Gestion/insertar_trabajador/'.$clave_evento['id'])?>" class="btn btn-primary"  role="button">Añadir</a>
                <a href="<?php echo base_url('Gestion/ver_evento/')?>" class="btn btn-danger" role="button">Volver</a>
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
                      <th scope="col">Horas</th>
                      <th scope="col">Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $id = 0;
                    foreach ($clave_trabajador as $k => $v){ $id=$id+1;?>
                    <tr>
                      <td data-label="ID"><?php echo($id) ?></td>
                      <td data-label="Nombre"><?php echo($clave_trabajador[$k]['nombre']) ?></td>
                      <td data-label="Apellidos"><?php echo($clave_trabajador[$k]['apellidos']) ?></td>
                      <td data-label="Rol"><?php echo($clave_trabajador[$k]['tipo']) ?></td>
                      <td data-label="Horas"><?php echo($clave_trabajador[$k]['horas']) ?></td>
                      <td data-label="Eliminar"><a onclick="if(confirma() == false) return false" href="<?php echo base_url('Gestion/eliminar_trabajador_evento/'.$clave_trabajador[$k]['id'].'/'.$clave_evento['id'])?>"><span class="glyphicon glyphicon-remove" style="color:red"></span></a></td>
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