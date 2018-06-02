<script type="text/javascript">
function confirma(){
 if (confirm("¿Realmente desea eliminarla?")){ 
 alert("La bebida ha sido eliminada.") }
 else { 
 return false
 }
}
</script>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php if(!empty($busqueda)) echo("Búsqueda"); else echo("Lista");?> de bebidas</h1>
            <!-- Con esa sentencia de php delimitamos si es una búsqueda o una muestra de activos -->
        </div>
    </div>
    <div class= "row">
        <div class="col-lg-3 col-lg-offset-8">
            <form action="<?php echo base_url('Gestion/buscar_bebida/')?>" class="search-form" align='right' METHOD='POST'>
                <div class="form-group has-feedback">
                    <label for="search" class="sr-only">Buscar</label>
                    <input type="text" class="form-control" name="search_box" id="search_box" placeholder="Buscar por nombre...">
                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
            </form>
        </div>
            <div class = "col-lg-1">
                <a href="<?php echo site_url() ?>Gestion/nueva_bebida" class="btn btn-primary"  role="button">Añadir</a>
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
                            <th scope="col">¿Contiene alcohol?</th>
                            <th scope="col">Precio de compra unitario</th>
                            <th scope="col">Precio de venta unitario</th>
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
                                <td data-label="Alcohol"><?php if($clave[$k]['contiene_alcohol']==0) echo("No"); else echo("Sí"); ?></td>
                                <td data-label="Precio de compra unitario"><?php echo(number_format((float)$clave[$k]['precio_unitario'], 2, ',', '')." €")?></td>
                                <td data-label="Precio de venta unitario"><?php echo(number_format((float)$clave[$k]['precio_total'], 2, ',', '')." €") ?></td>
                                <td data-label="Modificar"><a href="<?php echo base_url('Gestion/modificar_bebida/'.$clave[$k]['id'])?>"><span class="glyphicon glyphicon-pencil" style="color:light_blue"></span></a></td>
                                <td data-label="Eliminar"><a onclick="if(confirma() == false) return false" href="<?php echo base_url('Gestion/eliminar_bebida/'.$clave[$k]['id'])?>"><span class="glyphicon glyphicon-remove" style="color:red"></span></a></td>
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