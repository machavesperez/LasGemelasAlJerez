<?php

class Nuestros_menus extends CI_Controller {

	function index() {
		$active['active'] = "servicio";
		$this->load->view('head2',$active);
		$this->load->view('nuestros_menus');
		$this->load->view('footer');
	}

	function menus_comunion() {
		$active['active'] = "servicio";
		$this->load->view('head2',$active);
		$this->load->view('menus_comunion');
		$this->load->view('footer');
	}

	function menus_local() {
		$active['active'] = "servicio";
		$this->load->view('head2',$active);
		$this->load->view('menus_local');
		$this->load->view('footer');
	}
}
?>