<?php
Class Tiporeceta_model extends CI_Model {

    function __construct() {
        $this->load->database();
    }

    function get_tiposreceta() {
        return $this->db->query("SELECT * FROM TipoReceta")->result_array();
        /*$array_result = [];
        foreach ($data as $value) {
            $array_result[ $value[ 'id' ] ] = $value[ 'nombre' ];
        }
        //echo json_encode($array_result);echo json_encode($data); die;
        return $array_result;*/
    }

    function borrar_tiporeceta($id_tiporeceta) {
        $this->db->query("DELETE FROM RecetaTipoReceta WHERE id_tipo = $id_tiporeceta");
        $this->db->query("DELETE FROM TipoReceta WHERE id = $id_tiporeceta");
    }

    function crear_tiporeceta($nuevo_tiporeceta) {
        $this->db->query("INSERT INTO TipoReceta(nombre) VALUES ('$nuevo_tiporeceta[nombre]')");
    }

    function get_tiporeceta_id($id_tiporeceta) {
        return $this->db->query("SELECT * FROM TipoReceta WHERE id= $id_tiporeceta")->result_array()[0];
    }

    function modificar_tiporeceta($nuevo_cambio, $id_tiporeceta) {
        $this->db->query("UPDATE TipoReceta SET nombre = '$nuevo_cambio[nombre]' where id = $id_tiporeceta");
    }

    function get_numActivos() {
        return $this->db->query("SELECT COUNT(DISTINCT id) 'cantidad' FROM TipoReceta;")->result_array();
    }

    function num_tiposreceta() {
        $consulta = $this->db->get('TipoReceta');
        return $consulta->num_rows();
    }

    // Con este método lo que hacemos es obtener los tipos de receta de cada página
    function get_tiposreceta_paginados($por_pagina, $segmento) {
        $consulta = $this->db->get('TipoReceta', $por_pagina, $segmento);
        return $consulta->result_array();
    }
}
?>