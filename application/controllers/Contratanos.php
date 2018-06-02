<?php

class contratanos extends CI_Controller 
	{
		function __construct()
		{
			parent::__construct();
		}

		function index()
		{
			$active['active']="evento";
			$this->load->view('head2',$active);
			$this->load->view('contratanos');
			$this->load->view('footer');
		}
	}

?>