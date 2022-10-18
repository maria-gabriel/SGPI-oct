<?php

namespace App\Http\Controllers;

use App\Models\cat_accesos;
use App\Models\cat_perfiles;
use App\Models\Custom;
use Illuminate\Http\Request;

class CatAccesosController extends Controller
{
    protected $bg;
    public function __construct()
    {
        $this->bg = Custom::where('id_user', 1)->get()->last();
    }
    
    public function index()
    {
        $bg = $this->bg;
        $catalogo = [];
        $accesos = cat_perfiles::all();
        $catalogos= cat_perfiles::where('iactivo',1)->get();
        foreach ($catalogos as $key => $cat) {
            $catalogo[] =  ['label' => $cat->nombre, 'value' => $cat->id];
        }
        return view('accesos.index', compact('accesos', 'bg','catalogo'));
    }

    public function crud(Request $request)
    {
        $respuesta = [];
        $err = "Hubo un problema. Consulte al administrador.";
        try {
            if ($request->has('index')) {
                if ($request->index == "load") {
                    $accesos = cat_accesos::get(['id AS DT_RowId', 'cat_accesos.*']);
                    foreach ($accesos as $acceso) {
                        $perfiles = explode(",", $acceso->perfiles);
                        $acceso->perfiles = $perfiles;
                    }
                    $respuesta['data'] = $accesos;
                    return response()->json($respuesta);
                } elseif ($request->index == "save") {
                    $acceso = new cat_accesos();
                    $acceso->nombre = $request->nombre;
                    $acceso->ruta = $request->ruta;
                    $perfile = '';
                    $perfiles = '';
                    $cats = cat_perfiles::all();
                    foreach ($request->perfiles as $perfil) {
                        foreach ($cats as $cat) {
                            if($cat->id == $perfil){
                                $perfile = $perfile . $cat->id . ',';
                            }
                        }
                    }
                    $perfiles = rtrim($perfile, ", ");
                    $acceso->perfiles = $perfiles;
                    $request->iactivo == 1 ? $acceso->iactivo = 1 : $acceso->iactivo = 2;
                    $acceso->save();
                    $nuevo = cat_accesos::orderBy('created_at', 'desc')->first();
                    $respuesta['data'][0] = $nuevo;
                    return response()->json($respuesta);
                }elseif ($request->index == "update") {
                    $acceso = cat_accesos::where('id', $request->id)->get()->last();
                    $acceso->id = $request->id;
                    $acceso->nombre = $request->nombre;
                    $acceso->ruta = $request->ruta;
                    $perfile = '';
                    $perfiles = '';
                    $cats = cat_perfiles::all();
                    foreach ($request->perfiles as $perfil) {
                        foreach ($cats as $cat) {
                            if($cat->id == $perfil){
                                $perfile = $perfile . $cat->id . ',';
                            }
                        }
                    }
                    $perfiles = rtrim($perfile, ", ");
                    $acceso->perfiles = $perfiles;
                    $acceso->iactivo = $request->iactivo; 
                    $acceso->update();
                    $perfiles = explode(",", $acceso->perfiles);
                        $acceso->perfiles = $perfiles;
                    $respuesta['data'][0] = $acceso;
                    return response()->json($respuesta);
                }elseif ($request->index == "remove") {
                    $acceso = cat_accesos::where('id', $request->id)->delete();
                    $accesos = cat_accesos::get(['id AS DT_RowId', 'cat_accesos.*']);
                    foreach ($accesos as $acceso) {
                        $perfiles = explode(",", $acceso->perfiles);
                        $acceso->perfiles = $perfiles;
                    }
                    return response()->json($accesos);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $err, 'code' => $e], 404);
        }
    }
}
