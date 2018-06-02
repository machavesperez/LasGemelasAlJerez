<?php
Class Evento_model extends CI_Model
{

    function __construct(){
        $this->load->database();
    }

    function get_eventos()
    {
        return $this->db->query("SELECT * FROM Evento")->result_array();
    }

    function borrar_evento($id_evento)
    {
        $this->db->query("DELETE FROM Bebida_Evento WHERE id_evento = $id_evento");
        $this->db->query("DELETE FROM Material_Evento WHERE id_evento = $id_evento");
        $this->db->query("DELETE FROM Menu_Evento WHERE id_evento = $id_evento");
        $this->db->query("DELETE FROM Trabajador_Evento WHERE id_evento = $id_evento");
        $this->db->query("DELETE FROM Evento WHERE id = $id_evento");
    }

    function num_noticias_asociadas($id_evento) {
        $consulta = $this->db->query("SELECT * FROM Noticia WHERE id_evento = $id_evento");
        return $consulta->num_rows();
    }

    function crear_evento($nuevo_evento)
    {
        if(empty($nuevo_evento['persona'])) $persona = 'null'; else $persona = $nuevo_evento['persona'];
        $this->db->query("INSERT INTO Evento(titulo, descripcion, fecha, lugar, es_visible, persona) VALUES (\"$nuevo_evento[titulo]\", \"$nuevo_evento[descripcion]\", \"$nuevo_evento[fecha]\", \"$nuevo_evento[lugar]\", $nuevo_evento[es_visible], $persona)");
    }

    function get_evento_id($id_evento)
    {
        return $this->db->query("SELECT * FROM Evento WHERE id = $id_evento")->result_array()[0];
    }

    function get_evento_by_id($id_evento)
    {
        return $this->db->query("SELECT Evento.id as id, Evento.titulo as titulo_evento, Evento.descripcion as descripcion_evento, Evento.fecha as fecha_evento, Evento.lugar as lugar, Evento.persona as asistentes, Noticia.id as id_noticia, Noticia.titulo as titulo_noticia, Noticia.descripcion as descripcion_noticia, Noticia.contenido as contenido_noticia, Noticia.fecha as fecha_noticia, Foto.ruta as foto
                                FROM Evento 
                                JOIN Noticia ON Noticia.id_evento = Evento.id
                                JOIN Foto ON Noticia.id_foto_portada = Foto.id
                                WHERE Evento.id = $id_evento")->result_array();
    }

    function modificar_evento($nuevo_cambio, $id_evento)
    {
        if(empty($nuevo_cambio['persona'])) $persona = 'null'; else $persona = $nuevo_cambio['persona'];
        $this->db->query("UPDATE Evento SET titulo = \"$nuevo_cambio[titulo]\", descripcion = \"$nuevo_cambio[descripcion]\", fecha = \"$nuevo_cambio[fecha]\" , lugar =\"$nuevo_cambio[lugar]\", es_visible = $nuevo_cambio[es_visible], persona = $persona where id = $id_evento");
    }


    //Obtener todas los eventos para verlas en ultimoseventos
    public function get_eventos_ultimoseventos(){ 
        return $this->db->query("SELECT Evento.id as 'id', Evento.titulo, Evento.descripcion, Evento.fecha, Evento.lugar, Evento.es_visible, Foto.ruta as 'foto'
                                FROM Evento, Noticia, Foto
                                WHERE Evento.id = Noticia.id_evento
                                AND Noticia.id_foto_portada = Foto.id
                                AND Evento.es_visible = 1 
                                ORDER BY Evento.fecha DESC")->result_array();
    }

    //Obtener todas los eventos para verlas en ultimoseventos
    public function get_eventos_ultimoseventos_paginados($por_pagina, $segmento){ 
        if($segmento) $segmento = $segmento.',';

        return $this->db->query("SELECT Evento.id as 'id', Evento.titulo, Evento.descripcion, Evento.fecha, Evento.lugar, Evento.es_visible, Foto.ruta as 'foto'
                                FROM Evento, Noticia, Foto
                                WHERE Evento.id = Noticia.id_evento
                                AND Noticia.id_foto_portada = Foto.id
                                AND Evento.es_visible = 1 
                                ORDER BY Evento.fecha DESC LIMIT $segmento $por_pagina")->result_array();
    }

    public function get_total_ultimoseventos() {
        $consulta = $this->db->query("SELECT *
                                FROM Evento, Noticia
                                WHERE Evento.id = Noticia.id_evento
                                AND Evento.es_visible = 1 
                                ORDER BY Evento.fecha DESC");
        return $consulta->num_rows();
    }

    //obtener todas las fotos de un evento
    function get_evento_fotos($id_evento)
    {
        return $this->db->query("SELECT * 
                                FROM Evento, Noticia, Noticia_Foto, Foto
                                WHERE Evento.id = $id_evento 
                                AND Evento.id = Noticia.id_evento
                                AND Noticia_Foto.id_foto = Foto.id  
                                AND Noticia.id = Noticia_Foto.id_Noticia")->result_array();            
    }

/*    //Obtener todas los eventos para verlas en ultimosevnetos
    public function get_eventos_ultimosevnetos(){ 
        return $this->db->query("SELECT Evento.id as 'id', Evento.titulo, Evento.descripcion, Evento.fecha, Evento.lugar, Evento.es_visible, Foto.ruta as 'foto'
                                FROM Evento, Noticia_Foto, Foto
                                WHERE Evento.id = Noticia_Foto.id_Noticia
                                AND Noticia_Foto.id_foto = Foto.id
                                ORDER BY Evento.fecha DESC;")->result_array();
                                                            
    }
*/
/*
    //obtener todas las fotos de un evento
    function get_evento_fotos($id_evento)
    {
        return $this->db->query("SELECT * 
                                FROM Evento, Noticia_Foto, Foto
                                WHERE Evento.id = Noticia_Foto.id_Noticia
                                AND Foto.id = Noticia_Foto.id_foto
                                and Evento.id = $id_evento")->result_array();
    }
*/

    function get_numActivos() {
        return $this->db->query("SELECT COUNT(DISTINCT id) 'cantidad' FROM Evento;")->result_array();
    }

    function num_eventos() {
        $consulta = $this->db->get('Evento');
        return $consulta->num_rows();
    }

    // Con este método lo que hacemos es obtener los eventos de cada página
    function get_eventos_paginados($por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT * FROM Evento LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT * FROM Evento LIMIT $segmento, $por_pagina");
        return $consulta->result_array();
    }

    function get_eventos_buscar($texto, $por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT * FROM Evento WHERE titulo like '%$texto%' LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT * FROM Evento WHERE titulo like '%$texto%' LIMIT $segmento, $por_pagina");
        return $consulta->result_array();
    }

    function get_total_eventos_buscar($texto) {
        $consulta = $this->db->query("SELECT * FROM Evento WHERE titulo like '%$texto%'");
        return $consulta->num_rows();
    }
    
    function get_menus_evento($id_evento) {
        #return $this->db->query("SELECT * FROM Menu WHERE id = any(SELECT id_menu FROM Menu_Evento WHERE id_evento = $id_evento)")->result_array();
        return $this->db->query("select Menu.*, Menu_Evento.cantidad from Menu, Menu_Evento where Menu.id = Menu_Evento.id_menu and Menu_Evento.id_evento = $id_evento")->result_array();
    }

    function get_materiales_evento($id_evento) {
        return $this->db->query("SELECT Material.*, Material_Evento.cantidad FROM Material, Material_Evento WHERE Material.id = Material_Evento.id_material and Material_Evento.id_evento = $id_evento")->result_array();
    }

    function get_trabajadores_evento($id_evento) {
        return $this->db->query("SELECT Trabajador.id, TipoTrabajador.nombre as tipo, Trabajador.nombre, Trabajador.apellidos, Trabajador_Evento.horas FROM Trabajador INNER JOIN Trabajador_Evento ON Trabajador.id = Trabajador_Evento.id_trabajador AND Trabajador_Evento.id_evento = 1 INNER JOIN TipoTrabajador ON Trabajador.id_tipo = TipoTrabajador.id;")->result_array();
    }

    function get_menu_not_evento($id_evento) {
        return $this->db->query("SELECT * FROM Menu WHERE id != all(SELECT id_menu FROM Menu_Evento WHERE id_evento = $id_evento)")->result_array();  
    }

    function get_material_not_evento($id_evento) {
        return $this->db->query("SELECT * FROM Material WHERE id != all(SELECT id_material FROM Material_Evento WHERE id_evento = $id_evento)")->result_array();
    }

    function get_trabajador_not_evento($id_evento) {
        return $this->db->query("SELECT * FROM Trabajador WHERE id != all(SELECT id_trabajador FROM Trabajador_Evento WHERE id_evento = $id_evento)")->result_array();
    }

    function create_evento_menu($evento, $tipo, $cantidad){
       $evento = (int)$evento;
       foreach ($tipo as $k => $v){ 
            $t = (int)$tipo[$k];
            $this->db->query("INSERT INTO Menu_Evento(id_menu, id_evento, cantidad) VALUES ($t, $evento, $cantidad)");
        } 
    }

    function create_evento_material($evento, $tipo, $cantidad){
       $evento = (int)$evento;
       foreach ($tipo as $k => $v){ 
            $t = (int)$tipo[$k];
            $this->db->query("INSERT INTO Material_Evento(id_material, id_evento, cantidad) VALUES ($t, $evento, $cantidad)");
        } 
    }

    function create_evento_trabajador($evento, $tipo, $horas){
       $evento = (int)$evento;
       foreach ($tipo as $k => $v){ 
            $t = (int)$tipo[$k];
            $this->db->query("INSERT INTO Trabajador_Evento(id_trabajador, id_evento, horas) VALUES ($t, $evento, $horas)");
        } 
    }

    function delete_evento_menu($id_menu, $id_evento){
        return $this->db->query("DELETE FROM Menu_Evento WHERE id_menu = $id_menu and id_evento = $id_evento");
    }

    function delete_evento_material($id_material, $id_evento){
        return $this->db->query("DELETE FROM Material_Evento WHERE id_material = $id_material and id_evento = $id_evento");
    }

    function delete_evento_trabajador($id_trabajador, $id_evento){
        return $this->db->query("DELETE FROM Trabajador_Evento WHERE id_trabajador = $id_trabajador and id_evento = $id_evento");
    }

    function get_menus_coste($id_menu){
        return $this->db->query("select sum(precio) total from Receta where id = any(select id_receta from Menu_Receta where id_menu = $id_menu)");
    }

    function sumar_menu($id_menu, $id_evento){
        return $this->db->query("UPDATE Menu_Evento SET cantidad = cantidad + 1");
    }

    function restar_menu($id_menu, $id_evento){
        return $this->db->query("UPDATE Menu_Evento SET cantidad = cantidad - 1");
    }

    function sumar_material($id_material, $id_evento){
        return $this->db->query("UPDATE Material_Evento SET cantidad = cantidad + 1");
    }

    function restar_material($id_material, $id_evento){
        return $this->db->query("UPDATE Material_Evento SET cantidad = cantidad - 1");
    }

    function num_menus_evento($id_evento) {
        $consulta = $this->db->query("SELECT Menu.*, Menu_Evento.cantidad from Menu, Menu_Evento where Menu.id = Menu_Evento.id_menu and Menu_Evento.id_evento = $id_evento");
        return $consulta->num_rows();
    }

    function get_menus_evento_paginados($id_evento, $por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT Menu.*, Menu_Evento.cantidad from Menu, Menu_Evento where Menu.id = Menu_Evento.id_menu and Menu_Evento.id_evento = $id_evento LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT Menu.*, Menu_Evento.cantidad from Menu, Menu_Evento where Menu.id = Menu_Evento.id_menu and Menu_Evento.id_evento = $id_evento LIMIT $segmento, $por_pagina");

        return $consulta->result_array();
    }

    function get_total_menus_evento_buscar($id_evento, $texto) {
        $consulta = $this->db->query("SELECT Menu.*, Menu_Evento.cantidad from Menu, Menu_Evento where Menu.id = Menu_Evento.id_menu and Menu_Evento.id_evento = $id_evento and Menu.nombre like '%$texto%'");
        return $consulta->num_rows();
    }

    function get_menus_evento_buscar($id_evento, $texto, $por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT Menu.*, Menu_Evento.cantidad from Menu, Menu_Evento where Menu.id = Menu_Evento.id_menu and Menu_Evento.id_evento = $id_evento and Menu.nombre like '%$texto%' LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT Menu.*, Menu_Evento.cantidad from Menu, Menu_Evento where Menu.id = Menu_Evento.id_menu and Menu_Evento.id_evento = $id_evento and Menu.nombre like '%$texto%' LIMIT $segmento, $por_pagina");

        return $consulta->result_array();
    }

    function num_materiales_evento($id_evento) {
        $consulta = $this->db->query("SELECT Material.*, Material_Evento.cantidad FROM Material, Material_Evento WHERE Material.id = Material_Evento.id_material and Material_Evento.id_evento = $id_evento");
        return $consulta->num_rows();
    }

    function get_materiales_evento_paginados($id_evento, $por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT Material.*, Material_Evento.cantidad FROM Material, Material_Evento WHERE Material.id = Material_Evento.id_material and Material_Evento.id_evento = $id_evento LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT Material.*, Material_Evento.cantidad FROM Material, Material_Evento WHERE Material.id = Material_Evento.id_material and Material_Evento.id_evento = $id_evento LIMIT $segmento, $por_pagina");

        return $consulta->result_array();
    }

    function get_total_materiales_evento_buscar($id_evento, $texto) {
        $consulta = $this->db->query("SELECT Material.*, Material_Evento.cantidad FROM Material, Material_Evento WHERE Material.id = Material_Evento.id_material and Material_Evento.id_evento = $id_evento and Material.nombre like '%$texto%'");
        return $consulta->num_rows();
    }

    function get_materiales_evento_buscar($id_evento, $texto, $por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT Material.*, Material_Evento.cantidad FROM Material, Material_Evento WHERE Material.id = Material_Evento.id_material and Material_Evento.id_evento = $id_evento and Material.nombre like '%$texto%' LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT Material.*, Material_Evento.cantidad FROM Material, Material_Evento WHERE Material.id = Material_Evento.id_material and Material_Evento.id_evento = $id_evento and Material.nombre like '%$texto%' LIMIT $segmento, $por_pagina");

        return $consulta->result_array();
    }

    function num_trabajadores_evento($id_evento) {
        $consulta = $this->db->query("SELECT Trabajador.id, TipoTrabajador.nombre as tipo, Trabajador.nombre, Trabajador.apellidos, Trabajador_Evento.horas FROM Trabajador INNER JOIN Trabajador_Evento ON Trabajador.id = Trabajador_Evento.id_trabajador AND Trabajador_Evento.id_evento = $id_evento INNER JOIN TipoTrabajador ON Trabajador.id_tipo = TipoTrabajador.id");
        return $consulta->num_rows();
    }

    function get_trabajadores_evento_paginados($id_evento, $por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT Trabajador.id, TipoTrabajador.nombre as tipo, Trabajador.nombre, Trabajador.apellidos, Trabajador_Evento.horas FROM Trabajador INNER JOIN Trabajador_Evento ON Trabajador.id = Trabajador_Evento.id_trabajador AND Trabajador_Evento.id_evento = $id_evento INNER JOIN TipoTrabajador ON Trabajador.id_tipo = TipoTrabajador.id LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT Trabajador.id, TipoTrabajador.nombre as tipo, Trabajador.nombre, Trabajador.apellidos, Trabajador_Evento.horas FROM Trabajador INNER JOIN Trabajador_Evento ON Trabajador.id = Trabajador_Evento.id_trabajador AND Trabajador_Evento.id_evento = $id_evento INNER JOIN TipoTrabajador ON Trabajador.id_tipo = TipoTrabajador.id LIMIT $segmento, $por_pagina");

        return $consulta->result_array();
    }


    function get_total_trabajadores_evento_buscar($id_evento, $texto) {
        $consulta = $this->db->query("SELECT Trabajador.id, TipoTrabajador.nombre as tipo, Trabajador.nombre, Trabajador.apellidos, Trabajador_Evento.horas FROM Trabajador INNER JOIN Trabajador_Evento ON Trabajador.id = Trabajador_Evento.id_trabajador AND Trabajador_Evento.id_evento = $id_evento INNER JOIN TipoTrabajador ON Trabajador.id_tipo = TipoTrabajador.id WHERE Trabajador.nombre like '%$texto%'");
        return $consulta->num_rows();
    }

    function get_trabajadores_evento_buscar($id_evento, $texto, $por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT Trabajador.id, TipoTrabajador.nombre as tipo, Trabajador.nombre, Trabajador.apellidos, Trabajador_Evento.horas FROM Trabajador INNER JOIN Trabajador_Evento ON Trabajador.id = Trabajador_Evento.id_trabajador AND Trabajador_Evento.id_evento = $id_evento INNER JOIN TipoTrabajador ON Trabajador.id_tipo = TipoTrabajador.id WHERE Trabajador.nombre like '%$texto%' LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT Trabajador.id, TipoTrabajador.nombre as tipo, Trabajador.nombre, Trabajador.apellidos, Trabajador_Evento.horas FROM Trabajador INNER JOIN Trabajador_Evento ON Trabajador.id = Trabajador_Evento.id_trabajador AND Trabajador_Evento.id_evento = $id_evento INNER JOIN TipoTrabajador ON Trabajador.id_tipo = TipoTrabajador.id WHERE Trabajador.nombre like '%$texto%' LIMIT $segmento, $por_pagina");

        return $consulta->result_array();
    }

}
?>
