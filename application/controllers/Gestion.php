<?php

//USAR ESTE CONTROLADOR PARA LA PÁGINA DE GESTIÓN
class Gestion extends CI_Controller {
		function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->helper("url");
			$this->load->helper("download");
			$this->load->helper(array('form','url'));
			$this->load->library('session');
			$this->load->library('pagination'); //Cargamos la librería de paginación
			$this->load->model('Bebida_model');
			$this->load->model('Material_model');
			$this->load->model('Tipomenu_model');
			$this->load->model('Recetas_model');
			$this->load->model('Usuarios_model');
			$this->load->model('Producto_model');
			$this->load->model('Noticia_model');
			$this->load->model('Evento_model');
			$this->load->model('Trabajador_model');
			$this->load->model('TipoTrabajador_model');
			$this->load->model('Menu_model');
			$this->load->model('Foto_model');
			$this->form_validation->set_message('required', 'El campo %s es obligatorio.');
			$this->form_validation->set_message('numeric', 'El campo %s debe ser numérico.');
			$this->form_validation->set_message('integer', 'El campo %s debe ser un número entero.');
			$this->form_validation->set_message('is_unique', 'El campo %s ha de ser único.');
			$this->form_validation->set_message('greater_than_equal_to', 'El campo %s debe ser mayor o igual que cero.');
			
			//$this->load->library('Home');

