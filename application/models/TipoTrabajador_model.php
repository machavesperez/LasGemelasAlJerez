<?php
Class TipoTrabajador_model extends CI_Model
{

    function __construct(){
        $this->load->database();
    }

    function get_tipotrabajadores()
    {
        return $this->db->query("SELECT * FROM TipoTrabajador")->result_array();
    }

    function get_nombre_tipotrabajadores()
    {
        return $this->db->query("SELECT distinct nombre FROM TipoTrabajador")->result_array();
    }

    function get_id_tipo($tipo)
    {
        return $this->db->query("SELECT id FROM TipoTrabajador WHERE nombre = '$tipo'")->result_array();
    }

    function borrar_tipotrabajador($id_tipotrabajador)
    {
        return $this->db->query("DELETE FROM TipoTrabajador WHERE id = $id_tipotrabajador");
    }

    function crear_tipotrabajador($nuevo_tipotrabajador)
    {
        if(empty($nuevo_tipotrabajador['sueldo'])) $sueldo = 'null'; else $sueldo = $nuevo_tipotrabajador['sueldo'];
        $this->db->query("INSERT INTO TipoTrabajador(nombre, sueldo) VALUES ('$nuevo_tipotrabajador[nombre]', $sueldo)");
    }

    function num_trabajadores_asociados($id_tipotrabajador) {
        $consulta = $this->db->query("SELECT * FROM Trabajador WHERE id_tipo = $id_tipotrabajador");
        return $consulta->num_rows();
    }

    function get_tipotrabajador_id($id_tipotrabajador)
    {
        return $this->db->query("SELECT * FROM TipoTrabajador WHERE id= $id_tipotrabajador")->result_array()[0];
    }

    function modificar_tipotrabajador($nuevo_cambio, $id_tipotrabajador)
    {
        if(empty($nuevo_cambio['sueldo'])) $sueldo = 'null'; else $sueldo = $nuevo_cambio['sueldo'];
        $this->db->query("UPDATE TipoTrabajador SET nombre = '$nuevo_cambio[nombre]', sueldo = $sueldo where id = $id_tipotrabajador");
    }

    function num_tipostrabajador() {
        $consulta = $this->db->get('TipoTrabajador');
        return $consulta->num_rows();
    }

    // Con este método lo que hacemos es obtener los tipos de trabajador de cada página
    function get_tipostrabajador_paginados($por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT * FROM TipoTrabajador LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT * FROM TipoTrabajador LIMIT $segmento, $por_pagina");
        return $consulta->result_array();
    }

    function get_tipostrabajador_buscar($texto, $por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT * FROM TipoTrabajador WHERE nombre like '%$texto%' LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT * FROM TipoTrabajador WHERE nombre like '%$texto%' LIMIT $segmento, $por_pagina");
        return $consulta->result_array();
    }

    function get_total_tipostrabajador_buscar($texto) {
        $consulta = $this->db->query("SELECT * FROM TipoTrabajador WHERE nombre like '%$texto%'");
        return $consulta->num_rows();
    }
}
?>
