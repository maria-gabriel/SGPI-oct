<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use View;
use App\Models\Admin;
use App\Models\Custom;
use App\Models\Nota;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        //
    }

    public function boot()
    {
        //
        Carbon::setUTF8(true);
        setlocale(LC_ALL, 'es_MX', 'es', 'ES', 'es_MX.utf8');
        View::composer('layouts.plantilla', function( $view ){
            $fecha = Carbon::parse(Carbon::now());
            $mes = $fecha->formatLocalized('%B');
            $anio = $fecha->format('Y');
            $dia = $fecha->format('d');
            $nombre=date('w', strtotime($fecha));
            switch($nombre)
            {
                case 1: $nombre="Lunes";
                break;
                case 2: $nombre="Martes";
                break;
                case 3: $nombre="Miércoles";
                break;
                case 4: $nombre="Jueves";
                break;
                case 5: $nombre="Viernes";
                break;
                case 6: $nombre="Sabado";
                break;
                case 7: $nombre="Domingo";
                break;
            }
            $today = $nombre.' '.$dia.' de '.$mes.', '.$anio;
                $type = Admin::where('id_user', Auth::user()->id)->get()->last();
                $bg = Custom::where('id_user', 1)->get()->last();
                $notas_pen = Nota::where('id_user', Auth::user()->id)->where("estado","Pendiente")->get();
                $notas_fin = Nota::where('id_user', Auth::user()->id)->where("estado","Finalizada")->get();
                $view->with( 'bg', $bg);
                $view->with( 'today', $today);
                $view->with( 'notas_pen', $notas_pen);
                $view->with( 'notas_fin', $notas_fin);
        });
    }
}
