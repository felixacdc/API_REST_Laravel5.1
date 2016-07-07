<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{

    use DatabaseMigrations;
    use WithoutMiddleware;


    public function testUserCreate()
    {
        $data = $this->getData();
        // $data = json_encode($data);

        // Creamos un nuevo usuario y verificamos la respuesta
        $this->post('/user', $data)
            ->seeJsonEquals(['created' => true]);

        $data = $this->getData(['name' => 'Felix']);

        // Actualizamos al usuario recien creado (id = 1)
        $this->put('/user/1', $data)->seeJsonEquals(['updated' => true]);

        // Obtenemos los datos de dicho usuario modificado
        // y verificamos que el nombre sea el correcto
        $this->get('user/1')->seeJson(['name' => 'Felix']);

        // Eliminamos al usuario
        $this->delete('user/1')->seeJson(['deleted' => true]);
    }

    // Metodo para verificar la validacion de errores en crear usuario
    public function testValidationErrorOnCreateUser()
    {
        // $data = $this->getData(['name' => '', 'email' => 'felix']);
        /*
            dump() nos permite imprimir en pantalla la respuesta obtenida en la petición, en este caso estamos enviando el campo name vacío y para el campo email un valor que no es una cuenta de email válida.
        */
        // $this->post('/user', $data)->dump();
    }

    public function testNotFoundUser()
    {
        $this->get('user/10')->seeJsonEquals(['error' => 'Model not found']);
    }

    public function getData($custom = array())
    {
        $data = [
            'name'      =>  'Felix',
            'email'     =>  'felix@gmail.com',
            'password'  =>  '12345'
        ];

        $data = array_merge($data, $custom);
        return $data;
    }


}
