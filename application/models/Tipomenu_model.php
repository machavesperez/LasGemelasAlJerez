<?php
Class Tipomenu_model extends CI_Model {

    function __construct() {
        $this->load->database();
    }

    function get_tiposmenu() {
        return $this->db->query("SELECT * FROM TipoMenu")->result_array();
    }

    function get_tiposmenu_vista() {
        return $this->db->query("SELECT TipoMenu.*, GROUP_CONCAT(Menu.nombre SEPARATOR ', ') as menus 
                                 FROM Menu, Menu_TipoMenu, TipoMenu
                                 WHERE Menu.id = Menu_TipoMenu.id_menu and TipoMenu.id = Menu_TipoMenu.id_tipo
                                 GROUP BY TipoMenu.id;")->result_array();
    }

    function borrar_tipomenu($id_tipomenu) {
        $this->db->query("DELETE FROM Menu_TipoMenu WHERE id_tipo = $id_tipomenu");
        $this->db->query("DELETE FROM TipoMenu WHERE id = $id_tipomenu");
    }

    function crear_tipomenu($nuevo_tipomenu) {
        $this->db->query("INSERT INTO TipoMenu(nombre) VALUES ('$nuevo_tipomenu[nombre]')");
    }

    function get_tipomenu_id($id_tipomenu) {
        return $this->db->query("SELECT * FROM TipoMenu WHERE id= $id_tipomenu")->result_array()[0];
    }

    function modificar_tipomenu($nuevo_cambio, $id_tipomenu) {
        $this->db->query("UPDATE TipoMenu SET nombre = '$nuevo_cambio[nombre]' where id = $id_tipomenu");
    }

    function num_tiposmenu() {
        $consulta = $this->db->get('TipoMenu');
        return $consulta->num_rows();
    }

    // Con este método lo que hacemos es obtener los tipos de menú de cada página
    function get_tiposmenu_paginados($por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT TipoMenu.* 
                                 FROM TipoMenu
                                 LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT TipoMenu.*
                                 FROM TipoMenu
                                 LIMIT $segmento, $por_pagina");
        return $consulta->result_array();
    }

    function get_tiposmenu_buscar($texto, $por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT TipoMenu.*
                                 FROM TipoMenu
                                 WHERE TipoMenu.nombre like '%$texto%'
                                 LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT TipoMenu.*
                                 FROM TipoMenu
                                 WHERE TipoMenu.nombre like '%$texto%'
                                 LIMIT $segmento, $por_pagina");
        return $consulta->result_array();
    }

    function get_total_tiposmenu_buscar($texto) {
        $consulta = $this->db->query("SELECT TipoMenu.*
                                 FROM TipoMenu
                                 WHERE TipoMenu.nombre like '%$texto%'");
        return $consulta->num_rows();
    }
}
?>