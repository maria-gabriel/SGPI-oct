<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admin;
use Auth;

class val_acceso
{

    public function handle(Request $request, Closure $next)
    {

        $ruta=$request->route()->getName();
           if(Auth::user()==null){
            return redirect()->route('login');
            return $next($request); 

           }else{
            if(!empty($request->user()->cat_accesos)){
                $type = Admin::where('id_user', Auth::user()->id)->get()->last();
                if(!$type){
                    $perfil=1;
                }else{
                    $perfil=$type->perfil;
                }
                if(!empty($request->user()->cat_accesos->where('perfiles','like','%'.$perfil.'%')->where('nombre',$request->route()->getName())->get()->toarray())){
                    return $next($request);
                }else
                {
                    return abort(403,"No tienes autorización para ingresar al directorio");  
                }         
            }
            else
            {
               return abort(403,"No tienes autorización para ingresar al directorio");  
            }
        }

    }
}
