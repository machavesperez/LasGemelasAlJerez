<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('usuarios_model');
	}

	function verify_session(){
		$nombre = $this->input->post('nombre');
		if($this->usuarios_model->verify_user($nombre) and $this->usuarios_model->verify_sesion()){

				$usuario = $this->usuarios_model->get_user($nombre);

				// set array of items in session
        $arraydata = array(
        				'id' => $usuario->id,
                'username'  => $usuario->nombre,
                'email'     => $usuario->email                
        );
        $this->session->set_userdata($arraydata);
				redirect('/Gestion');
		} else {

				$this->session->set_flashdata('mensaje', 'Usuario y/o contraseña incorrectos.');
				redirect('/Home#popupAdmin');
		}
	}
	
}
?>