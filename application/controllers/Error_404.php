<?php

class Error_404 extends CI_Controller 
	{
		function __construct()
		{
			parent::__construct();
		}

		function index()
		{
			$this->load->view('head2');
			$this->load->view('error_404_view');
			$this->load->view('footer');
		}
	}

?>