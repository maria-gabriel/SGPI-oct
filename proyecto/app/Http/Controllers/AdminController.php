<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Custom;
use App\Models\User;
use App\Models\cat_perfiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    protected $bg;
    public function __construct()
    {
        $this->bg = Custom::where('id_user', 1)->get()->last();
    }

    public function index()
    {
        $bg = $this->bg;
        $users_id = [];
        $catalogo = [];
        $users = User::all();
        $type = Admin::where('id_user', Auth::user()->id)->get()->last();
        foreach ($users as $key => $user) {
            $users_id[$key] = $user->id;
        }
        $catalogos= cat_perfiles::where('iactivo',1)->get();
        foreach ($catalogos as $key => $cat) {
            $cat->nombre == 'Normal' ? $cat->nombre = 'Normal (Sin permisos)' : $cat->nombre = $cat->nombre;
            $catalogo[] =  ['label' => $cat->nombre, 'value' => $cat->id];
        }

        $admins = Admin::WhereIn('id_user', $users_id)->get();
        return view('admins.index', compact('admins', 'bg', 'type','catalogo'));
    }

    public function asignar(Admin $admin)
    {
        $clues = cat_clue::all()->where('iactivo', 1)->pluck('Cluescompleto', 'id');
        return view('admins.asignar', compact('admin', 'clues'));
    }

    public function crud(Request $request)
    {
        $respuesta = [];
        $err = "Hubo un problema. Consulte al administrador.";
        try {
            if ($request->has('index')) {
                if ($request->index == "load") {
                    $usuario = Admin::get(['id AS DT_RowId', 'admins.*']);
                    foreach ($usuario as $user) {
                        $user->nombre = $user->usuario->nombreCompleto;
                        $user->username = $user->usuario->username;
                    }
                    $respuesta['data'] = $usuario;
                    return response()->json($respuesta);
                } elseif ($request->index == "update") {
                    $usuario = Admin::where('id', $request->id)->get()->last();
                    $usuario->id = $request->id;
                    $usuario->perfil = $request->perfil;
                    $usuario->disponible = $request->disponible;
                    $usuario->confirmacion = $request->confirmacion;
                    if($request->confirmacion == 1){
                        $user = User::find($usuario->id_user);
                        $user->tipo_usuario = 2;
                        $user->update();
                    }else{
                        $user = User::find($usuario->id_user);
                        $user->tipo_usuario = 1;
                        $user->update();
                    }
                    $usuario->update();
                    $usuario->estatus = $usuario->nombreCompleto;
                    $respuesta['data'][0] = $usuario;
                    return response()->json($respuesta);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $err, 'code' => $e], 404);
        }
    }
}
