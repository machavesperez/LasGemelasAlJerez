<?php
Class Noticia_model extends CI_Model
{

    function __construct(){
        $this->load->database();
    }

    function get_noticias()
    {
        return $this->db->query("SELECT Noticia.id as id, Noticia.titulo as titulo, Noticia.contenido as contenido,
                                Noticia.descripcion as descripcion, Noticia.fecha as fecha, Evento.titulo as evento
                                FROM Noticia
                                LEFT JOIN Evento 
                                ON Noticia.id_evento = Evento.id
                                ORDER BY Noticia.fecha DESC")->result_array();
    }

    function borrar_noticia($id_noticia)
    {
        $this->db->query("DELETE FROM Noticia_Foto WHERE id_noticia = $id_noticia");
        $this->db->query("DELETE FROM Noticia WHERE id = $id_noticia");
    }

    function crear_noticia($nueva_noticia)
    {
        $this->db->query("INSERT INTO Noticia(id_evento, id_foto_portada, titulo, descripcion, contenido, fecha) VALUES ($nueva_noticia[id_evento], $nueva_noticia[id_foto_portada], \"$nueva_noticia[titulo]\", \"$nueva_noticia[descripcion]\", \"$nueva_noticia[contenido]\", CURRENT_TIMESTAMP)");
    }

    function get_noticia_by_id($id_noticia)
    {
        return $this->db->query("SELECT Noticia.id as id, Noticia.titulo as titulo, Noticia.contenido as contenido,
                                Noticia.descripcion as descripcion, Noticia.fecha as fecha, Noticia.id_evento, Evento.titulo as evento,
                                Foto.ruta as foto, Foto.id as id_foto_portada
                                FROM Noticia
                                LEFT JOIN Evento ON Noticia.id_evento = Evento.id
                                LEFT JOIN Foto ON Noticia.id_foto_portada = Foto.id
                                WHERE Noticia.id = $id_noticia")->result_array();
    }

    function get_noticia_foto($id_noticia)
    {
        return $this->db->query("SELECT Foto.ruta as 'ruta'
                                FROM Noticia, Foto
                                WHERE Noticia.id = $id_noticia
                                AND Noticia.id_foto_portada = Foto.id")->result_array();
    }

    function modificar_noticia($nuevo_cambio, $id_noticia)
    {
        $this->db->query("UPDATE Noticia SET id_evento = $nuevo_cambio[id_evento], titulo = \"$nuevo_cambio[titulo]\", descripcion = \"$nuevo_cambio[descripcion]\", contenido = \"$nuevo_cambio[contenido]\" where id = $id_noticia");
    }

    public function get_noticias_blog() {
        return $this->db->query("SELECT Noticia.id as 'id', Noticia.titulo, Noticia.contenido, Noticia.descripcion, 
                                Noticia.fecha, Foto.ruta as 'foto'
                                FROM Noticia, Foto
                                WHERE Noticia.id_foto_portada = Foto.id
                                AND Noticia.id_evento is null
                                ORDER BY Noticia.fecha DESC, Noticia.id DESC")->result_array();
    }

    //Obtener todas las noticias para verlas en el blog paginadas
    public function get_noticias_blog_paginadas($por_pagina, $segmento){ 
        if($segmento) $segmento = $segmento.",";

        return $this->db->query("SELECT Noticia.id as 'id', Noticia.titulo, Noticia.contenido, Noticia.descripcion, 
                                Noticia.fecha, Foto.ruta as 'foto'
                                FROM Noticia, Foto
                                WHERE Noticia.id_foto_portada = Foto.id
                                AND Noticia.id_evento is null
                                ORDER BY Noticia.fecha DESC, Noticia.id DESC LIMIT $segmento $por_pagina;")->result_array();
                                                            
    }

    public function get_total_noticias_blog() {
            $consulta = $this->db->query("SELECT Noticia.id as 'id', Noticia.titulo, Noticia.contenido, Noticia.descripcion, 
                                    Noticia.fecha, Foto.ruta as 'foto'
                                    FROM Noticia, Foto
                                    WHERE Noticia.id_foto_portada = Foto.id
                                    AND Noticia.id_evento is null
                                    ORDER BY Noticia.fecha DESC, Noticia.id DESC");
        return $consulta->num_rows();
    }

    //obtener todas las fotos de una noticia
    function get_fotos_noticia($id_noticia)
    {
        return $this->db->query("SELECT * 
                                FROM Noticia, Noticia_Foto, Foto
                                WHERE Noticia.id = Noticia_Foto.id_Noticia
                                AND Foto.id = Noticia_Foto.id_foto
                                and Noticia.id = $id_noticia")->result_array();
    }

    function get_numActivos() {
        return $this->db->query("SELECT COUNT(DISTINCT id) 'cantidad' FROM Noticia;")->result_array();
    }

    function num_noticias() {
        $consulta = $this->db->get('Noticia');
        return $consulta->num_rows();
    }

    // Con este método lo que hacemos es obtener las noticias de cada página
    function get_noticias_paginadas($por_pagina, $segmento) {
        if($segmento) $segmento = $segmento.",";
            
        $consulta = $this->db->query("SELECT Noticia.id as id, Noticia.titulo as titulo, Noticia.contenido as contenido,
                            Noticia.descripcion as descripcion, Noticia.fecha as fecha, Evento.titulo as evento
                            FROM Noticia
                            LEFT JOIN Evento 
                            ON Noticia.id_evento = Evento.id
                            ORDER BY Noticia.fecha DESC, Noticia.id DESC 
                            LIMIT $segmento $por_pagina");

        return $consulta->result_array();
    }

    function get_noticias_buscar($texto, $por_pagina, $segmento) {
        if($segmento) $segmento = $segmento.",";

        $consulta = $this->db->query("SELECT Noticia.id as id, Noticia.titulo as titulo, Noticia.contenido as contenido,
                            Noticia.descripcion as descripcion, Noticia.fecha as fecha, Evento.titulo as evento
                            FROM Noticia
                            LEFT JOIN Evento 
                            ON Noticia.id_evento = Evento.id
                            WHERE Noticia.titulo like '%$texto%'
                            ORDER BY Noticia.fecha DESC, Noticia.id DESC 
                            LIMIT $segmento $por_pagina");

        return $consulta->result_array();
    }

    function get_total_noticias_buscar($texto) {
        $consulta = $this->db->query("SELECT Noticia.id as id, Noticia.titulo as titulo, Noticia.contenido as contenido,
                                Noticia.descripcion as descripcion, Noticia.fecha as fecha, Evento.titulo as evento
                                FROM Noticia
                                LEFT JOIN Evento 
                                ON Noticia.id_evento = Evento.id
                                WHERE Noticia.titulo like '%$texto%'
                                ORDER BY Noticia.fecha DESC, Noticia.id DESC ");
        return $consulta->num_rows();
    }

    //ACTUALIZAR LA FOTO DE PORTADA DE UNA NOTICIA YA CREADA
    function actualizar_foto_portada($id_foto_portada, $id_noticia){
        $this->db->query("UPDATE Noticia SET id_foto_portada = $id_foto_portada WHERE id = $id_noticia");
    }

    //CRUD DE AGRADECIMIENTOS

    //obtener los agradecimientos de una noticia
    function get_agradecimientos($id_noticia){
        return $this->db->query("SELECT *
                                FROM Agradecimiento
                                WHERE id_noticia = $id_noticia")->result_array();
    }

    function get_agradecimiento_by_id($id_agradecimiento){
        return $this->db->query("SELECT * FROM Agradecimiento WHERE id = $id_agradecimiento")->result_array()[0];
    }

    function borrar_agradecimiento($id_agradecimiento)
    {
        $this->db->query("DELETE FROM Agradecimiento WHERE id = $id_agradecimiento");
    }

    function crear_agradecimiento($nuevo_agradecimiento)
    {
        $this->db->query("INSERT INTO Agradecimiento(id_noticia, nota, comentario, agradecimiento, fecha) VALUES ($nuevo_agradecimiento[id_noticia], \"$nuevo_agradecimiento[nota]\", \"$nuevo_agradecimiento[comentario]\", \"$nuevo_agradecimiento[agradecimiento]\", CURRENT_TIMESTAMP)");
    }

    function modificar_agradecimiento($nuevo_cambio, $id_agradecimiento)
    {
        $this->db->query("UPDATE Agradecimiento SET nota = \"$nuevo_cambio[nota]\", comentario = \"$nuevo_cambio[comentario]\", agradecimiento = \"$nuevo_cambio[agradecimiento]\" where id = $id_agradecimiento");
    }
}
?>
