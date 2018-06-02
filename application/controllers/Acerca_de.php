<?php

class Acerca_de extends CI_Controller 
	{
		function __construct()
		{
			parent::__construct();
		}

		function index()
		{
			$active['active'] = "acerca"; 
			$this->load->view('head2',$active);
			$this->load->view('acerca_de_view');
			$this->load->view('footer');
		}
	}

?>