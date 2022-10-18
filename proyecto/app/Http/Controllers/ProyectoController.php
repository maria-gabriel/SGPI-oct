<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Custom;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Proyecto;
use App\Models\User;
use App\Models\Admin;
use App\Models\Tarea;
use App\Models\Subtarea;
use App\Models\cat_docs;
use App\Models\Documento;
use App\Models\Sede;
use App\Models\Direccion;
use App\Models\Subdireccion;
use App\Models\Departamento;

class ProyectoController extends Controller
{

    protected $bg;
    public function __construct()
    {
        $this->bg = Custom::where('id_user', 1)->get()->last();
    }
    public function crud(Request $request)
    {
        $respuesta = [];
        $err = "Hubo un problema. Consulte al administrador.";
        try {
            if ($request->has('index')) {
                if ($request->index == "load") {
                    $proyecto = Proyecto::get(['id AS DT_RowId', 'proyectos.*']);
                    $areas = [];
                    $sedes = Sede::get()->where('iactivo',1);
                    $direcciones = Direccion::get()->where('iactivo',1); 
                    $subdirecciones = Subdireccion::get()->where('iactivo',1); 
                    $departamentos = Departamento::get()->where('iactivo',1); 
                    foreach ($sedes as $key => $sede) {
                        $areas +=  [$sede->id => $sede->ide];
                    }
                    foreach ($direcciones as $key => $direccion) {
                        $areas +=  [$direccion->id => $direccion->ide];
                    }
                    foreach ($subdirecciones as $key => $subdireccion) {
                        $areas +=  [$subdireccion->id => $subdireccion->ide];
                    }
                    foreach ($departamentos as $key => $departamento) {
                        $areas +=  [$departamento->id => $departamento->ide];
                    }
                    foreach ($proyecto as $pro) {
                        $pro->area = $pro->subdirecciones->nombre;
                        if($pro->estado == 'En curso'){
                            $status = Carbon::now()->diffInDays(Carbon::parse($pro->final), false);
                            if($status > 0) {$pro->estado = 'En curso';
                            }else if($status < 0) {$pro->estado = 'Atrasado';
                            }else if ($status == 0) {$pro->estado = 'Entrega hoy';}
                        }
                        
                        $respon = '';
                        $res = explode(",", $pro->responsables);
                        for ($y=0; $y<count($res);  $y++) {
                            foreach ($areas as $keya => $are) {
                                if($keya == $res[$y]){
                                    $respon = $respon.$are.',';
                                }
                            }
                        }
                        $responsables = rtrim($respon, ", ");
                        $pro->responsables = $responsables;
                    }
                    $respuesta['data'] = $proyecto;
                    return response()->json($respuesta);
                } elseif ($request->index == "save") {
                    $proyecto = new Proyecto();
                    $proyecto->nombre = $request->nombre;
                    $proyecto->descripcion = $request->descripcion;
                    $proyecto->inicio = $request->inicio;
                    $proyecto->final = $request->final;
                    $proyecto->id_user = Auth::user()->id;
                    $proyecto->area = Auth::user()->area;
                    $proyecto->responsables = Auth::user()->area;
                    $proyecto->estado = "En curso";
                    $proyecto->save();
                    $nuevo = Proyecto::orderBy('created_at', 'desc')->first();
                    $respuesta['data'][0] = $nuevo;
                    return response()->json($respuesta);
                } elseif ($request->index == "remove") {
                    $proyecto = Proyecto::where('id', $request->id)->delete();
                    $data = Proyecto::all();
                    return response()->json($data);
                } elseif ($request->index == "update") {
                    $proyecto = Proyecto::where('id', $request->id)->get()->last();
                    $proyecto->id = $request->id;
                    $proyecto->nombre = $request->nombre;
                    $proyecto->descripcion = $request->descripcion;
                    $proyecto->inicio = $request->inicio;
                    $proyecto->final = $request->final;
                    if ($proyecto->estado != '') {
                        if($request->estado == 'Atrasado' || $request->estado == 'Entrega hoy' || $request->estado == 'En curso') {
                        $proyecto->estado = 'En curso';
                        }else if($request->estado == 'Finalizado'){
                        $proyecto->estado = 'Finalizado';
                        $tareas = Tarea::where('id_proyecto', $proyecto->id)->get();
                        foreach ($tareas as $tarea) {
                            $subtareas = Subtarea::where('id_tarea', $tarea->id)->get();
                            foreach ($subtareas as $sub) {
                                $sub->estado = 'Finalizado';
                                $sub->update();
                            }
                            $tarea->estado = 'Finalizado';
                            $tarea->update();
                        }
                        }
                    }
                    $proyecto->update();
                    $respuesta['data'][0] = $proyecto;
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
        $err = "Hubo un problema. Consulte al administrador.";
        try {
            if ($request->has('index')) {
                if ($request->index == "load") {
                    $proyecto = Proyecto::where('area', Auth::user()->area)->get(['id AS DT_RowId', 'proyectos.*']);
                    foreach ($proyecto as $pro) {
                        $pro->area = $pro->subdirecciones->nombre;
                        if($pro->estado == 'En curso'){
                            $status = Carbon::now()->diffInDays(Carbon::parse($pro->final), false);
                            if($status > 0) {$pro->estado = 'En curso';
                            }else if($status < 0) {$pro->estado = 'Atrasado';
                            }else if ($status == 0) {$pro->estado = 'Entrega hoy';}
                        }
                    }
                    $respuesta['data'] = $proyecto;
                    return response()->json($respuesta);
                } elseif ($request->index == "save") {
                    $proyecto = new Proyecto();
                    $proyecto->nombre = $request->nombre;
                    $proyecto->descripcion = $request->descripcion;
                    $proyecto->inicio = $request->inicio;
                    $proyecto->final = $request->final;
                    $proyecto->id_user = Auth::user()->id;
                    $proyecto->area = Auth::user()->area;
                    $proyecto->responsables = Auth::user()->area;
                    $proyecto->estado = "En curso";
                    $proyecto->save();
                    $nuevo = Proyecto::orderBy('created_at', 'desc')->first();
                    $respuesta['data'][0] = $nuevo;
                    return response()->json($respuesta);
                } elseif ($request->index == "remove") {
                    $proyecto = Proyecto::where('id', $request->id)->delete();
                    $data = Proyecto::where('area', Auth::user()->area)->get(['id AS DT_RowId', 'proyectos.*']);
                    foreach ($data as $dat) {
                        $dat->area = $dat->subdirecciones->nombre;
                        if($dat->estado == 'En curso'){
                            $status = Carbon::now()->diffInDays(Carbon::parse($dat->final), false);
                            if($status > 0) {$dat->estado = 'En curso';
                            }else if($status < 0) {$dat->estado = 'Atrasado';
                            }else if ($status == 0) {$dat->estado = 'Entrega hoy';}
                        }
                    }
                    return response()->json($data);
                } elseif ($request->index == "update") {
                    $proyecto = Proyecto::where('id', $request->id)->get()->last();
                    $proyecto->id = $request->id;
                    $proyecto->nombre = $request->nombre;
                    $proyecto->descripcion = $request->descripcion;
                    $proyecto->inicio = $request->inicio;
                    $proyecto->final = $request->final;
                    if ($proyecto->estado != '') {
                        if($request->estado == 'Atrasado' || $request->estado == 'Entrega hoy' || $request->estado == 'En curso') {
                        $proyecto->estado = 'En curso';
                        }else if($request->estado == 'Finalizado'){
                        $proyecto->estado = 'Finalizado';
                        $tareas = Tarea::where('id_proyecto', $proyecto->id)->get();
                        foreach ($tareas as $tarea) {
                            $subtareas = Subtarea::where('id_tarea', $tarea->id)->get();
                            foreach ($subtareas as $sub) {
                                $sub->estado = 'Finalizado';
                                $sub->update();
                            }
                            $tarea->estado = 'Finalizado';
                            $tarea->update();
                        }
                        }
                    }
                    $proyecto->update();
                    $respuesta['data'][0] = $proyecto;
                    return response()->json($respuesta);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $err, 'code' => $e], 404);
        }
    }

    public function home()
    {  
        $bg = $this->bg;
        $type = Admin::where('id_user', Auth::user()->id)->get()->last();
        $proyectos = Proyecto::all();
       return view('proyectos.home',compact('type', 'bg','proyectos'));
    }

    public function index()
    {
        $bg = $this->bg;
        $areas = [];
        $proyectos = Proyecto::all();
        $sedes = Sede::get()->where('iactivo',1);
        $direcciones = Direccion::get()->where('iactivo',1); 
        $subdirecciones = Subdireccion::get()->where('iactivo',1); 
        $departamentos = Departamento::get()->where('iactivo',1); 
        foreach ($sedes as $key => $sede) {
            $areas +=  [$sede->id => $sede->ide];
        }
        foreach ($direcciones as $key => $direccion) {
            $areas +=  [$direccion->id => $direccion->ide];
        }
        foreach ($subdirecciones as $key => $subdireccion) {
            $areas +=  [$subdireccion->id => $subdireccion->ide];
        }
        foreach ($departamentos as $key => $departamento) {
            $areas +=  [$departamento->id => $departamento->ide];
        }
        foreach ($proyectos as $proyecto) {
            $respon = '';
            $res = explode(",", $proyecto->responsables);
            for ($y=0; $y<count($res);  $y++) {
                foreach ($areas as $keya => $are) {
                    if($keya == $res[$y]){
                        $respon = $respon.$are.',';
                    }
                }
            }
            $responsables = rtrim($respon, ", ");
            $proyecto->responsables = $responsables;
            if($proyecto->area < 300){
                if($proyecto->area>=200){
                    $area = Departamento::where('id', Auth::user()->area)->first();
                   }else if($proyecto->area>= 100 && $proyecto->area<200){
                    $area = Subdireccion::where('id', Auth::user()->area)->first(); 
                   }else if($proyecto->area< 100){
                    $area = Direccion::where('id', Auth::user()->area)->first(); 
                   }
               }else{
                    $area = Sede::where('id', Auth::user()->area)->first(); 
               }
            isset($area) ? $proyecto->area = $area->nombre : $proyecto->area = "NA";
        }
        return view('proyectos.index', compact('bg', 'proyectos'));
    }

    public function graphic(Proyecto $proyecto)
    {
        $bg = $this->bg;
        $tareas_id = [];
        $tar = [];
        $subtar = [];
        $sub = [];
        $all = [];
        $tareas = Tarea::where('id_proyecto', $proyecto->id)->orderBy('created_at', 'ASC')->get();
        foreach ($tareas as $key => $tarea) {
            $tareas_id[$key] = $tarea->id;
        }
        $subtareas = Subtarea::WhereIn('id_tarea', $tareas_id)->get();
        foreach ($tareas as $key => $tarea) {
            foreach ($subtareas as $key => $subtarea) {
                if ($subtarea->id_tarea == $tarea->id) {
                    $subtar[] = [
                        'id' => $subtarea->id,
                        'client' => $subtarea->nombre,
                        'descrip' => $subtarea->descripcion,
                        'name' => $subtarea->tareas->nombre,
                        'fromDate' => $subtarea->inicio,
                        'toDate' => $subtarea->final,
                        'tipo' => 'Subtarea',
                        'color' => 'color',
                    ];
                    $sub[] = [
                        'id' => $subtarea->id,
                        'client' => $subtarea->nombre,
                        'descrip' => $subtarea->descripcion,
                        'name' => $subtarea->nombre,
                        'fromDate' => $subtarea->inicio,
                        'toDate' => $subtarea->final,
                        'tipo' => 'Subtarea',
                        'color' => 'color',
                    ];
                }
            }
            $tar[] = [
                'id' => $tarea->id,
                'client' => $tarea->nombre,
                'descrip' => $tarea->descripcion,
                'name' => $tarea->nombre,
                'fromDate' => $tarea->inicio,
                'toDate' => $tarea->final,
                'tipo' => 'Tarea',
                'color' => 'color',
            ];
        }
        $all = array_merge($tar, $sub);
        return view('proyectos.graphic', compact('bg', 'tar', 'subtar', 'sub', 'all', 'proyecto'));
    }
    
    public function create2(Proyecto $proyecto)
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
        $areas2= explode(",", $proyecto->responsables);
        return view('proyectos.responsable', compact('bg', 'proyecto','areas','areas2'));
    }

    public function documentos(Proyecto $proyecto)
    {
        $bg = $this->bg;
        $cat_doc = cat_docs::where('iactivo', 1)->pluck('nombre', 'id');
        $documentos = Documento::where('id_user', Auth::user()->id)->where('id_proyecto', $proyecto->id)->orderBy('created_at', 'DESC')->get();
        foreach ($documentos as $documento) {
            $xx = strtolower($documento->extension);
            if ($xx == 'xls' || $xx == 'csv' || $xx == 'xlsx') {
                $documento->tipo = 'fa-file-excel-o text-success';
            } elseif ($xx == 'pdf') {
                $documento->tipo = 'fa-file-pdf-o text-danger';
            } elseif ($xx == 'doc' || $xx == 'docx') {
                $documento->tipo = 'fa-file-word-o text-info';
            } elseif ($xx == 'ppt' || $xx == 'pptx') {
                $documento->tipo = 'fa-file-powerpoint-o text-secondary';
            } elseif ($xx == 'zip' || $xx == 'rar' || $xx == 'bin') {
                $documento->tipo = 'fa-file-zip-o text-primary';
            } elseif ($xx == 'txt') {
                $documento->tipo = 'fa-file-text-o text-warning';
            } elseif ($xx == 'png' || $xx == 'jpg' || $xx == 'jpeg' || $xx == 'gif' || $xx == 'raw' || $xx == 'svg' || $xx == 'psd') {
                $documento->tipo = 'fa-file-image-o text-dribbble';
            } elseif ($xx == 'js' || $xx == 'php' || $xx == 'html' || $xx == 'css' || $xx == 'java' || $xx == 'sql') {
                $documento->tipo = 'fa-file-code-o text-instagram';
            } elseif ($xx == 'mp3' || $xx == 'mp4' || $xx == 'mov' || $xx == 'avi' || $xx == 'wav') {
                $documento->tipo = 'fa-file-audio-o text-light';
            } else {
                $documento->tipo = 'fa-file-o text-dark';
            }
        }
        return view('proyectos.documentos', compact('bg', 'documentos', 'proyecto', 'cat_doc'));
    }

    public function store(Request $request, Proyecto $proyecto)
    {
        try {
            $archi = new Documento();
            $archi->nombre = $request->nombre;
            $nombreout = str_replace(' ', '-', $request->nombre);
            $archi->descripcion = $request->descripcion;
            $archi->url = '/SGPI/documents/proyectos';
            $archi->url_edit = 'documents/proyectos';
            $archi->id_user = Auth::user()->id;
            $usuario = User::where('id', Auth::user()->id)->get()->last();
            $archi->id_area = $usuario->area;
            $archi->cat_doc = $request->tipo;
            $mytime = Carbon::now()->format('d-m-Y_H-i');
            $extension = $request->archivo->getClientOriginalExtension();
            $nombre = Auth::user()->id . '_' . $nombreout . '_' . $mytime . '.' . $extension;
            $archi->nombre_doc = $nombre;
            $archi->tipo = 'Proyecto';
            $archi->extension = $extension;
            $archi->id_proyecto = $proyecto->id;
            $archi->save();
            $request->archivo->move('documents/proyectos', $nombre);

            return back()->with('ok', 'ok');
        } catch (\Exception $e) {
            return back()->with('nook', $e->getMessage());
        }
    }

    public function details(Request $request)
    {
        if ($request->apd == 'proyecto') {
            $proyecto = Proyecto::where('id', $request->ide)->get()->last();
            if ($proyecto == 'undefined' || $proyecto == null) {
                $proyecto = new Proyecto();
                $proyecto->nombre = 'Tarea independiente';
                $proyecto->descripcion = 'Sin proyecto raíz';
            } else {
                $proyecto->descripcion = 'Proyecto raíz';
            }
            return response()->json($proyecto);
        } elseif ($request->apd == 'tarea') {
            $tarea = Tarea::where('id', $request->ide)->get()->last();
            $proyecto = Proyecto::where('id', $tarea->id_proyecto)->get()->last();
            if ($proyecto == 'undefined' || $proyecto == null) {
                $proyecto = new Proyecto();
                $proyecto->nombre = 'Sin proyecto raíz';
                $proyecto->descripcion = 'Tarea raíz';
                $proyecto->estado = $tarea->nombre;
            } else {
                $proyecto->descripcion = 'Proyecto raíz';
                $proyecto->estado = $tarea->nombre;
            }
            return response()->json($proyecto);
        }
    }

    public function store2(Request $request, Proyecto $proyecto){
        try{
            $rec='';
            $iter = count($request->responsables);
            $i=0;
            for($i=0;$i<$iter;$i++){
                $rec=$rec.$request->responsables[$i].',';
            }
            $responsables = rtrim($rec, ", ");
            $proyecto->responsables = $responsables;
            $proyecto->update();

            return back()->with('ok', 'ok');
        }catch(\Exception $e){
            return back()->with('nook', $e->getMessage());
        }
    }
}
