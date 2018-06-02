<?php

class Bebida_model_test extends TestCase
{
    private $global;
    //var_dump($list); LA PUTA VIDA
    public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->model('Bebida_model');
        $this->obj = $this->CI->Bebida_model;
        $this->global = [
            'id' => '',
            'nombre' => 'Prueba',
            'cantidad' => '1',
            'alcohol' => '0',
            'precio_unitario' => '1',
            'precio_total' => '1',
        ];
    }

    public function test_crear_bebida()
    {
        $this->assertTrue($this->obj->crear_bebida($this->global));
    }

    public function test_get_bebidas()
    {
        $flag = false;
        $list = $this->obj->get_bebidas();

        foreach ($list as $bebida => $k) 
        {
            if($list[$bebida]['nombre'] == $this->global['nombre'])
            {
                $this->assertTrue(true);
                $this->global['id'] = $list[$bebida]['id'];
                $flag = true;
            }
        }
        if(!$flag) $this->assertTrue(false);
    }

    public function test_modificar_bebida()
    {
        $this->global['id'] = $this->obj->get_id_bebida_by_name($this->global['nombre'])['id'];
        $this->assertTrue($this->obj->modificar_bebida($this->global,$this->global['id']));
    }

    public function test_borrar_bebida()
    {
        $this->assertTrue($this->obj->borrar_bebida($this->obj->get_id_bebida_by_name($this->global['nombre'])['id']));
    }
}
?>