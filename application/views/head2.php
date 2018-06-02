<head>
	<link href="<?php echo base_url() ?>/assets/css/home/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="<?php echo base_url() ?>/assets/js/home/jquery.min.js" type="text/javascript"></script>
<!-- Custom Theme files -->
<!--theme-style-->
<link href="<?php echo base_url() ?>/assets/css/home/style.css" rel="stylesheet" type="text/css" media="all" />	
<!--//theme-style-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Cookery Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!---->
<link href='//fonts.googleapis.com/css?family=Raleway:400,200,100,300,500,600,700,800,900' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link href="<?php echo base_url() ?>/assets/css/home/popup.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<link href="<?php echo base_url() ?>/assets/css/home/styles.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/assets/css/home/styleSlider.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/assets/css/home/elastislide.css" />
<link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow&v1' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css' />

<!-- animation-effect -->
<link href="<?php echo base_url() ?>/assets/css/home/animate.min.css" rel="stylesheet"> 
<script src="<?php echo base_url() ?>/assets/js/home/wow.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/slider/jquery.tmpl.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/slider/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/slider/jquery.elastislide.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/slider/gallery.js"></script>
<script>
 new WOW().init();
</script>
<!-- //animation-effect -->



<div class="header head">
	<div class="container">
		<div class="logo animated wow pulse" data-wow-duration="1000ms" data-wow-delay="500ms">
			<h1><a href="<?php echo base_url() ?>home"><img src="<?php echo base_url() ?>/assets/img/menulasgemelas3.png" alt=""></a></h1>
		</div>
		<div class="nav-icon" >		
			<a href="#" class="navicon"></a>
				<div class="toggle">
					<ul class="toggle-menu">
						<li><a  href="<?php echo site_url() ?>home">Inicio</a></li>
						<li><a <?php if(!empty($active)){if($active == 'blog') echo"class='active'";} ?> href='<?php echo site_url() ?>Blog/ver_noticias'>Blog</a></li>
						<li><a <?php if(!empty($active)){if($active == 'acerca') echo"class='active'";} ?> href="<?php echo site_url() ?>Acerca_de">Conócenos</a></li>
						<li><a <?php if(!empty($active)){if($active == 'servicio') echo"class='active'";} ?> href="<?php echo site_url() ?>Nuestros_menus">Nuestros menús</a></li>		
						<li><a <?php if(!empty($active)){if($active == 'ultimo') echo"class='active'";} ?> href="<?php echo site_url() ?>Eventos/ver_eventos">Nuestros eventos</a></li>
						<li><a <?php if(!empty($active)){if($active == 'contacto') echo"class='active'";} ?> href="<?php echo site_url() ?>Contacto">Contacto</a></li>
						<li><a <?php if(!empty($active)){if($active == 'evento') echo"class='active'";} ?> href="<?php echo site_url() ?>Contratanos">Contrátanos</a></li>
					</ul>
				</div>
			<script>
			$('.navicon').on('click', function (e) {
			  e.preventDefault();
			  $(this).toggleClass('navicon--active');
			  $('.toggle').toggleClass('toggle--active');
			});
			</script>
		</div>
	<div class="clearfix"></div>
	</div>
	<!-- start search-->	
		
</div>

</head>
