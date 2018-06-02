<script type="text/javascript">
function confirma(){
    if (confirm("¿Realmente desea eliminar esta receta?")) { 
        alert("La receta será eliminada.");
        return true;
    } else {
        return false;
    }
}
</script>

<style type="text/css">
<a.elit{
	font-size: 1em;
    color: #000;
    text-decoration: none;
    font-family: 'Raleway', sans-serif;
    font-weight: 700;
}
a.elit:hover{
	color:#000;
}
</style>

<title><?= $receta['nombre'] ?></title>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Receta <?= $receta['nombre'] ?></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class= "row">
        <h4 style="color:red;" class="form-signin-heading"><?php echo $this->session->flashdata('mensaje'); ?></h4>
        <div class="col-md-1 col-md-offset-11">
            <div class="container-contact1-form-btn">
                <?php if(!empty($menu)) { ?>
                    <a href="<?php echo base_url('Gestion/mostrar_recetas/'.$menu)?>".$menu class="btn btn-danger" role="button">Atrás</a>
                <?php } else { ?>
                    <a href="<?php echo base_url('Gestion/ver_receta')?>" class="btn btn-danger" role="button">Atrás</a>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="panel-body">
          	<div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-body">
                        	<img class="img-responsive" src="<?= $foto ?>" alt=" ">
                        	<br>
                            <h3><?= $receta['nombre'] ?></h3>
							<ul class="grid-blog">
                            <li><span><i class="glyphicon glyphicon-calendar"></i>Fecha de creación: <?= $receta['fecha'] ?></span></li>
							<li><span><i class="glyphicon glyphicon-time"> </i><?php if($receta['horas'] > 0) echo $receta['horas'].'h';?> <?= $receta['minutos']?>m</span></li>
                            <li><a href="<?= base_url()."Gestion/modificar_receta/".$receta['id']?>"><i class="glyphicon glyphicon-pencil"> </i>Modificar</a></li>
                            <li><a href="<?= base_url()."Gestion/eliminar_receta/".$receta['id']?>" onclick="return confirma()"><i class="glyphicon glyphicon-remove"> </i>Eliminar</a></li>
							</ul>
                            <p>Comensales: <?= $receta['comensales'] ?> </p>
                            <a class="elit" style="color:black;font-weight:bold;">Descripción:</a>
							<p class="wow fadeInLeft animated" data-wow-delay=".5s"><?= $receta['descripcion'] ?></p>
							<br>
							<a class="elit" style="color:black;font-weight:bold;">Ingredientes:</a>
							<br></br>
							<ul style="list-style-type: circle;">
								<?php foreach ($productos as $prod) { ?>
									<li> <?= $prod ?> </li>
								<?php } ?>
							</ul>
							<br>
							<a class="elit" style="color:black;font-weight:bold;">Instrucciones:</a>
								<br></br>
								<ul style="list-style-type: decimal;">
									<?php foreach ($instrucciones as $inst) { ?>
										<li> <?= $inst ?> </li>
									<?php } ?>
								</ul>
                        </div>
                        <div class="panel-footer">
                            <a class="elit" style="color:black;font-weight:bold;">Notas de la receta:</a>
							<br></br>
							<p><?= $receta['nota'] ?></p>
                            <p>Valoración: <?= $receta['valoracion'] ?> </p>
                        </div>
                    </div>
            </div>
            <div class="col-lg-4">
	            <div class="panel panel-default">
	                <div class="panel-heading" style="font-weight:bold;">
	                    <i class="glyphicon glyphicon-list-alt"></i> Últimas recetas
	                </div>

	                <div class="panel-body">
                        <?php foreach ($ultimas_recetas as $receta_id => $receta) {  ?>
        	                    <div class="row"> <!-- Cada div de row será una receta -->
        	                    	<div class="col-lg-4">
        	                    		<a href="<?= site_url() ?>Gestion/receta/<?= $receta_id?>" class="fashion"><img class="img-responsive " src="<?php $img = ( count( $receta['fotos'] ) == 0 ? site_url().'/assets/img/default.jpg' : site_url().reset($receta['fotos']) ) ?><?= $img ?>" alt="" style="float:left; margin:10px;"></a>
        	                    	</div>
        	                    	<div class="col-lg-8">
        									<a href="<?= site_url() ?>Gestion/receta/<?= $receta_id?>" class="elit"><?= $receta['nombre'] ?></a>
        									<p><?= $receta['descripcion'] ?></p>
        							</div>
        	                    </div>
                        <?php } ?>
	                </div>
	            </div>
            </div>

        </div>

        
            
            
        </div>

	</div>

</div>


