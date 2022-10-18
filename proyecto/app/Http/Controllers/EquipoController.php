<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipo;
use App\Models\Custom;

class EquipoController extends Controller
{
    protected $bg;
    public function __construct()
    {
        $this->bg = Custom::where('id_user', 1)->get()->last();
    }
    public function index()
    {
        $bg = $this->bg;
        $equipos = Equipo::orderBy('created_at', 'DESC')->get();
       return view('catalogos/equipos.index',compact('equipos','bg'));   
    }

    public function crud(Request $request)
    {
        $respuesta = [];
        $err = "Hubo un problema. Consulte al administrador.";
        try {
            if ($request->has('index')) {
                if ($request->index == "load") {
                    $equipos = Equipo::get(['id AS DT_RowId', 'equipos.*']);
                    $respuesta['data'] = $equipos;
                    return response()->json($respuesta);
                } elseif ($request->index == "save") {
                    $equipo = new Equipo();
                    $equipo->nombre = $request->nombre;
                    $equipo->iactivo = $request->iactivo;
                    $equipo->save();
                    $nuevo = Equipo::orderBy('created_at', 'desc')->first();
                    $respuesta['data'][0] = $nuevo;
                    return response()->json($respuesta);
                }elseif ($request->index == "update") {
                    $equipo = Equipo::where('id', $request->id)->get()->last();
                    $equipo->id = $request->id;
                    $equipo->nombre = $request->nombre;
                    $equipo->iactivo = $request->iactivo;
                    $equipo->update();
                    $respuesta['data'][0] = $equipo;
                    return response()->json($respuesta);
                }elseif ($request->index == "remove") {
                    $equipo = Equipo::where('id', $request->id)->delete();
                    $equipos = Equipo::get(['id AS DT_RowId', 'equipos.*']);
                    $respuesta['data'] = $equipos;
                    return response()->json($respuesta);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $err, 'code' => $e], 404);
        }
    }
}
