<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Direccion;
use App\Models\Custom;

class DireccionController extends Controller
{
    protected $bg;
    public function __construct()
    {
        $this->bg = Custom::where('id_user', 1)->get()->last();
    }

    public function index()
    {
        $bg = $this->bg;
        $direcciones = Direccion::orderBy('created_at', 'DESC')->get();
       return view('sectores/direcciones.index',compact('direcciones','bg'));   
    }

    public function crud(Request $request)
    {
        $respuesta = [];
        $err = "Hubo un problema. Consulte al administrador.";
        try {
            if ($request->has('index')) {
                if ($request->index == "load") {
                    $direcciones = Direccion::get(['id AS DT_RowId', 'direcciones.*']);
                    $respuesta['data'] = $direcciones;
                    return response()->json($respuesta);
                } elseif ($request->index == "save") {
                    $dir = new Direccion();
                    $dir->nombre = $request->nombre;
                    $request->iactivo == 1 ? $dir->iactivo = 1 : $dir->iactivo = 2;
                    $dir->save();
                    $nuevo = Direccion::orderBy('created_at', 'desc')->first();
                    $respuesta['data'][0] = $nuevo;
                    return response()->json($respuesta);
                }elseif ($request->index == "update") {
                    $dir = Direccion::where('id', $request->id)->get()->last();
                    $dir->id = $request->id;
                    $dir->nombre = $request->nombre;
                    $dir->iactivo = $request->iactivo;
                    $dir->update();
                    $respuesta['data'][0] = $dir;
                    return response()->json($respuesta);
                }elseif ($request->index == "remove") {
                    $dir = Direccion::where('id', $request->id)->delete();
                    $direcciones = Direccion::get(['id AS DT_RowId', 'direcciones.*']);
                    $respuesta['data'] = $direcciones;
                    return response()->json($respuesta);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $err, 'code' => $e], 404);
        }
    }

    public function inactivar(Direccion $direccion){
        $direccion->iactivo=0;
        $direccion->update();
        return redirect()->route('direcciones.index');
    }
     public function activar(Direccion $direccion){
        $direccion->iactivo=1;
        $direccion->update();
        return redirect()->route('direcciones.index');
    }
    public function create(Direccion $direccion)
    {  
        $bg = $this->bg;
        return view('direcciones.create',compact('direccion','bg'));
       
    }
    public function store(Request $request, Direccion $direccion){
        try{
            $up = Direccion::where('id', $direccion->id)->get()->last();
        if($up){
            $up->nombre=$request->nombre;
            $up->update();
        }else{
            $dir = new Direccion();
            $dir->nombre=$request->nombre;
            $dir->save();
        } 
        
            return back()->with('ok', 'ok');

    }catch(\Exception $e){
            return back()->with('nook', $e->getMessage());
         }
    }
}