			//FUNCION PARA COMPROBAR SI SE HA INICIADO SESION
			$this->comprobar_sesion();
		}

		function index() {

			// Cargamos el número de elementos existentes por cada activo para mostrarlos en los botones
			$numero_activos['productos'] = $this->Producto_model->get_numActivos();
			$numero_activos['materiales'] = $this->Material_model->get_numActivos();
			$numero_activos['bebidas'] = $this->Bebida_model->get_numActivos();
			$numero_activos['recetas'] = $this->Recetas_model->get_numActivos();
			$numero_activos['noticias'] = $this->Noticia_model->get_numActivos();
			$numero_activos['menus'] = $this->Menu_model->get_numActivos();
			$numero_activos['eventos'] = $this->Evento_model->get_numActivos();
			$numero_activos['trabajadores'] = $this->Trabajador_model->get_numActivos();

			$this->load->view('head_gestion');
			$this->load->view('Admin',$numero_activos);
			$this->load->view('footer_gestion');
		}

		#####################
		# PERFIL DE USUARIO #
		#####################
		function perfil() {
			$this->load->view('head_gestion');
			$this->load->view('form_perfil');
			$this->load->view('footer_gestion');
		}

		// CAMBIAR NOMBRE USUARIO
		function cambiar_nombre_usuario() {
			$nombre = $this->input->post('nombre');

			$this->form_validation->set_rules('nombre', 'Nombre', 'required');

  		if($this->form_validation->run()){ // Si la validación es correcta
  			$this->Usuarios_model->cambiar_nombre($nombre);
				$arraydata = array(
	        				'id' => $this->session->userdata('id'),
	                'username'  => $nombre,
	                'email'     => $this->session->userdata('email')                
	      		);
	      		$this->session->set_userdata($arraydata);

	      $mensaje['correcto'] = "El nombre de usuario ha sido cambiado correctamente";
				$this->load->view('head_gestion');
      	$this->load->view('form_perfil', $mensaje);
      	$this->load->view('footer_gestion');

	    } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
	        $this->load->view('head_gestion');
	      	$this->load->view('form_perfil');
	      	$this->load->view('footer_gestion');
	      	}       
		}

		// CAMBIAR EMAIL USUARIO
		function cambiar_email_usuario() {
			$email = $this->input->post('email');

			$this->form_validation->set_rules('email', 'Email', 'required');

  		if($this->form_validation->run()){ // Si la validación es correcta
  			$this->Usuarios_model->cambiar_email($email);
				$arraydata = array(
	        				'id' => $this->session->userdata('id'),
	                'username'  => $this->session->userdata('username'),
	                'email'     => $email                
	      		);
	      		$this->session->set_userdata($arraydata);

				$mensaje['correcto'] = "El email ha sido cambiado correctamente";
				$this->load->view('head_gestion');
      	$this->load->view('form_perfil', $mensaje);
      	$this->load->view('footer_gestion');

      } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
        $this->load->view('head_gestion');
      	$this->load->view('form_perfil');
      	$this->load->view('footer_gestion');
      }
		}

		// CAMBIAR PASSWORD USUARIO
		function cambiar_pass_usuario() {
			$pass1 = $this->input->post('pass1');
			$pass2 = $this->input->post('pass2');

			$this->form_validation->set_rules('pass1', 'antigua contraseña', 'required');
			$this->form_validation->set_rules('pass2', 'nueva contraseña', 'required');

  		if($this->form_validation->run()){ // Si la validación es correcta
  			if($this->Usuarios_model->verify_pass($pass1)) {
					$this->Usuarios_model->cambiar_pass($pass2);	

					$mensaje['correcto'] = "La contraseña ha sido cambiada correctamente";
					$this->load->view('head_gestion');
	      	$this->load->view('form_perfil', $mensaje);
	      	$this->load->view('footer_gestion');
				}
				else{
					$error['error'] = "La antigua contraseña no es correcta";
					$this->load->view('head_gestion');
	      	$this->load->view('form_perfil', $error);
	      	$this->load->view('footer_gestion');
				}

      } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
        $this->load->view('head_gestion');
      	$this->load->view('form_perfil');
      	$this->load->view('footer_gestion');
      }
		}

		// COMPROBAR SESION
		private function comprobar_sesion() {
			if(!$this->session->userdata('username')){
				show_404();
			}
		}

		// CERRAR SESION
		function desconectarse() {
			$this->session->sess_destroy();
			redirect('/Home');
		}

		################
		# CRUD DE MENÚ #
		################

		// Con esta función cargamos la lista de todos los menús disponibles paginada
		function ver_menu() {
    		$num_paginas = 10; // Menús mostrados por página
			$config['base_url'] = base_url().'Gestion/ver_menu/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Menu_model->num_menus(); // Calcula el número de menus
			$config['per_page'] = $num_paginas; // Número de menus mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 3; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 
			$datos_menus['clave'] = $this->Menu_model->get_menus_paginados($config['per_page'], $this->uri->segment(3)); 
        	$this->load->view('head_gestion');
        	$this->load->view('listaMenus', $datos_menus);
        	$this->load->view('footer_gestion');
		}

		// Función para eliminar un menú concreto
		function eliminar_menu($id_menu) {
			$this->Menu_model->borrar_menu($id_menu);
			redirect('Gestion/ver_menu', 'refresh');
		}

		// Función que llama al formulario para crear un nuevo menú
		function nuevo_menu() {
        	$this->load->view('head_gestion');
        	$this->load->view('form_menu');
        	$this->load->view('footer_gestion');
		}

		// Función para crear un menú con los elementos introducidos en el formulario
		function crear_menu() {
    		$nuevo_menu = array('nombre'           => $this->input->post('nombre'),
                                'descripcion'      => $this->input->post('descripcion'),
                                'coste'            => $this->input->post('coste'),
                                'precio'           => $this->input->post('precio'),
                                'comensales'       => $this->input->post('comensales'),
                               );   			

    		$this->form_validation->set_rules('nombre', 'Nombre', 'required|is_unique[Menu.nombre]');
    		$this->form_validation->set_rules('precio', 'Precio', 'numeric|greater_than_equal_to[0]');
    		$this->form_validation->set_rules('coste', 'Coste', 'numeric|greater_than_equal_to[0]');
    		$this->form_validation->set_rules('comensales', 'Comensales', 'numeric|greater_than_equal_to[0]');

    		if($this->form_validation->run()){ // Si la validación es correcta
    			$this->Menu_model->crear_menu($nuevo_menu);
	            redirect('Gestion/ver_menu', 'refresh');
	        } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
            	$this->load->view('head_gestion');
	        	$this->load->view('form_menu',$nuevo_menu);
	        	$this->load->view('footer_gestion');
	        }       	
		}

		// Función que llama al formulario para modificar un menú en concreto
		function modificar_menu($id_menu) {
			$menu['clave'] = $this->Menu_model->get_menu_id($id_menu);
			$this->load->view('head_gestion');
			$this->load->view('form_cambio_menu', $menu);
			$this->load->view('footer_gestion');
		}

		// Función para modificar los datos de un menú con los elementos introducidos en el formulario
		function cambio_menu($id_menu) {
			$nuevo_cambio = array('nombre'       => $this->input->post('nombre'),
                                  'descripcion'  => $this->input->post('descripcion'),
                                  'precio'       => $this->input->post('precio'),
                                  'coste'		 => $this->input->post('coste'),
                                  'comensales'   => $this->input->post('comensales')
                                 ); 

			$menu['clave'] = $this->Menu_model->get_menu_id($id_menu);

			if($menu['clave']['nombre'] == $nuevo_cambio['nombre'])
				$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			else
				$this->form_validation->set_rules('nombre', 'Nombre', 'required|is_unique[Menu.nombre]');

    		$this->form_validation->set_rules('precio', 'Precio', 'numeric|greater_than_equal_to[0]');
    		$this->form_validation->set_rules('coste', 'Coste', 'numeric|greater_than_equal_to[0]');
    		$this->form_validation->set_rules('comensales', 'Comensales', 'numeric|greater_than_equal_to[0]');

    		if($this->form_validation->run()) { // Si la validación es correcta
    			$this->Menu_model->modificar_menu($nuevo_cambio, $id_menu);
	            redirect('Gestion/ver_menu', 'refresh');
	        } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
	        	$nuevo_cambio['clave'] = $this->Menu_model->get_menu_id($id_menu);
            	$this->load->view('head_gestion');
	        	$this->load->view('form_cambio_menu',$nuevo_cambio);
	        	$this->load->view('footer_gestion');
	        }    
		}

		// Función para mostrar las recetas de un menú concreto
		function mostrar_recetas($id_menu) {

			$num_paginas = 10; // Menús mostrados por página
			$config['base_url'] = base_url().'Gestion/mostrar_recetas/'.$id_menu.'/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Recetas_model->num_recetas_menu($id_menu); // Calcula el número de menus
			$config['per_page'] = $num_paginas; // Número de menus mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 4; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 
			$menu['clave_receta'] = $this->Recetas_model->get_recetas_menu_paginados($id_menu, $config['per_page'], $this->uri->segment(4)); 

			$id_menu = (int)$id_menu;
			$menu['clave_menu']   = $this->Menu_model->get_menu_id($id_menu);
			$this->load->view('head_gestion');
			$this->load->view('mostrarReceta', $menu);
			$this->load->view('footer_gestion');
		}

		function eliminar_receta_menu($id_receta, $id_menu) {
			$id_receta = (int)$this->uri->segment(3);
			$id_menu = (int)$this->uri->segment(4);
			$this->Menu_model->delete_menu_receta($id_receta, $id_menu);
			redirect('Gestion/mostrar_recetas/'.$id_menu, 'refresh');
		}

		function insertar_receta($id_menu) {
			$id_menu = (int)$id_menu;
			$menu['clave_receta']   = $this->Menu_model->get_receta_not_menu($id_menu);
			$menu['clave_menu']     = $this->Menu_model->get_menu_id($id_menu);
			$this->load->view('head_gestion');
			$this->load->view('nuevaReceta', $menu);
			$this->load->view('footer_gestion');
		}

		function insertar_receta_menu($id_menu) {
			$id_menu = (int)$id_menu;
			$tipo = $this->input->post('tipo');
			$this->Menu_model->create_menu_receta($id_menu, $tipo);
			redirect('Gestion/mostrar_recetas/'.$id_menu, 'refresh');
		}

		function mostrar_bebidas($id_menu) {

			$num_paginas = 10; // Menús mostrados por página
			$config['base_url'] = base_url().'Gestion/mostrar_bebidas/'.$id_menu.'/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Bebida_model->num_bebidas_menu($id_menu); // Calcula el número de menus
			$config['per_page'] = $num_paginas; // Número de menus mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 4; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 
			$menu['clave_bebida'] = $this->Bebida_model->get_bebidas_menu_paginados($id_menu, $config['per_page'], $this->uri->segment(4)); 

			$id_menu = (int)$id_menu;
			$menu['clave_menu']     = $this->Menu_model->get_menu_id($id_menu);
			$this->load->view('head_gestion');
			$this->load->view('mostrarBebida', $menu);
			$this->load->view('footer_gestion');
		}

		function eliminar_bebida_menu($id_bebida, $id_menu) {
			$id_receta = (int)$this->uri->segment(3);
			$id_menu = (int)$this->uri->segment(4);
			$this->Menu_model->delete_menu_bebida($id_receta, $id_menu);
			redirect('Gestion/mostrar_bebidas/'.$id_menu, 'refresh');
		}

		function insertar_bebida($id_menu) {
			$id_menu = (int)$id_menu;
			$menu['clave_bebida']   = $this->Bebida_model->get_bebidas_not_menu($id_menu);
			$menu['clave_menu']     = $this->Menu_model->get_menu_id($id_menu);
			$this->load->view('head_gestion');
			$this->load->view('nuevaBebida', $menu);
			$this->load->view('footer_gestion');
		}

		function insertar_bebida_menu($id_menu) {
			$id_menu = (int)$id_menu;
			$tipo = $this->input->post('tipo');
			$cantidad = $this->input->post('cantidad');

			if(empty($tipo))
				$this->form_validation->set_rules('tipo', 'Bebida', 'required');

			$this->form_validation->set_rules('cantidad', 'Cantidad', 'required|numeric|greater_than_equal_to[0]|integer');

    		if($this->form_validation->run()) { //Si la validación es correcta
    			$this->Menu_model->create_menu_bebida($id_menu, $tipo, $cantidad);
	            redirect('Gestion/mostrar_bebidas/'.$id_menu, 'refresh');
	        } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
	        	$menu['clave_bebida']   = $this->Bebida_model->get_bebidas_not_menu($id_menu);
				$menu['clave_menu']     = $this->Menu_model->get_menu_id($id_menu);
	            $this->load->view('head_gestion');
				$this->load->view('nuevaBebida', $menu);
				$this->load->view('footer_gestion');
	        }    
		}

		function mostrar_eventos($id_menu) {
			$id_menu = (int)$id_menu;
			$menu['clave_menu']     = $this->Menu_model->get_menu_id($id_menu);
			$menu['clave_evento']   = $this->Evento_model->get_eventos_menu($id_menu);
			$this->load->view('head_gestion');
			$this->load->view('mostrarEvento', $menu);
			$this->load->view('footer_gestion');
		}

		function eliminar_evento_menu($id_evento, $id_menu) {
			$id_evento = (int)$this->uri->segment(3);
			$id_menu = (int)$this->uri->segment(4);
			$this->Menu_model->delete_menu_evento($id_evento, $id_menu);
			redirect('Gestion/mostrar_eventos/'.$id_menu, 'refresh');
		}

		function insertar_evento($id_menu) {
			$id_menu = (int)$id_menu;
			$menu['clave_evento']   = $this->Evento_model->get_eventos_not_menu($id_menu);
			$menu['clave_menu']     = $this->Menu_model->get_menu_id($id_menu);
			$this->load->view('head_gestion');
			$this->load->view('nuevoEvento', $menu);
			$this->load->view('footer_gestion');
		}

		function insertar_evento_menu($id_menu) {
			$id_menu = (int)$id_menu;
			$tipo = $this->input->post('tipo');
			$this->Menu_model->create_menu_evento($id_menu, $tipo);
			$menu['clave_evento']   = $this->Evento_model->get_eventos_menu($id_menu);
			$menu['clave_menu']     = $this->Menu_model->get_menu_id($id_menu);
			$this->load->view('head_gestion');
			$this->load->view('mostrarEvento', $menu);
			$this->load->view('footer_gestion');
		}

		function mostrar_tiposmenu($id_menu) {
			$num_paginas = 10; // Menús mostrados por página
			$config['base_url'] = base_url().'Gestion/mostrar_tiposmenu/'.$id_menu.'/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Menu_model->num_tiposmenu_menu($id_menu); // Calcula el número de menus
			$config['per_page'] = $num_paginas; // Número de menus mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 4; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 
			$menu['clave_tipo'] = $this->Menu_model->get_tiposmenu_menu_paginados($id_menu, $config['per_page'], $this->uri->segment(4)); 

			$id_menu = (int)$id_menu;
			$menu['clave_menu']   = $this->Menu_model->get_menu_id($id_menu);
			$this->load->view('head_gestion');
			$this->load->view('mostrarTipoMenu', $menu);
			$this->load->view('footer_gestion');
		}

		function eliminar_tipo_menu($id_tipo, $id_menu) {
			$id_tipo = (int)$this->uri->segment(3);
			$id_menu = (int)$this->uri->segment(4);
			$this->Menu_model->delete_menu_tipo($id_tipo, $id_menu);
			redirect('Gestion/mostrar_tiposmenu/'.$id_menu, 'refresh');
		}

		function insertar_tipo($id_menu) {
			$id_menu = (int)$id_menu;
			$menu['clave_tipo']   = $this->Menu_model->get_tiposmenu_notmenu($id_menu);
			$menu['clave_menu']   = $this->Menu_model->get_menu_id($id_menu);
			$this->load->view('head_gestion');
			$this->load->view('nuevoTipoMenu', $menu);
			$this->load->view('footer_gestion');
		}

		function insertar_tipo_menu($id_menu) {
			$id_menu = (int)$id_menu;
			$tipo = $this->input->post('tipo');
			$this->Menu_model->create_menu_tipo($id_menu, $tipo);
			$menu['clave_tipo']   = $this->Menu_model->get_tiposmenu_menu($id_menu);
			$menu['clave_menu']   = $this->Menu_model->get_menu_id($id_menu);
			$this->load->view('head_gestion');
			$this->load->view('mostrarTipoMenu', $menu);
			$this->load->view('footer_gestion');
		}

		function generar_pdf_listaCompraMenu($id_menu) {
			exec("sudo python3 -m calculadoraAlimentos listaCompraMenu ".$id_menu);
			$name = "menu.pdf";
			$data = file_get_contents($name);
       		force_download($name,$data);
		}

		function generar_pdf_beneficioMenu($id_menu) {
			exec("sudo python3 -m calculadoraAlimentos beneficioMenu ".$id_menu);
			$name = "menu.pdf";
			$data = file_get_contents($name);
       		force_download($name,$data);
		}

		// Función para realizar la búsqueda de un menú 
		function buscar_menu() {
			$texto = $this->input->post('search_box');
			$num_paginas = 10; // Activos mostrados por página
			$config['base_url'] = base_url().'Gestion/buscar_menu/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Menu_model->get_total_menus_buscar($texto); // Calcula el número de activos
			$config['per_page'] = $num_paginas; // Número de activos mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 3; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 

			$menu['clave'] = $this->Menu_model->get_menus_buscar($texto, $config['per_page'], $this->uri->segment(3));
			$menu['busqueda'] = true;
			$this->load->view('head_gestion');
			$this->load->view('mostrarTipoMenu', $menu);
			$this->load->view('footer_gestion');
		}

		function buscar_tipomenu_menu($id_menu) {

			$texto = $this->input->post('search_box');
			$num_paginas = 10; // Tipos de menu mostrados por página
			$config['base_url'] = base_url().'Gestion/buscar_tipomenu_menu/'.$id_menu.'/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Menu_model->get_total_tiposmenu_menu_buscar($id_menu, $texto); // Calcula el número de tipos de menu
			$config['per_page'] = $num_paginas; // Número de menus mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 4; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 
			$menu['clave_tipo'] = $this->Menu_model->get_tiposmenu_menu_buscar($id_menu, $texto, $config['per_page'], $this->uri->segment(4));
			$menu['busqueda'] = true;

			$id_menu = (int)$id_menu;
			$menu['clave_menu']   = $this->Menu_model->get_menu_id($id_menu);
			$this->load->view('head_gestion');
			$this->load->view('mostrarTipoMenu', $menu);
			$this->load->view('footer_gestion');
		}

		function buscar_receta_menu($id_menu) {

			$texto = $this->input->post('search_box');
			$num_paginas = 10; // Tipos de menu mostrados por página
			$config['base_url'] = base_url().'Gestion/buscar_receta_menu/'.$id_menu.'/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Recetas_model->get_total_recetas_menu_buscar($id_menu, $texto); // Calcula el número de tipos de menu
			$config['per_page'] = $num_paginas; // Número de menus mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 4; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 
			$menu['clave_receta'] = $this->Recetas_model->get_recetas_menu_buscar($id_menu, $texto, $config['per_page'], $this->uri->segment(4)); 
			$menu['busqueda'] = true;

			$id_menu = (int)$id_menu;
			$menu['clave_menu']   = $this->Menu_model->get_menu_id($id_menu);
			$this->load->view('head_gestion');
			$this->load->view('mostrarReceta', $menu);
			$this->load->view('footer_gestion');
		}

		function buscar_bebida_menu($id_menu) {

			$texto = $this->input->post('search_box');
			$num_paginas = 10; // Tipos de menu mostrados por página
			$config['base_url'] = base_url().'Gestion/buscar_bebida_menu/'.$id_menu.'/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Bebida_model->get_total_bebidas_menu_buscar($id_menu, $texto); // Calcula el número de tipos de menu
			$config['per_page'] = $num_paginas; // Número de menus mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 4; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 
			$menu['clave_bebida'] = $this->Bebida_model->get_bebidas_menu_buscar($id_menu, $texto, $config['per_page'], $this->uri->segment(4)); 
			$menu['busqueda'] = true;

			$id_menu = (int)$id_menu;
			$menu['clave_menu']   = $this->Menu_model->get_menu_id($id_menu);
			$this->load->view('head_gestion');
			$this->load->view('mostrarBebida', $menu);
			$this->load->view('footer_gestion');
		}

		###########################
		# CRUD DE TIPO TRABAJADOR #
		###########################

		// Función para ver la lista de roles
		function ver_tipotrabajador() {	
    		$num_paginas = 10; // Tipos de trabajador mostrados por página
			$config['base_url'] = base_url().'Gestion/ver_tipotrabajador/'; // Dirección base de la primera página
			$config['total_rows'] = $this->TipoTrabajador_model->num_tipostrabajador(); // Calcula el número de Tipos de trabajador
			$config['per_page'] = $num_paginas; // Número de Tipos de trabajador mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 3; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 
			$datos_tipostrabajador['clave'] = $this->TipoTrabajador_model->get_tipostrabajador_paginados($config['per_page'], $this->uri->segment(3)); 
        	$this->load->view('head_gestion');
        	$this->load->view('listaTipostrabajador', $datos_tipostrabajador);
        	$this->load->view('footer_gestion');
		}

		// Función para eliminar un rol
		function eliminar_tipotrabajador($id_tipotrabajador) {
			if($this->TipoTrabajador_model->num_trabajadores_asociados($id_tipotrabajador) == 0) {
				$this->TipoTrabajador_model->borrar_tipotrabajador($id_tipotrabajador);
				redirect('Gestion/ver_tipotrabajador', 'refresh');
			}
			else {
				$this->session->set_flashdata('mensaje', 'Error al eliminar. Existen trabajadores asociados.');
				redirect('Gestion/ver_tipotrabajador');
			}
		}	

		// Función para llamar al formulario de creación de nuevo rol
		function nuevo_tipotrabajador() {
        	$this->load->view('head_gestion');
        	$this->load->view('form_tipotrabajador');
        	$this->load->view('footer_gestion');
		}

		// Función para crear un nuevo rol
		function crear_tipotrabajador() {
    		$nuevo_tipotrabajador = array('nombre'  => $this->input->post('nombre'),
                                          'sueldo'  => $this->input->post('sueldo')
                              	          );

    		$this->form_validation->set_rules('nombre', 'Nombre', 'required|is_unique[TipoTrabajador.nombre]');
    		$this->form_validation->set_rules('sueldo', 'Sueldo', 'numeric|greater_than_equal_to[0]');

    		if($this->form_validation->run()) { //Si la validación es correcta
    			$this->TipoTrabajador_model->crear_tipotrabajador($nuevo_tipotrabajador);
	            redirect('Gestion/ver_tipotrabajador', 'refresh');
	        } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
            	$this->load->view('head_gestion');
	        	$this->load->view('form_tipotrabajador',$nuevo_tipotrabajador);
	        	$this->load->view('footer_gestion');
	        }     	
		}

		// Función para llamar al formulario de modificación de rol concreto
		function modificar_tipotrabajador($id_tipotrabajador) {
			$tipotrabajador['clave'] = $this->TipoTrabajador_model->get_tipotrabajador_id($id_tipotrabajador);
			$this->load->view('head_gestion');
			$this->load->view('form_cambio_tipotrabajador', $tipotrabajador);
			$this->load->view('footer_gestion');
		}

		// Función para modificar un rol concreto
		function cambio_tipotrabajador($id_tipotrabajador) {
			$nuevo_cambio = array('nombre'  => $this->input->post('nombre'),
                                  'sueldo' => $this->input->post('sueldo')
                              	  );

			$tipotrabajador['clave'] = $this->TipoTrabajador_model->get_tipotrabajador_id($id_tipotrabajador);

    		if($tipotrabajador['clave']['nombre'] == $nuevo_cambio['nombre'])
				$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			else
				$this->form_validation->set_rules('nombre', 'Nombre', 'required|is_unique[TipoTrabajador.nombre]');

			$this->form_validation->set_rules('sueldo', 'Sueldo', 'required|numeric|greater_than_equal_to[0]');
			
			if($this->form_validation->run()){ //Si la validación es correcta
        		$this->TipoTrabajador_model->modificar_tipotrabajador($nuevo_cambio, $id_tipotrabajador);
	            redirect('Gestion/ver_tipotrabajador', 'refresh');
	        } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
	        	$nuevo_cambio['clave'] = $this->TipoTrabajador_model->get_tipotrabajador_id($id_tipotrabajador);
            	$this->load->view('head_gestion');
	        	$this->load->view('form_cambio_tipotrabajador',$nuevo_cambio);
	        	$this->load->view('footer_gestion');
	        }
		}

		// Función para buscar roles
		function buscar_tipotrabajador() {
			$texto = $this->input->post('search_box');
			$num_paginas = 10; // Activos mostrados por página
			$config['base_url'] = base_url().'Gestion/buscar_tipotrabajador/'; // Dirección base de la primera página
			$config['total_rows'] = $this->TipoTrabajador_model->get_total_tipostrabajador_buscar($texto); // Calcula el número de activos
			$config['per_page'] = $num_paginas; // Número de activos mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 3; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 

			$tipostrabajador['clave'] = $this->TipoTrabajador_model->get_tipostrabajador_buscar($texto, $config['per_page'], $this->uri->segment(3));
			$tipostrabajador['busqueda'] = true;
			$this->load->view('head_gestion');
		 	$this->load->view('listaTipostrabajador', $tipostrabajador);
		 	$this->load->view('footer_gestion');
		}

		######################
		# CRUD DE TRABAJADOR #
		######################

		// Función para ver la lista de trabajadores
		function ver_trabajador() {
			$num_paginas = 10; // Trabajadores mostrados por página
			$config['base_url'] = base_url().'Gestion/ver_trabajador/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Trabajador_model->num_trabajadores(); // Calcula el número de trabajadores
			$config['per_page'] = $num_paginas; // Número de trabajadores mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 3; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 
			$datos_trabajadores['clave'] = $this->Trabajador_model->get_trabajadores_paginados($config['per_page'], $this->uri->segment(3));
			//$datos_trabajadores['clave'] = $this->Trabajador_model->get_trabajadores(); 
        	$this->load->view('head_gestion');
        	$this->load->view('listaTrabajadores', $datos_trabajadores);
        	$this->load->view('footer_gestion');
		}

		// Función para eliminar un trabajador de la base de datos
		function eliminar_trabajador($id_trabajador) {
			$this->Trabajador_model->borrar_trabajador($id_trabajador);
			redirect('Gestion/ver_trabajador', 'refresh');
		}

		// Función que llama al formulario de creación de un nuevo trabajador
		function nuevo_trabajador() {
        	$this->load->view('head_gestion');
        	$datos_tipotrabajadores['clave'] = $this->TipoTrabajador_model->get_nombre_tipotrabajadores();
        	$this->load->view('form_trabajador', $datos_tipotrabajadores);
        	$this->load->view('footer_gestion');
		}

		// Función para crear un nuevo trabajador
		function crear_trabajador() {
    		$nuevo_trabajador = array('nombre'    => $this->input->post('nombre'),
                                      'apellidos' => $this->input->post('apellidos'),
                                      'tipo'      => $this->input->post('tipo')
                              	     );

    		$this->form_validation->set_rules('nombre', 'Nombre', 'required');
    		$this->form_validation->set_rules('apellidos', 'apellidos', 'required');
    		if($this->form_validation->run()) { //Si la validación es correcta
    			$this->Trabajador_model->crear_trabajador($nuevo_trabajador);
	            redirect('Gestion/ver_trabajador', 'refresh');
	        } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
	        	$nuevo_trabajador['clave'] = $this->TipoTrabajador_model->get_nombre_tipotrabajadores();
            	$this->load->view('head_gestion');
	        	$this->load->view('form_trabajador',$nuevo_trabajador);
	        	$this->load->view('footer_gestion');       	
			}
		}

		// Función que llama al formulario de modificación de trabajador
		function modificar_trabajador($id_trabajador) {
			$trabajador['clave'] = $this->Trabajador_model->get_trabajador_id($id_trabajador);
			$this->load->view('head_gestion');
			$trabajador['clave_tipotrabajador'] = $this->TipoTrabajador_model->get_tipotrabajadores();
			$this->load->view('form_cambio_trabajador', $trabajador);
			$this->load->view('footer_gestion');
		}

		// Función para modificar un trabajador
		function cambio_trabajador($id_trabajador) {
			$nuevo_cambio = array('nombre'    => $this->input->post('nombre'),
                                  'apellidos' => $this->input->post('apellidos'),
                                  'tipo'      => $this->input->post('tipo'),
                              	  );

			$this->form_validation->set_rules('nombre', 'Nombre', 'required');
    		$this->form_validation->set_rules('apellidos', 'Apellidos', 'required');

        	if($this->form_validation->run()) { //Si la validación es correcta
        		$this->Trabajador_model->modificar_trabajador($nuevo_cambio, $id_trabajador);
	            redirect('Gestion/ver_trabajador', 'refresh');
	        } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
	        	$nuevo_cambio['clave'] = $this->Trabajador_model->get_trabajador_id($id_trabajador);
	        	$nuevo_cambio['clave_tipotrabajador'] = $this->TipoTrabajador_model->get_tipotrabajadores();
            	$this->load->view('head_gestion');
	        	$this->load->view('form_cambio_trabajador',$nuevo_cambio);
	        	$this->load->view('footer_gestion');
	        }
		}

		// Función para buscar un trabajador en concreto
		function buscar_trabajador() {
			$texto = $this->input->post('search_box');
			$num_paginas = 10; // Activos mostrados por página
			$config['base_url'] = base_url().'Gestion/buscar_trabajador/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Trabajador_model->get_total_trabajadores_buscar($texto); // Calcula el número de activos
			$config['per_page'] = $num_paginas; // Número de activos mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 3; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 

			
			$trabajadores['clave'] = $this->Trabajador_model->get_trabajadores_buscar($texto, $config['per_page'], $this->uri->segment(3));
			$trabajadores['busqueda'] = true;
			$this->load->view('head_gestion');
		 	$this->load->view('listaTrabajadores', $trabajadores);
		 	$this->load->view('footer_gestion');
		}

		#####################
	    # CRUD DE PRODUCTOS #
	    #####################
		
		// Función para ver la lista de productos
		function ver_producto() {
			$num_paginas = 10; // Productos mostrados por página
			$config['base_url'] = base_url().'Gestion/ver_producto/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Producto_model->num_productos(); // Calcula el número de productos
			$config['per_page'] = $num_paginas; // Número de productos mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 3; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 
			$datos_productos['clave'] = $this->Producto_model->get_productos_paginados($config['per_page'], $this->uri->segment(3)); 

			$this->load->view('head_gestion');
		 	$this->load->view('listaProductos', $datos_productos);
		 	$this->load->view('footer_gestion');
		}

		// Función para eliminar un producto concreto
		function eliminar_producto($id_producto) {
			$this->Producto_model->borrar_producto($id_producto);
			redirect('Gestion/ver_producto', 'refresh');
		}

		// Función que llama al formulario de creación de nuevo producto
		function nuevo_producto() {
        	$this->load->view('head_gestion');
        	$this->load->view('form_producto');
        	$this->load->view('footer_gestion');
		}

		// Función para crear un nuevo producto
		function crear_producto() {
    		$nuevo_producto = array('nombre'  => $this->input->post('nombre'),
                                    'precio_unitario'  => $this->input->post('precio_unitario'),
                                    'precio_total' => $this->input->post('precio_total'),
                                    'unidad' => $this->input->post('unidad')
                              	  );

    		$this->form_validation->set_rules('nombre', 'Nombre', 'required|is_unique[Producto.nombre]');
    		$this->form_validation->set_rules('precio_unitario', 'Precio de compra unitario', 'numeric|greater_than_equal_to[0]');
    		$this->form_validation->set_rules('precio_total', 'Precio de venta unitario', 'numeric|greater_than_equal_to[0]');

    		if($this->form_validation->run()) { //Si la validación es correcta
    			$this->Producto_model->crear_producto($nuevo_producto);
	            redirect('Gestion/ver_producto', 'refresh');
	        } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
            	$this->load->view('head_gestion');
	        	$this->load->view('form_producto',$nuevo_producto);
	        	$this->load->view('footer_gestion');
	        }
		}

		// Función que llama al formulario de modificación de un producto concreto
		function modificar_producto($id_producto) {
			$producto['clave'] = $this->Producto_model->get_producto_id($id_producto);
			$this->load->view('head_gestion');
			$this->load->view('form_cambio_producto', $producto);
			$this->load->view('footer_gestion');
		}

		// Función para modificar un producto
		function cambio_producto($id_producto) {
			$nuevo_cambio = array('nombre'  => $this->input->post('nombre'),
                                    'precio_unitario'  => $this->input->post('precio_unitario'),
                                    'precio_total' => $this->input->post('precio_total'),
                                    'unidad' => $this->input->post('unidad')
                              	  );

			$producto['clave'] = $this->Producto_model->get_producto_id($id_producto);

			if($producto['clave']['nombre'] == $nuevo_cambio['nombre'])
				$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			else
				$this->form_validation->set_rules('nombre', 'Nombre', 'required|is_unique[Producto.nombre]');

    		$this->form_validation->set_rules('precio_unitario', 'Precio de compra unitario', 'required|numeric|greater_than_equal_to[0]');
    		$this->form_validation->set_rules('precio_total', 'Precio de venta unitario', 'required|numeric|greater_than_equal_to[0]');

        	if($this->form_validation->run()) { //Si la validación es correcta
        		$this->Producto_model->modificar_producto($nuevo_cambio, $id_producto);
	            redirect('Gestion/ver_producto', 'refresh');
	        } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
	        	$nuevo_cambio['clave'] = $this->Producto_model->get_producto_id($id_producto);
            	$this->load->view('head_gestion');
	        	$this->load->view('form_cambio_producto',$nuevo_cambio);
	        	$this->load->view('footer_gestion');
	        }
		}

		// Función para buscar productos
		function buscar_producto() {
			$texto = $this->input->post('search_box');
			$num_paginas = 10; // Activos mostrados por página
			$config['base_url'] = base_url().'Gestion/buscar_producto/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Producto_model->get_total_productos_buscar($texto); // Calcula el número de activos
			$config['per_page'] = $num_paginas; // Número de activos mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 3; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 

			
			$productos['clave'] = $this->Producto_model->get_productos_buscar($texto, $config['per_page'], $this->uri->segment(3));
			$productos['busqueda'] = true;
			$this->load->view('head_gestion');
		 	$this->load->view('listaProductos', $productos);
		 	$this->load->view('footer_gestion');
		}

		##################
		# CRUD DE BEBIDA #
		##################

		// Función para ver la lista de bebidas de la base de datos
		function ver_bebida() {
    		$num_paginas = 10; // Bebidas mostrados por página
			$config['base_url'] = base_url().'Gestion/ver_bebida/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Bebida_model->num_bebidas(); // Calcula el número de bebidas
			$config['per_page'] = $num_paginas; // Número de productos mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 3; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 
			$datos_bebidas['clave'] = $this->Bebida_model->get_bebidas_paginadas($config['per_page'], $this->uri->segment(3)); 
        	$this->load->view('head_gestion');
        	$this->load->view('listaBebidas', $datos_bebidas);
        	$this->load->view('footer_gestion');
		}

		// Función para eliminar una bebida en concreto
		function eliminar_bebida($id_bebida) {
			$this->Bebida_model->borrar_bebida($id_bebida);
			redirect('Gestion/ver_bebida', 'refresh');
		}

		// Función que llama al formulario de creación de una nueva bebida
		function nueva_bebida() {
        	$this->load->view('head_gestion');
        	$this->load->view('form_bebida');
        	$this->load->view('footer_gestion');
		}

		// Función para crear una nueva bebida
		function crear_bebida() {
    		$nueva_bebida = array('nombre'  => $this->input->post('nombre'),
                                  'alcohol' => $this->input->post('alcohol'),
                                  'precio_unitario'  => $this->input->post('precio_unitario'),
                                  'precio_total' => $this->input->post('precio_total')
                              	  );

    		
    		$this->form_validation->set_rules('nombre', 'Nombre', 'required|is_unique[Bebida.nombre]');
    		$this->form_validation->set_rules('precio_unitario', 'Precio de compra unitario', 'numeric|greater_than_equal_to[0]');
    		$this->form_validation->set_rules('precio_total', 'Precio de venta unitario', 'numeric|greater_than_equal_to[0]');

    		if($this->form_validation->run()) { //Si la validación es correcta
    			$this->Bebida_model->crear_bebida($nueva_bebida);
	            redirect('Gestion/ver_bebida', 'refresh');
	        } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
            	$this->load->view('head_gestion');
	        	$this->load->view('form_bebida',$nueva_bebida);
	        	$this->load->view('footer_gestion');
	        }
		}

		// Función que llama al formulario de modificación de bebidas
		function modificar_bebida($id_bebida) {
			$bebida['clave'] = $this->Bebida_model->get_bebida_id($id_bebida);
			$this->load->view('head_gestion');
			$this->load->view('form_cambio_bebida', $bebida);
			$this->load->view('footer_gestion');
		}

		// Función para modificar una bebida en concreto
		function cambio_bebida($id_bebida) {
			$nuevo_cambio = array('nombre'  => $this->input->post('nombre'),
                                  'alcohol' => $this->input->post('alcohol'),
                                  'precio_unitario'  => $this->input->post('precio_unitario'),
                                  'precio_total' => $this->input->post('precio_total')
                              	  );

			$bebida['clave'] = $this->Bebida_model->get_bebida_id($id_bebida);

			if($bebida['clave']['nombre'] == $nuevo_cambio['nombre'])
				$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			else
				$this->form_validation->set_rules('nombre', 'Nombre', 'required|is_unique[Bebida.nombre]');

    		$this->form_validation->set_rules('precio_unitario', 'Precio de compra unitario', 'numeric|greater_than_equal_to[0]');
    		$this->form_validation->set_rules('precio_total', 'Precio de venta unitario', 'numeric|greater_than_equal_to[0]');

    		if($this->form_validation->run()) { //Si la validación es correcta
    			$this->Bebida_model->modificar_bebida($nuevo_cambio, $id_bebida);
	            redirect('Gestion/ver_bebida', 'refresh');
	        } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
	        	$nuevo_cambio['clave'] = $this->Bebida_model->get_bebida_id($id_bebida);
            	$this->load->view('head_gestion');
	        	$this->load->view('form_cambio_bebida',$nuevo_cambio);
	        	$this->load->view('footer_gestion');
	        }
		}

		// Función para buscar bebidas
		function buscar_bebida() {
			$texto = $this->input->post('search_box');
			$num_paginas = 10; // Activos mostrados por página
			$config['base_url'] = base_url().'Gestion/buscar_bebida/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Bebida_model->get_total_bebidas_buscar($texto); // Calcula el número de activos
			$config['per_page'] = $num_paginas; // Número de activos mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 3; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 

			$bebidas['clave'] = $this->Bebida_model->get_bebidas_buscar($texto, $config['per_page'], $this->uri->segment(3));
			$bebidas['busqueda'] = true;
			$this->load->view('head_gestion');
		 	$this->load->view('listaBebidas', $bebidas);
		 	$this->load->view('footer_gestion');
		}

		####################
		# CRUD DE MATERIAL #
		####################

		// Función para obtener la lista de materiales
		function ver_material() {
			$num_paginas = 10; // Materiales mostrados por página
			$config['base_url'] = base_url().'Gestion/ver_material/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Material_model->num_materiales(); // Calcula el número de materiales
			$config['per_page'] = $num_paginas; // Número de materiales mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 3; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 
			$datos_materiales['clave'] = $this->Material_model->get_materiales_paginados($config['per_page'], $this->uri->segment(3)); 
    		$this->load->view('head_gestion');
    		$this->load->view('listaMateriales', $datos_materiales);
    		$this->load->view('footer_gestion');
		}

		// Función para eliminar de la BD un material en concreto
		function eliminar_material($id_material) {
			$this->Material_model->borrar_material($id_material);
			redirect('Gestion/ver_material', 'refresh');
		}

		// Función que llama al formulario de creación de nuevo material
		function nuevo_material() {
	    	$this->load->view('head_gestion');
	    	$this->load->view('form_material');
	    	$this->load->view('footer_gestion');
		}

		// Función para crear un nuevo material
		function crear_material() {
			$nuevo_material = array('nombre'  => $this->input->post('nombre'),
                                    'precio_unitario'  => $this->input->post('precio_unitario'),
                                    'precio_total' => $this->input->post('precio_total'),
	                          	  );

			$this->form_validation->set_rules('nombre', 'Nombre', 'required|is_unique[Material.nombre]');
    		$this->form_validation->set_rules('precio_unitario', 'Precio de compra unitario', 'numeric|greater_than_equal_to[0]');
    		$this->form_validation->set_rules('precio_total', 'Precio de venta unitario', 'numeric|greater_than_equal_to[0]');

    		if($this->form_validation->run()) { //Si la validación es correcta
    			$this->Material_model->crear_material($nuevo_material);
	            redirect('Gestion/ver_material', 'refresh');
	        } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
            	$this->load->view('head_gestion');
	        	$this->load->view('form_material',$nuevo_material);
	        	$this->load->view('footer_gestion');
	        }
	    	
		}

		// Función que llama al formulario de modificación de un material concreto
		function modificar_material($id_material) {
			$material['clave'] = $this->Material_model->get_material_id($id_material);
			$this->load->view('head_gestion');
			$this->load->view('form_cambio_material', $material);
			$this->load->view('footer_gestion');
		}

		// Función para modificar un material concreto
		function cambio_material($id_material) {
			$nuevo_cambio = array('nombre'  => $this->input->post('nombre'),
                                  'precio_unitario'  => $this->input->post('precio_unitario'),
                                  'precio_total' => $this->input->post('precio_total')
	                          	  );

			$material['clave'] = $this->Material_model->get_material_id($id_material);

			if($material['clave']['nombre'] == $nuevo_cambio['nombre'])
				$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			else
				$this->form_validation->set_rules('nombre', 'Nombre', 'required|is_unique[Material.nombre]');

    		$this->form_validation->set_rules('precio_unitario', 'Precio de compra unitario', 'required|numeric|greater_than_equal_to[0]');
    		$this->form_validation->set_rules('precio_total', 'Precio de venta unitario', 'required|numeric|greater_than_equal_to[0]');

    		if($this->form_validation->run()) { //Si la validación es correcta
    			$this->Material_model->modificar_material($nuevo_cambio, $id_material);
	            redirect('Gestion/ver_material', 'refresh');
	        } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
	        	$nuevo_cambio['clave'] = $this->Material_model->get_material_id($id_material);
            	$this->load->view('head_gestion');
	        	$this->load->view('form_cambio_material',$nuevo_cambio);
	        	$this->load->view('footer_gestion');
	        }
		}

		// Función para buscar materiales
		function buscar_material() {
			$texto = $this->input->post('search_box');
			$num_paginas = 10; // Activos mostrados por página
			$config['base_url'] = base_url().'Gestion/buscar_material/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Material_model->get_total_materiales_buscar($texto); // Calcula el número de activos
			$config['per_page'] = $num_paginas; // Número de activos mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 3; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 

			$materiales['clave'] = $this->Material_model->get_materiales_buscar($texto, $config['per_page'], $this->uri->segment(3));
			$materiales['busqueda'] = true;
			$this->load->view('head_gestion');
		 	$this->load->view('listaMateriales', $materiales);
		 	$this->load->view('footer_gestion');
		}

		#####################
		# CRUD DE TIPO MENU #
		#####################

		// Función para ver la lista de tipos de menús existentes
		function ver_tipomenu() {
			$num_paginas = 10; // Tipos de menú mostrados por página
			$config['base_url'] = base_url().'Gestion/ver_tipomenu/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Tipomenu_model->num_tiposmenu(); // Calcula el número de tipos de menú
			$config['per_page'] = $num_paginas; // Número de tipos de menú mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 3; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 
			$datos_tiposmenu['clave'] = $this->Tipomenu_model->get_tiposmenu_paginados($config['per_page'], $this->uri->segment(3));
			//$datos_tiposmenu['clave'] = $this->Tipomenu_model->get_tiposmenu_vista();
    		$this->load->view('head_gestion');
    		$this->load->view('listaTiposmenu', $datos_tiposmenu);
    		$this->load->view('footer_gestion');
		}

		// Función para eliminar un tipo de menú conreto
		function eliminar_tipomenu($id_tipomenu) {
			$this->Tipomenu_model->borrar_tipomenu($id_tipomenu);
			redirect('Gestion/ver_tipomenu', 'refresh');
		}

		// Función que llama al formulario de creación de tipo de menú
		function nuevo_tipomenu() {
	    	$this->load->view('head_gestion');
	    	$this->load->view('form_tipomenu');
	    	$this->load->view('footer_gestion');
		}

		// Función para crear un tipo de menú
		function crear_tipomenu() {
			$nuevo_tipomenu = array('nombre'  => $this->input->post('nombre')
	                          	  );

			$this->form_validation->set_rules('nombre', 'Nombre', 'required|is_unique[TipoMenu.nombre]');

			if($this->form_validation->run()) { //Si la validación es correcta
    			$this->Tipomenu_model->crear_tipomenu($nuevo_tipomenu);
	            redirect('Gestion/ver_tipomenu', 'refresh');
	        } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
            	$this->load->view('head_gestion');
	        	$this->load->view('form_tipomenu',$nuevo_tipomenu);
	        	$this->load->view('footer_gestion');
	        }
		}

		// Función que llama al formulario de modificación de un tipo de menú concreto
		function modificar_tipomenu($id_tipomenu) {
			$tipomenu['clave'] = $this->Tipomenu_model->get_tipomenu_id($id_tipomenu);
			$this->load->view('head_gestion');
			$this->load->view('form_cambio_tipomenu', $tipomenu);
			$this->load->view('footer_gestion');
		}

		// Función para modificar un tipo de menú concreto
		function cambio_tipomenu($id_tipomenu) {
			$nuevo_cambio = array('nombre'  => $this->input->post('nombre')
	                          	  );

			
			$tipomenu['clave'] = $this->Tipomenu_model->get_tipomenu_id($id_tipomenu);

			if($tipomenu['clave']['nombre'] == $nuevo_cambio['nombre'])
				$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			else
				$this->form_validation->set_rules('nombre', 'Nombre', 'required|is_unique[TipoMenu.nombre]');

			if($this->form_validation->run()) { //Si la validación es correcta
        		$this->Tipomenu_model->modificar_tipomenu($nuevo_cambio, $id_tipomenu);
	            redirect('Gestion/ver_tipomenu', 'refresh');
	        } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
	        	$nuevo_cambio['clave'] = $this->Tipomenu_model->get_tipomenu_id($id_tipomenu);
            	$this->load->view('head_gestion');
	        	$this->load->view('form_cambio_tipomenu',$nuevo_cambio);
	        	$this->load->view('footer_gestion');
	        }
		}

		// Función para buscar tipos de menú
		function buscar_tipomenu() {
			$texto = $this->input->post('search_box');
			$num_paginas = 10; // Activos mostrados por página
			$config['base_url'] = base_url().'Gestion/buscar_tipomenu/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Tipomenu_model->get_total_tiposmenu_buscar($texto); // Calcula el número de activos
			$config['per_page'] = $num_paginas; // Número de activos mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 3; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 

			$tiposmenu['clave'] = $this->Tipomenu_model->get_tiposmenu_buscar($texto, $config['per_page'], $this->uri->segment(3));
			$tiposmenu['busqueda'] = true;
			$this->load->view('head_gestion');
		 	$this->load->view('listaTiposmenu', $tiposmenu);
		 	$this->load->view('footer_gestion');
		}

		/*
		######################
		# CRUD DE TIPORECETA #
		######################

		// Función para ver la lista de tipos de recetas
		function ver_tiporeceta() {
			$num_paginas = 10; // Tipos de receta mostrados por página
			$config['base_url'] = base_url().'Gestion/ver_tiporeceta/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Tiporeceta_model->num_tiposreceta(); // Calcula el número de tipos de receta
			$config['per_page'] = $num_paginas; // Número de tipos de receta mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 3; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 
			$datos_tiporeceta['clave'] = $this->Tiporeceta_model->get_tiposreceta_paginados($config['per_page'], $this->uri->segment(3)); 
    		$this->load->view('head_gestion');
    		$this->load->view('listaTiposreceta', $datos_tiporeceta);
    		$this->load->view('footer_gestion');
		}

		// Función para eliminar un tipo de receta
		function eliminar_tiporeceta($id_tiporeceta) {
			$this->Tiporeceta_model->borrar_tiporeceta($id_tiporeceta);
			redirect('Gestion/ver_tiporeceta', 'refresh');
		}

		// Función que llama al formulario de creación de tipo de receta
		function nuevo_tiporeceta() {
	    	$this->load->view('head_gestion');
	    	$this->load->view('form_tiporeceta');
	    	$this->load->view('footer_gestion');
		}

		// Función para crear un nuevo tipo de receta
		function crear_tiporeceta() {
			$nuevo_tiporeceta = array('nombre'  => $this->input->post('nombre')
	                          	  );

			$this->form_validation->set_rules('nombre', 'Nombre', 'required|is_unique[Tiporeceta.nombre]');

			if($this->form_validation->run()) { //Si la validación es correcta
    			$this->Tiporeceta_model->crear_tiporeceta($nuevo_tiporeceta);
	            redirect('Gestion/ver_tiporeceta', 'refresh');
	        } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
            	$this->load->view('head_gestion');
	        	$this->load->view('form_tiporeceta',$nuevo_tiporeceta);
	        	$this->load->view('footer_gestion');
	        }
		}

		// Función que llama al formulario de modificación de un tipo de receta concreto
		function modificar_tiporeceta($id_tiporeceta) {
			$tiporeceta['clave'] = $this->Tiporeceta_model->get_tiporeceta_id($id_tiporeceta);
			$this->load->view('head_gestion');
			$this->load->view('form_cambio_tiporeceta', $tiporeceta);
			$this->load->view('footer_gestion');
		}

		// Función para modificar un tipo de receta concreto
		function cambio_tiporeceta($id_tiporeceta) {
			$nuevo_cambio = array('nombre'  => $this->input->post('nombre')
	                          	  );

			$tiporeceta['clave'] = $this->Tiporeceta_model->get_tiporeceta_id($id_tiporeceta);

			if($tiporeceta['clave']['nombre'] == $nuevo_cambio['nombre'])
				$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			else
				$this->form_validation->set_rules('nombre', 'Nombre', 'required|is_unique[Tiporeceta.nombre]');


			if($this->form_validation->run()) { //Si la validación es correcta
    			$this->Tiporeceta_model->modificar_tiporeceta($nuevo_cambio, $id_tiporeceta);
	            redirect('Gestion/ver_tiporeceta', 'refresh');
	        } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
	        	$nuevo_cambio['clave'] = $this->Tiporeceta_model->get_tiporeceta_id($id_tiporeceta);
            	$this->load->view('head_gestion');
	        	$this->load->view('form_cambio_tiporeceta',$nuevo_cambio);
	        	$this->load->view('footer_gestion');
	        }
		}

		// Función para buscar tipos de receta
		function buscar_tiporeceta() {
			$texto = $this->input->post('search_box');
			$num_paginas = 10; // Activos mostrados por página
			$config['base_url'] = base_url().'Gestion/buscar_tiporeceta/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Tiporeceta_model->get_total_tiposreceta_buscar($texto); // Calcula el número de activos
			$config['per_page'] = $num_paginas; // Número de activos mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 3; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 

			$tiposreceta['clave'] = $this->Tiporeceta_model->get_tiposreceta_buscar($texto, $config['per_page'], $this->uri->segment(3));
			$tiposreceta['busqueda'] = true;
			$this->load->view('head_gestion');
		 	$this->load->view('listaTiposreceta', $tiposreceta);
		 	$this->load->view('footer_gestion');
		}
		*/

		###################
		# CRUD DE NOTICIA #
		###################

		// Función para ver la lista de noticias 
		function ver_noticia() {
    		$num_paginas = 10; // Noticias mostrados por página
			$config['base_url'] = base_url().'Gestion/ver_noticia/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Noticia_model->num_noticias(); // Calcula el número de noticias
			$config['per_page'] = $num_paginas; // Número de noticias mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 3; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 
			$datos_noticia['clave'] = $this->Noticia_model->get_noticias_paginadas($config['per_page'], $this->uri->segment(3)); 
    		
    	$this->load->view('head_gestion');
    	$this->load->view('listaNoticias', $datos_noticia);
    	$this->load->view('footer_gestion');
		}

		// Función para eliminar una noticia en concreto
		function eliminar_noticia($id_noticia) {
			$id_foto_portada = $this->Noticia_model->get_noticia_by_id($id_noticia)[0]['id_foto_portada'];
			$galeria = $this->Noticia_model->get_fotos_noticia($id_noticia);
			$this->Noticia_model->borrar_noticia($id_noticia);
			$this->Foto_model->delete_foto($id_foto_portada);
			foreach ($galeria as $foto) {
				$this->Foto_model->delete_foto($foto['id']);
			}
			redirect('Gestion/ver_noticia', 'refresh');
		}

		// Función que llama al formulario de creación de nueva noticia
		function nueva_noticia() {
    	$noticia['eventos'] = $this->Evento_model->get_eventos();
    	$this->load->view('head_gestion');
    	$this->load->view('form_noticia', $noticia);
    	$this->load->view('footer_gestion');
		}

		// Función para crear una nueva noticia
		function crear_noticia() {
			$tit = $this->input->post('titulo');
    	$cont = $this->input->post('contenido');
			$desc = $this->input->post('descripcion');
			$event = $this->input->post('evento');
			if($event == 0) $event = "NULL";

  		$nueva_noticia = array( 'titulo'  => $tit,
  														'descripcion' => $desc,
                              'contenido' => $cont,
                        			'id_evento' => $event);

  		$this->form_validation->set_rules('titulo', 'Título', 'required|is_unique[Noticia.titulo]');
  		//$this->form_validation->set_rules('descripcion', 'Descripción', 'required');
  		//$this->form_validation->set_rules('contenido', 'Contenido', 'required');

			if($this->form_validation->run()) { //Si la validación es correcta

				$config['upload_path'] = './assets/img/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';

        $this->load->library('upload', $config);
        //SI LA IMAGEN FALLA AL SUBIR MOSTRAMOS EL ERROR EN LA VISTA UPLOAD_VIEW
        if (!$this->upload->do_upload()) {
          $noticia['eventos'] = $this->Evento_model->get_eventos();
      		$noticia['noticia'] = $nueva_noticia;
          $noticia['error'] = $this->upload->display_errors();
	     		$this->load->view('head_gestion');
	      	$this->load->view('form_noticia',$noticia);
	      	$this->load->view('footer_gestion');
        } else {
	        //EN OTRO CASO SUBIMOS LA IMAGEN, CREAMOS LA MINIATURA Y HACEMOS 
	        //ENVÍAMOS LOS DATOS AL MODELO PARA HACER LA INSERCIÓN
          $file_info = $this->upload->data();

          $data = array('upload_data' => $this->upload->data());
          $titulo = $file_info['file_name'];
          $imagen = "/assets/img/".$file_info['file_name'];
          $subir = $this->Foto_model->insert_foto($titulo,$imagen);  

          $nueva_noticia['id_foto_portada'] = $this->Foto_model->get_foto_by_nombre($titulo)[0]['id'];

          $this->Noticia_model->crear_noticia($nueva_noticia);
      		redirect('Gestion/ver_noticia', 'refresh');    
        }	
      } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
      	$noticia['eventos'] = $this->Evento_model->get_eventos();
      	$noticia['noticia'] = $nueva_noticia;
     		$this->load->view('head_gestion');
      	$this->load->view('form_noticia', $noticia);
      	$this->load->view('footer_gestion');
      }
		}

		// Función que llama al formulario para modificar una noticia
		function modificar_noticia($id_noticia) {
			$noticia['noticia'] = $this->Noticia_model->get_noticia_by_id($id_noticia)[0];
			$noticia['eventos'] = $this->Evento_model->get_eventos();
			$this->load->view('head_gestion');
			$this->load->view('form_noticia', $noticia);
			$this->load->view('footer_gestion');
		}

		// Función para modificar una noticia
		function cambio_noticia($id_noticia) {
			$tit = $this->input->post('titulo');
    	$cont = $this->input->post('contenido');
			$desc = $this->input->post('descripcion');
			$event = $this->input->post('evento');
			if($event == 0) $event = "NULL";

  		$nueva_noticia = array( 'id' => $id_noticia,
  														'titulo'  => $tit,
  														'descripcion' => $desc,
                              'contenido' => $cont,
                        			'id_evento' => $event,
                        			'foto' => $this->Noticia_model->get_noticia_by_id($id_noticia)[0]['foto']);

  		$this->form_validation->set_rules('titulo', 'Título', 'required');
  		//$this->form_validation->set_rules('descripcion', 'Descripción', 'required');
  		//$this->form_validation->set_rules('contenido', 'Contenido', 'required');

			if($this->form_validation->run()) { //Si la validación es correcta

				$config['upload_path'] = './assets/img/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';

        $this->load->library('upload', $config);
        //SI LA IMAGEN FALLA AL SUBIR MOSTRAMOS EL ERROR EN LA VISTA UPLOAD_VIEW
        if ($this->upload->do_upload()) {
	        //EN OTRO CASO SUBIMOS LA IMAGEN, CREAMOS LA MINIATURA Y HACEMOS 
	        //ENVÍAMOS LOS DATOS AL MODELO PARA HACER LA INSERCIÓN
          $file_info = $this->upload->data();

          $data = array('upload_data' => $this->upload->data());
          $titulo = $file_info['file_name'];
          $imagen = "/assets/img/".$file_info['file_name'];
          $subir = $this->Foto_model->insert_foto($titulo,$imagen);  

          $this->Noticia_model->actualizar_foto_portada($this->Foto_model->get_foto_by_nombre($titulo)[0]['id'], $id_noticia);
        }	

        $this->Noticia_model->modificar_noticia($nueva_noticia, $id_noticia);
      	redirect('Gestion/ver_noticia', 'refresh'); 
      } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
      	$noticia['eventos'] = $this->Evento_model->get_eventos();
      	$noticia['noticia'] = $nueva_noticia;
     		$this->load->view('head_gestion');
      	$this->load->view('form_noticia', $noticia);
      	$this->load->view('footer_gestion');
      }
		}

		// Función para buscar una noticia
		function buscar_noticia() {
			$texto = $this->input->post('search_box');
			$num_paginas = 10; // Activos mostrados por página
			$config['base_url'] = base_url().'Gestion/buscar_noticia/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Noticia_model->get_total_noticias_buscar($texto); // Calcula el número de activos
			$config['per_page'] = $num_paginas; // Número de activos mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 3; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 

			$noticias['clave'] = $this->Noticia_model->get_noticias_buscar($texto, $config['per_page'], $this->uri->segment(3));
			$noticias['busqueda'] = true;
			$this->load->view('head_gestion');
		 	$this->load->view('listaNoticias', $noticias);
		 	$this->load->view('footer_gestion');
		}

		function modificar_galeria($id_noticia){
        $data = array();
        if($this->input->post('fileSubmit') && !empty($_FILES['userFiles']['name'])){
            $filesCount = count($_FILES['userFiles']['name']);
            for($i = 0; $i < $filesCount; $i++){
                $_FILES['userFile']['name'] = $_FILES['userFiles']['name'][$i];
                $_FILES['userFile']['type'] = $_FILES['userFiles']['type'][$i];
                $_FILES['userFile']['tmp_name'] = $_FILES['userFiles']['tmp_name'][$i];
                $_FILES['userFile']['error'] = $_FILES['userFiles']['error'][$i];
                $_FILES['userFile']['size'] = $_FILES['userFiles']['size'][$i];

                $uploadPath = "assets/img";
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $uploadData[$i]['nombre'] = $fileData['file_name'];
                    $uploadData[$i]['ruta'] = "/assets/img/".$fileData['file_name'];
                    //$uploadData[$i]['created'] = date("Y-m-d H:i:s");
                    //$uploadData[$i]['modified'] = date("Y-m-d H:i:s");
                }
            }
            
            if(!empty($uploadData)){
                //Insert file information into the database
                $insert = $this->Foto_model->insert_galeria($uploadData, $id_noticia);
                $statusMsg = $insert?'Las imágenes se han subido correctamente.':'Ha ocurrido un problema, por favor inténtalo de nuevo.';
                $this->session->set_flashdata('statusMsg',$statusMsg);
            }
        }
        //Get files data from database
        $data['files'] = $this->Noticia_model->get_fotos_noticia($id_noticia);//$this->Foto_model->getRows();
        $data['noticia'] = $this->Noticia_model->get_noticia_by_id($id_noticia)[0];
        //Pass the files data to view
        $this->load->view('head_gestion');
		 		$this->load->view('galeriaNoticias_view', $data);
		 		$this->load->view('footer_gestion');
    }

    function eliminar_foto_galeria($id_noticia, $id_foto){
    	$this->Foto_model->delete_foto_galeria($id_noticia,$id_foto);
    	redirect("Gestion/modificar_galeria/$id_noticia");
    }

    function agradecimientos_noticia($id_noticia){
    	$data['agradecimientos'] = $this->Noticia_model->get_agradecimientos($id_noticia);
    	$data['noticia'] = $this->Noticia_model->get_noticia_by_id($id_noticia)[0];
    	$this->load->view('head_gestion');
	 		$this->load->view('listaAgradecimientos', $data);
	 		$this->load->view('footer_gestion');
    }

    function modificar_agradecimiento($id_agradecimiento){
    	$data['agradecimiento'] = $this->Noticia_model->get_agradecimiento_by_id($id_agradecimiento);
    	$data['id_noticia'] = $data['agradecimiento']['id_noticia'];
    	$this->load->view('head_gestion');
	 		$this->load->view('form_agradecimiento', $data);
	 		$this->load->view('footer_gestion');
    }

    function nuevo_agradecimiento($id_noticia){
 			$data['id_noticia'] = $id_noticia;
    	$this->load->view('head_gestion');
	 		$this->load->view('form_agradecimiento', $data);
	 		$this->load->view('footer_gestion');
    }

    // Función para crear un nuevo agradecimiento
		function crear_agradecimiento() {
			$nota = $this->input->post('nota');
    		$comentario = $this->input->post('comentario');
			$agradecimiento = $this->input->post('agradecimiento');
			$id_noticia = $this->input->post('id_noticia');

  		$nuevo_agradecimiento = array( 'nota'  => $nota,
  														'comentario' => $comentario,
                              'agradecimiento' => $agradecimiento,
                        			'id_noticia' => $id_noticia);

  		$this->form_validation->set_rules('nota', 'Nota', 'required');
  		$this->form_validation->set_rules('comentario', 'Comentario', 'required');
  		$this->form_validation->set_rules('agradecimiento', 'Agradecimiento', 'required');

			if($this->form_validation->run()) { //Si la validación es correcta

          $this->Noticia_model->crear_agradecimiento($nuevo_agradecimiento);
      		redirect('Gestion/agradecimientos_noticia/'.$id_noticia);    
      } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
      	$data['agradecimiento'] = $nuevo_agradecimiento;
      	$data['id_noticia'] = $id_noticia;
     		$this->load->view('head_gestion');
      	$this->load->view('form_agradecimiento', $data);
      	$this->load->view('footer_gestion');
      }
		}

		// Función para modificar agradecimiento
		function cambio_agradecimiento($id_agradecimiento) {
			$nota = $this->input->post('nota');
    		$comentario = $this->input->post('comentario');
			$agradecimiento = $this->input->post('agradecimiento');
			$id_noticia = $this->input->post('id_noticia');

  		$nuevo_agradecimiento = array( 'nota'  => $nota,
  														'comentario' => $comentario,
                              'agradecimiento' => $agradecimiento,
                        			'id_noticia' => $id_noticia);

  		$this->form_validation->set_rules('nota', 'Nota', 'required');
  		$this->form_validation->set_rules('comentario', 'Comentario', 'required');
  		$this->form_validation->set_rules('agradecimiento', 'Agradecimiento', 'required');

			if($this->form_validation->run()) { //Si la validación es correcta

          $this->Noticia_model->modificar_agradecimiento($nuevo_agradecimiento, $id_agradecimiento);
      		redirect('Gestion/agradecimientos_noticia/'.$id_noticia);    
      } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
      	$data['agradecimiento'] = $nuevo_agradecimiento;
      	$data['id_noticia'] = $id_noticia;
     		$this->load->view('head_gestion');
      	$this->load->view('form_agradecimiento', $data);
      	$this->load->view('footer_gestion');
      }
		}

		function eliminar_agradecimiento($id_agradecimiento, $id_noticia){
    	$this->Noticia_model->borrar_agradecimiento($id_agradecimiento);
    	redirect("Gestion/agradecimientos_noticia/$id_noticia");
    }


		###################
		# CRUD DE EVENTOS #
		###################

		function mostrar_menus($id_evento) {

			$num_paginas = 10; // Menús mostrados por página
			$config['base_url'] = base_url().'Gestion/mostrar_menus/'.$id_evento.'/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Evento_model->num_menus_evento($id_evento); // Calcula el número de menus
			$config['per_page'] = $num_paginas; // Número de menus mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 4; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 
			$evento['clave_menu'] = $this->Evento_model->get_menus_evento_paginados($id_evento, $config['per_page'], $this->uri->segment(4)); 

			$id_evento = (int)$id_evento;
			$evento['clave_evento']   = $this->Evento_model->get_evento_id($id_evento);
			$this->load->view('head_gestion');
			$this->load->view('mostrarMenu', $evento);
			$this->load->view('footer_gestion');
		}

		function eliminar_menu_evento($id_menu, $id_evento) {
			$id_menu = (int)$this->uri->segment(3);
			$id_evento = (int)$this->uri->segment(4);
			$this->Evento_model->delete_evento_menu($id_menu, $id_evento);
			redirect('Gestion/mostrar_menus/'."$id_evento", 'refresh');
		}

		function insertar_menu($id_evento) {
			$id_evento = (int)$id_evento;
			$evento['clave_menu']   = $this->Evento_model->get_menu_not_evento($id_evento);
			$evento['clave_evento']     = $this->Evento_model->get_evento_id($id_evento);
			$this->load->view('head_gestion');
			$this->load->view('nuevoMenu', $evento);
			$this->load->view('footer_gestion');
		}

		function insertar_menu_evento($id_evento) {
			$id_evento = (int)$id_evento;
			$tipo = $this->input->post('tipo');
			$cantidad = $this->input->post('cantidad');

			if(empty($tipo))
				$this->form_validation->set_rules('tipo', 'Menú', 'required');

			$this->form_validation->set_rules('cantidad', 'Cantidad', 'required|numeric|greater_than_equal_to[0]|integer');

    		if($this->form_validation->run()) { //Si la validación es correcta
    			$this->Evento_model->create_evento_menu($id_evento, $tipo, $cantidad);
	            redirect('Gestion/mostrar_menus/'.$id_evento, 'refresh');
	        } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
				$evento['clave_menu']   = $this->Evento_model->get_menu_not_evento($id_evento);
				$evento['clave_evento']     = $this->Evento_model->get_evento_id($id_evento);
	            $this->load->view('head_gestion');
				$this->load->view('nuevoMenu', $evento);
				$this->load->view('footer_gestion');
	        }
		}

		function aumentar_menu_evento($id_menu, $id_evento){
			$id_menu = (int)$this->uri->segment(3);
			$id_evento = (int)$this->uri->segment(4);
			$a = $this->Evento_model->sumar_menu($id_menu, $id_evento);
			redirect('Gestion/mostrar_menus/'."$id_evento", 'refresh');	
		}

		function reducir_menu_evento($id_menu, $id_evento){
			$id_menu = (int)$this->uri->segment(3);
			$id_evento = (int)$this->uri->segment(4);
			$a = $this->Evento_model->restar_menu($id_menu, $id_evento);
			redirect('Gestion/mostrar_menus/'."$id_evento", 'refresh');	
		}

		function mostrar_materiales($id_evento) {
			$num_paginas = 10; // Activos mostrados por página
			$config['base_url'] = base_url().'Gestion/mostrar_menus/'.$id_evento.'/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Evento_model->num_materiales_evento($id_evento); // Calcula el número de activos
			$config['per_page'] = $num_paginas; // Número de activos mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 4; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 
			$evento['clave_material'] = $this->Evento_model->get_materiales_evento_paginados($id_evento, $config['per_page'], $this->uri->segment(4)); 

			$id_evento = (int)$id_evento;
			$evento['clave_evento']   = $this->Evento_model->get_evento_id($id_evento);
			$this->load->view('head_gestion');
			$this->load->view('mostrarMaterial', $evento);
			$this->load->view('footer_gestion');
		}

		function aumentar_material_evento($id_material, $id_evento){
			$id_material = (int)$this->uri->segment(3);
			$id_evento = (int)$this->uri->segment(4);
			$a = $this->Evento_model->sumar_material($id_material, $id_evento);
			redirect('Gestion/mostrar_materiales/'."$id_evento", 'refresh');	
		}

		function reducir_material_evento($id_material, $id_evento){
			$id_material = (int)$this->uri->segment(3);
			$id_evento = (int)$this->uri->segment(4);
			$a = $this->Evento_model->restar_material($id_material, $id_evento);
			redirect('Gestion/mostrar_materiales/'."$id_evento", 'refresh');	
		}

		function eliminar_material_evento($id_material, $id_evento) {
			$id_material = (int)$this->uri->segment(3);
			$id_evento = (int)$this->uri->segment(4);
			$this->Evento_model->delete_evento_material($id_material, $id_evento);
			redirect('Gestion/mostrar_materiales/'."$id_evento", 'refresh');
		}

		function insertar_material($id_evento) {
			$id_evento = (int)$id_evento;
			$evento['clave_material']   = $this->Evento_model->get_material_not_evento($id_evento);
			$evento['clave_evento']     = $this->Evento_model->get_evento_id($id_evento);
			$this->load->view('head_gestion');
			$this->load->view('nuevoMaterial', $evento);
			$this->load->view('footer_gestion');
		}

		function insertar_material_evento($id_evento) {

			$id_evento = (int)$id_evento;
			$tipo = $this->input->post('tipo');
			$cantidad = $this->input->post('cantidad');

			if(empty($tipo))
				$this->form_validation->set_rules('tipo', 'Material', 'required');

			$this->form_validation->set_rules('cantidad', 'Cantidad', 'required|numeric|greater_than_equal_to[0]|integer');

    		if($this->form_validation->run()) { //Si la validación es correcta
    			$this->Evento_model->create_evento_material($id_evento, $tipo, $cantidad);
	            redirect('Gestion/mostrar_materiales/'.$id_evento, 'refresh');
	        } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
				$evento['clave_material']   = $this->Evento_model->get_material_not_evento($id_evento);
				$evento['clave_evento']     = $this->Evento_model->get_evento_id($id_evento);
				$this->load->view('head_gestion');
				$this->load->view('nuevoMaterial', $evento);
				$this->load->view('footer_gestion');
	        }
		}

		function mostrar_trabajadores($id_evento) {

			$num_paginas = 10; // Activos mostrados por página
			$config['base_url'] = base_url().'Gestion/mostrar_trabajadores/'.$id_evento.'/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Evento_model->num_trabajadores_evento($id_evento); // Calcula el número de activos
			$config['per_page'] = $num_paginas; // Número de activos mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 4; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 
			$evento['clave_trabajador'] = $this->Evento_model->get_trabajadores_evento_paginados($id_evento, $config['per_page'], $this->uri->segment(4)); 

			$id_evento = (int)$id_evento;
			$evento['clave_evento']   = $this->Evento_model->get_evento_id($id_evento);
			$this->load->view('head_gestion');
			$this->load->view('mostrarTrabajador', $evento);
			$this->load->view('footer_gestion');
		}

		function eliminar_trabajador_evento($id_trabajador, $id_evento) {
			$id_trabajador = (int)$this->uri->segment(3);
			$id_evento = (int)$this->uri->segment(4);
			$this->Evento_model->delete_evento_trabajador($id_trabajador, $id_evento);
			redirect('Gestion/mostrar_trabajadores/'."$id_evento", 'refresh');
		}

		function insertar_trabajador($id_evento) {
			$id_evento = (int)$id_evento;
			$evento['clave_trabajador']   = $this->Evento_model->get_trabajador_not_evento($id_evento);
			$evento['clave_evento']     = $this->Evento_model->get_evento_id($id_evento);
			$this->load->view('head_gestion');
			$this->load->view('nuevoTrabajador', $evento);
			$this->load->view('footer_gestion');
		}

		function insertar_trabajador_evento($id_evento) {

			$id_evento = (int)$id_evento;
			$tipo = $this->input->post('tipo');
			$horas = $this->input->post('horas');

			if(empty($tipo))
				$this->form_validation->set_rules('tipo', 'Trabajador', 'required');

			$this->form_validation->set_rules('horas', 'Horas', 'required|numeric|greater_than_equal_to[0]');

    		if($this->form_validation->run()) { //Si la validación es correcta
				$this->Evento_model->create_evento_trabajador($id_evento, $tipo, $horas);
	            redirect('Gestion/mostrar_trabajadores/'.$id_evento, 'refresh');
	        } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
				$evento['clave_trabajador']   = $this->Evento_model->get_trabajador_not_evento($id_evento);
				$evento['clave_evento']     = $this->Evento_model->get_evento_id($id_evento);
				$this->load->view('head_gestion');
				$this->load->view('nuevoTrabajador', $evento);
				$this->load->view('footer_gestion');
	        }
		}

		// Función para ver la lista de eventos
		function ver_evento() {
 			$num_paginas = 10; // Eventos mostrados por página
			$config['base_url'] = base_url().'Gestion/ver_evento/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Evento_model->num_eventos(); // Calcula el número de eventos
			$config['per_page'] = $num_paginas; // Número de eventos mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 3; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 
			$datos_evento['clave'] = $this->Evento_model->get_eventos_paginados($config['per_page'], $this->uri->segment(3)); 

    		/*
    		if (is_null($datos_noticia['clave']['id_evento']))
    			$datos_noticia['clave']['id_evento'] = "-";
    		else
    			$datos_noticia['clave']['id_evento'] = $this->Evento_model->get_evento_titulo($datos_noticia['clave']['id_evento']);
    		*/
        	$this->load->view('head_gestion');
        	$this->load->view('listaEventos', $datos_evento);
        	$this->load->view('footer_gestion');
		}

		// Función para eliminar un evento concreto
		function eliminar_evento($id_evento) {
			if($this->Evento_model->num_noticias_asociadas($id_evento) == 0) {
				$this->Evento_model->borrar_evento($id_evento);
				redirect('Gestion/ver_evento', 'refresh');
			}
			else {
				$this->session->set_flashdata('mensaje', 'Error al eliminar. Existen noticias asociadas.');
				redirect('Gestion/ver_evento');
			}
		}

		// Función que llama al formulario de creación de evento
		function nuevo_evento() {
        	$this->load->view('head_gestion');
        	$this->load->view('form_evento');
        	$this->load->view('footer_gestion');
		}

		// Función para crear un nuevo evento
		function crear_evento() {
    		$nuevo_evento = array('titulo'  => $this->input->post('titulo'),
                                  'descripcion' => $this->input->post('descripcion'),
                                  'lugar' => $this->input->post('lugar'),
                                  'fecha' => $this->input->post('fecha'),
                                  'es_visible' => $this->input->post('es_visible'),
                                  'persona' => $this->input->post('persona'),
                              	  );

    		$this->form_validation->set_rules('titulo', 'Título', 'required|is_unique[Evento.titulo]');
  			$this->form_validation->set_rules('fecha', 'Fecha', 'required');
  			$this->form_validation->set_rules('persona', 'Asistentes', 'numeric|greater_than_equal_to[0]|integer');

			if($this->form_validation->run()){ //Si la validación es correcta
    			$this->Evento_model->crear_evento($nuevo_evento);
	            redirect('Gestion/ver_evento', 'refresh');
	        } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
            	$this->load->view('head_gestion');
	        	$this->load->view('form_evento',$nuevo_evento);
	        	$this->load->view('footer_gestion');
	        }
		}

		// Función que llama al formulario de modificación de evento en concreto
		function modificar_evento($id_evento) {
			$evento['clave'] = $this->Evento_model->get_evento_id($id_evento);
			$this->load->view('head_gestion');
			$this->load->view('form_cambio_evento', $evento);
			$this->load->view('footer_gestion');
		}

		// Función para modificar un evento en concreto
		function cambio_evento($id_evento) {
			$nuevo_cambio = array('titulo'  => $this->input->post('titulo'),
                                  'descripcion' => $this->input->post('descripcion'),
                                  'lugar' => $this->input->post('lugar'),
                                  'fecha' => $this->input->post('fecha'),
                                  'persona' => $this->input->post('persona'),
                                  'es_visible' => $this->input->post('es_visible'),
                              	  );

			$evento['clave'] = $this->Evento_model->get_evento_id($id_evento);

			if($evento['clave']['titulo'] == $nuevo_cambio['titulo'])
				$this->form_validation->set_rules('titulo', 'Título', 'required');
			else
				$this->form_validation->set_rules('titulo', 'Título', 'required|is_unique[Evento.titulo]');

  			$this->form_validation->set_rules('fecha', 'Fecha', 'required');
  			$this->form_validation->set_rules('persona', 'Asistentes', 'numeric|greater_than_equal_to[0]|integer');

			if($this->form_validation->run()) { //Si la validación es correcta
    			$this->Evento_model->modificar_evento($nuevo_cambio, $id_evento);
	            redirect('Gestion/ver_evento', 'refresh');
	        } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
	        	$nuevo_cambio['clave'] = $this->Evento_model->get_evento_id($id_evento);
            	$this->load->view('head_gestion');
	        	$this->load->view('form_cambio_evento',$nuevo_cambio);
	        	$this->load->view('footer_gestion');
	        }
		}

		function generar_pdf_listaCompraEvento($id_evento) {
			exec("sudo python3 -m calculadoraAlimentos listaCompraEvento ".$id_evento);
			$name = "evento.pdf";
			$data = file_get_contents($name);
       		force_download($name,$data);
		}

		function generar_pdf_beneficioEvento($id_evento) {
			exec("sudo python3 -m calculadoraAlimentos beneficioEvento ".$id_evento);
			$name = "evento.pdf";
			$data = file_get_contents($name);
       		force_download($name,$data);
		}

		// Función para buscar un evento
		function buscar_evento() {
			$texto = $this->input->post('search_box');
			$num_paginas = 6; // Activos mostrados por página
			$config['base_url'] = base_url().'Gestion/buscar_evento/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Evento_model->get_total_eventos_buscar($texto); // Calcula el número de activos
			$config['per_page'] = $num_paginas; // Número de activos mostrados por cada página
			$config['num_links'] = 6; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 3; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 

			$eventos['clave'] = $this->Evento_model->get_eventos_buscar($texto, $config['per_page'], $this->uri->segment(3));
			$eventos['busqueda'] = true;
 
    		$this->load->view('head_gestion');
        	$this->load->view('listaEventos', $eventos);
        	$this->load->view('footer_gestion');
		}

		function buscar_menu_evento($id_evento) {
			$texto = $this->input->post('search_box');
			$num_paginas = 10; // Activos mostrados por página
			$config['base_url'] = base_url().'Gestion/buscar_menu_evento/'.$id_evento.'/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Evento_model->get_total_menus_evento_buscar($id_evento, $texto); // Calcula el número de Activos
			$config['per_page'] = $num_paginas; // Número de activos mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 4; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 
			$evento['clave_menu'] = $this->Evento_model->get_menus_evento_buscar($id_evento, $texto, $config['per_page'], $this->uri->segment(4)); 
			$evento['busqueda'] = true;

			$id_evento = (int)$id_evento;
			$evento['clave_evento'] = $this->Evento_model->get_evento_id($id_evento);
			$this->load->view('head_gestion');
			$this->load->view('mostrarMenu', $evento);
			$this->load->view('footer_gestion');
		}

		function buscar_material_evento($id_evento) {
			$texto = $this->input->post('search_box');
			$num_paginas = 10; // Activos mostrados por página
			$config['base_url'] = base_url().'Gestion/buscar_material_evento/'.$id_evento.'/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Evento_model->get_total_materiales_evento_buscar($id_evento, $texto); // Calcula el número de Activos
			$config['per_page'] = $num_paginas; // Número de activos mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 4; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 
			$evento['clave_material'] = $this->Evento_model->get_materiales_evento_buscar($id_evento, $texto, $config['per_page'], $this->uri->segment(4)); 
			$evento['busqueda'] = true;

			$id_evento = (int)$id_evento;
			$evento['clave_evento'] = $this->Evento_model->get_evento_id($id_evento);
			$this->load->view('head_gestion');
			$this->load->view('mostrarMaterial', $evento);
			$this->load->view('footer_gestion');
		}

		function buscar_trabajador_evento($id_evento) {
			$texto = $this->input->post('search_box');
			$num_paginas = 10; // Activos mostrados por página
			$config['base_url'] = base_url().'Gestion/buscar_trabajador_evento/'.$id_evento.'/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Evento_model->get_total_trabajadores_evento_buscar($id_evento, $texto); // Calcula el número de Activos
			$config['per_page'] = $num_paginas; // Número de activos mostrados por cada página
			$config['num_links'] = 20; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 4; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 
			$evento['clave_trabajador'] = $this->Evento_model->get_trabajadores_evento_buscar($id_evento, $texto, $config['per_page'], $this->uri->segment(4)); 
			$evento['busqueda'] = true;

			$id_evento = (int)$id_evento;
			$evento['clave_evento'] = $this->Evento_model->get_evento_id($id_evento);
			$this->load->view('head_gestion');
			$this->load->view('mostrarTrabajador', $evento);
			$this->load->view('footer_gestion');
		}

		##################
		# CRUD DE RECETA #
		##################
		 
		// Función para ver la lista de recetas disponibles
		function ver_receta() {	
    		$num_paginas = 6; // Activos mostrados por página
			$config['base_url'] = base_url().'Gestion/ver_receta/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Recetas_model->num_recetas(); // Calcula el número de activos
			$config['per_page'] = $num_paginas; // Número de activos mostrados por cada página
			$config['num_links'] = 3; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 3; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 
			$datos_recetas['recetas'] = $this->Recetas_model->get_recetas_paginadas($config['per_page'], $this->uri->segment(3)); 
    		$datos_recetas['ultimas_recetas'] = $this->Recetas_model->get_last_recipes();
    		$this->load->view('head_gestion');
        	$this->load->view('listaRecetas', $datos_recetas);
        	$this->load->view('footer_gestion');
		}

		# Visualización de una única receta
		function receta ($id, $menu = null) {
			//if( !isset( $_GET['id'] ) ){ // VISTA DE TODAS LAS RECETAS
			if( !isset( $id ) ){
			} else { // RECETA CONCRETA
				$receta = $this->Recetas_model->getRecipeInfo( $id );
				$receta['id'] = $id;

				$foto = ( count( $receta['fotos'] ) == 0 ? site_url().'/assets/img/default.jpg' : site_url().reset($receta['fotos']) );
				// SI NO HAY FOTOS, CARGA UNA POR DEFECTO. SI HAY MAS DE UNA, CARGA LA PRIMERA

				$productos = $receta['productos'];

				$instrucciones = $receta['instrucciones'];
				$ultimas_recetas = $this->Recetas_model->get_last_recipes();
				$this->load->view('head_gestion');
				$this->load->view('receta', compact('receta', 'productos', 'instrucciones', 'foto', 'ultimas_recetas', 'menu'));
				$this->load->view('footer_gestion');
			}
		}

		// Función para abrir el formulario de creación de una nueva receta
		function nueva_receta() {
	    	$receta['productos'] = $this->Producto_model->get_productos_order();
	   		
	    	$this->load->view('head_gestion');
	    	$this->load->view('form_receta', $receta);
	    	$this->load->view('footer_gestion');
		}

		// Función para crear una nueva receta
		function crear_receta() {
			$nom = $this->input->post('nombre');
			$desc = $this->input->post('descripcion');
			$nota = $this->input->post('nota');
			$com = $this->input->post('comensales');
			$tiem = $this->input->post('tiempo');
			$prec = $this->input->post('precio');
			$val = $this->input->post('valoracion');

			// Conseguir las instrucciones del formulario de receta:
			$inst_array = $this->input->post('inst[]');

			// Conseguir los ingredientes del formulario de receta:
			$prod_array = $this->input->post('prod[]');

  			$nueva_receta = array(  'nombre'  => $nom,
  									'descripcion' => $desc,
  									'nota' => $nota,
  									'comensales' => $com,
  									'tiempo' => $tiem,
  									'precio' => $prec,
  									'valoracion' => $val);

	  		$this->form_validation->set_rules('nombre', 'Nombre', 'required|is_unique[Receta.nombre]');
	  		$this->form_validation->set_rules('precio', 'Precio', 'required|numeric');
	  		$this->form_validation->set_rules('comensales', 'Comensales', 'required|integer');
	  		$this->form_validation->set_rules('tiempo', 'Tiempo', 'required|integer');
	  		$this->form_validation->set_rules('valoracion', 'Valoración', 'required');
	  		$this->form_validation->set_rules('inst[]', 'Instrucciones', 'required');
	  		for($i = 0; $i < count($prod_array); $i++){
	  			$ingred = 'prod['.$i.'][id]'; $ingred_message = 'Ingrediente '.($i+1);
	  			$cant = 'prod['.$i.'][cant]'; $cant_message = 'Cantidad '.($i+1);
	  			$unit = 'prod['.$i.'][unit]'; $unit_message = 'Unidad '.($i+1);
	  			$this->form_validation->set_rules($ingred, $ingred_message, 'callback_select_validate');
	  			$this->form_validation->set_rules($cant, $cant_message, 'required|integer');
	  			$this->form_validation->set_rules($unit, $unit_message, 'callback_select_validate|callback_check_unit['.$prod_array[$i]['id'].']');
	  		}

			if($this->form_validation->run()) { //Si la validación es correcta

				$config['upload_path'] = './assets/img/';
		        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';

		        $this->load->library('upload', $config);
		        //SI LA IMAGEN FALLA AL SUBIR MOSTRAMOS EL ERROR EN LA VISTA UPLOAD_VIEW
		        if (!$this->upload->do_upload()) {
		        	$receta['productos'] = $this->Producto_model->get_productos_order();
		      		$receta['receta'] = $nueva_receta;
		      		$receta['receta']['instrucciones'] = $inst_array;
			      	$receta['receta']['productos'] = $prod_array;
		        	$receta['error'] = $this->upload->display_errors();
			     	$this->load->view('head_gestion');
			      	$this->load->view('form_receta', $receta);
			      	$this->load->view('footer_gestion');
		    	} else {
					    //EN OTRO CASO SUBIMOS LA IMAGEN, CREAMOS LA MINIATURA Y 
					    //ENVÍAMOS LOS DATOS AL MODELO PARA HACER LA INSERCIÓN
				        $file_info = $this->upload->data();

				        $data = array('upload_data' => $this->upload->data());
				        $nombre = $file_info['file_name'];
				        $imagen = "/assets/img/".$file_info['file_name'];
				        $subir = $this->Foto_model->insert_foto($nombre, $imagen);  

				        $id_foto = $this->Foto_model->get_foto_by_nombre($nombre)[0]['id'];

				        $this->Recetas_model->crear_receta($nueva_receta);
				        $this->Recetas_model->set_receta_variables($nueva_receta['nombre'], $prod_array, $inst_array, $id_foto);
				      	redirect('Gestion/receta/'.$this->Recetas_model->get_recipe_by_name($nueva_receta['nombre']), 'refresh');    
		        	}	
		    } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
			      	$receta['productos'] = $this->Producto_model->get_productos_order();
			      	$receta['receta'] = $nueva_receta;
			      	$receta['receta']['instrucciones'] = $inst_array;
			      	$receta['receta']['productos'] = $prod_array;
			     	$this->load->view('head_gestion');
			      	$this->load->view('form_receta', $receta);
			      	$this->load->view('footer_gestion');
		    	}
		}

		// Función para abrir el formulario de modificación de una receta
		function modificar_receta($id) {
	    	$receta['productos'] = $this->Producto_model->get_productos_order();
	    	$receta['receta'] = $this->Recetas_model->getRecipeInfo( $id );
	    	$receta['receta']['tiempo'] = $receta['receta']['horas']*60+$receta['receta']['minutos'];  
	    	$receta['id'] = $id; 

	    	$this->load->view('head_gestion');
	    	$this->load->view('form_receta', $receta);
	    	$this->load->view('footer_gestion');
		}

		// Función para eliminar una receta existente
		function eliminar_receta($id) {
			if($this->Recetas_model->num_menus_receta($id) == 0) {
				
				$galeria = $this->Recetas_model->get_fotos_receta($id);
				$this->Recetas_model->borrar_receta($id);
				foreach ($galeria as $foto) {
					$this->Foto_model->delete_foto($foto['id_foto']);
				}
				redirect('Gestion/ver_receta', 'refresh');
			}
			else {
				$this->session->set_flashdata('mensaje', 'Error al eliminar. Existen menús asociados.');
				redirect('Gestion/receta/'.$id);
			}
		}

		// Función para crear una nueva receta
		function cambio_receta($id) {
			$nom = $this->input->post('nombre');
			$desc = $this->input->post('descripcion');
			$nota = $this->input->post('nota');
			$com = $this->input->post('comensales');
			$tiem = $this->input->post('tiempo');
			$prec = $this->input->post('precio');
			$val = $this->input->post('valoracion');

			// Conseguir las instrucciones del formulario de receta:
			$inst_array = $this->input->post('inst[]');

			// Conseguir los ingredientes del formulario de receta:
			$prod_array = $this->input->post('prod[]');

			$productos = $this->Producto_model->get_productos_order();
			$prod_units = [];
			foreach ($productos as $prod) {
				$prod_units[$prod['id']] = $prod['unidad'];
			}

  			$nueva_receta = array(  'id' => $id,
  									'nombre'  => $nom,
  									'descripcion' => $desc,
  									'nota' => $nota,
  									'comensales' => $com,
  									'tiempo' => $tiem,
  									'precio' => $prec,
  									'valoracion' => $val,
  									'fotos' => $this->Recetas_model->getRecipeInfo($id)['fotos']);

	  		$this->form_validation->set_rules('nombre', 'Nombre', 'required');
	  		$this->form_validation->set_rules('precio', 'Precio', 'required|numeric');
	  		$this->form_validation->set_rules('comensales', 'Comensales', 'required|integer');
	  		$this->form_validation->set_rules('tiempo', 'Tiempo', 'required|integer');
	  		$this->form_validation->set_rules('inst[]', 'Instrucciones', 'required');
	  		$this->form_validation->set_rules('valoracion', 'Valoración', 'required');
	  		for($i = 0; $i < count($prod_array); $i++){
	  			$ingred = 'prod['.$i.'][id]'; $ingred_message = 'Ingrediente '.($i+1);
	  			$cant = 'prod['.$i.'][cant]'; $cant_message = 'Cantidad '.($i+1);
	  			$unit = 'prod['.$i.'][unit]'; $unit_message = 'Unidad '.($i+1);
	  			$this->form_validation->set_rules($ingred, $ingred_message, 'callback_select_validate');
	  			$this->form_validation->set_rules($cant, $cant_message, 'required|integer');
	  			$this->form_validation->set_rules($unit, $unit_message, 'callback_select_validate|callback_check_unit['.$prod_array[$i]['id'].']');
	  		}

			if($this->form_validation->run()) { //Si la validación es correcta

				$config['upload_path'] = './assets/img/';
		        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';

		        $this->load->library('upload', $config);
		        //SI LA IMAGEN FALLA AL SUBIR MOSTRAMOS EL ERROR EN LA VISTA UPLOAD_VIEW
		        if ($this->upload->do_upload()) {
		        	
					    //EN OTRO CASO SUBIMOS LA IMAGEN, CREAMOS LA MINIATURA Y 
					    //ENVÍAMOS LOS DATOS AL MODELO PARA HACER LA INSERCIÓN
				        $file_info = $this->upload->data();

				        $data = array('upload_data' => $this->upload->data());
				        $nombre = $file_info['file_name'];
				        $imagen = "/assets/img/".$file_info['file_name'];
				        $subir = $this->Foto_model->insert_foto($nombre, $imagen);  

				        $id_foto = $this->Foto_model->get_foto_by_nombre($nombre)[0]['id'];

				        $this->Recetas_model->modificar_photo_receta($id, $id_foto);
				      }

				        $this->Recetas_model->modificar_receta($nueva_receta);
				        $this->Recetas_model->modificar_receta_variables($nueva_receta['nombre'], $prod_array, $inst_array);
				      	redirect('Gestion/receta/'.$id, 'refresh');    
		        		
		    } else { // Si no, volvemos a la vista pasandole los datos que se añadieron al formulario para mostrarlos de nuevo, además del error
			      	$receta['productos'] = $this->Producto_model->get_productos_order();
			      	$receta['receta'] = $nueva_receta;
			      	$receta['receta']['instrucciones'] = $inst_array;
			      	$receta['receta']['productos'] = $prod_array;
			     	$this->load->view('head_gestion');
			      	$this->load->view('form_receta', $receta);
			      	$this->load->view('footer_gestion');
		    	}
		}

		// Función para comprobar que el usuario ha seleccionado un ingrediente de la select box
		function select_validate ($option)
		{
			if($option == "none"){
				$this->form_validation->set_message('select_validate', 'El campo %s debe ser seleccionado.');
				return false;
			} else {
				return true;
			}
		}

		function check_unit ($option, $ingred){
			$productos = $this->Producto_model->get_productos_order();
			$prod_units = [];
			foreach ($productos as $prod) {
				$prod_units[$prod['id']] = $prod['unidad'];
			}
			
			if(mb_substr($option, -1) == mb_substr($prod_units[$ingred], -1)) {
				return true;
			} elseif (mb_substr($prod_units[$ingred], -1) == 'l'){
				if(mb_substr($option, -1) == 'o' || mb_substr($option, -1) == 'a') {
					return true;
				}
			}
			$this->form_validation->set_message('check_unit', 'El campo %s no es válido');
			return false;
		}

		// Función para buscar una receta
		function buscar_receta() {
			$texto = $this->input->post('search_box');
			$num_paginas = 6; // Activos mostrados por página
			$config['base_url'] = base_url().'Gestion/buscar_receta/'; // Dirección base de la primera página
			$config['total_rows'] = $this->Recetas_model->get_total_recetas_buscar($texto); // Calcula el número de activos
			$config['per_page'] = $num_paginas; // Número de activos mostrados por cada página
			$config['num_links'] = 3; // Número de links que se muestran en la paginación
			$config['first_link'] = 'Primera'; // Primer link
			$config['last_link'] = 'Última'; // Último link
			$config['uri_segment'] = 3; // Segmento de la paginación (Esto es, lugar de la URL donde se encuentra el nº de la página)
			// Cada segmento es cada elemento entre / / en la URL
			$config['next_link'] = 'Siguiente';// Siguiente link
			$config['prev_link'] = 'Anterior';// Anterior link
			$this->pagination->initialize($config); // Inicializamos la paginación 

			$datos_recetas['recetas'] = $this->Recetas_model->get_recetas_buscar($texto, $config['per_page'], $this->uri->segment(3)); 

    		$datos_recetas['ultimas_recetas'] = $this->Recetas_model->get_last_recipes();
    		$this->load->view('head_gestion');
        	$this->load->view('listaRecetas', $datos_recetas);
        	$this->load->view('footer_gestion');
		}

		function generar_pdf_listaCompraReceta($id_receta) {
			exec("sudo python3 -m calculadoraAlimentos listaCompraReceta ".$id_receta);
			$name = "receta.pdf";
			$data = file_get_contents($name);
       		force_download($name,$data);
		}

		function generar_pdf_beneficioReceta($id_receta) {
			exec("sudo python3 -m calculadoraAlimentos beneficioReceta ".$id_receta);
			$name = "receta.pdf";
			$data = file_get_contents($name);
       		force_download($name,$data);
		}
}
?>