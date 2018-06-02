<?php
Class Menu_model extends CI_Model
{

    function __construct(){
        $this->load->database();
    }

    function get_menus()
    {
        return $this->db->query("SELECT Menu.*, GROUP_CONCAT(TipoMenu.nombre SEPARATOR ', ') as tipos 
								 FROM Menu, Menu_TipoMenu, TipoMenu
								 WHERE Menu.id = Menu_TipoMenu.id_menu and TipoMenu.id = Menu_TipoMenu.id_tipo
								 GROUP BY Menu.id;")->result_array();
    }

    function get_menu()
    {
        return $this->db->query("SELECT * FROM Menu")->result_array();
    }

    function borrar_menu($id_menu)
    {
        $this->db->query("DELETE FROM Menu_Bebida WHERE id_menu = $id_menu");
        $this->db->query("DELETE FROM Menu_Evento WHERE id_menu = $id_menu");
        $this->db->query("DELETE FROM Menu_Receta WHERE id_menu = $id_menu");
    	$this->db->query("DELETE FROM Menu_TipoMenu WHERE id_menu = $id_menu");
        $this->db->query("DELETE FROM Menu WHERE id = $id_menu");
    }

    function crear_menu($nuevo_menu)
    {

        if(empty($nuevo_menu['coste'])) $coste = 'null'; else $coste = $nuevo_menu['coste'];
        if(empty($nuevo_menu['precio'])) $precio = 'null'; else $precio = $nuevo_menu['precio'];
        if(empty($nuevo_menu['comensales'])) $comensales = 'null'; else $comensales = $nuevo_menu['comensales'];

        $this->db->query("INSERT INTO Menu(nombre, descripcion, coste, precio, comensales) VALUES ('$nuevo_menu[nombre]', '$nuevo_menu[descripcion]', $coste, $precio, $comensales)");
    }

    function crear_asociacion($menu, $tipo)
    {
    	$m = (int)$menu[0]['id_menu'];
    	foreach ($tipo as $k => $v){ 
    		$t = (int)$tipo[$k];
    		$this->db->query("INSERT INTO Menu_TipoMenu(id_menu, id_tipo) VALUES ($m, $t)");
    	} 
    }

    function get_tiposmenu_menu($id_menu)
    {
        return $this->db->query("SELECT TipoMenu.* FROM Menu, TipoMenu, Menu_TipoMenu WHERE Menu.id = Menu_TipoMenu.id_menu and TipoMenu.id = Menu_TipoMenu.id_tipo and id_menu = $id_menu")->result_array();
    }

    function get_tiposmenu_notmenu($id_menu)
    {
        return $this->db->query("select * from TipoMenu where id != all(select id_tipo from Menu_TipoMenu where id_menu =any(select id from Menu where id=$id_menu));")->result_array();
    }

    function get_menu_id($id_menu)
    {
        return $this->db->query("SELECT * FROM Menu WHERE id= $id_menu")->result_array()[0];
    }

    function modificar_menu($nuevo_cambio, $id_menu)
    {
        if(empty($nuevo_cambio['coste'])) $coste = 'null'; else $coste = $nuevo_cambio['coste'];
        if(empty($nuevo_cambio['precio'])) $precio = 'null'; else $precio = $nuevo_cambio['precio'];
        if(empty($nuevo_cambio['comensales'])) $comensales = 'null'; else $comensales = $nuevo_cambio['comensales'];

        $this->db->query("UPDATE Menu SET nombre = '$nuevo_cambio[nombre]', descripcion = '$nuevo_cambio[descripcion]', coste = $coste, precio = $precio, comensales = $comensales WHERE id = $id_menu");
    }

    function get_numActivos() {
        return $this->db->query("SELECT COUNT(DISTINCT id) 'cantidad' FROM Menu;")->result_array();
    }


    function delete_menu_receta($receta, $menu)
    {
       $this->db->query("DELETE FROM Menu_Receta WHERE id_menu = $menu and id_receta = $receta"); 
    }

    function delete_menu_bebida($bebida, $menu)
    {
       $this->db->query("DELETE FROM Menu_Bebida WHERE id_menu = $menu and id_bebida = $bebida"); 
    }

    function delete_menu_evento($evento, $menu)
    {
       $this->db->query("DELETE FROM Menu_Evento WHERE id_menu = $menu and id_evento = $evento"); 
    }

    function delete_menu_tipo($tipo, $menu)
    {
       $this->db->query("DELETE FROM Menu_TipoMenu WHERE id_menu = $menu and id_tipo = $tipo"); 
    }

    function create_menu_receta($menu, $tipo)
    {
       $menu = (int)$menu;
       foreach ($tipo as $k => $v){ 
            $t = (int)$tipo[$k];
            $this->db->query("INSERT INTO Menu_Receta(id_menu, id_receta) VALUES ($menu, $t)");
        } 
    }

    function create_menu_bebida($menu, $tipo, $cantidad)
    {
       $menu = (int)$menu;
       foreach ($tipo as $k => $v){ 
            $t = (int)$tipo[$k];
            $this->db->query("INSERT INTO Menu_Bebida(id_menu, id_bebida, cantidad) VALUES ($menu, $t, $cantidad)");
        } 
    }

    function create_menu_evento($menu, $tipo, $cantidad)
    {
       $menu = (int)$menu;
       foreach ($tipo as $k => $v){ 
            $t = (int)$tipo[$k];
            $this->db->query("INSERT INTO Menu_Evento(id_menu, id_evento) VALUES ($menu, $t, $cantidad)");
        } 
    }

    function create_menu_tipo($menu, $tipo)
    {
       $menu = (int)$menu;
       foreach ($tipo as $k => $v){ 
            $t = (int)$tipo[$k];
            $this->db->query("INSERT INTO Menu_TipoMenu(id_menu, id_tipo) VALUES ($menu, $t)");
        } 
    }


    function get_receta_not_menu($menu)
    {
       return $this->db->query("SELECT * FROM Receta WHERE id != all(SELECT id_receta FROM Menu_Receta WHERE id_menu = $menu)")->result_array(); 
    }

    function num_menus() {
        $consulta = $this->db->get('Menu');
        return $consulta->num_rows();
    }

    // Con este método lo que hacemos es obtener los menús de cada página
    function get_menus_paginados($por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT Menu.*
                                 FROM Menu
                                 LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT Menu.* 
                                 FROM Menu
                                 LIMIT $segmento, $por_pagina");
        return $consulta->result_array();
    }

    function get_menus_buscar($texto, $por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT Menu.*
                                 FROM Menu
                                 WHERE Menu.nombre like '%$texto%' 
                                 LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT Menu.*
                                 FROM Menu
                                 WHERE Menu.nombre like '%$texto%' 
                                 LIMIT $segmento, $por_pagina");
        return $consulta->result_array();
    }

    function get_total_menus_buscar($texto) {
        $consulta = $this->db->query("SELECT Menu.*
                                 FROM Menu
                                 WHERE Menu.nombre like '%$texto%'");
        return $consulta->num_rows();
    }

    function num_tiposmenu_menu($id_menu) {
        $consulta = $this->db->query("SELECT TipoMenu.* FROM Menu, TipoMenu, Menu_TipoMenu WHERE Menu.id = Menu_TipoMenu.id_menu and TipoMenu.id = Menu_TipoMenu.id_tipo and id_menu = $id_menu");
        return $consulta->num_rows();
    }

    function get_tiposmenu_menu_paginados($id_menu, $por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT TipoMenu.* FROM Menu, TipoMenu, Menu_TipoMenu WHERE Menu.id = Menu_TipoMenu.id_menu and TipoMenu.id = Menu_TipoMenu.id_tipo and id_menu = $id_menu LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT TipoMenu.* FROM Menu, TipoMenu, Menu_TipoMenu WHERE Menu.id = Menu_TipoMenu.id_menu and TipoMenu.id = Menu_TipoMenu.id_tipo and id_menu = $id_menu LIMIT $segmento, $por_pagina");

        return $consulta->result_array();
    }

    function get_tiposmenu_menu_buscar($id_menu, $texto, $por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT TipoMenu.* FROM Menu, TipoMenu, Menu_TipoMenu WHERE Menu.id = Menu_TipoMenu.id_menu and TipoMenu.id = Menu_TipoMenu.id_tipo and id_menu = $id_menu and TipoMenu.nombre like '%$texto%' LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT TipoMenu.* FROM Menu, TipoMenu, Menu_TipoMenu WHERE Menu.id = Menu_TipoMenu.id_menu and TipoMenu.id = Menu_TipoMenu.id_tipo and id_menu = $id_menu and TipoMenu.nombre like '%$texto%' LIMIT $segmento, $por_pagina");

        return $consulta->result_array();
    }

    function get_total_tiposmenu_menu_buscar($id_menu, $texto) {
        $consulta = $this->db->query("SELECT TipoMenu.* FROM Menu, TipoMenu, Menu_TipoMenu WHERE Menu.id = Menu_TipoMenu.id_menu and TipoMenu.id = Menu_TipoMenu.id_tipo and id_menu = $id_menu and TipoMenu.nombre like '%$texto%'");
        return $consulta->num_rows();
    }
}
?>
