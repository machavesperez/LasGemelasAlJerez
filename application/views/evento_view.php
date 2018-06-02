<!DOCTYPE html>
<html>
<title><?= $evento['titulo_noticia'] ?></title>
<noscript>
			<style>
				.es-carousel ul{
					display:block;
				}
			</style>
		</noscript>
		<script id="img-wrapper-tmpl" type="text/x-jquery-tmpl">	
			<div class="rg-image-wrapper">
				{{if itemsCount > 1}}
					<div class="rg-image-nav">
						<a href="#" class="rg-image-nav-prev">Previous Image</a>
						<a href="#" class="rg-image-nav-next">Next Image</a>
					</div>
				{{/if}}
				<div class="rg-image"></div>
				<div class="rg-loading"></div>
				<div class="rg-caption-wrapper">
					<div class="rg-caption" style="display:none;">
						<p></p>
					</div>
				</div>
			</div>
		</script>

<!--content-->
	<div class="blog">
	<div class="container">
		<div class="col-md-9 ">
			<div class="single">
				<div class="single-top">
				<div class="lone-line">
					<h4><?= $evento['titulo_noticia'] ?></h4>
					<h5><?= str_replace("\n", "<br>", $evento['descripcion_noticia']) ?></h5>
					<img class="img-responsive wow fadeInUp animated" data-wow-delay=".5s" src="<?= base_url().$evento['foto']?>" alt="" />
						<ul class="grid-blog">
							<li><span><i class="glyphicon glyphicon-time"> </i><?= $evento['fecha_noticia'] ?></span></li>
							<li><span>Compartir: </span>
											<a href="https://twitter.com/share?text=¡Mira este evento de Las Gemelas al Jerez! - <?=$evento['titulo_noticia']?>&url=<?=base_url()."Eventos/Evento/".$evento['id']?>" onclick="window.open(this.href, this.target, 'width=500,height=400'); return false;"><i class="fa fa-twitter-square" style="font-size:24px"> </i></a>

											<a href="https://www.facebook.com/sharer.php?u=<?=base_url()."Eventos/Evento/".$evento['id']?>" onclick="window.open(this.href, this.target, 'width=600,height=600'); return false;" rel="<?= base_url().$evento['foto'] ?>"><i class="fa fa-facebook-square" style="font-size:24px"> </i></a>
					  
										  <a href="https://plus.google.com/share?url=<?=base_url()."Eventos/Evento/".$evento['id']?>" onclick="window.open(this.href, this.target, 'width=600,height=600'); return false;" rel="<?= base_url().$evento['foto'] ?>"><i class="fa fa-google-plus-square" style="font-size:24px"> </i></a>

							</li>
						</ul>
							<p style="text-align:left"><?= str_replace("\n", "<br>", $evento['descripcion_noticia']) ?></p>
				</div>
				<div class="clearfix"> </div>
				
		</div>

		<!--CONTENIDO DEL EVENTO-->
		<h3>Información del evento - <?= $evento['titulo_evento'] ?></h3>
		<h4>Descripción: <?= str_replace("\n", "<br>", $evento['descripcion_evento']) ?></h4>
		<h4>Fecha: <?= $evento['fecha_evento']?></h4>
		<h4>Lugar: <?= $evento['lugar']?></h4>
		<h4>Asistentes: <?= $evento['asistentes']?></h4>

		<?php if(isset($galeria[0])){?>
		<div class="lone-line">
					<div class="comment">
					<h3>Galería de Imágenes</h3>

		<div class="container">
			<div class="col-md-8">
				<div id="rg-gallery" class="rg-gallery">
					<div class="rg-thumbs">
						<!-- Elastislide Carousel Thumbnail Viewer -->
						<div class="es-carousel-wrapper">
							<div class="es-carousel">
								<ul>
									<?php foreach($galeria as $foto) { ?>
									<li><a href="#"><img src="<?= base_url().$foto['ruta'] ?>" data-large="<?= base_url().$foto['ruta'] ?>" /></a></li>
									<?php } ?>
								</ul>
							</div>
						</div>
						<!-- End Elastislide Carousel Thumbnail Viewer -->
					</div><!-- rg-thumbs -->
				</div><!-- rg-gallery -->
				
			</div><!-- content -->
		</div><!-- container -->
				</div>
		</div>
		<?php } ?>
		
		<!--AGRADECIMIENTOS-->
		<?php if(isset($agradecimientos[0])){?>
		<div class="comment">
							<h3>Agradecimientos</h3>
							<?php foreach ($agradecimientos as $agradecimiento) {?>
	
							 <div class="media wow fadeInLeft animated" data-wow-delay=".5s">
								<div class="code-in">
									<p class="smith"><a><?= $agradecimiento['nota']?></a> <span><?= $agradecimiento['fecha']?></span></p>
									<div class="clearfix"> </div>
								</div>
								<!--
							    <div class="media-left">
							        <a href="#">
							        	<img src="<?= base_url() ?>/assets/img/si1.jpg" alt="">
							        </a>
							     </div>-->
							    <div class="media-left">
		
									<p>Comentario: <?= $agradecimiento['comentario']?></p>
									<p><?= $agradecimiento['agradecimiento']?></p>
							      </div>
							    </div>
							    <?php }?>
						 </div>
		<?php }?>
						
						<br></br>
						<br></br>
		
