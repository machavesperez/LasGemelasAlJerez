<?php
Class Foto_model extends CI_Model
{

    function __construct(){
        $this->load->database();
    }

    function get_foto_by_id($id){
        return $this->db->get_where('Foto', array('id' => $id))->result_array();
    }

    function get_foto_by_nombre($nombre)
    {
        return $this->db->get_where('Foto', array('nombre' => $nombre))->result_array();
    }

    function delete_foto($id){
        $foto = $this->get_foto_by_id($id)[0];
        unlink(".".$foto['ruta']);
        $this->db->query("DELETE FROM Foto WHERE id = $id");
    }

    //FUNCIÓN PARA INSERTAR LOS DATOS DE LA IMAGEN SUBIDA
    function insert_foto($titulo,$imagen)
    {
        $data = array(
            'nombre' => $titulo,
            'ruta' => $imagen
        );
        return $this->db->insert('Foto', $data);
    }

    function delete_foto_galeria($id_noticia, $id_foto){
        $this->db->query("DELETE FROM Noticia_Foto WHERE id_noticia = $id_noticia AND id_foto = $id_foto");
        $this->delete_foto($id_foto);
    }
    
    public function insert_galeria($data = array(), $id_noticia){
        
        $insert = $this->db->insert_batch('Foto',$data);
        foreach ($data as $foto) {
            $id_foto = $this->get_foto_by_nombre($foto['nombre'])[0]['id'];
            $this->db->query("INSERT INTO Noticia_Foto(id_noticia, id_foto) VALUES ($id_noticia, $id_foto); ");
        }
        return $insert?true:false;
    }

}
?>
