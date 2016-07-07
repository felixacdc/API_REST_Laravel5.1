<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Modificar metodo para que maneje validaciones
        // Creamos las reglas de validacion
        $rules = [
            'name'      =>  'required',
            'email'     =>  'required|email',
            'password'  =>  'required'
        ];

        // Utilizamos un manejador de excepciones
        try {

            // Ejecutamos el validados, en caso de que falle devolvemos la respuesta
            $validator = \Validator::make($request->all(), $rules);

            if ( $validator->fails() ) {
                return [
                    'created'   =>  false,
                    'errors'    =>  $validator->errors()->all()
                ];
            }

            User::create($request->all());

            return ["created" => true];

        } catch (Exception $e) {
            \Log::info('Error creating user: ' . $e);
            return \Response::json(['created' => false], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /*
            Cuando usamos el método findOrFail() forzamos a que la aplicación arroje una excepción de tipo ModelNotFoundException, podemos capturar entonces el tipo de excepcion y enviar una respuesta personalizada, esto lo hacemos editando el archivo app/Exceptions/Handler.php
        */
        return User::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name'      =>  'required',
            'email'     =>  'required|email',
            'password'  =>  'required'
        ];

        try {

            $validator = \Validator::make($request->all(), $rules);

            if ( $validator->fails() ) {
                return [
                    'updated'   =>  false,
                    'errors'    =>  $validator->errors()->all()
                ];
            }

            $user = User::findOrFail($id);
            $user->update($request->all());
            return ['updated' => true];
        } catch (Exception $e) {
            \Log::info('Error creating user: ' . $e);
            return \Response::json(['updated' => false], 500);
        }

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::destroy($id);
        return ['deleted' => true];
    }
}
