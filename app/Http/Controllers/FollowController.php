<?php

namespace App\Http\Controllers;

use App\Follow;
use App\User;
use App\Equipo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function seguido($equipo)
    {
        $follow = Follow::where('equipo',(int)$equipo)->where('idusuario', (int)Auth::user()->id)->get()->first();
        if($follow != null){
            return 1;
        }
        else{
            return 0;
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'idequipo' => 'required|string',
        ]);
        $idEq = $request->idequipo;
        $nuevo =$this->seguido($idEq);
        if($nuevo==1){
            return response()->json([
            'mensaje' => 'Ya sigue al equipo',
        ]);
            
        }
        else{
            $equipo = Equipo::find($idEq);
            $user = Auth::user();
            $follow = new Follow;
            $follow->idusuario = $user->id;
            $follow->equipo = $equipo->id_Equipo;
            $follow->save();
            return response()->json([
            'mensaje' => 'siguiendo a ' . $equipo->name_Equipo,
            'followid'=> $follow->getKey(),
        ]);
        }

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Follow  $follow
     * @return \Illuminate\Http\Response
     */
    public function destroy(Follow $follow)
    {
        $follow->delete();
        return response()->json([
            'mensaje' => 'dejado de seguir correctamente'
        ], 200);
    }

    public function destruir(Request $request){
        $request->validate([
            'idequipo' => 'required|string',
        ]);
        $idEq = $request->idequipo;
        $nuevo =$this->seguido($idEq);
        if($nuevo==1){
            $follow = Follow::where('equipo',(int)$idEq)->where('idusuario', (int)Auth::user()->id)->get()->first();
            $follow->delete();
            return response()->json([
            'mensaje' => 'borrado',
        ]);
            
        }
        else{
            return response()->json(["mensaje" =>"no sigue a este equipo"]);
        }


    }

    
    //RUTAS PARA EL USUARIO GENERAL 
    public function isFollowed(Equipo $equipo){
        $follow = Follow::where('equipo','=',$equipo->id_Equipo)->where('idusuario','=', Auth::user()->id)->get()->first();
        if($follow != null){
            return response()->json([
                'seguido' => 1
            ], 200);
        }
        return response()->json([
            'seguido' => 0
        ], 200);

    }

}
