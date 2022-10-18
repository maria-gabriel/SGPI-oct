<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Custom;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Tarea;
use App\Models\User;
use App\Models\Subtarea;
use App\Models\Proyecto;
use App\Models\cat_docs;
use App\Models\Documento;
use App\Models\Sede;
use App\Models\Direccion;
use App\Models\Subdireccion;
use App\Models\Departamento;

class SubtareaController extends Controller
{
    protected $bg;
    public function __construct()
    {
        $this->bg = Custom::where('id_user', 1)->get()->last();
    }
    public function crud(Request $request)
    {
        $respuesta = [];
        $err = "Hubo un problema. Consulte un administrador.";
        try {
            if ($request->has('index')) {
                if ($request->index == "load") {
                    $subtarea = Subtarea::get(['id AS DT_RowId', 'subtareas.*']);
                    $respuesta['data'] = $subtarea;
                    return response()->json($respuesta);
                } elseif ($request->index == "get") {
                    $subtarea = Subtarea::where('id_tarea', $request->id_tarea)->get(['id AS DT_RowId', 'subtareas.*']);
                    $respuesta['data'] = $subtarea;
                    return response()->json($respuesta);
                }elseif ($request->index == "save") {
                    $subtarea = new Subtarea();
                    $subtarea->nombre = $request->nombre;
                    $subtarea->descripcion = $request->descripcion;
                    $subtarea->inicio = $request->inicio;
                    $subtarea->id_tarea = $request->id_tarea;
                    $subtarea->area = Auth::user()->area;
                    $subtarea->final = $request->final;
                    $subtarea->id_user = Auth::user()->id;
                    $subtarea->estado = "En curso";
                    $subtarea->save();
                    $nuevo = Subtarea::orderBy('created_at', 'desc')->first();
                    $respuesta['data'][0] = $nuevo;
                    return response()->json($respuesta);
                } elseif ($request->index == "remove") {
                    $subtarea = Subtarea::where('id', $request->id)->delete();
                    $data = Subtarea::all();
                    return response()->json($data);
                } elseif ($request->index == "update") {
                    $subtarea = Subtarea::where('id', $request->id)->get()->last();
                    $subtarea->id = $request->id;
                    $subtarea->nombre = $request->nombre;
                    $subtarea->descripcion = $request->descripcion;
                    $subtarea->inicio = $request->inicio;
                    $subtarea->final = $request->final;
                    if($request->has('estado')){
                        if ($subtarea->estado != '') {
                            if($request->estado == 'Atrasado' || $request->estado == 'Entrega hoy' || $request->estado == 'En curso') {
                            $subtarea->estado = 'En curso';
                            }else if($request->estado == 'Finalizado'){
                            $subtarea->estado = 'Finalizado';
                            }
                        }
                    }else{
                        $subtarea->estado = 'En curso';
                    }
                    $subtarea->update();
                    $respuesta['data'][0] = $subtarea;
                    return response()->json($respuesta);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $err, 'code' => $e], 404);
        }
    }

