<?php

namespace App\Http\Controllers;
use App\Models\Servicio;
use App\Models\Custom;

use Illuminate\Http\Request;

class ServicioController extends Controller
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
        $servicios = Servicio::orderBy('created_at', 'DESC')->get();
        $catalogo[] =  ['label' => 'Seleccione una dificultad', 'value' => null];
        $catalogo[] =  ['label' => 'Dificultad baja', 'value' => '1'];
        $catalogo[] =  ['label' => 'Dificultad media', 'value' => '2'];
        $catalogo[] =  ['label' => 'Dificultad alta', 'value' => '3'];
       return view('catalogos/servicios.index',compact('servicios','bg','catalogo'));   
    }

    public function crud(Request $request)
    {
        $respuesta = [];
        $err = "Hubo un problema. Consulte al administrador.";
        try {
            if ($request->has('index')) {
                if ($request->index == "load") {
                    $servicios = Servicio::get(['id AS DT_RowId', 'servicios.*']);
                    $respuesta['data'] = $servicios;
                    return response()->json($respuesta);
                } elseif ($request->index == "save") {
                    $servicio = new Servicio();
                    $servicio->nombre = $request->nombre;
                    $servicio->peso = $request->peso;
                    $servicio->iactivo = $request->iactivo;
                    $servicio->save();
                    $nuevo = Servicio::orderBy('created_at', 'desc')->first();
                    $respuesta['data'][0] = $nuevo;
                    return response()->json($respuesta);
                }elseif ($request->index == "update") {
                    $servicio = Servicio::where('id', $request->id)->get()->last();
                    $servicio->id = $request->id;
                    $servicio->nombre = $request->nombre;
                    $servicio->peso = $request->peso;
                    $servicio->iactivo = $request->iactivo;
                    $servicio->update();
                    $respuesta['data'][0] = $servicio;
                    return response()->json($respuesta);
                }elseif ($request->index == "remove") {
                    $servicio = Servicio::where('id', $request->id)->delete();
                    $servicios = Servicio::get(['id AS DT_RowId', 'servicios.*']);
                    $respuesta['data'] = $servicios;
                    return response()->json($respuesta);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $err, 'code' => $e], 404);
        }
    }
}
