<?php

class Producto_model_test extends TestCase
{
    private $global;
    //var_dump($list); LA PUTA VIDA
    public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->model('Producto_model');
        $this->obj = $this->CI->Producto_model;
        $this->global = [
            'id' => '',
            'nombre' => 'Prueba',
            'unidad' => 'kg',
            'precio_unitario' => '1',
            'precio_total' => '1',
        ];
    }

    public function test_crear_producto()
    {
        $this->assertTrue($this->obj->crear_producto($this->global));
    }

    public function test_get_productos()
    {
        $flag = false;
        $list = $this->obj->get_productos();

        foreach ($list as $producto => $k) 
        {
            if($list[$producto]['nombre'] == $this->global['nombre'])
            {
                $this->assertTrue(true);
                $this->global['id'] = $list[$producto]['id'];
                $flag = true;
            }
        }
        if(!$flag) $this->assertTrue(false);
    }

    public function test_modificar_producto()
    {
        $this->global['id'] = $this->obj->get_id_producto_by_name($this->global['nombre'])['id'];
        $this->assertTrue($this->obj->modificar_producto($this->global,$this->global['id']));
    }

    public function test_borrar_producto()
    {
        $this->assertTrue($this->obj->borrar_producto($this->obj->get_id_producto_by_name($this->global['nombre'])['id']));
    }
}
?>