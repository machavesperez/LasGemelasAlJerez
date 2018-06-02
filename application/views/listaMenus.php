<script type="text/javascript">
function confirma(){
 if (confirm("¿Realmente desea eliminarlo?")){ 
 alert("El menú ha sido eliminado.") }
 else { 
 return false
 }
}
</script>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php if(!empty($busqueda)) echo("Búsqueda"); else echo("Lista");?> de menús</h1>
            <!-- Con esa sentencia de php delimitamos si es una búsqueda o una muestra de activos -->
        </div>
    </div>
    <div class= "row">
        <div class="col-lg-3 col-lg-offset-8">
            <form action="<?php echo base_url('Gestion/buscar_menu/')?>" class="search-form" align='right' METHOD='POST'>
                <div class="form-group has-feedback">
                    <label for="search" class="sr-only">Buscar</label>
                    <input type="text" class="form-control" name="search_box" id="search_box" placeholder="Buscar por nombre...">
                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
            </form>
        </div>
            <div class = "col-lg-1">
                <a href="<?php echo site_url() ?>Gestion/nuevo_menu" class="btn btn-primary"  role="button">Añadir</a>
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
                            <th scope="col">Coste</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Comensales</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Recetas</th>
                            <th scope="col">Bebidas</th>
                            <th scope="col">Lista compra</th>
                            <th scope="col">Beneficio</th> 
                            <th scope="col">Modificar</th>
                            <th scope="col">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $id = 0;
                        foreach ($clave as $k => $v){ $id=$id+1;?>
                            <tr>
                                <td data-label="#"><?php echo($id) ?></td>
                                <td data-label="Nombre"><?php echo($clave[$k]['nombre']) ?></td>
                                <td data-label="Descripción"><?php echo(substr(($clave[$k]['descripcion']), 0, 50)."...") ?></td>
                                <td data-label="Coste"><?php echo(number_format((float)$clave[$k]['coste'], 2, ',', '')." €") ?></td>
                                <td data-label="Precio"><?php echo(number_format((float)$clave[$k]['precio'], 2, ',', '')." €") ?></td>
                                <td data-label="Comensales"><?php echo(number_format((int)$clave[$k]['comensales'])) ?></td>
                                <td data-label="Tipo"><a href="<?php echo base_url('Gestion/mostrar_tiposmenu/'.$clave[$k]['id'])?>"><span class="glyphicon glyphicon-list fa-fw" style="color:light_blue"></span></a></td>
                                <td data-label="Recetas"><a href="<?php echo base_url('Gestion/mostrar_recetas/'.$clave[$k]['id'])?>"><span class="glyphicon glyphicon-list fa-fw" style="color:light_blue"></span></a></td>
                                <td data-label="Bebidas"><a href="<?php echo base_url('Gestion/mostrar_bebidas/'.$clave[$k]['id'])?>"><span class="glyphicon glyphicon-list fa-fw" style="color:light_blue"></span></a></td>
                                <td data-label="Lista compra"><a href="<?php echo base_url('Gestion/generar_pdf_listaCompraMenu/'.$clave[$k]['id'])?>"><span class="glyphicon glyphicon-save-file" style="color:green"></span></a></td>
                                <td data-label="Beneficio"><a href="<?php echo base_url('Gestion/generar_pdf_beneficioMenu/'.$clave[$k]['id'])?>"><span class="glyphicon glyphicon-save-file" style="color:green"></span></a></td>
                                <td data-label="Modificar"><a href="<?php echo base_url('Gestion/modificar_menu/'.$clave[$k]['id'])?>"><span class="glyphicon glyphicon-pencil" style="color:light_blue"></span></a></td>
                                <td data-label="Eliminar"><a onclick="if(confirma() == false) return false" href="<?php echo base_url('Gestion/eliminar_menu/'.$clave[$k]['id'])?>"><span class="glyphicon glyphicon-remove" style="color:red"></span></a></td>
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
