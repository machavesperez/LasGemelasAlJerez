<?php

class Eventos extends CI_Controller 
	{
		function __construct()
		{
			parent::__construct();
			$this->load->model('Evento_model');
			$this->load->model('Noticia_model');
			$this->load->library('pagination'); //Cargamos la librería de paginación
		}

		function index() {
			redirect("eventos/ver_eventos");
		}

		function ver_eventos() {
			$num_paginas = 5; // Eventos mostrados por página
			$config['base_url'] = base_url().'Eventos/ver_eventos/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Evento_model->get_total_ultimoseventos(); // Calcula el número de eventos
			$config['per_page'] = $num_paginas; // Número de eventos mostrados por cada página
			$config['num_links'] = 5; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 3; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 
			$consulta['eventos'] = $this->Evento_model->get_eventos_ultimoseventos_paginados($config['per_page'], $this->uri->segment(3)); 
    		
	    	$active['active'] = "ultimo";
			$this->load->view('head2',$active);
	    	$this->load->view('ultimos_eventos_view', $consulta);
	    	$this->load->view('footer');
		}


/*		function noticia($id_noticia)
		{
			$consulta['noticia'] = $this->Noticia_model->get_noticia_id($id_noticia);
			$consulta['fotos'] = $this->Noticia_model->get_noticia_fotos($id_noticia);
			$consulta['noticias'] = $this->Noticia_model->get_noticias_blog();

			$this->load->view('head2');
			$this->load->view('noticia', $consulta);
			$this->load->view('footer');
		}*/

		function evento($id_evento)
		{
			if(!isset($id_evento)){
				redirect("Eventos");
			}
			else{
				$evento = $this->Evento_model->get_evento_by_id($id_evento);
				if(!isset($evento[0])){
					$active['active'] = "ultimo";
					$this->load->view('head2',$active);
					$this->load->view('error_404_view');
					$this->load->view('footer');
				}
				else{
					$consulta['evento'] = $evento[0];
					$consulta['galeria'] = $this->Evento_model->get_evento_fotos($id_evento);
					$consulta['eventos'] = $this->Evento_model->get_eventos_ultimoseventos();
					$consulta['noticias'] = $this->Noticia_model->get_noticias_blog();
					$consulta['agradecimientos'] = $this->Noticia_model->get_agradecimientos($evento[0]['id_noticia']);

					$active['active'] = "ultimo";
					$this->load->view('head2',$active);
					$this->load->view('evento_view', $consulta);
					$this->load->view('footer');
				}
			}		
		}

		function enviar_comentario($id_evento) {
	        	
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
  
			$evento = $this->Evento_model->get_evento_by_id($id_evento);

			foreach($evento as $row)
				$asunto = "Comentario evento ".$row['titulo_evento'];

	       	$from_email = "lasgemelasdejerez@gmail.comm";

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

			$consulta['evento'] = $evento[0];
			$consulta['galeria'] = $this->Evento_model->get_evento_fotos($id_evento);
			$consulta['eventos'] = $this->Evento_model->get_eventos_ultimoseventos();
			$consulta['agradecimientos'] = $this->Noticia_model->get_agradecimientos($evento[0]['id_noticia']);

			$active['active'] = "ultimo";
			$this->load->view('head2',$active);
			$this->load->view('evento_view', $consulta);
			$this->load->view('footer');
	    }

	}

?>