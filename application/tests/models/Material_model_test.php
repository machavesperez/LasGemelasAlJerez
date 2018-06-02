<?php

class Material_model_test extends TestCase
{
    private $global;
    //var_dump($list); LA PUTA VIDA
    public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->model('Material_model');
        $this->obj = $this->CI->Material_model;
        $this->global = [
            'id' => '',
            'nombre' => 'Prueba',
            'precio_unitario' => '1',
            'precio_total' => '1',
        ];
    }

    public function test_crear_material()
    {
        $this->assertTrue($this->obj->crear_material($this->global));
    }

    public function test_get_materiales()
    {
        $flag = false;
        $list = $this->obj->get_materiales();

        foreach ($list as $material => $k) 
        {
            if($list[$material]['nombre'] == $this->global['nombre'])
            {
                $this->assertTrue(true);
                $this->global['id'] = $list[$material]['id'];
                $flag = true;
            }
        }
        if(!$flag) $this->assertTrue(false);
    }

    public function test_modificar_material()
    {
        $this->global['id'] = $this->obj->get_id_material_by_name($this->global['nombre'])['id'];
        $this->assertTrue($this->obj->modificar_material($this->global,$this->global['id']));
    }

    public function test_borrar_material()
    {
        $this->assertTrue($this->obj->borrar_material($this->obj->get_id_material_by_name($this->global['nombre'])['id']));
    }
}
?>