<script type="text/javascript">
function confirma(){
 if (confirm("¿Realmente desea eliminarla?")){ 
 alert("El menú ha sido eliminado.") }
 else { 
 return false
 }
}
</script>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php if(!empty($busqueda)) echo("Búsqueda"); else echo("Lista");?> menús | Evento: <?php echo($clave_evento['titulo']) ?> </h1>
            <!-- Con esa sentencia de php delimitamos si es una búsqueda o una muestra de activos -->
        </div>
    </div>
    <div class= "row">
        <div class="col-lg-3 col-lg-offset-7">
            <form action="<?php echo base_url('Gestion/buscar_menu_evento/'.$clave_evento['id'])?>" class="search-form" align='right' METHOD='POST'>
                <div class="form-group has-feedback">
                    <label for="search" class="sr-only">Buscar</label>
                    <input type="text" class="form-control" name="search_box" id="search_box" placeholder="Buscar por nombre...">
                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
            </form>
        </div>
            <div class = "col-lg-2">
                <a href="<?php echo base_url('Gestion/insertar_menu/'.$clave_evento['id'])?>" class="btn btn-primary"  role="button">Añadir</a>
                <a href="<?php echo base_url('Gestion/ver_evento/')?>" class="btn btn-danger"  role="button">Volver</a>
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
                            <th scope="col">Descripción</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Coste</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Comensales</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Recetas</th>
                            <th scope="col">Bebidas</th>
                            <th scope="col">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $id = 0;
                        foreach ($clave_menu as $k => $v){ $id=$id+1;?>
                            <tr>
                                <td data-label="#"><?php echo($id) ?></td>
                                <td data-label="Nombre"><?php echo($clave_menu[$k]['nombre']) ?></td>
                                <td data-label="Descripción"><?php echo(substr(($clave_menu[$k]['descripcion']), 0, 50)."...") ?></td>
                                <td data-label="Cantidad"><?php echo($clave_menu[$k]['cantidad']) ?></td>
                                <td data-label="Coste"><?php echo(number_format((float)$clave_menu[$k]['coste'], 2, ',', '')." €") ?></td>
                                <td data-label="Precio"><?php echo(number_format((float)$clave_menu[$k]['precio'], 2, ',', '')." €") ?></td>
                                <td data-label="Comensales"><?php echo(number_format((int)$clave_menu[$k]['comensales'])) ?></td>
                                <td data-label="Tipo"><a href="<?php echo base_url('Gestion/mostrar_tiposmenu/'.$clave_menu[$k]['id'])?>"><span class="glyphicon glyphicon-list fa-fw" style="color:light_blue"></span></a></td>
                                <td data-label="Recetas"><a href="<?php echo base_url('Gestion/mostrar_recetas/'.$clave_menu[$k]['id'])?>"><span class="glyphicon glyphicon-list fa-fw" style="color:light_blue"></span></a></td>
                                <td data-label="Bebidas"><a href="<?php echo base_url('Gestion/mostrar_bebidas/'.$clave_menu[$k]['id'])?>"><span class="glyphicon glyphicon-list fa-fw" style="color:light_blue"></span></a></td>
                                <td data-label="Eliminar"><a onclick="if(confirma() == false) return false" href="<?php echo base_url('Gestion/eliminar_menu_evento/'.$clave_menu[$k]['id'].'/'.$clave_evento['id'])?>" <span class="glyphicon glyphicon-remove" style="color:red"></span></a></td>
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