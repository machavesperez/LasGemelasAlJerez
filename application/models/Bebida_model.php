<?php
Class Bebida_model extends CI_Model
{

    function __construct(){
        $this->load->database();
    }

    function get_bebidas()
    {
        return $this->db->query("SELECT * FROM Bebida")->result_array();
    }

    function borrar_bebida($id_bebida)
    {
        $this->db->query("DELETE FROM Bebida_Evento WHERE id_bebida = $id_bebida");
        $this->db->query("DELETE FROM Menu_Bebida WHERE id_bebida = $id_bebida");
        return $this->db->query("DELETE FROM Bebida WHERE id = $id_bebida");
    }

    function crear_bebida($nueva_bebida)
    {
        if(empty($nueva_bebida['precio_unitario'])) $precio_unitario = 'null'; else $precio_unitario = $nueva_bebida['precio_unitario'];
        if(empty($nueva_bebida['precio_total'])) $precio_total = 'null'; else $precio_total = $nueva_bebida['precio_total'];

        return $this->db->query("INSERT INTO Bebida(nombre, contiene_alcohol, precio_unitario, precio_total) VALUES ('$nueva_bebida[nombre]', $nueva_bebida[alcohol], $precio_unitario, $precio_total)");
    }

    function get_bebida_id($id_bebida)
    {
        return $this->db->query("SELECT * FROM Bebida WHERE id= $id_bebida")->result_array()[0];
    }

    function get_id_bebida_by_name($nombre_bebida)
    {
        return $this->db->query("SELECT id FROM Bebida WHERE nombre= '$nombre_bebida'")->result_array()[0];
    }

    function modificar_bebida($nuevo_cambio, $id_bebida)
    {
        if(empty($nuevo_cambio['precio_unitario'])) $precio_unitario = 'null'; else $precio_unitario = $nuevo_cambio['precio_unitario'];
        if(empty($nuevo_cambio['precio_total'])) $precio_total = 'null'; else $precio_total = $nuevo_cambio['precio_total'];

        return $this->db->query("UPDATE Bebida SET nombre = '$nuevo_cambio[nombre]', contiene_alcohol = $nuevo_cambio[alcohol], precio_unitario = $precio_unitario, precio_total = $precio_total where id = $id_bebida");
    }

    function get_numActivos() {
        return $this->db->query("SELECT COUNT(DISTINCT id) 'cantidad' FROM Bebida;")->result_array();
    }

    function get_bebidas_menu($id_menu)
    {
        return $this->db->query("SELECT Bebida.id as id, Bebida.nombre as nombre, Bebida.contiene_alcohol as contiene_alcohol, Bebida.precio_unitario as precio_unitario, Bebida.precio_total as precio_total, Menu_Bebida.cantidad as cantidad FROM Bebida LEFT JOIN Menu_Bebida ON Bebida.id = Menu_Bebida.id_bebida WHERE Menu_Bebida.id_menu = $id_menu")->result_array();
    }

    function get_bebidas_not_menu($id_menu)
    {
        return $this->db->query("SELECT * FROM Bebida WHERE id != all(SELECT id_bebida FROM Menu_Bebida WHERE id_menu = $id_menu)")->result_array();
    }

    function num_bebidas() {
        $consulta = $this->db->get('Bebida');
        return $consulta->num_rows();
    }

    // Con este método lo que hacemos es obtener las bebidas de cada página
    function get_bebidas_paginadas($por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT * FROM Bebida LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT * FROM Bebida LIMIT $segmento, $por_pagina");
        return $consulta->result_array();
    }

    function get_bebidas_buscar($texto, $por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT * FROM Bebida WHERE nombre like '%$texto%' LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT * FROM Bebida WHERE nombre like '%$texto%' LIMIT $segmento, $por_pagina");
        return $consulta->result_array();
    }

    function get_total_bebidas_buscar($texto) {
        $consulta = $this->db->query("SELECT * FROM Bebida WHERE nombre like '%$texto%'");
        return $consulta->num_rows();
    }

    function num_bebidas_menu($id_menu) {
        $consulta = $this->db->query("SELECT Bebida.id as id, Bebida.nombre as nombre, Bebida.contiene_alcohol as contiene_alcohol, Bebida.precio_unitario as precio_unitario, Bebida.precio_total as precio_total, Menu_Bebida.cantidad as cantidad FROM Bebida LEFT JOIN Menu_Bebida ON Bebida.id = Menu_Bebida.id_bebida WHERE Menu_Bebida.id_menu = $id_menu");
        return $consulta->num_rows();
    }

    function get_bebidas_menu_paginados($id_menu, $por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT Bebida.id as id, Bebida.nombre as nombre, Bebida.contiene_alcohol as contiene_alcohol, Bebida.precio_unitario as precio_unitario, Bebida.precio_total as precio_total, Menu_Bebida.cantidad as cantidad FROM Bebida LEFT JOIN Menu_Bebida ON Bebida.id = Menu_Bebida.id_bebida WHERE Menu_Bebida.id_menu = $id_menu LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT Bebida.id as id, Bebida.nombre as nombre, Bebida.contiene_alcohol as contiene_alcohol, Bebida.precio_unitario as precio_unitario, Bebida.precio_total as precio_total, Menu_Bebida.cantidad as cantidad FROM Bebida LEFT JOIN Menu_Bebida ON Bebida.id = Menu_Bebida.id_bebida WHERE Menu_Bebida.id_menu = $id_menu LIMIT $segmento, $por_pagina");

        return $consulta->result_array();
    }

    function get_total_bebidas_menu_buscar($id_menu, $texto) {
        $consulta = $this->db->query("SELECT Bebida.id as id, Bebida.nombre as nombre, Bebida.contiene_alcohol as contiene_alcohol, Bebida.precio_unitario as precio_unitario, Bebida.precio_total as precio_total, Menu_Bebida.cantidad as cantidad FROM Bebida LEFT JOIN Menu_Bebida ON Bebida.id = Menu_Bebida.id_bebida WHERE Menu_Bebida.id_menu = $id_menu and Bebida.nombre like '%$texto%'");
        return $consulta->num_rows();
    }

    function get_bebidas_menu_buscar($id_menu, $texto, $por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT Bebida.id as id, Bebida.nombre as nombre, Bebida.contiene_alcohol as contiene_alcohol, Bebida.precio_unitario as precio_unitario, Bebida.precio_total as precio_total, Menu_Bebida.cantidad as cantidad FROM Bebida LEFT JOIN Menu_Bebida ON Bebida.id = Menu_Bebida.id_bebida WHERE Menu_Bebida.id_menu = $id_menu and Bebida.nombre like '%$texto%' LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT Bebida.id as id, Bebida.nombre as nombre, Bebida.contiene_alcohol as contiene_alcohol, Bebida.precio_unitario as precio_unitario, Bebida.precio_total as precio_total, Menu_Bebida.cantidad as cantidad FROM Bebida LEFT JOIN Menu_Bebida ON Bebida.id = Menu_Bebida.id_bebida WHERE Menu_Bebida.id_menu = $id_menu and Bebida.nombre like '%$texto%' LIMIT $segmento, $por_pagina");

        return $consulta->result_array();
    }
}
?>