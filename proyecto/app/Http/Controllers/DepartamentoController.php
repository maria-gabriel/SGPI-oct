<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departamento;
use App\Models\Subdireccion;
use App\Models\Custom;

class DepartamentoController extends Controller
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
        $departamentos = Departamento::orderBy('created_at', 'DESC')->get();
        $dir= Subdireccion::where('iactivo',1)->get();
        $areas[] =  ['label' => 'Seleccione una subdirección', 'value' => null];
        foreach ($dir as $key => $area) {
            $areas[] =  ['label' => $area->nombre, 'value' => $area->id];
        }
       return view('sectores/departamentos.index',compact('departamentos','bg','areas'));   
    }

    public function crud(Request $request)
    {
        $respuesta = [];
        $err = "Hubo un problema. Consulte al administrador.";
        try {
            if ($request->has('index')) {
                if ($request->index == "load") {
                    $departamentos = Departamento::get(['id AS DT_RowId', 'departamentos.*']);
                    $respuesta['data'] = $departamentos;
                    return response()->json($respuesta);
                } elseif ($request->index == "save") {
                    $dep = new Departamento();
                    $dep->nombre = $request->nombre;
                    $dep->id_sub = $request->id_sub;
                    $dep->iactivo = $request->iactivo;
                    $dep->save();
                    $nuevo = Departamento::orderBy('created_at', 'desc')->first();
                    $respuesta['data'][0] = $nuevo;
                    return response()->json($respuesta);
                }elseif ($request->index == "update") {
                    $dep = Departamento::where('id', $request->id)->get()->last();
                    $dep->id = $request->id;
                    $dep->nombre = $request->nombre;
                    $dep->id_sub = $request->id_sub;
                    $dep->iactivo = $request->iactivo;
                    $dep->update();
                    $respuesta['data'][0] = $dep;
                    return response()->json($respuesta);
                }elseif ($request->index == "remove") {
                    $dep = Departamento::where('id', $request->id)->delete();
                    $departamentos = Departamento::get(['id AS DT_RowId', 'departamentos.*']);
                    $respuesta['data'] = $departamentos;
                    return response()->json($respuesta);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $err, 'code' => $e], 404);
        }
    }

    public function details(Request $request){
        $departamentos = Departamento::where('id_sub', $request->sub)->get();
        $res_dep[0] = array(
            'id' => '',
            'value' => '',
            'text' => 'Seleccione un departamento',
        );
        $i=1;
        foreach ($departamentos as $departamento) {
            $res_dep[$i] = array(
                'id' => $departamento->id,
                'value' => $departamento->id,
                'text' => $departamento->nombre,
            );
            $i++;
        }
        return response()->json($res_dep);
    }
}