    public function mycrud(Request $request)
    {
        $respuesta = [];
        $err = "Hubo un problema. Consulte un administrador.";
        try {
            if ($request->has('index')) {
                if ($request->index == "load") {
                    $subtarea = Subtarea::where('area', Auth::user()->area)->get(['id AS DT_RowId', 'subtareas.*']);
                    foreach ($subtarea as $tar) {
                        if($tar->tarea){
                            if($tar->tarea->id_proyecto){
                                if($tar->tarea->proyecto){
                                    $tar->id_user = $tar->tarea->proyecto->nombre;
                                }
                            }else{
                                $tar->id_user = $tar->tarea->nombre;
                            }
                        }else{
                            $tar->id_user = 'Sin proyecto raíz';
                        }
                        if($tar->estado == 'En curso'){
                            $status = Carbon::now()->diffInDays(Carbon::parse($tar->final), false);
                            if($status > 0) {$tar->estado = 'En curso';
                            }else if($status < 0) {$tar->estado = 'Atrasado';
                            }else if ($status == 0) {$tar->estado = 'Entrega hoy';}
                        }
                    }
                    $respuesta['data'] = $subtarea;
                    return response()->json($respuesta);
                } elseif ($request->index == "get") {
                    $subtarea = Subtarea::where('id_tarea', $request->id_tarea)->get(['id AS DT_RowId', 'subtareas.*']);
                    $respuesta['data'] = $subtarea;
                    return response()->json($respuesta);
                }elseif ($request->index == "save") {
                    $subtarea = new Subtarea();
                    $subtarea->nombre = $request->nombre;
                    $subtarea->descripcion = $request->descripcion;
                    $subtarea->inicio = $request->inicio;
                    $subtarea->id_tarea = $request->id_tarea;
                    $subtarea->area = Auth::user()->area;
                    $subtarea->final = $request->final;
                    $subtarea->id_user = Auth::user()->id;
                    $subtarea->estado = "En curso";
                    $subtarea->save();
                    $nuevo = Subtarea::orderBy('created_at', 'desc')->first();
                    $respuesta['data'][0] = $nuevo;
                    return response()->json($respuesta);
                } elseif ($request->index == "remove") {
                    $subtarea = Subtarea::where('id', $request->id)->delete();
                    $data = Subtarea::where('area', Auth::user()->area)->get(['id AS DT_RowId', 'subtareas.*']);
                    return response()->json($data);
                } elseif ($request->index == "update") {
                    $subtarea = Subtarea::where('id', $request->id)->get()->last();
                    $subtarea->id = $request->id;
                    $subtarea->nombre = $request->nombre;
                    $subtarea->descripcion = $request->descripcion;
                    $subtarea->inicio = $request->inicio;
                    $subtarea->final = $request->final;
                    if($request->has('estado')){
                        if ($subtarea->estado != '') {
                            if($request->estado == 'Atrasado' || $request->estado == 'Entrega hoy' || $request->estado == 'En curso') {
                            $subtarea->estado = 'En curso';
                            }else if($request->estado == 'Finalizado'){
                            $subtarea->estado = 'Finalizado';
                            }
                        }
                    }else{
                        $subtarea->estado = 'En curso';
                    }
                    $subtarea->update();
                    $respuesta['data'][0] = $subtarea;
                    return response()->json($respuesta);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $err, 'code' => $e], 404);
        }
    }
    
    public function index(){
       $bg = $this->bg;
       $subtareas = Subtarea::where('id_user', Auth::user()->id)->get();
       return view('subtareas.index',compact('bg','subtareas'));     
    }

    public function create(Tarea $tarea){
       $bg = $this->bg;
       return view('subtareas.create',compact('bg','tarea'));     
    }

    public function create2(Subtarea $subtarea)
    {
        $bg = $this->bg;
        $areas = [];
        $sedes = Sede::get()->where('iactivo',1);
        $direcciones = Direccion::get()->where('iactivo',1); 
        $subdirecciones = Subdireccion::get()->where('iactivo',1); 
        $departamentos = Departamento::get()->where('iactivo',1); 
        foreach ($sedes as $key => $sede) {
            $areas +=  [$sede->id => $sede->nombre];
        }
        foreach ($direcciones as $key => $direccion) {
            $areas +=  [$direccion->id => $direccion->nombre];
        }
        foreach ($subdirecciones as $key => $subdireccion) {
            $areas +=  [$subdireccion->id => $subdireccion->nombre];
        }
        foreach ($departamentos as $key => $departamento) {
            $areas +=  [$departamento->id => $departamento->nombre];
        }
        $areas2= explode(",", $subtarea->responsables);
        return view('subtareas.responsable', compact('bg','subtarea','areas','areas2'));
    }

