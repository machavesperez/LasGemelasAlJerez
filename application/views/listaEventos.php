<script type="text/javascript">
function confirma(){
 if (confirm("¿Realmente desea eliminarlo?")){ 
 alert("Se va a proceder con la eliminación.") }
 else { 
 return false
 }
}
</script>

<div id="page-wrapper">
     <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php if(!empty($busqueda)) echo("Búsqueda"); else echo("Lista");?> de eventos</h1>
            <!-- Con esa sentencia de php delimitamos si es una búsqueda o una muestra de activos -->
        </div>
    </div>
    <h3 style="color:red;" class="form-signin-heading"><?php echo $this->session->flashdata('mensaje'); ?></h3>
    <div class= "row">
        <div class="col-lg-3 col-lg-offset-8">
            <form action="<?php echo base_url('Gestion/buscar_evento/')?>" class="search-form" align='right' METHOD='POST'>
                <div class="form-group has-feedback">
                    <label for="search" class="sr-only">Buscar</label>
                    <input type="text" class="form-control" name="search_box" id="search_box" placeholder="Buscar por título...">
                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
            </form>
        </div>
            <div class = "col-lg-1">
                <a href="<?php echo site_url() ?>Gestion/nuevo_evento" class="btn btn-primary"  role="button">Añadir</a>
            </div>
    </div>
    <div class="row">
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Título</th>
                          <th scope="col">Descripción</th>
                          <th scope="col">Fecha</th>
                          <th scope="col">Lugar</th>
                          <th scope="col">Asistentes</th>
                          <th scope="col">Visible</th> 
                          <th scope="col">Menús</th>
                          <th scope="col">Materiales</th>
                          <th scope="col">Trabajadores</th>
                          <th scope="col">Lista compra</th>
                          <th scope="col">Beneficio</th>                         
                          <th scope="col">Modificar</th>
                          <th scope="col">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                          $id = 0;
                          foreach ($clave as $evento){ $id++;?>
                          <tr>
                            <td data-label="#"><?= $id ?></td>
                            <td data-label="Titulo"><?= $evento['titulo'] ?></td>
                            <!--<td data-label="Descripcion"><?= substr(($evento['descripcion']), 0, 50)."..." ?></td>-->
                            <?php $newtext = wordwrap($evento['descripcion'], 50, "<br />\n"); ?>  
                            <td data-label="Descripcion"><?= substr(($newtext), 0, 200)."..." ?></td>
                            
                            <td data-label="Fecha"><?= $evento['fecha'] ?></td>

                            <?php $newtext2 = wordwrap($evento['lugar'], 50, "<br />\n"); ?>
                            <td data-label="Lugar"><?= $newtext2 ?></td>

                            <td data-label="Asistentes"><?= number_format((int)$evento["persona"]) ?></td>
                            
                            <td data-label="Visible"><?php if($evento['es_visible']==0) echo("No"); else echo("Sí"); ?></td>

                            <td data-label="Menus"><a href="<?php echo base_url('Gestion/mostrar_menus/'.$evento['id'])?>"><span class="glyphicon glyphicon-list fa-fw" style="color:light_blue"></span></a></td>
                            <td data-label="Materiales"><a href="<?php echo base_url('Gestion/mostrar_materiales/'.$evento['id'])?>"><span class="glyphicon glyphicon-list fa-fw" style="color:light_blue"></span></a></td>
                            <td data-label="Trabajadores"><a href="<?php echo base_url('Gestion/mostrar_trabajadores/'.$evento['id'])?>"><span class="glyphicon glyphicon-list fa-fw" style="color:light_blue"></span></a></td>
                            <td data-label="Lista compra"><a href="<?php echo base_url('Gestion/generar_pdf_listaCompraEvento/'.$evento['id'])?>"><span class="glyphicon glyphicon-save-file" style="color:green"></span></a></td>
                            <td data-label="Beneficio"><a href="<?php echo base_url('Gestion/generar_pdf_beneficioEvento/'.$evento['id'])?>"><span class="glyphicon glyphicon-save-file" style="color:green"></span></a></td>
                            <td data-label="Modificar"><a href="<?php echo base_url('Gestion/modificar_evento/'.$evento['id'])?>"><span class="glyphicon glyphicon-pencil" style="color:light_blue"></span></a></td>
                            <td data-label="Eliminar"><a onclick="if(confirma() == false) return false" href="<?php echo base_url('Gestion/eliminar_evento/'.$evento['id'])?>"><span class="glyphicon glyphicon-remove" style="color:red"></span></a></td>
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