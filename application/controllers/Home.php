<?php

class Home extends CI_Controller 
	{
		function __construct()
		{
			parent::__construct();
			$this->load->model('Noticia_model');
		}

		function index()
		{
			$consulta['noticias'] = $this->Noticia_model->get_noticias_blog();	

			$this->load->view('head');
			$this->load->view('home', $consulta);
			$this->load->view('footer');
		}
	}

?>