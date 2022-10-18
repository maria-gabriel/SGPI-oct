<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Nota;
use App\Models\User;

class NotaController extends Controller
{
    //
    public function crud(Request $request)
    {
        $respuesta = [];
        $err = "Hubo un problema. Consulte un administrador.";
        try {
            if ($request->has('index')) {
                if ($request->index == "load") {
                    $nota = Nota::where('id_user', Auth::user()->id)->get();
                    $respuesta['data'] = $nota;
                    return response()->json($respuesta);
                } elseif ($request->index == "save") {
                    $nota = new Nota();
                    $nota->nombre = $request->nombre;
                    $nota->id_user = Auth::user()->id;
                    $nota->estado = "Pendiente";
                    $nota->save();
                    $nuevo = Nota::orderBy('created_at', 'desc')->first();
                    $respuesta['data'][0] = $nuevo;
                    return response()->json($respuesta);
                } elseif ($request->index == "remove") {
                    $nota = Nota::where('id', $request->id)->delete();
                    $data = Nota::all();
                    return response()->json($data);
                } elseif ($request->index == "update") {
                    $nota = Nota::where('id', $request->id)->get()->last();
                    $nota->id = $request->id;
                    $nota->nombre = $request->nombre;
                    $nota->update();
                    $respuesta['data'][0] = $nota;
                    return response()->json($respuesta);
                } elseif ($request->index == "active") {
                    $nota = Nota::where('id', $request->id)->get()->last();
                    $nota->id = $request->id;
                    $nota->estado = "Finalizada";
                    $nota->update();
                    $respuesta['data'][0] = $nota;
                    return response()->json($respuesta);
                } elseif ($request->index == "inactive") {
                    $nota = Nota::where('id', $request->id)->get()->last();
                    $nota->id = $request->id;
                    $nota->estado = "Pendiente";
                    $nota->update();
                    $respuesta['data'][0] = $nota;
                    return response()->json($respuesta);
                } elseif ($request->index == "finalize") {
                    $notas = Nota::where('id_user', Auth::user()->id)->get();
                    foreach ($notas as $nota) {
                        $nota->estado = "Finalizada";
                        $nota->update();
                    }
                    $respuesta['data'][0] = $notas;
                    return response()->json($respuesta);
                } elseif ($request->index == "reset") {
                    $notas = Nota::where('id_user', Auth::user()->id)->where("estado", "Finalizada")->delete();
                    $respuesta['data'][0] = $notas;
                    return response()->json($respuesta);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $err, 'code' => $e], 404);
        }
    }
}
