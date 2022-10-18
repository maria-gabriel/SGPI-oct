<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sede;
use App\Models\Custom;

class SedeController extends Controller
{
    protected $bg;
    public function __construct()
    {
        $this->bg = Custom::where('id_user', 1)->get()->last();
    }
    
    public function index()
    {
        $sedes = Sede::orderBy('created_at', 'DESC')->get();
        $bg = $this->bg;
        return view('sectores/sedes.index', compact('sedes', 'bg'));
    }

    public function crud(Request $request)
    {
        $respuesta = [];
        $err = "Hubo un problema. Consulte al administrador.";
        try {
            if ($request->has('index')) {
                if ($request->index == "load") {
                    $sedes = Sede::get(['id AS DT_RowId', 'sedes.*']);
                    $respuesta['data'] = $sedes;
                    return response()->json($respuesta);
                } elseif ($request->index == "save") {
                    $sede = new Sede();
                    $sede->nombre = $request->nombre;
                    $sede->ide = $request->ide;
                    $sede->iactivo = $request->iactivo;
                    $sede->save();
                    $nuevo = Sede::orderBy('created_at', 'desc')->first();
                    $respuesta['data'][0] = $nuevo;
                    return response()->json($respuesta);
                }elseif ($request->index == "update") {
                    $sede = Sede::where('id', $request->id)->get()->last();
                    $sede->id = $request->id;
                    $sede->nombre = $request->nombre;
                    $sede->ide = $request->ide;
                    $sede->iactivo = $request->iactivo;
                    $sede->update();
                    $respuesta['data'][0] = $sede;
                    return response()->json($respuesta);
                }elseif ($request->index == "remove") {
                    $sede = Sede::where('id', $request->id)->delete();
                    $sedes = Sede::get(['id AS DT_RowId', 'sedes.*']);
                    $respuesta['data'] = $sedes;
                    return response()->json($respuesta);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $err, 'code' => $e], 404);
        }
    }
}
