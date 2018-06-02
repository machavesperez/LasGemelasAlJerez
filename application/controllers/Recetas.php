<?php

class Recetas extends CI_Controller 
	{
		function __construct()
		{
			parent::__construct();
			$this->load->model('Recetas_model');
		}

		function index($id)
		{
			if( !isset( $_GET['id'] ) ){ // VISTA DE TODAS LAS RECETAS

			} else { // RECETA CONCRETA
				$receta = $this->recetas_model->getRecipeInfo( $_GET['id'] );

				/*$foto = base_url().'/assets/img/'.( count( $receta['fotos'] ) == 0 ? 'default' : reset($receta['fotos']) ).'.jpg';*/
				$foto = ( count( $receta['fotos'] ) == 0 ? site_url().'/assets/img/default.jpg' : reset($receta['fotos']) );
				// SI NO HAY FOTOS, CARGA UNA POR DEFECTO. SI HAY MAS DE UNA, CARGA LA PRIMERA

				//$tipos [] = $receta['tipos'];

				$productos = $receta['productos'];

				$this->load->view('head2');
				$this->load->view('receta', compact('receta', 'productos', 'foto'));
				$this->load->view('footer');
			}
		}


	}

?>