<script type="text/javascript">
function confirma(){
 if (confirm("¿Realmente desea eliminarlo?")){ 
 alert("El tipo de receta ha sido eliminado.") }
 else { 
 return false
 }
}
</script>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Lista de tipos de receta</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class= "row">
      <a href="<?php echo site_url() ?>Gestion/nuevo_tiporeceta" class="btn btn-primary" role="button">Añadir</a>
        <div class="col-md-3 col-md-offset-8">
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
                            <th scope="col">Nombre</th>
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
                                <td data-label="Modificar"><a href="<?php echo base_url('Gestion/modificar_tiporeceta/'.$clave[$k]['id'])?>"><span class="glyphicon glyphicon-pencil" style="color:light_blue"></span></a></td>
                                <td data-label="Eliminar"><a onclick="if(confirma() == false) return false" href="<?php echo base_url('Gestion/eliminar_tiporeceta/'.$clave[$k]['id'])?>"><span class="glyphicon glyphicon-remove" style="color:red"></span></a></td>
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