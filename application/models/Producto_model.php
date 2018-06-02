<?php
Class Producto_model extends CI_Model
{

    function __construct(){
        $this->load->database();
    }

    function get_productos()
    {
        return $this->db->query("SELECT * FROM Producto")->result_array();
    }

    function get_productos_order()
    {
        return $this->db->query("SELECT * FROM Producto ORDER BY nombre")->result_array();
    }

    function borrar_producto($id_producto)
    {
        $this->db->query("DELETE FROM Receta_Producto WHERE id_producto = $id_producto");
        return $this->db->query("DELETE FROM Producto WHERE id = $id_producto");
    }

    function crear_producto($nuevo_producto)
    {
        if(empty($nuevo_producto['precio_unitario'])) $precio_unitario = 'null'; else $precio_unitario = $nuevo_producto['precio_unitario'];
        if(empty($nuevo_producto['precio_total'])) $precio_total = 'null'; else $precio_total = $nuevo_producto['precio_total'];

        return $this->db->query("INSERT INTO Producto(nombre, unidad, precio_unitario, precio_total) VALUES ('$nuevo_producto[nombre]', '$nuevo_producto[unidad]', $precio_unitario, $precio_total)");
    }

    function get_producto_id($id_producto)
    {
        return $this->db->query("SELECT * FROM Producto WHERE id = $id_producto")->result_array()[0];
    }

    function get_id_producto_by_name($nombre_producto)
    {
        return $this->db->query("SELECT id FROM Producto WHERE nombre= '$nombre_producto'")->result_array()[0];
    }

    function modificar_producto($nuevo_cambio, $id_producto) {   

        if(empty($nuevo_cambio['precio_unitario'])) $precio_unitario = 'null'; else $precio_unitario = $nuevo_cambio['precio_unitario'];
        if(empty($nuevo_cambio['precio_total'])) $precio_total = 'null'; else $precio_total = $nuevo_cambio['precio_total'];

        return $this->db->query("UPDATE Producto SET nombre = '$nuevo_cambio[nombre]', unidad = '$nuevo_cambio[unidad]', precio_unitario = $precio_unitario, precio_total = $precio_total where id = $id_producto");
    }

    function get_numActivos() {
        return $this->db->query("SELECT COUNT(DISTINCT id) 'cantidad' FROM Producto;")->result_array();
    }

    function num_productos() {
        $consulta = $this->db->get('Producto');
        return $consulta->num_rows();
    }

    // Con este método lo que hacemos es obtener los productos de cada página
    function get_productos_paginados($por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT * FROM Producto LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT * FROM Producto LIMIT $segmento, $por_pagina");
        return $consulta->result_array();
    }

    function get_productos_buscar($texto, $por_pagina, $segmento) {
        if($segmento == null)
            $consulta = $this->db->query("SELECT * FROM Producto WHERE nombre like '%$texto%' LIMIT $por_pagina");
        else
            $consulta = $this->db->query("SELECT * FROM Producto WHERE nombre like '%$texto%' LIMIT $segmento, $por_pagina");
        return $consulta->result_array();
    }

    function get_total_productos_buscar($texto) {
        $consulta = $this->db->query("SELECT * FROM Producto WHERE nombre like '%$texto%'");
        return $consulta->num_rows();
    }
}
?>