<footer>
	<div class="footer">
		<div class="container">
			<div class="footer-head">
				<div class="col-md-8 footer-top animated wow fadeInRight" data-wow-duration="1000ms" data-wow-delay="500ms">
					<ul class=" in">
					<div class= "propio">
						<li><a href="<?php echo site_url() ?>home">Inicio</a></li>
						<li><a  href="<?php echo site_url() ?>Blog/ver_noticias">Blog</a></li>
						<li><a  href="<?php echo site_url() ?>Acerca_de">Conócenos</a></li>
						<li><a  href="<?php echo site_url() ?>Nuestros_menus">Nuestros menús</a></li>		
						<li><a  href="<?php echo site_url() ?>Eventos/ver_eventos">Nuestros Eventos</a></li>
						<li><a  href="<?php echo site_url() ?>Contacto">Contacto</a></li>
						<li><a  href="<?php echo site_url() ?>Contratanos">Contrátanos</a></li>
						<li><a  href="#popupAdmin">Admin</a></li>
					</div>
					</ul>					
						<span style="color:white;">&nbsp;Las Gemelas al Jerez<br>
						<img src="<?php echo base_url() ?>/assets/img/logoweb1.png" style="height:20%;"></img></span>



				</div>
				<div class="col-md-4 footer-bottom  animated wow fadeInLeft" data-wow-duration="1000ms" data-wow-delay="500ms">
					<p style="font-family: 'Raleway', sans-serif;font-size: 2em;">Las Gemelas al Jerez</p>				
					<p>Calle Clavel nº 10 Jerez de la Frontera</p>
					<p>Teléfono:  665474092</p>
					<p>Email: comercial@lasgemelasaljerez.com</p>
					<br></br>
					<div class= "propio">
					<div class = "icon-redsocial">
				          <a class="fa fa-facebook fa-3x" style="size:3px; margin-left: 35px; " href="https://www.facebook.com/GemelasAlJerez/"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				          <a class="fa fa-twitter fa-3x" href="https://twitter.com/gemelasaljerez"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				          <a class="fa fa-instagram fa-3x" href="https://www.instagram.com/virginiamchef4/?hl=es"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				          <a class="fa fa-google-plus fa-3x" href="https://plus.google.com/u/0/collection/IXxSVE"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				          <!--<a class="fa fa-youtube-square fa-3x" href="#"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
				          
				    </div>
				</div>


				</div>
			<div class="clearfix"> </div>
					
			</div>
			<p class="footer-class animated wow bounce" data-wow-duration="1000ms" data-wow-delay="500ms"> 2017. Todos los Derechos Reservados por Las Gemelas al Jerez<a href="http://w3layouts.com/" target="_blank"></a></p>
		</div>
	</div>		
	<!--//footer-->

	<div id="popupAdmin" class="overlay">
    <div class="popup">
			<div class="wrapper">
			  <form class="form-signin" method="POST"  action="<?=base_url().'Login/verify_session'?>">       
			    <h2 class="form-signin-heading">Iniciar Sesion</h2>
			     <h3 style="color:green;" class="form-signin-heading"><?php echo $this->session->flashdata('mensaje'); ?></h3>
			    <input type="text" class="form-control" name="nombre" placeholder="Usuario" required autofocus />
			    <input type="password" class="form-control" name="pass" placeholder="Password" required />      
			    <!--<label class="checkbox">
			      <input type="checkbox" value="remember-me" id="rememberMe" name="rememberMe"> Recordarme
			    </label>-->
			    <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>   
			  </form>
			</div>
      <a class="close" href="#cerrar">&times;</a>
      </div>
  </div>

        <script type="text/javascript">
        	$('.message a').click(function(){
			   $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
			});
        </script>
</footer>