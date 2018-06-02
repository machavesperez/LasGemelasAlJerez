<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Recetas_model extends CI_Model {
	public function __construct(){
		parent::__construct();
	}

	// Función que consigue toda la información de una receta para mostrarla por pantalla
	public function getRecipeInfo( $id ) {
		$data = $this->db->query(
		  'SELECT Receta.id as id, Receta.nombre as receta_nombre, Receta.descripcion as receta_descripcion, Receta.nota as receta_nota, Receta.comensales as receta_comensales, Receta.tiempo as receta_tiempo, Receta.precio as receta_precio, Receta.valoracion as receta_valoracion, Receta.fecha as receta_fecha, Instruccion.id as instruccion_id, Instruccion.orden as instruccion_orden, Instruccion.paso as instruccion_paso, Foto.id as foto_id, Foto.ruta as foto_ruta, Producto.id as producto_id, Producto.nombre as producto_nombre, Receta_Producto.cantidad as producto_cantidad, Receta_Producto.unidad as producto_unidad
		   FROM Receta 
		   LEFT JOIN Receta_Producto ON Receta.id = Receta_Producto.id_receta 
		   LEFT JOIN Producto ON Receta_Producto.id_producto = Producto.id
		   LEFT JOIN Receta_Foto ON Receta_Foto.id_receta = Receta.id
		   LEFT JOIN Foto ON Receta_Foto.id_foto = Foto.id
		   LEFT JOIN Instruccion ON Receta.id = Instruccion.id_receta
		   WHERE Receta.id = ' . $id . ';'
		);

		foreach ( $data->result_array() as $row ) {
		    if ( !isset( $receta )) 
		       $receta = [ // En caso de ser la primera vez que haya esa receta
		          'nombre' => $row['receta_nombre'],
		          'descripcion' => $row['receta_descripcion'],
		          'nota' => $row['receta_nota'],
		          'comensales' => $row['receta_comensales'],
		          'horas' => floor($row['receta_tiempo'] / 60),
		          'minutos' => $row['receta_tiempo'] % 60,
		          'precio' => $row['receta_precio'],
		          'valoracion' => $row['receta_valoracion'],
		          'fecha' => $row['receta_fecha'],
		          'instrucciones' => [],
		          'fotos' => [],
		          'productos' => []
		       ];
		   

		    if ( !is_null($row['instruccion_paso']) ) $receta['instrucciones'][ $row[ 'instruccion_orden' ] ] = 
		    	$row['instruccion_paso'];
		    if ( !is_null($row['foto_ruta']) ) $receta['fotos'][ $row[ 'foto_id' ] ] = $row['foto_ruta'];
		    if ( !is_null($row['producto_nombre']) ) $receta['productos'][ $row[ 'producto_id' ] ] = $row['producto_nombre']." - ".$row['producto_cantidad']." ".$row['producto_unidad'];
		}

		//echo json_encode( $receta ); die;

		return $receta;
	}

	// Función para conseguir la información de todas las recetas
	public function getAllRecipes( ) {
		$data = $this->db->query(
		  'SELECT Receta.id as id, Receta.nombre as receta_nombre, Receta.descripcion as receta_descripcion, Receta.tiempo as receta_tiempo, Foto.id as foto_id, Foto.ruta as foto_ruta
		   FROM Receta 
		   LEFT JOIN Receta_Foto ON Receta_Foto.id_receta = Receta.id
		   LEFT JOIN Foto ON Receta_Foto.id_foto = Foto.id;'
		);

    	$finalData = [];
		foreach ( $data->result_array() as $row ) {
		    if ( !isset( $finalData[ $row[ 'id' ] ] )) 
		       $finalData[ $row[ 'id' ] ] = [ // En caso de ser la primera vez que haya esa receta
		          'nombre' => $row['receta_nombre'],
		          'descripcion' => $row['receta_descripcion'],
		          'horas' => floor($row['receta_tiempo'] / 60),
		          'minutos' => $row['receta_tiempo'] % 60,
		          'fotos' => []
		       ];
		   
		    if ( !is_null($row['foto_ruta']) ) $finalData[ $row[ 'id' ] ]['fotos'][ $row[ 'foto_id' ] ] = $row['foto_ruta'];
		
		}

		return $finalData;
	}

	function get_recipe_by_name($nombre)
	{
		return $this->db->get_where('Receta', array('nombre' => $nombre))->result_array()[0]['id'];
	}

	// Método para mostrar las últimas recetas por pantalla
	function get_last_recipes()
	{
		$data = $this->db->query(
		  'SELECT Receta.id as id, Receta.nombre as receta_nombre, Receta.descripcion as receta_descripcion, Receta.fecha as receta_fecha, Foto.id as foto_id, Foto.ruta as foto_ruta
		   FROM Receta 
		   LEFT JOIN Receta_Foto ON Receta_Foto.id_receta = Receta.id
		   LEFT JOIN Foto ON Receta_Foto.id_foto = Foto.id
		   ORDER BY Receta.fecha DESC LIMIT 3;'
		);

    	$finalData = [];
		foreach ( $data->result_array() as $row ) {
		    if ( !isset( $finalData[ $row[ 'id' ] ] )) 
		       $finalData[ $row[ 'id' ] ] = [
		          'nombre' => $row['receta_nombre'],
		          'descripcion' => $row['receta_descripcion'],
		          'fecha' => $row['receta_fecha'],
		          'fotos' => []
		       ];
		   
		    if ( !is_null($row['foto_ruta']) ) $finalData[ $row[ 'id' ] ]['fotos'][ $row[ 'foto_id' ] ] = $row['foto_ruta'];
		
		}

		return $finalData;
	}

	//obtener todas las fotos de una receta
    function get_fotos_receta($id_receta)
    {
        return $this->db->query("SELECT id_foto 
                                FROM Receta_Foto
                                WHERE id_receta=$id_receta")->result_array();
    }

	// CREAR RECETA NUEVA
	function crear_receta($nueva_receta)
    {
        $this->db->query("INSERT INTO Receta(nombre, descripcion, nota, comensales, tiempo, precio, valoracion, fecha) VALUES (\"$nueva_receta[nombre]\", \"$nueva_receta[descripcion]\", \"$nueva_receta[nota]\", $nueva_receta[comensales], $nueva_receta[tiempo], $nueva_receta[precio], $nueva_receta[valoracion], CURRENT_TIMESTAMP)");
    }

    function set_receta_variables($nombre_receta, $productos_receta, $instrucciones_receta, $id_foto) {
    	$id_receta = $this->get_recipe_by_name($nombre_receta);
        $this->set_products_receta($id_receta, $productos_receta);
        $this->set_instructions_receta($id_receta, $instrucciones_receta);
        $this->set_photo_receta($id_receta, $id_foto);
    }

    function set_products_receta($id_receta, $productos)
    {
    	foreach ($productos as $clave => $prod) {
  			$this->db->query("INSERT INTO Receta_Producto(id_receta, id_producto, cantidad, unidad) VALUES ($id_receta, $prod[id], $prod[cant], \"$prod[unit]\")");
    	}
    }

    function set_instructions_receta($id_receta, $instructions)
    {
    	foreach ($instructions as $id => $inst) {
  			$this->db->query("INSERT INTO Instruccion(id_receta, orden, paso) VALUES ($id_receta, $id+1, \"$inst\")");
    	}
    }

    function set_photo_receta($id_receta, $id_foto)
    {
  		$this->db->query("INSERT INTO Receta_Foto(id_receta, id_foto) VALUES ($id_receta, $id_foto)");
    }

    ///////////////////////////////////////////////////////

    //MODIFICAR RECETA EXISTENTE
    function modificar_receta($receta)
    {
        $this->db->query("UPDATE Receta SET 
        	nombre = \"$receta[nombre]\", 
        	descripcion = \"$receta[descripcion]\", 
        	nota = \"$receta[nota]\", 
        	comensales = $receta[comensales], 
        	tiempo = $receta[tiempo], 
        	precio = $receta[precio], 
        	valoracion = $receta[valoracion]
        	WHERE id = $receta[id]");
    }

    function modificar_receta_variables($nombre_receta, $productos_receta, $instrucciones_receta) {
    	$id_receta = $this->get_recipe_by_name($nombre_receta);
        $this->modificar_products_receta($id_receta, $productos_receta);
        $this->modificar_instructions_receta($id_receta, $instrucciones_receta);
        //$this->modificar_photo_receta($id_receta, $id_foto);
    }

    function modificar_products_receta($id_receta, $productos)
    {
    	$this->db->query("DELETE FROM Receta_Producto WHERE id_receta = $id_receta");
    	foreach ($productos as $clave => $prod) {
  			$this->db->query("INSERT INTO Receta_Producto(id_receta, id_producto, cantidad, unidad) VALUES ($id_receta, $prod[id], $prod[cant], \"$prod[unit]\")");
    	}
    }

    function modificar_instructions_receta($id_receta, $instructions)
    {
    	$this->db->query("DELETE FROM Instruccion WHERE id_receta = $id_receta");
    	foreach ($instructions as $id => $inst) {
  			$this->db->query("INSERT INTO Instruccion(id_receta, orden, paso) VALUES ($id_receta, $id+1, \"$inst\")");
    	}
    }

    function modificar_photo_receta($id_receta, $id_foto)
    {
    	$this->db->query("DELETE FROM Receta_Foto WHERE id_receta = $id_receta");
  		$this->db->query("INSERT INTO Receta_Foto(id_receta, id_foto) VALUES ($id_receta, $id_foto)");
    }
    ///////////////////////////////////////////////////////////////

    // ELIMINAR RECETA
    function borrar_receta($id_receta)
    {
    	$this->borrar_receta_variables($id_receta);
      	$this->db->query("DELETE FROM Receta WHERE id = $id_receta");
    }

    function borrar_receta_variables($id_receta) {
        $this->borrar_products_receta($id_receta);
        $this->borrar_instructions_receta($id_receta);
        $this->borrar_photo_receta($id_receta);
    }

    function borrar_products_receta($id_receta)
    {
    	$this->db->query("DELETE FROM Receta_Producto WHERE id_receta = $id_receta");
    }

    function borrar_instructions_receta($id_receta)
    {
    	$this->db->query("DELETE FROM Instruccion WHERE id_receta = $id_receta");
    }

    function borrar_photo_receta($id_receta)
    {
    	$this->db->query("DELETE FROM Receta_Foto WHERE id_receta = $id_receta");
    }

    //////////////////////////////////////////////////

	function get_numActivos() {
        return $this->db->query("SELECT COUNT(DISTINCT id) 'cantidad' FROM Receta;")->result_array();
    }

    function get_recetas_menu($id_menu){
    	return $this->db->query("SELECT * FROM Receta WHERE id = any(SELECT id_receta FROM Menu_Receta WHERE id_menu = $id_menu)")->result_array();
    }

    function num_recetas() {
        $consulta = $this->db->get('Receta');
        return $consulta->num_rows();
    }

    // Con este método lo que hacemos es obtener las recetas de cada página
    function get_recetas_paginadas($por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT Receta.id as id, Receta.nombre as receta_nombre, Receta.descripcion as receta_descripcion, Receta.tiempo as receta_tiempo, Foto.id as foto_id, Foto.ruta as foto_ruta
		   FROM Receta 
		   LEFT JOIN Receta_Foto ON Receta_Foto.id_receta = Receta.id
		   LEFT JOIN Foto ON Receta_Foto.id_foto = Foto.id ORDER BY Receta.nombre LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT Receta.id as id, Receta.nombre as receta_nombre, Receta.descripcion as receta_descripcion, Receta.tiempo as receta_tiempo, Foto.id as foto_id, Foto.ruta as foto_ruta
		   FROM Receta 
		   LEFT JOIN Receta_Foto ON Receta_Foto.id_receta = Receta.id
		   LEFT JOIN Foto ON Receta_Foto.id_foto = Foto.id ORDER BY Receta.nombre LIMIT $segmento, $por_pagina");
        
        $finalData = [];
		foreach ( $consulta->result_array() as $row ) {
		    if ( !isset( $finalData[ $row[ 'id' ] ] )) 
		       $finalData[ $row[ 'id' ] ] = [ // En caso de ser la primera vez que haya esa receta
		          'nombre' => $row['receta_nombre'],
		          'descripcion' => $row['receta_descripcion'],
		          'horas' => floor($row['receta_tiempo'] / 60),
		          'minutos' => $row['receta_tiempo'] % 60,
		          'fotos' => []
		       ];
		   
		    if ( !is_null($row['foto_ruta']) ) $finalData[ $row[ 'id' ] ]['fotos'][ $row[ 'foto_id' ] ] = $row['foto_ruta'];
		
		}

		//echo json_encode($finalData); die;

		return $finalData;
    }

    function get_recetas_buscar($texto, $por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT Receta.id as id, Receta.nombre as receta_nombre, Receta.descripcion as receta_descripcion, Receta.tiempo as receta_tiempo, Foto.id as foto_id, Foto.ruta as foto_ruta
		   FROM Receta 
		   LEFT JOIN Receta_Foto ON Receta_Foto.id_receta = Receta.id
		   LEFT JOIN Foto ON Receta_Foto.id_foto = Foto.id WHERE Receta.nombre like '%$texto%' ORDER BY Receta.nombre LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT Receta.id as id, Receta.nombre as receta_nombre, Receta.descripcion as receta_descripcion, Receta.tiempo as receta_tiempo, Foto.id as foto_id, Foto.ruta as foto_ruta
		   FROM Receta 
		   LEFT JOIN Receta_Foto ON Receta_Foto.id_receta = Receta.id
		   LEFT JOIN Foto ON Receta_Foto.id_foto = Foto.id WHERE Receta.nombre like '%$texto%' ORDER BY Receta.nombre LIMIT $segmento, $por_pagina");
        
        $finalData = [];
		foreach ( $consulta->result_array() as $row ) {
		    if ( !isset( $finalData[ $row[ 'id' ] ] )) 
		       $finalData[ $row[ 'id' ] ] = [ // En caso de ser la primera vez que haya esa receta
		          'nombre' => $row['receta_nombre'],
		          'descripcion' => $row['receta_descripcion'],
		          'horas' => floor($row['receta_tiempo'] / 60),
		          'minutos' => $row['receta_tiempo'] % 60,
		          'fotos' => []
		       ];
		   
		    if ( !is_null($row['foto_ruta']) ) $finalData[ $row[ 'id' ] ]['fotos'][ $row[ 'foto_id' ] ] = $row['foto_ruta'];
		
		}

		//echo json_encode($finalData); die;

		return $finalData;
    }

    function get_total_recetas_buscar($texto) {
        $consulta = $this->db->query("SELECT Receta.id as id, Receta.nombre as receta_nombre, Receta.descripcion as receta_descripcion, Receta.tiempo as receta_tiempo, Foto.id as foto_id, Foto.ruta as foto_ruta
		   FROM Receta 
		   LEFT JOIN Receta_Foto ON Receta_Foto.id_receta = Receta.id
		   LEFT JOIN Foto ON Receta_Foto.id_foto = Foto.id WHERE Receta.nombre like '%$texto%' ORDER BY Receta.nombre");
        return $consulta->num_rows();
    }

    function num_menus_receta($id_receta){
    	$consulta = $this->db->query("SELECT * FROM Menu_Receta WHERE id_receta = $id_receta");
    	return $consulta->num_rows();
    }

    function num_recetas_menu($id_menu) {
    	$consulta = $this->db->query("SELECT * FROM Receta WHERE id = any(SELECT id_receta FROM Menu_Receta WHERE id_menu = $id_menu)");
    	return $consulta->num_rows();
    }

	function get_recetas_menu_paginados($id_menu, $por_pagina, $segmento) {
		if($segmento == null)
			$consulta = $this->db->query("SELECT * FROM Receta WHERE id = any(SELECT id_receta FROM Menu_Receta WHERE id_menu = $id_menu) LIMIT $por_pagina");
		else
			$consulta = $this->db->query("SELECT * FROM Receta WHERE id = any(SELECT id_receta FROM Menu_Receta WHERE id_menu = $id_menu) LIMIT $segmento, $por_pagina");
    	return $consulta->result_array();
	} 

	function get_total_recetas_menu_buscar($id_menu, $texto) {
		$consulta = $this->db->query("SELECT * FROM Receta WHERE id = any(SELECT id_receta FROM Menu_Receta WHERE id_menu = $id_menu) and Receta.nombre like '%$texto%'");
        return $consulta->num_rows();
	}

	function get_recetas_menu_buscar($id_menu, $texto, $por_pagina, $segmento) {
		if($segmento == null)
			$consulta = $this->db->query("SELECT * FROM Receta WHERE id = any(SELECT id_receta FROM Menu_Receta WHERE id_menu = $id_menu) and Receta.nombre like '%$texto%' LIMIT $por_pagina");
		else
			$consulta = $this->db->query("SELECT * FROM Receta WHERE id = any(SELECT id_receta FROM Menu_Receta WHERE id_menu = $id_menu) and Receta.nombre like '%$texto%' LIMIT $segmento, $por_pagina");
    	return $consulta->result_array();
	}
	
}
?>