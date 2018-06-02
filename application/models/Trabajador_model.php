<?php
Class Trabajador_model extends CI_Model
{

    function __construct(){
        $this->load->database();
        $this->load->model('TipoTrabajador_model');
    }

    function get_trabajadores()
    {
        return $this->db->query("SELECT Trabajador.id id, Trabajador.nombre nombre, Trabajador.apellidos apellidos, TipoTrabajador.nombre tipo FROM Trabajador, TipoTrabajador WHERE TipoTrabajador.id = Trabajador.id_tipo;")->result_array();
    }

    function borrar_trabajador($id_trabajador)
    {
        $this->db->query("DELETE FROM Trabajador_Evento WHERE id_trabajador = $id_trabajador");
        return $this->db->query("DELETE FROM Trabajador WHERE id = $id_trabajador");
    }

    function get_trabajador_id($id_trabajador)
    {
        return $this->db->query("SELECT * FROM Trabajador WHERE id = $id_trabajador")->result_array()[0];
    }

    function get_id_trabajador_by_name($nombre_trabajador)
    {
        return $this->db->query("SELECT id FROM Trabajador WHERE nombre= '$nombre_trabajador'")->result_array()[0];
    }

    function crear_trabajador($nueva_trabajador)
    {
        $tipo_trabajador = $this->TipoTrabajador_model->get_id_tipo($nueva_trabajador['tipo']);
        foreach($tipo_trabajador as $id_tipo)
            $tipo = $id_tipo['id'];

        return $this->db->query("INSERT INTO Trabajador(nombre, apellidos, id_tipo) VALUES ('$nueva_trabajador[nombre]', '$nueva_trabajador[apellidos]', $tipo)");
    }

    function modificar_trabajador($nuevo_cambio, $id_trabajador)
    {
        $tipo_trabajador = $this->TipoTrabajador_model->get_id_tipo($nuevo_cambio['tipo']);
        foreach($tipo_trabajador as $id_tipo)
            $tipo = $id_tipo['id'];
        return $this->db->query("UPDATE Trabajador SET nombre = '$nuevo_cambio[nombre]', apellidos = '$nuevo_cambio[apellidos]', id_tipo = $tipo where id = $id_trabajador");
    }

    function get_numActivos() {
        return $this->db->query("SELECT COUNT(DISTINCT id) 'cantidad' FROM Trabajador;")->result_array();
    }

    function num_trabajadores() {
        $consulta = $this->db->get('Trabajador');
        return $consulta->num_rows();
    }

    // Con este método lo que hacemos es obtener los trabajadores de cada página
    function get_trabajadores_paginados($por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT Trabajador.id id, Trabajador.nombre nombre, Trabajador.apellidos apellidos, TipoTrabajador.nombre tipo FROM Trabajador, TipoTrabajador WHERE TipoTrabajador.id = Trabajador.id_tipo LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT Trabajador.id id, Trabajador.nombre nombre, Trabajador.apellidos apellidos, TipoTrabajador.nombre tipo FROM Trabajador, TipoTrabajador WHERE TipoTrabajador.id = Trabajador.id_tipo LIMIT $segmento, $por_pagina");
        return $consulta->result_array();
    }

    function get_trabajadores_buscar($texto, $por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT Trabajador.id id, Trabajador.nombre nombre, Trabajador.apellidos apellidos, TipoTrabajador.nombre tipo FROM Trabajador, TipoTrabajador WHERE TipoTrabajador.id = Trabajador.id_tipo AND (Trabajador.nombre like '%$texto%' OR Trabajador.apellidos like '%$texto%' OR TipoTrabajador.nombre like '%$texto%') LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT Trabajador.id id, Trabajador.nombre nombre, Trabajador.apellidos apellidos, TipoTrabajador.nombre tipo FROM Trabajador, TipoTrabajador WHERE TipoTrabajador.id = Trabajador.id_tipo AND (Trabajador.nombre like '%$texto%' OR Trabajador.apellidos like '%$texto%' OR TipoTrabajador.nombre like '%$texto%') LIMIT $segmento, $por_pagina");
        return $consulta->result_array();
    }

    function get_total_trabajadores_buscar($texto) {
        $consulta = $this->db->query("SELECT Trabajador.id id, Trabajador.nombre nombre, Trabajador.apellidos apellidos, TipoTrabajador.nombre tipo FROM Trabajador, TipoTrabajador WHERE TipoTrabajador.id = Trabajador.id_tipo AND (Trabajador.nombre like '%$texto%' OR Trabajador.apellidos like '%$texto%' OR TipoTrabajador.nombre like '%$texto%')");
        return $consulta->num_rows();
    }
}
?>
