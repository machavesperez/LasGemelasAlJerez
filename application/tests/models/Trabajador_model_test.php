<?php

class Trabajador_model_test extends TestCase
{
    private $global;
    //var_dump($list); LA PUTA VIDA
    public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->model('Trabajador_model');
        $this->obj = $this->CI->Trabajador_model;
        $this->global = [
            'id' => '',
            'nombre' => 'Prueba',
            'apellidos' => 'Probador',
            'tipo' => 'Camarero',
        ];
    }

    public function test_crear_trabajador()
    {
        $this->assertTrue($this->obj->crear_trabajador($this->global));
    }

    public function test_get_trabajadores()
    {
        $flag = false;
        $list = $this->obj->get_trabajadores();

        foreach ($list as $trabajador => $k) 
        {
            if($list[$trabajador]['nombre'] == $this->global['nombre'])
            {
                $this->assertTrue(true);
                $this->global['id'] = $list[$trabajador]['id'];
                $flag = true;
            }
        }
        if(!$flag) $this->assertTrue(false);
    }

    public function test_modificar_trabajador()
    {
        $this->global['id'] = $this->obj->get_id_trabajador_by_name($this->global['nombre'])['id'];
        $this->assertTrue($this->obj->modificar_trabajador($this->global,$this->global['id']));
    }

    public function test_borrar_trabajador()
    {
        $this->assertTrue($this->obj->borrar_trabajador($this->obj->get_id_trabajador_by_name($this->global['nombre'])['id']));
    }
}
?>