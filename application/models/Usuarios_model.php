<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Usuarios_model extends CI_Model {
	public function __construct(){
		parent::__construct();
	}
	
	//Comprueba si el usuario existe o no
	public function verify_user($user){
		$consulta = $this->db->get_where('Usuario', array('nombre' => $user));
		$fila = $consulta->row();
		return isset($fila);
	}

	//añade un usuario
	public function add_usuario(){

		$pass = $this->input->post('pass' , TRUE );
		$hash = password_hash($pass, PASSWORD_DEFAULT);

		$this->db->insert('Usuario' , array(
			'nombre' => $this->input->post('nombre' , TRUE ), 
			'pass' => $hash, 
			'email' => $this->input->post('email' , TRUE )));
	}
	
	//verifica usuario y contraseña
	public function verify_sesion(){

		$consulta = $this->db->get_where('Usuario' , array('nombre' => $this->input->post('nombre' , TRUE )));
		$fila = $consulta->row();
		$hash = $fila->pass;

		$pass = $this->input->post('pass' , TRUE);

		return password_verify($pass,$hash);
	}

	public function get_user($nombre){
		return $this->db->get_where('Usuario', array('nombre' => $nombre))->row();
	}

	//cambiar el nombre de usuario
	function cambiar_nombre($nombre){
		$id = $_SESSION['id'];
		$this->db->query("UPDATE Usuario 
											SET nombre = \"$nombre\" 
											WHERE id = $id");
	}

	//cambiar el email de usuario
	function cambiar_email($email){
		$id = $_SESSION['id'];
		$this->db->query("UPDATE Usuario 
											SET email = \"$email\" 
											WHERE id = $id");
	}

	//verificar la pass
	function verify_pass($pass){
		$id = $_SESSION['id'];
		$hash = $this->db->query("SELECT pass FROM Usuario WHERE id = $id")->result_array()[0]['pass'];

		return password_verify($pass,$hash);
	}

	//CAMBIAR CONTRASEÑA
	function cambiar_pass($pass){
		$id = $_SESSION['id'];
		$hash = password_hash($pass, PASSWORD_DEFAULT);
		$this->db->query("UPDATE Usuario 
											SET pass = \"$hash\" 
											WHERE id = $id");
	}
}
?>