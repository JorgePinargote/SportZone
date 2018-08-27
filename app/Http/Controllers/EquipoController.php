<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use App\Equipo;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Equipo::all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = request()->all();

        // 
        $request->validate([
            'nombre' => 'required|string',
            'deporte' => 'required|string',
        ]);

        $equipo = Equipo::create(['name_Equipo' => $input['nombre'] , 'idUsers' => Auth::id(), 'name_deporte' => $input['deporte']]);

        return response()->json([
            'mensaje' => 'equipo creado correctamente'
        ], 200); // responder de esta manera en las demas respuestas que sean mensajes. 

        return $message;     
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Equipo  $equipo
     * @return \Illuminate\Http\Response
     */
    public function show(Equipo $equipo)
    {
        return $equipo;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Equipo  $equipo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Equipo $equipo)
    {   
        $input = request()->all();
   // 
        $request->validate([
            'nombre' => 'required|string',
            'deporte' => 'required|string',
        ]);


        //aqui se podria validar que el que actualice sea el mimso usuario que creo el recurso anteriormente, se puede ver por el id. 
        $equipo->fill(['name_Equipo' => $input['nombre'] , 'idUsers' => $equipo->idUsers, 'name_deporte' => $input['deporte']])->save();


        $message = 'Equipo actualizado con exito';
        return $message;     
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Equipo  $equipo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipo $equipo)
    {
        $id = $equipo->name_Equipo;
        $equipo->delete();

        $message = "Se ha eliminado ". $id;
        return $message;      
    }


    public function equiposPorUsuario(){
        $user = Auth::user(); 
        return $user->equipos;
    }

    public function noticiasPorEquipo(Equipo $equipo){
        return $equipo->noticias;

    }











}