<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subdireccion;
use App\Models\Direccion;
use App\Models\Custom;

class SubdireccionController extends Controller
{
    protected $bg;
    public function __construct()
    {
        $this->bg = Custom::where('id_user', 1)->get()->last();
    }

    public function index()
    {
        $bg = $this->bg;
        $areas = [];
        $subdirecciones = Subdireccion::orderBy('created_at', 'DESC')->get();
        $dir= Direccion::where('iactivo',1)->get();
        $areas[] =  ['label' => 'Seleccione una dirección', 'value' => null];
        foreach ($dir as $key => $area) {
            $areas[] =  ['label' => $area->nombre, 'value' => $area->id];
        }
       return view('sectores/subdirecciones.index',compact('subdirecciones','bg','areas'));   
    }

    public function crud(Request $request)
    {
        $respuesta = [];
        $err = "Hubo un problema. Consulte al administrador.";
        try {
            if ($request->has('index')) {
                if ($request->index == "load") {
                    $subdirecciones = Subdireccion::get(['id AS DT_RowId', 'subdirecciones.*']);
                    $respuesta['data'] = $subdirecciones;
                    return response()->json($respuesta);
                } elseif ($request->index == "save") {
                    $sub = new Subdireccion();
                    $sub->nombre = $request->nombre;
                    $sub->id_dir = $request->id_dir;
                    $sub->iactivo = $request->iactivo;
                    $sub->save();
                    $nuevo = Subdireccion::orderBy('created_at', 'desc')->first();
                    $respuesta['data'][0] = $nuevo;
                    return response()->json($respuesta);
                }elseif ($request->index == "update") {
                    $sub = Subdireccion::where('id', $request->id)->get()->last();
                    $sub->id = $request->id;
                    $sub->nombre = $request->nombre;
                    $sub->id_dir = $request->id_dir;
                    $sub->iactivo = $request->iactivo;
                    $sub->update();
                    $respuesta['data'][0] = $sub;
                    return response()->json($respuesta);
                }elseif ($request->index == "remove") {
                    $sub = Subdireccion::where('id', $request->id)->delete();
                    $subdirecciones = Subdireccion::get(['id AS DT_RowId', 'subdirecciones.*']);
                    $respuesta['data'] = $subdirecciones;
                    return response()->json($respuesta);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $err, 'code' => $e], 404);
        }
    }

    public function details(Request $request){
        $subdirecciones = Subdireccion::where('id_dir', $request->dir)->get();
        $res_sub[0] = array(
            'id' => '',
            'value' => '',
            'text' => 'Seleccione una subdirección',
        );
        $i=1;
        foreach ($subdirecciones as $subdireccion) {
            $res_sub[$i] = array(
                'id' => $subdireccion->id,
                'value' => $subdireccion->id,
                'text' => $subdireccion->nombre,
            );
            $i++;
        }
        return response()->json($res_sub);
    }
}
