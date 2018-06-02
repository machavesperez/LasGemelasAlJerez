<?php

class Blog extends CI_Controller 
	{
		function __construct()
		{
			parent::__construct();
			$this->load->library('pagination'); //Cargamos la librería de paginación
			$this->load->model('Noticia_model');
			$this->load->model('Evento_model');
		}

		function index() {
			redirect("Blog/ver_noticias");
		}

		function ver_noticias() {
			$num_paginas = 5; // Noticias mostrados por página
			$config['base_url'] = base_url().'Blog/ver_noticias/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Noticia_model->get_total_noticias_blog(); // Calcula el número de noticias
			$config['per_page'] = $num_paginas; // Número de noticias mostrados por cada página
			$config['num_links'] = 5; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 3; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 
			$consulta['noticias'] = $this->Noticia_model->get_noticias_blog_paginadas($config['per_page'], $this->uri->segment(3)); 
    		
	    	$active['active'] = "blog";
			$this->load->view('head2',$active);
	    	$this->load->view('blog_view', $consulta);
	    	$this->load->view('footer');
		}

		function noticia($id_noticia)
		{
			if(!isset($id_noticia)){
				redirect("Blog");
			}
			else{
				$noticia = $this->Noticia_model->get_noticia_by_id($id_noticia);
				if(!isset($noticia[0])){
					$active['active'] = "blog";
					$this->load->view('head2',$active);
					$this->load->view('error_404_view');
					$this->load->view('footer');
				}
				else{
					$consulta['noticia'] = $noticia[0];
					$consulta['galeria'] = $this->Noticia_model->get_fotos_noticia($id_noticia);
					$consulta['noticias'] = $this->Noticia_model->get_noticias_blog();
					$consulta['eventos'] = $this->Evento_model->get_eventos_ultimoseventos();

					$active['active'] = "blog";
					$this->load->view('head2',$active);
					$this->load->view('noticia', $consulta);
					$this->load->view('footer');
				}
			}	
		}

	    function enviar_comentario($id_noticia) {
	        	
			$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'ssl://smtp.googlemail.com',
				'smtp_port' => 465,
				'smtp_user' => 'lasgemelasdejerez@gmail.com', 
				'smtp_pass' => 'lasgemelasmasterchef', 
				'mailtype' => 'html',
				'charset' => 'UFT-8',
				'wordwrap' => TRUE
			);
  
			$noticia = $this->Noticia_model->get_noticia_by_id($id_noticia);

			foreach($noticia as $row)
				$asunto = "Comentario noticia ".$row['titulo'];

	       	$from_email = "lasgemelasdejerez@gmail.com";

	        $nombre = $this->input->post('nombre');
	        $contacto = $this->input->post('contacto');
	        $mensaje = $this->input->post('mensaje');
	       
	        //Load email library
	        $this->load->library('email', $config);
	        $this->email->from($from_email, 'Correo Sito Web Las Gemelas');
	        $this->email->to('pinfgruponn@gmail.com');
	        $this->email->subject($asunto);
	        $this->email->message("Nombre: ".$nombre."<br>Email: ".$contacto."<br>Mensaje: ".$mensaje);
	        $this->email->set_newline("\r\n");
	        
	        //Send mail
	        if($this->email->send())
	            $this->session->set_flashdata("email_sent","El comentario se ha enviado satisfactoriamente.");
	        else
	            $this->session->set_flashdata("email_sent","El comentario no se ha podido enviar.");
	        	$this->email->print_debugger();
				//$this->load->helper('form');

				$consulta['noticia'] = $noticia[0];
				$consulta['galeria'] = $this->Noticia_model->get_fotos_noticia($id_noticia);
				$consulta['noticias'] = $this->Noticia_model->get_noticias_blog();

				$active['active'] = "blog";
				$this->load->view('head2',$active);
				$this->load->view('noticia', $consulta);
				$this->load->view('footer');
	    }
	}

?>