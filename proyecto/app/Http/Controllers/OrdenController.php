<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Servicio;
use App\Models\Equipo;
use App\Models\User;
use App\Models\Custom;
use App\Models\Orden;
use App\Models\Departamento;
use App\Models\Subdireccion;
use App\Models\Direccion;

class OrdenController extends Controller
{
    protected $bg;
    public function __construct()
    {
        $this->bg = Custom::where('id_user', 1)->get()->last();
    }

    public function home()
    {
        $bg = $this->bg;
        $user=User::find(Auth::user()->id);
        $cat_tarea = Servicio::where('iactivo',1)->pluck('nombre', 'id');
        $cat_equipo = Equipo::where('iactivo',1)->pluck('nombre', 'id');
        if($user->area>=200){
            $cat_area = Departamento::where('iactivo',1)->pluck('nombre', 'id');
           }else if($user->area>= 100 && $user->area<200){
            $cat_area = Subdireccion::where('iactivo',1)->pluck('nombre', 'id'); 
           }else if($user->area< 100){
            $cat_area = Direccion::where('iactivo',1)->pluck('nombre', 'id');
           }
        return view('ordenes.home',compact('cat_tarea','bg','user','cat_equipo','cat_area'));   
    }

    public function index()
    {
        $bg = $this->bg;
        // $perfiles = Orden::orderBy('created_at', 'DESC')->get();
        return view('ordenes.index', compact('bg'));
    }

    public function crud(Request $request)
    {
        $respuesta = [];
        $err = "Hubo un problema. Consulte al administrador.";
        try {
            if ($request->has('index')) {
                if ($request->index == "load") {
                    $ordenes = Orden::get(['id AS DT_RowId', 'ordenes.*']);
                    foreach ($ordenes as $key => $orden) {
                        $orden->id_admin = $orden->admin_orden->username;
                        $orden->id_servicio = $orden->servicio_orden->nombre;
                    }
                    $respuesta['data'] = $ordenes;
                    return response()->json($respuesta);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $err, 'code' => $e], 404);
        }
    }
}
