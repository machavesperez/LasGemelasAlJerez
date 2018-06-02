<?php
Class Material_model extends CI_Model {

    function __construct() {
        $this->load->database();
    }

    function get_materiales() {
        return $this->db->query("SELECT * FROM Material")->result_array();
    }

    function borrar_material($id_material) {
        $this->db->query("DELETE FROM Material_Evento WHERE id_material = $id_material");
        return $this->db->query("DELETE FROM Material WHERE id = $id_material");
    }

    function crear_material($nuevo_material) {

        if(empty($nuevo_material['precio_unitario'])) $precio_unitario = 'null'; else $precio_unitario = $nuevo_material['precio_unitario'];
        if(empty($nuevo_material['precio_total'])) $precio_total = 'null'; else $precio_total = $nuevo_material['precio_total'];

        return $this->db->query("INSERT INTO Material(nombre, precio_unitario, precio_total) VALUES ('$nuevo_material[nombre]', $precio_unitario, $precio_total)");
    }

    function get_material_id($id_material) {
        return $this->db->query("SELECT * FROM Material WHERE id= $id_material")->result_array()[0];
    }

    function get_id_material_by_name($nombre_material)
    {
        return $this->db->query("SELECT id FROM Material WHERE nombre= '$nombre_material'")->result_array()[0];
    }

    function modificar_material($nuevo_cambio, $id_material) {

        if(empty($nuevo_cambio['precio_unitario'])) $precio_unitario = 'null'; else $precio_unitario = $nuevo_cambio['precio_unitario'];
        if(empty($nuevo_cambio['precio_total'])) $precio_total = 'null'; else $precio_total = $nuevo_cambio['precio_total'];

        return $this->db->query("UPDATE Material SET nombre = '$nuevo_cambio[nombre]', precio_unitario = $precio_unitario, precio_total = $precio_total where id = $id_material");
    }

    function get_numActivos() {
        return $this->db->query("SELECT COUNT(DISTINCT id) 'cantidad' FROM Material;")->result_array();
    }

    function num_materiales() {
        $consulta = $this->db->get('Material');
        return $consulta->num_rows();
    }

    // Con este método lo que hacemos es obtener los materiales de cada página
    function get_materiales_paginados($por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT * FROM Material LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT * FROM Material LIMIT $segmento, $por_pagina");
        return $consulta->result_array();
    }

    function get_materiales_buscar($texto, $por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT * FROM Material WHERE nombre like '%$texto%' LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT * FROM Material WHERE nombre like '%$texto%' LIMIT $segmento, $por_pagina");
        return $consulta->result_array();
    }

    function get_total_materiales_buscar($texto) {
        $consulta = $this->db->query("SELECT * FROM Material WHERE nombre like '%$texto%'");
        return $consulta->num_rows();
    }
}
?>