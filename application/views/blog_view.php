<!--A Design by W3layouts 
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>

<title>Blog</title>

<!--content-->
	<div class="content">
	<div class="events">
		<div class="container">
			<div class="events-top">
				<div class="col-md-4 events-left animated wow fadeInLeft" data-wow-duration="1000ms" data-wow-delay="500ms">
					<h3>Blog</h3>
					
					<span>Portal de noticias</span>
				</div>
				<div class="col-md-8 events-right animated wow fadeInRight" data-wow-duration="1000ms" data-wow-delay="500ms">
					<p>Aqui os enseñamos todas nuestras novedades....</p>
				</div>
				<div class="clearfix"> </div>
			</div>
			<?php
				$i = 1;
				foreach ($noticias as $noticia) { 
					if($i % 2){
					?>
					<div class="events-bottom">
						<div class="col-md-5 events-bottom1 animated wow fadeInRight" data-wow-duration="1000ms" data-wow-delay="500ms">
							<a style="text-decoration:none;" href="<?= base_url()?>Blog/Noticia/<?= $noticia['id'] ?>"><img src="<?= base_url().$noticia['foto']?>" alt="" class="img-responsive"></a>
						</div>
						<div class="col-md-7 events-bottom2 animated wow fadeInLeft" data-wow-duration="1000ms" data-wow-delay="500ms">
							<a style="text-decoration:none;" href="<?= base_url()?>Blog/Noticia/<?= $noticia['id'] ?>"><h3><?= $noticia['titulo'] ?></h3></a>
							
							<p><?= $noticia['descripcion'] ?></p>
							<p><?= $noticia['fecha'] ?></p>
							<div class="read-more">						
								<a style="text-decoration:none;" class="link link-yaku" href="<?= base_url()?>Blog/Noticia/<?= $noticia['id'] ?>">
									<span>L</span><span>E</span><span>E</span><span>R</span> <span>M</span><span>Á</span><span>S</span>				
								</a>
							</div>
						</div>
						<div class="clearfix"> </div>
					</div>
				<?php }else { ?>
					<div class="events-bottom">
								<div class="col-md-7 events-bottom2 animated wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="500ms">
									<a style="text-decoration:none;" href="<?= base_url()?>Blog/Noticia/<?= $noticia['id'] ?>"><h3><?= $noticia['titulo'] ?></h3></a>
									
									<p><?= $noticia['descripcion'] ?></p>
									<p><?= $noticia['fecha'] ?></p>
									<div class="read-more">						
										<a style="text-decoration:none;" class="link link-yaku" href="<?= base_url()?>Blog/Noticia/<?= $noticia['id'] ?>">
											<span>L</span><span>E</span><span>E</span><span>R</span> <span>M</span><span>Á</span><span>S</span>
										</a>
									</div>
								</div>
								<div class="col-md-5 events-bottom1 animated wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="500ms">
									<a style="text-decoration:none;" href="<?= base_url()?>Blog/Noticia/<?= $noticia['id'] ?>"><img src="<?= base_url().$noticia['foto']?>" alt="" class="img-responsive"></a>
								</div>
								<div class="clearfix"> </div>
							</div>
				<?php }$i++;} echo $this->pagination->create_links() ?>

				<div class="clearfix"> </div>
				
			</div>
		</div>
	</div>
</div>
<!--footer-->
	
	<!--//footer-->

</body>
</html>