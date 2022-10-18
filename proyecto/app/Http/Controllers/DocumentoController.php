<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Documento;
use Carbon\Carbon;
use App\Models\cat_docs;
use App\Models\Custom;

class DocumentoController extends Controller
{
    //
    protected $bg;
    public function __construct()
    {
        $this->bg = Custom::where('id_user', 1)->get()->last();
    }
    public function index()
    {
       $bg = $this->bg;
       $documentos = Documento::where('id_user', Auth::user()->id)->get();
       foreach ($documentos as $documento) {
        if($documento->tipo == "Proyecto"){
            $documento->url = 'proyectos';
        }
        if($documento->tipo == "Tarea"){
            $documento->url = 'tareas';
        }
        if($documento->tipo == "Subtarea"){
            $documento->url = 'subtareas';
        }
        $xx = strtolower($documento->extension);
        if($xx=='xls' || $xx=='csv' || $xx=='xlsx'){
            $documento->url_edit = 'fa-file-excel-o text-success';
        }elseif($xx=='pdf') {
            $documento->url_edit = 'fa-file-pdf-o text-danger';
        }elseif($xx=='doc' || $xx=='docx') {
            $documento->url_edit = 'fa-file-word-o text-info';
        }elseif($xx=='ppt' || $xx=='pptx') {
            $documento->url_edit = 'fa-file-powerpoint-o text-secondary';
        }elseif($xx=='zip' || $xx=='rar' || $xx=='bin') {
            $documento->url_edit = 'fa-file-zip-o text-primary';
        }elseif($xx=='txt') {
            $documento->url_edit = 'fa-file-text-o text-warning';
        }elseif($xx=='png' || $xx == 'jpg' || $xx == 'jpeg' || $xx == 'gif' || $xx == 'raw' || $xx == 'svg' || $xx == 'psd') {
            $documento->url_edit = 'fa-file-image-o text-dribbble';
        }elseif($xx=='js' || $xx == 'php' || $xx == 'html' || $xx == 'css' || $xx == 'java' || $xx == 'sql') {
            $documento->url_edit = 'fa-file-code-o text-instagram';
        }elseif($xx=='mp3' || $xx == 'mp4' || $xx == 'mov' || $xx == 'avi' || $xx == 'wav') {
            $documento->url_edit = 'fa-file-audio-o text-light';
        }else{
            $documento->url_edit = 'fa-file-o text-dark';
        }
    }
       return view('archivos.index',compact('documentos','bg'));   
    }

    public function create(Documento $documento)
    {  
        $bg = $this->bg;
        $cat_doc = cat_docs::where('iactivo',1)->pluck('nombre', 'id'); 
        return view('archivos.create',compact('documento','bg','cat_doc'));
    }

    public function store(Request $request, Documento $documento){
        try{
            $archi = Documento::where('id', $documento->id)->get()->last();
        if($archi){
            $archi->nombre=$request->nombre;
            $archi->descripcion=$request->descripcion;
            if($archi->tipo == "Proyecto"){
                $apartado='proyectos';
            }
            if($archi->tipo == "Tarea"){
                $apartado='tareas';
            }
            if($archi->tipo == "Subtarea"){
                $apartado='subtareas';
            }
            $archi->url='/SGPI/documents/'.$apartado;
            $file_path = 'documents/'.$apartado.'/'.$archi->nombre_doc;
            $archi->url_edit='documents/'.$apartado;
            $archi->cat_doc=$request->tipo;
            $mytime = Carbon::now()->format('d-m-Y_H-i');
            $extension = $request->archivo->getClientOriginalExtension();
            $nombre = Auth::user()->id.'_'.$request->nombre.'_'.$mytime.'.'.$extension;
            $archi->nombre_doc=$nombre;
            $archi->extension=$extension;
            $archi->update();
            $request->archivo->move('documents/'.$apartado, $nombre);
            unlink($file_path);
        }
        
            return back()->with('ok', 'ok');

    }catch(\Exception $e){
            return back()->with('nook', $e->getMessage());
         }
    }

    public function destroy(Documento $documento)
    {
        try {
            if($documento->tipo == "Proyecto"){
                $apartado='proyectos';
            }
            if($documento->tipo == "Tarea"){
                $apartado='tareas';
            }
            if($documento->tipo == "Subtarea"){
                $apartado='subtareas';
            }
            $file_path = 'documents/'.$apartado.'/'.$documento->nombre_doc;
            unlink($file_path);
            $doc = Documento::where('id', $documento->id)->delete();
            return back()->with('ok', 'ok');
        } catch (\Exception $e) {
            return back()->with('nook', $e->getMessage());
        }
    }
    
}
