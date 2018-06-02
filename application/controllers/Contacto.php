<?php

class contacto extends CI_Controller 
	{
		function __construct()
		{
			parent::__construct();
        	$this->load->library('session');
        	$this->load->helper('form');			
		}

		function index()
		{
			$this->load->helper('form');
			$active['active'] = "contacto";
			$this->load->view('head2',$active);
			$this->load->view('contacto');
			$this->load->view('footer');
		}

		function enviar_email($asunto) {
			$asunto =urldecode($asunto);
			$this->load->helper('form');
			$active['active'] = "contacto";
			$active['asunto'] = $asunto;
			$this->load->view('head2',$active);
			$this->load->view('contacto');
			$this->load->view('footer');
		}

	    public function send_mail() {
	        	
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


	        $from_email = "lasgemelasdejerez@gmail.com";
	        $asunto = $this->input->post('asunto');
	        $nombre = $this->input->post('nombre');
	        $telefono = $this->input->post('telefono');
	        $contacto = $this->input->post('contacto');
	        $mensaje = $this->input->post('mensaje');
	       
	        //Load email library
	        $this->load->library('email', $config);
	        $this->email->from($contacto, 'Correo Sito Web Las Gemelas');
	        $this->email->to('pinfgruponn@gmail.com');
	        $this->email->subject($asunto);
	        $this->email->message("Nombre: ".$nombre."<br>Telefono: ".$telefono."<br>Email: ".$contacto."<br>Mensaje: ".$mensaje);
	        $this->email->set_newline("\r\n");
	        
	        //Send mail
	        if($this->email->send())
	            $this->session->set_flashdata("email_sent","El formulario se ha enviado satisfactoriamente.");
	        else
	            $this->session->set_flashdata("email_sent","El formulario no se ha podido envair.");
	        $this->email->print_debugger();

				$active['active'] = "contacto";
				$this->load->view('head2',$active);
				$this->load->view('contacto');
				$this->load->view('footer');
	    }

	}

?>