    public function documentos(Subtarea $subtarea){
        $bg = $this->bg;
        $cat_doc = cat_docs::where('iactivo',1)->pluck('nombre', 'id'); 
        $documentos = Documento::where('id_user', Auth::user()->id)->where('id_subtarea', $subtarea->id)->orderBy('created_at', 'DESC')->get();
        foreach ($documentos as $documento) {
            $xx = strtolower($documento->extension);
            if($xx=='xls' || $xx=='csv' || $xx=='xlsx'){
                $documento->tipo = 'fa-file-excel-o text-success';
            }elseif($xx=='pdf') {
                $documento->tipo = 'fa-file-pdf-o text-danger';
            }elseif($xx=='doc' || $xx=='docx') {
                $documento->tipo = 'fa-file-word-o text-info';
            }elseif($xx=='ppt' || $xx=='pptx') {
                $documento->tipo = 'fa-file-powerpoint-o text-secondary';
            }elseif($xx=='zip' || $xx=='rar' || $xx=='bin') {
                $documento->tipo = 'fa-file-zip-o text-primary';
            }elseif($xx=='txt') {
                $documento->tipo = 'fa-file-text-o text-warning';
            }elseif($xx=='png' || $xx == 'jpg' || $xx == 'jpeg' || $xx == 'gif' || $xx == 'raw' || $xx == 'svg' || $xx == 'psd') {
                $documento->tipo = 'fa-file-image-o text-dribbble';
            }elseif($xx=='js' || $xx == 'php' || $xx == 'html' || $xx == 'css' || $xx == 'java' || $xx == 'sql') {
                $documento->tipo = 'fa-file-code-o text-instagram';
            }elseif($xx=='mp3' || $xx == 'mp4' || $xx == 'mov' || $xx == 'avi' || $xx == 'wav') {
                $documento->tipo = 'fa-file-audio-o text-light';
            }else{
                $documento->tipo = 'fa-file-o text-dark';
            }
        }
        return view('subtareas.documentos',compact('bg','documentos','subtarea','cat_doc'));     
     }

     public function store(Request $request, Subtarea $subtarea){
        try{
        $archi=new Documento();
        $archi->nombre=$request->nombre;
        $nombreout = str_replace(' ', '-', $request->nombre);
        $archi->descripcion=$request->descripcion;
        $archi->url='/SGPI/documents/subtareas';
        $archi->url_edit='documents/subtareas';
        $archi->id_user=Auth::user()->id;
        $usuario = User::where('id', Auth::user()->id)->get()->last();
        $archi->id_area=$usuario->area;
        $archi->cat_doc=$request->tipo;
        $mytime = Carbon::now()->format('d-m-Y_H-i');
        $extension = $request->archivo->getClientOriginalExtension();
        $nombre = Auth::user()->id.'_'.$nombreout.'_'.$mytime.'.'.$extension;
        $archi->nombre_doc=$nombre;
        $archi->tipo='Subtarea';
        $archi->extension=$extension;
        $archi->id_tarea=$subtarea->id;
        $archi->save();
        $request->archivo->move('documents/subtareas', $nombre);

            return back()->with('ok', 'ok');
        }catch(\Exception $e){
            return back()->with('nook', $e->getMessage());
        }
    }

    public function store2(Request $request, Subtarea $subtarea){
        try{
            $rec='';
            $iter = count($request->responsables);
            $i=0;
            for($i=0;$i<$iter;$i++){
                $rec=$rec.$request->responsables[$i].',';
            }
            $responsables = rtrim($rec, ", ");
            $subtarea->responsables = $responsables;
            $subtarea->update();

            return back()->with('ok', 'ok');
        }catch(\Exception $e){
            return back()->with('nook', $e->getMessage());
        }
    }

    /*public function save(Request $request){
      $respuesta = [];
      if($request->has('index')){
        $tar = Subtarea::where('id_user', Auth::user()->id)->where('id_tarea', $request->id_tarea)->get(['id AS DT_RowId', 'subtareas.*']);
          $respuesta['data'] = $tar;
          return response()->json($respuesta);
      }else{
          $tar = new Subtarea();
          $tar->nombre = $request->nombre;
          $tar->descripcion = $request->descripcion;
          $tar->inicio = $request->inicio;
          $tar->final = $request->final;
          $tar->responsable = Auth::user()->id;
          $tar->id_tarea = $request->id_tarea;
          $tar->id_user = Auth::user()->id;
          $tar->estado = "En curso";
          $tar->save();
          $nuevo = Subtarea::orderBy('created_at', 'desc')->where('id_user', Auth::user()->id)->where('id_tarea', $request->id_tarea)->first();
          $respuesta['data'][0] = $nuevo;
          return response()->json($respuesta);
         }
      
     }

     public function remove(Request $request){
         $tar=Subtarea::where('id',$request->id)->delete();
         $data = Subtarea::all();
         return response()->json($data);
     }

     public function update(Request $request){
         $respuesta = [];
         $tar = Subtarea::where('id', $request->id)->get()->last();
         $tar->id = $request->id;
         $tar->nombre = $request->nombre;
         $tar->descripcion = $request->descripcion;
         $tar->inicio = $request->inicio;
         $tar->final = $request->final;
         $tar->update();
         $respuesta['data'][0] = $tar;
         return response()->json($respuesta);
     }*/
}
