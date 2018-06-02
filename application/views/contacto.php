<!--A Design by W3layouts 
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>

<title>Contacto</title>

<!--content-->
	<div class="contact">
		<div class="container">
		<div class="menu-top">
				<div class="col-md-4 menu-left animated wow fadeInLeft" data-wow-duration="1000ms" data-wow-delay="500ms">
					<h3>Contacto</h3>
					
					<span>Información de contacto</span>
				</div>
				<div class="col-md-8 menu-right animated wow fadeInRight" data-wow-duration="1000ms" data-wow-delay="500ms">
					<p>Nuestras instalaciones,  están situadas en el centro de Jerez, desde donde os atenderemos para todo lo relacionado con la realizamos de los catering además en ellas disponemos de  espacio para dar clases de cocina y ofrecer sesiones de cocina en directo. También están preparadas para realizar eventos como cumpleaños y comuniones.</p>
				</div>
				<div class="clearfix"> </div>
			</div>
			<div class="contact-top">
			<div class="col-md-5 contact-map">
			<h5>Google Maps</h5>
			<div class="map animated wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="500ms">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3199.507499952413!2d-6.13568988423751!3d36.68634087997224!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd0dc69503296ead%3A0xbbc6e375df77251a!2sGemelas+al+Jerez+(Catering)!5e0!3m2!1ses!2ses!4v1525769383802" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>

			</div>
			<div class="address">
					      <h4>Catering Las Gemelas al Jerez</h4>
					      <p style="text-align: left;"> Dirección: Calle Clavel nº 10 Jerez de la Frontera</p>
						  <p style="text-align: left;">Teléfono: 665474092</p>				  
						  <p style="text-align: left;">Email : <a href="comercial@lasgemelasaljerez.com">comercial@lasgemelasaljerez.com</a></p>
						  <p style="text-align: left;">Email : <a href="virginia@lasgemelasaljerez.com">virginia@lasgemelasaljerez.com</a></p>
						  <p style="text-align: left;">Email : <a href="raquel@lasgemelasaljerez.com">raquel@lasgemelasaljerez.com</a></p>
					 </div>
			</div>

			<?php
		         echo form_open('/Contacto/send_mail'); 
		      ?> 

			<div class="col-md-7 contact-para animated wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="500ms">
			<h5> Formulario de Contacto</h5>

			<div class="col-md-10 col-md-offset-2"><h3 > <?php echo $this->session->flashdata('email_sent');?> </h3></div> 

	 			<form>
					<div class="grid-contact">
						<div class="col-md-6 contact-grid">
														
  							<p class="your-para">Nombre</p>	
							<input type="text" name="nombre" required="" oninvalid="this.setCustomValidity('Por favor rellene el campo nombre')" oninput="setCustomValidity('')"></input>
						</div>
						<div class="col-md-6 contact-grid">

							<p class="your-para">Asunto </p>
							<input type="text"  name=asunto required="" oninvalid="this.setCustomValidity('Por favor rellene el campo asunto')" oninput="setCustomValidity('')"
							 <?php if(!empty($asunto)) { ?> 
								value="<?php echo($asunto) ?>" readonly <?php } ?>></input>
						</div>
						
						<div class="clearfix"> </div>
					</div>
					
					<div class="grid-contact">
						<div class="col-md-6 contact-grid">
							
							<p class="your-para">Número de Teléfono</p>
							<input type="text" name="telefono" required="" oninvalid="this.setCustomValidity('Por favor rellene el campo teléfono')" oninput="setCustomValidity('')"></input>
						</div>
						<div class="col-md-6 contact-grid">
							
							<p class="your-para">Email</p>
							<input type="text" name="contacto" required="" oninvalid="this.setCustomValidity('Por favor rellene el campo correo electrónico')" oninput="setCustomValidity('')"></input>
						</div>
						<div class="clearfix"> </div>
					</div>
					
							<p class="your-para msg-para">Mensaje</p>
						<textarea cols="77" rows="6" name="mensaje" required="" oninvalid="this.setCustomValidity('Por favor rellene el campo comentario')" oninput="setCustomValidity('')"></textarea>				
			      
					<div class="send">
						<input type = "submit" value = "Enviar"> 
					</div>
			</form> 
		</div>	

      <?php 
         echo form_close();         
      ?>			

			<div class="clearfix"> </div>
		</div>
	</div>
	</div>
<!--footer-->
	
	<!--//footer-->

</body>
</html>