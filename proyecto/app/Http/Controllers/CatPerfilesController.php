<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cat_perfiles;
use App\Models\Custom;

class CatPerfilesController extends Controller
{
    protected $bg;
    public function __construct()
    {
        $this->bg = Custom::where('id_user', 1)->get()->last();
    }
    
    public function index()
    {
        $bg = $this->bg;
        $perfiles = cat_perfiles::orderBy('created_at', 'DESC')->get();
        return view('catalogos/perfiles.index', compact('perfiles', 'bg'));
    }

    public function crud(Request $request)
    {
        $respuesta = [];
        $err = "Hubo un problema. Consulte al administrador.";
        try {
            if ($request->has('index')) {
                if ($request->index == "load") {
                    $perfiles = cat_perfiles::get(['id AS DT_RowId', 'cat_perfiles.*']);
                    $respuesta['data'] = $perfiles;
                    return response()->json($respuesta);
                } elseif ($request->index == "save") {
                    $perfil = new cat_perfiles();
                    $perfil->nombre = $request->nombre;
                    $perfil->descripcion = $request->descripcion;
                    $perfil->iactivo = $request->iactivo;
                    $perfil->save();
                    $nuevo = cat_perfiles::orderBy('created_at', 'desc')->first();
                    $respuesta['data'][0] = $nuevo;
                    return response()->json($respuesta);
                }elseif ($request->index == "update") {
                    $perfil = cat_perfiles::where('id', $request->id)->get()->last();
                    $perfil->id = $request->id;
                    $perfil->nombre = $request->nombre;
                    $perfil->descripcion = $request->descripcion;
                    $perfil->iactivo = $request->iactivo;
                    $perfil->update();
                    $respuesta['data'][0] = $perfil;
                    return response()->json($respuesta);
                }elseif ($request->index == "remove") {
                    $perfil = cat_perfiles::where('id', $request->id)->delete();
                    $perfiles = cat_perfiles::get(['id AS DT_RowId', 'cat_perfiles.*']);
                    $respuesta['data'] = $perfiles;
                    return response()->json($respuesta);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $err, 'code' => $e], 404);
        }
    }
}
