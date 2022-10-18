<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Custom;
use App\Models\Conferencia;
use App\Models\Departamento;
use App\Models\Subdireccion;
use App\Models\Direccion;
use App\Models\Sede;

class ConferenciaController extends Controller
{
    protected $bg;
    public function __construct()
    {
        $this->bg = Custom::where('id_user', 1)->get()->last();
    }

    public function calendario(Request $request){
        $bg = $this->bg;
        $cat_dir = Direccion::where('iactivo',1)->pluck('nombre', 'id');
        $cat_sub = Subdireccion::where('iactivo',1)->pluck('nombre', 'id');
        $cat_dep = Departamento::where('iactivo',1)->pluck('nombre', 'id');
        $cat_sed = Sede::where('iactivo',1)->pluck('nombre', 'id');
        $vc = [];
        if (Auth::user()->tipo_usuario == 2) {
            $confe = Conferencia::all();
        }else{
            $confe = Conferencia::where('estado',2)->get();
        }
        foreach ($confe as $key => $c) {
            if($c->estado == 1){
                $color = '#43A047';
            }elseif($c->estado == 2){
                $color = '#1A73E8';
            }elseif($c->estado == 3){
                $color = '#E53935';
            }
            $vc[] = [
            'id' => $c->id,
            'title' => $c->nombre,
            'start' => $c->feini,
            'end' => $c->fefin,
            'estado' => $c->estado,
            'color' => $color,
            ];
        }
        return view('conferencias.calendario',compact('vc','bg','cat_dir','cat_sub','cat_dep','cat_sed'));
    }
}
