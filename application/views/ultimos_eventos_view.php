<!--A Design by W3layouts 
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>

<title>Últimos Eventos</title>

<!--content-->
	<div class="content">
	<div class="events">
		<div class="container">
			<div class="events-top">
				<div class="col-md-4 events-left animated wow fadeInLeft" data-wow-duration="1000ms" data-wow-delay="500ms">
					<h3>Eventos</h3>
					
					<span>Últimos eventos</span>
				</div>
				<div class="col-md-8 events-right animated wow fadeInRight" data-wow-duration="1000ms" data-wow-delay="500ms">
					<p>Puedes ver los eventos que realizamos.</p>
				</div>
				<div class="clearfix"> </div>
			</div>
			<?php
				$i = 1;
				foreach ($eventos as $evento) { 
					if($i % 2){
					?>
					<div class="events-bottom">
						<div class="col-md-5 events-bottom1 animated wow fadeInRight" data-wow-duration="1000ms" data-wow-delay="500ms">
							<a href="<?= base_url()?>Eventos/Evento/<?= $evento['id'] ?>"><img src="<?= base_url().$evento['foto']?>" alt="" class="img-responsive"></a>
						</div>
						<div class="col-md-7 events-bottom2 animated wow fadeInLeft" data-wow-duration="1000ms" data-wow-delay="500ms">
							<a href="<?= base_url()?>Eventos/Evento/<?= $evento['id'] ?>"><h3><?= $evento['titulo'] ?></h3></a>
							<label><i class="glyphicon glyphicon-menu-up"></i></label>
							<p><?= $evento['descripcion'] ?></p>
							<p><?= $evento['fecha'] ?></p>
							<div class="read-more">						
								<a class="link link-yaku" href="<?= base_url()?>Eventos/Evento/<?= $evento['id'] ?>">
									<span>L</span><span>E</span><span>E</span><span>R</span> <span>M</span><span>Á</span><span>S</span>				
								</a>
							</div>
						</div>
						<div class="clearfix"> </div>
					</div>
				<?php }else { ?>
					<div class="events-bottom">
								<div class="col-md-7 events-bottom2 animated wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="500ms">
									<a href="<?= base_url()?>Eventos/Evento/<?= $evento['id'] ?>"><h3><?= $evento['titulo'] ?></h3></a>
									<label><i class="glyphicon glyphicon-menu-up"></i></label>
									<p><?= $evento['descripcion'] ?></p>
									<p><?= $evento['fecha'] ?></p>
									<div class="read-more">						
										<a class="link link-yaku" href="<?= base_url()?>Eventos/Evento/<?= $evento['id'] ?>">
											<span>L</span><span>E</span><span>E</span><span>R</span> <span>M</span><span>Á</span><span>S</span>
										</a>
									</div>
								</div>
								<div class="col-md-5 events-bottom1 animated wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="500ms">
									<a href="<?= base_url()?>Eventos/Evento/<?= $evento['id'] ?>"><img src="<?= base_url().$evento['foto']?>" alt="" class="img-responsive"></a>
								</div>
								<div class="clearfix"> </div>
							</div>
				<?php }$i++;} echo $this->pagination->create_links(); ?>
			
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
</div>
<!--footer-->
	
	<!--//footer-->

</body>
</html>