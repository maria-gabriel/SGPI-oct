<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cat_docs;
use App\Models\Custom;

class CatDocsController extends Controller
{
    protected $bg;
    public function __construct()
    {
        $this->bg = Custom::where('id_user', 1)->get()->last();
    }
    public function index()
    {
        $bg = $this->bg;
        $documentos = cat_docs::orderBy('created_at', 'DESC')->get();
       return view('catalogos/documentos.index',compact('documentos','bg'));   
    }

    public function crud(Request $request)
    {
        $respuesta = [];
        $err = "Hubo un problema. Consulte al administrador.";
        try {
            if ($request->has('index')) {
                if ($request->index == "load") {
                    $documentos = cat_docs::get(['id AS DT_RowId', 'cat_docs.*']);
                    $respuesta['data'] = $documentos;
                    return response()->json($respuesta);
                } elseif ($request->index == "save") {
                    $doc = new cat_docs();
                    $doc->nombre = $request->nombre;
                    $doc->iactivo = $request->iactivo;
                    $doc->save();
                    $nuevo = cat_docs::orderBy('created_at', 'desc')->first();
                    $respuesta['data'][0] = $nuevo;
                    return response()->json($respuesta);
                }elseif ($request->index == "update") {
                    $doc = cat_docs::where('id', $request->id)->get()->last();
                    $doc->id = $request->id;
                    $doc->nombre = $request->nombre;
                    $doc->iactivo = $request->iactivo;
                    $doc->update();
                    $respuesta['data'][0] = $doc;
                    return response()->json($respuesta);
                }elseif ($request->index == "remove") {
                    $doc = cat_docs::where('id', $request->id)->delete();
                    $documentos = cat_docs::get(['id AS DT_RowId', 'cat_docs.*']);
                    $respuesta['data'] = $documentos;
                    return response()->json($respuesta);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $err, 'code' => $e], 404);
        }
    }

}