</div>

				<?php

		         echo form_open('/Eventos/enviar_comentario/'.$evento['id']); 
		      ?> 
	<div class="leave">
		<h3>Añadir Comentario</h3>

			<div class="col-md-9 col-md-offset-2"><h2> <?php echo $this->session->flashdata('email_sent');?> </h2></div> 

			<form>
				<div class="single-grid wow fadeInLeft animated" data-wow-delay=".5s">
						
						<input placeholder="Nombre" type="text" name="nombre" required="" oninvalid="this.setCustomValidity('Por favor rellene el campo nombre')" oninput="setCustomValidity('')"></input>
						<input placeholder="Correo electrónico" type="text" name="contacto"required="" oninvalid="this.setCustomValidity('Por favor rellene el campo correo electrónico')" oninput="setCustomValidity('')"></input>
						<textarea placeholder="Comentario" name="mensaje" required="" oninvalid="this.setCustomValidity('Por favor rellene el campo comentario')" oninput="setCustomValidity('')"></textarea>
					<label class="hvr-rectangle-out">
							<input type="submit" value="Enviar">
					</label>						
			</div>
			</form>
		</div>
		      <?php 
         echo form_close(); 	
         //echo $this->session->flashdata('email_sent'); 
      ?>
<!---->
<!--//content-->
		</div>
		
		<div class="col-md-3 categories-grid">
			<!--<div class="search-in animated wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="500ms">
				<h4>Buscar</h4>
					<div class="search">
					<form>
						<input type="text" placeholder="Buscar" required="" >
						<input type="submit" value="" >
					</form>
					</div>
			</div>-->

			<!--ULTIMOS EVENTOS-->
				<div class="blog-bottom animated wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="500ms">
						<h4>Últimos eventos</h4>
						<?php  for($i=0; $i<5; $i++) { 
							if(isset($eventos[$i])) { ?>
							<div class="product-go">
								<a href="<?= $eventos[$i]['id'] ?>" class="fashion"><img class="img-responsive " src="<?= base_url().$eventos[$i]['foto']?>" alt=""></a>
								<div class="grid-product">
									<a href="<?= $eventos[$i]['id'] ?>" class="elit"><?= $eventos[$i]['titulo'] ?></a>
									<p style="text-align:left"><?= substr($eventos[$i]['descripcion'], 0, 50)."..." ?></p>
								</div>

							<div class="clearfix"> </div>
						</div>
							<?php }} ?>
						
							
						
					</div>
					<br><br><br>

					<!-- ULTIMAS NOTICIAS -->
				<div class="blog-bottom animated wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="500ms">
						<h4>Últimas noticias</h4>
						<?php  for($i=0; $i<5; $i++) { 
							if(isset($noticias[$i])) { ?>
							<div class="product-go">
								<a href="<?= base_url()."Blog/Noticia/".$noticias[$i]['id'] ?>" class="fashion"><img class="img-responsive " src="<?= base_url().$noticias[$i]['foto'] ?>" alt=""></a>
								<div class="grid-product">
									<a href="<?= base_url()."Blog/Noticia/".$noticias[$i]['id'] ?>" class="elit"><?= $noticias[$i]['titulo'] ?></a>
									<p style="text-align:left"><?= substr($noticias[$i]['descripcion'], 0, 50)."..." ?></p>
								</div>

							<div class="clearfix"> </div>
						</div>
							<?php }} ?>
						
							
						
					</div>
				</div>
			</div>
		</div>
</body>
</html>