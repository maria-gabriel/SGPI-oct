<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sede;
use App\Models\Custom;
use App\Models\Direccion;
use App\Models\Subdireccion;
use App\Models\Departamento;
use Illuminate\Support\Facades\Auth;
use App\Models\cat_perfiles;

class UserController extends Controller
{
    protected $bg;
    public function __construct()
    {
        $this->bg = Custom::where('id_user', 1)->get()->last();
    }
    public function index(){
        $bg = $this->bg;
        $areas = [];
        $users= User::all();
        $dir= Direccion::where('iactivo',1)->get();
        $sub= Subdireccion::where('iactivo',1)->get();
        $dep= Departamento::where('iactivo',1)->get();
        $areas[] =  ['label' => 'Seleccione un area', 'value' => null];
        foreach ($dir as $key => $area) {
            $areas[] =  ['label' => $area->nombre, 'value' => $area->id];
        }
        foreach ($sub as $key => $area) {
            $areas[] =  ['label' => $area->nombre, 'value' => $area->id];
        }
        foreach ($dep as $key => $area) {
            $areas[] =  ['label' => $area->nombre, 'value' => $area->id];
        }
       return view('usuarios.index',compact('users', 'bg','areas'));        
    }
    public function perfil(){
       $bg = $this->bg;
       $log = User::where('id', Auth::user()->id)->first();
       $usuarios = User::where('area', Auth::user()->area)->get();
       if($log->area < 300){
        if($log->area>=200){
            $area = Departamento::where('id', Auth::user()->area)->first();
           }else if($log->area>= 100 && $log->area<200){
            $area = Subdireccion::where('id', Auth::user()->area)->first(); 
           }else if($log->area< 100){
            $area = Direccion::where('id', Auth::user()->area)->first(); 
           }
       }else{
            $area = Sede::where('id', Auth::user()->area)->first(); 
       }

       if($log->tipo_usuario == 1){
        $tipo = 'Usuario de dominio';
       }else{
        $perfil = cat_perfiles::where('id', $log->admin->perfil)->first();
        $tipo = $perfil->nombre;
       }
       return view('usuarios.perfil',compact('log','area','bg','tipo','usuarios'));     
    }
   
    public function area(){
       $bg = $this->bg;
       $cat_sed = Sede::where('iactivo',1)->pluck('nombre', 'id'); 
       $cat_dir = Direccion::where('iactivo',1)->pluck('nombre', 'id'); 
       $cat_sub = Subdireccion::where('iactivo',1)->pluck('nombre', 'id'); 
       $cat_dep = Departamento::where('iactivo',1)->pluck('nombre', 'id'); 
       return view('usuarios.area',compact('bg','cat_dir','cat_sub','cat_dep','cat_sed'));     
    }
    public function update(Request $request, User $usuario){
        try{
        $usuario->nombre = $request->nombre;
        $usuario->apepa = $request->apepa;
        $usuario->apema = $request->apema;
        $usuario->sexo = $request->sexo;
        $usuario->email = $request->email;
        $usuario->telefono = $request->telefono;
        $usuario->update();
        return back()->with('ok', 'ok');

    }catch(\Exception $e){
            return back()->with('nook', $e->getMessage());
    }
}

    public function update_area(Request $request, User $usuario){
        try{
            if($request->sede == 301){
                $usuario->id_dir = $request->direccion;
                $usuario->area = $request->direccion;
                if($request->departamento != null && $request->has('departamento')){
                    $usuario->area = $request->departamento;
                }else if($request->subdireccion != null && $request->has('subdireccion')){
                    $usuario->area = $request->subdireccion;
            }
            }else{
                $usuario->area = $request->sede;
            }
            
        $usuario->update();
        return back()->with('ok', 'ok');
        }catch(\Exception $e){
                return back()->with('nook', $e->getMessage());
        }
    }

    public function custom(Request $request){
        $bg = $this->bg;
        $bg->customcolor = $request->custom;
        $bg->custom = 'btn-'.$request->custom;
        $bg->custombackground = 'bg-gradient-'.$request->custom.' active';
        $bg->custommode = $request->custom2;
        $bg->custommenu = $request->custom3;
        $bg->customother = $request->custom4;
        $bg->update();
        return back();
    }

    public function crud(Request $request)
    {
        $respuesta = [];
        $err = "Hubo un problema. Consulte al administrador.";
        try {
            if ($request->has('index')) {
                if ($request->index == "load") {
                    $usuario = User::get(['id AS DT_RowId', 'users.*']);
                    foreach ($usuario as $user) {
                        $user->nombre = $user->nombreCompleto;
                        if($user->area>=200){
                            $area = Departamento::where('id',$user->area)->first();
                            $user->apema = $area->nombre;
                           }else if($user->area<200 && $user->area >= 100){
                            $area = Subdireccion::where('id',$user->area)->first();
                            $user->apema = $area->nombre;
                           }else if($user->area<100 && $user->area >= 1){
                            $area = Direccion::where('id',$user->area)->first();
                            $user->apema = $area->nombre;
                           }else{
                            $user->apema = null;
                           }
                    }
                    $respuesta['data'] = $usuario;
                    return response()->json($respuesta);
                } elseif ($request->index == "update") {
                    $usuario = User::where('id', $request->id)->get()->last();
                    $usuario->id = $request->id;
                    $usuario->email = $request->email;
                    $usuario->telefono = $request->telefono;
                    $usuario->iactivo = $request->iactivo;
                    $usuario->update();
                    $usuario->nombre = $usuario->nombreCompleto;
                    if($usuario->area>=200){
                        $area = Departamento::where('id',$usuario->area)->first();
                        $usuario->apema = $area->nombre;
                        }else if($usuario->area<200 && $usuario->area >= 100){
                        $area = Subdireccion::where('id',$usuario->area)->first();
                        $usuario->apema = $area->nombre;
                        }else if($usuario->area<100 && $usuario->area >= 1){
                        $area = Direccion::where('id',$usuario->area)->first();
                        $usuario->apema = $area->nombre;
                        }else{
                        $usuario->apema = null;
                        }
                    $respuesta['data'][0] = $usuario;
                    return response()->json($respuesta);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $err, 'code' => $e], 404);
        }
    }
}
