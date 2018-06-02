<script src="<?php echo base_url() ?>assets/js/home/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/js/receta/receta_prod.js" type="text/javascript"></script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Formulario de receta</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php if(isset($receta['id']) || isset($id)) echo "Modificar Receta";
                    else echo "Nueva Receta"; ?>
                </div>


                <div class="panel-body">

                    <?php if (validation_errors() or isset($error)): ?>
                        <div class="col-lg-14">
                            <div class="panel panel-red">
                                <div class="panel-heading">
                                    Errores en el formulario
                                </div>
                                <div class="panel-body">
                                    <?php echo validation_errors(); ?>
                                    <?=@$error?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    

                	<div class="contact1-pic js-tilt" data-tilt>
                        <?php if(isset($receta['fotos'])){?><img  src="<?= base_url().current($receta['fotos'])?>" alt="IMG" style="max-width:50%;width:auto;height:auto;">
                        <?php }else {?>
                        <i class="fa fa-cutlery fa-5x"></i>
                        <?php }?>
                    </div>

                    <div class="row">
                        <?php if(isset($id)) echo form_open_multipart(base_url()."Gestion/cambio_receta/".$id); 
                            else if(isset($receta['id'])) echo form_open_multipart(base_url()."Gestion/cambio_receta/".$receta['id']);
                            else echo form_open_multipart(base_url()."Gestion/crear_receta");?>
                             <div class="col-lg-5">
                            
                                <label>Foto de la Receta:</label>
                                <input class="form-control" type="file" name="userfile" /><br>

                                <label>Datos de la Receta:</label>
                                <label><?php if(isset($receta['fecha'])) echo $receta['fecha']?></label>

                                <div class="form-group" data-validate = "Por favor, rellene el campo Nombre">
                                    <input class="form-control" type="text" name="nombre" placeholder="Nombre de la receta" value="<?php if(isset($receta['nombre'])) echo $receta['nombre'];?>">
                                </div>

                                <div class="form-group">
                                    <textarea class="form-control" name="descripcion" rows="5" cols="55" placeholder="Descripción de la receta"><?php if(isset($receta['descripcion'])) echo $receta['descripcion']?></textarea>
                                </div> 

                                <div class="form-group">
                                    <textarea class="form-control" name="nota" rows="5" cols="55" placeholder="Nota adicional"><?php if(isset($receta['nota'])) echo $receta['nota']?></textarea>
                                </div>

                                <div class="form-group" data-validate = "Por favor, rellene el campo Comensales">
                                    <input class="form-control" type="text" name="comensales" placeholder="Número de Comensales" value="<?php if(isset($receta['comensales'])) echo $receta['comensales'];?>">
                                </div> 

                                <div class="form-group" data-validate = "Por favor, rellene el campo Tiempo">
                                    <input class="form-control" type="text" name="tiempo" placeholder="Tiempo de preparación (minutos)" value="<?php if(isset($receta['tiempo'])) echo $receta['tiempo'];?>">
                                </div> 

                                <div class="form-group" data-validate = "Por favor, rellene el campo Precio">
                                    <input class="form-control" type="text" name="precio" placeholder="Precio" value="<?php if(isset($receta['precio'])) echo $receta['precio'];?>">
                                </div>

                                <div class="form-group">
                                    <input class="form-control" type="text" name="valoracion" placeholder="Valoración" value="<?php if(isset($receta['valoracion'])) echo $receta['valoracion'];?>">
                                </div>

                                <label>Instrucciones:</label>
                                <?php if(!isset($receta['instrucciones'])){?>
                                <div id="input1" style="margin-bottom:4px;" class="clonedInputInst">
                                    <input class="form-control" type="text" name="inst[]" placeholder="Paso 1" />
                                </div>
                                <?php } else{ 
                                    foreach ($receta['instrucciones'] as $i => $inst) {?>
                                      <div id="input<?=$i?>" style="margin-bottom:4px;" class="clonedInputInst">
                                        <input class="form-control" type="text" name="inst[]" placeholder="Paso <?=$i?>" value="<?=$inst?>"/>
                                      </div>  
                                    
                                <?php }} ?>

                                <div>
                                    <input class="contact1-form-btn btn" type="button" id="btnAddInst" value="Añadir" />
                                    <input class="contact1-form-btn btn" type="button" id="btnDelInst" value="Quitar" />
                                </div>

                                <br></br>

                                <div class="container-contact1-form-btn">
                                    <button class="contact1-form-btn btn btn-primary" aria-hidden="true">Confirmar</button>
                                    <a href="<?php echo site_url() ?>Gestion/ver_receta" class="btn btn-danger" role="button">Atrás</a>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label>Ingredientes:</label>
                                    <?php if(!isset($receta['productos'])){ ?>
                                    <div id="select1" style="margin-bottom:4px;" class="clonedInput">
                                        Ingrediente:
                                        <select class="form-control" name="prod[0][id]" size="5">  
                                            <option value="none" selected="selected">Ninguno</option>
                                            <?php foreach ($productos as $producto) {
                                               echo("<option value=\"");
                                               echo $producto['id'];
                                               echo("\">");
                                               echo $producto['nombre'];
                                               echo(" - ");
                                               echo $producto['unidad'];
                                               echo("</option>"); 
                                            }?>
                                        </select>
                                    </div>

                                    <div id="cant1" style="margin-bottom:4px;">
                                        <input class="form-control" type="text" name="prod[0][cant]" placeholder="Cantidad" />
                                    </div>

                                    <div id="unit1" style="margin-bottom:4px;">
                                        <select class="form-control" name="prod[0][unit]">
                                            <option value="none" selected="selected">- Seleccione una unidad -</option>
                                            <option value="unidad">Unidad</option>
                                            <option value="kg">Kilogramo</option>
                                            <option value="hg">Hectogramo</option>
                                            <option value="dag">Decagramo</option>
                                            <option value="g">Gramo</option>
                                            <option value="dg">Decigramo</option>
                                            <option value="cg">Centigramo</option>
                                            <option value="mg">Miligramo</option>
                                            <option value="kl">Kilolitro</option>
                                            <option value="hl">Hectolitro</option>
                                            <option value="dal">Decalitro</option>
                                            <option value="l">Litro</option>
                                            <option value="dl">Decilitro</option>
                                            <option value="cl">Centilitro</option>
                                            <option value="ml">Mililitro</option>
                                            <option value="vaso">Vaso</option>
                                            <option value="taza">Taza</option>
                                            <option value="cucharada">Cucharada</option>
                                            <option value="cucharadita">Cucharadita</option>
                                        </select>
                                    </div>

                                    <div>
                                        <input class="contact1-form-btn btn" type="button" id="btnAdd" value="Añadir" />
                                        <input class="contact1-form-btn btn" type="button" id="btnDel" value="Quitar" />
                                    </div>
                                <?php } else { 
                                    if(isset($id)){
                                        $i = 1;
                                        foreach($receta['productos'] as $id => $prod){ ?>
                                            <div id="select<?=$i?>" style="margin-bottom:4px;" class="clonedInput">
                                            Ingrediente:
                                            <select class="form-control" name="prod[<?=$i-1?>][id]" size="5">  
                                                <option value="0">Ninguno</option>
                                                <?php foreach ($productos as $producto) {
                                                       echo("<option value=\"");
                                                       echo $producto['id'];
                                                       if($id == $producto['id']) echo("\" selected=\"true\">");
                                                       else echo("\">");
                                                       echo $producto['nombre'];
                                                       echo(" - ");
                                                       echo $producto['unidad'];
                                                       echo("</option>"); 
                                                   }?>
                                        </select>
                                    </div>

                                    <div id="cant<?=$i?>" style="margin-bottom:4px;">
                                        <input class="form-control" type="text" value="<?=explode(' ', explode('-', $prod)[1])[1]?>" name="prod[<?=$i-1?>][cant]" placeholder="Cantidad" />
                                    </div>

                                    <div id="unit<?=$i?>" style="margin-bottom:4px;">
                                        <select class="form-control" name="prod[<?=$i-1?>][unit]">
                                            <option value="unidad" <?php if(!strcmp(explode(' ', explode('-', $prod)[1])[2],"unidad")) echo "selected=\"true\""?>>Unidad</option>
                                            <option value="kg"<?php if(!strcmp(explode(' ', explode('-', $prod)[1])[2],"kg")) echo "selected=\"true\""?>>Kilogramo</option>
                                            <option value="hg"<?php if(!strcmp(explode(' ', explode('-', $prod)[1])[2],"hg")) echo "selected=\"true\""?>>Hectogramo</option>
                                            <option value="dag"<?php if(!strcmp(explode(' ', explode('-', $prod)[1])[2],"dag")) echo "selected=\"true\""?>>Decagramo</option>
                                            <option value="g"<?php if(!strcmp(explode(' ', explode('-', $prod)[1])[2],"g")) echo "selected=\"true\""?>>Gramo</option>
                                            <option value="dg"<?php if(!strcmp(explode(' ', explode('-', $prod)[1])[2],"dg")) echo "selected=\"true\""?>>Decigramo</option>
                                            <option value="cg"<?php if(!strcmp(explode(' ', explode('-', $prod)[1])[2],"cg")) echo "selected=\"true\""?>>Centigramo</option>
                                            <option value="mg"<?php if(!strcmp(explode(' ', explode('-', $prod)[1])[2],"mg")) echo "selected=\"true\""?>>Miligramo</option>
                                            <option value="kl"<?php if(!strcmp(explode(' ', explode('-', $prod)[1])[2],"kl")) echo "selected=\"true\""?>>Kilolitro</option>
                                            <option value="hl"<?php if(!strcmp(explode(' ', explode('-', $prod)[1])[2],"hl")) echo "selected=\"true\""?>>Hectolitro</option>
                                            <option value="dal">Decalitro</option>
                                            <option value="l"<?php if(!strcmp(explode(' ', explode('-', $prod)[1])[2],"l")) echo "selected=\"true\""?>>Litro</option>
                                            <option value="dl"<?php if(!strcmp(explode(' ', explode('-', $prod)[1])[2],"dl")) echo "selected=\"true\""?>>Decilitro</option>
                                            <option value="cl"<?php if(!strcmp(explode(' ', explode('-', $prod)[1])[2],"cl")) echo "selected=\"true\""?>>Centilitro</option>
                                            <option value="ml"<?php if(!strcmp(explode(' ', explode('-', $prod)[1])[2],"ml")) echo "selected=\"true\""?>>Mililitro</option>
                                            <option value="vaso"<?php if(!strcmp(explode(' ', explode('-', $prod)[1])[2],"vaso")) echo "selected=\"true\""?>>Vaso</option>
                                            <option value="taza"<?php if(!strcmp(explode(' ', explode('-', $prod)[1])[2],"taza")) echo "selected=\"true\""?>>Taza</option>
                                            <option value="cucharada"<?php if(!strcmp(explode(' ', explode('-', $prod)[1])[2],"cucharada")) echo "selected=\"true\""?>>Cucharada</option>
                                            <option value="cucharadita"<?php if(!strcmp(explode(' ', explode('-', $prod)[1])[2],"cucharadita")) echo "selected=\"true\""?>>Cucharadita</option>
                                        </select>
                                    </div>
                                    
                                    <?php $i++;} } else{ $i = 1;
                                        foreach($receta['productos'] as $prod){ ?>
                                            <div id="select<?=$i?>" style="margin-bottom:4px;" class="clonedInput">
                                            Ingrediente:
                                            <select class="form-control" name="prod[<?=$i-1?>][id]" size="5">  
                                                <option value="0">Ninguno</option>
                                                <?php foreach ($productos as $producto) {
                                                       echo("<option value=\"");
                                                       echo $producto['id'];
                                                       if($prod['id'] == $producto['id']) echo("\" selected=\"true\">");
                                                       else echo("\">");
                                                       echo $producto['nombre'];
                                                       echo(" - ");
                                                       echo $producto['unidad'];
                                                       echo("</option>"); 
                                                   }?>
                                            </select>
                                    </div>

                                    <div id="cant<?=$i?>" style="margin-bottom:4px;">
                                        <input class="form-control" type="text" value="<?=$prod['cant']?>" name="prod[<?=$i-1?>][cant]" placeholder="Cantidad" />
                                    </div>

                                    <div id="unit<?=$i?>" style="margin-bottom:4px;">
                                        <select class="form-control" name="prod[<?=$i-1?>][unit]">
                                            <option value="unidad" <?php if(!strcmp($prod['unit'],"unidad")) echo "selected=\"true\""?>>Unidad</option>
                                            <option value="kg"<?php if(!strcmp($prod['unit'],"kg")) echo "selected=\"true\""?>>Kilogramo</option>
                                            <option value="hg"<?php if(!strcmp($prod['unit'],"hg")) echo "selected=\"true\""?>>Hectogramo</option>
                                            <option value="dag"<?php if(!strcmp($prod['unit'],"dag")) echo "selected=\"true\""?>>Decagramo</option>
                                            <option value="g"<?php if(!strcmp($prod['unit'],"g")) echo "selected=\"true\""?>>Gramo</option>
                                            <option value="dg"<?php if(!strcmp($prod['unit'],"dg")) echo "selected=\"true\""?>>Decigramo</option>
                                            <option value="cg"<?php if(!strcmp($prod['unit'],"cg")) echo "selected=\"true\""?>>Centigramo</option>
                                            <option value="mg"<?php if(!strcmp($prod['unit'],"mg")) echo "selected=\"true\""?>>Miligramo</option>
                                            <option value="kl"<?php if(!strcmp($prod['unit'],"kl")) echo "selected=\"true\""?>>Kilolitro</option>
                                            <option value="hl"<?php if(!strcmp($prod['unit'],"hl")) echo "selected=\"true\""?>>Hectolitro</option>
                                            <option value="dal">Decalitro</option>
                                            <option value="l"<?php if(!strcmp($prod['unit'],"l")) echo "selected=\"true\""?>>Litro</option>
                                            <option value="dl"<?php if(!strcmp($prod['unit'],"dl")) echo "selected=\"true\""?>>Decilitro</option>
                                            <option value="cl"<?php if(!strcmp($prod['unit'],"cl")) echo "selected=\"true\""?>>Centilitro</option>
                                            <option value="ml"<?php if(!strcmp($prod['unit'],"ml")) echo "selected=\"true\""?>>Mililitro</option>
                                            <option value="vaso"<?php if(!strcmp($prod['unit'],"vaso")) echo "selected=\"true\""?>>Vaso</option>
                                            <option value="taza"<?php if(!strcmp($prod['unit'],"taza")) echo "selected=\"true\""?>>Taza</option>
                                            <option value="cucharada"<?php if(!strcmp($prod['unit'],"cucharada")) echo "selected=\"true\""?>>Cucharada</option>
                                            <option value="cucharadita"<?php if(!strcmp($prod['unit'],"cucharadita")) echo "selected=\"true\""?>>Cucharadita</option>
                                        </select>
                                    </div>
                                    
                                    <?php $i++;} }  ?>
                                    <div>
                                        <input class="contact1-form-btn btn" type="button" id="btnAdd" value="Añadir" />
                                        <input class="contact1-form-btn btn" type="button" id="btnDel" value="Quitar" />
                                    </div>
                                <?php }?>

                                </div>
                            <?=form_close()?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>