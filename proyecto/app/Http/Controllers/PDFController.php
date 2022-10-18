<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use App\Models\Proyecto;
use App\Models\Area;
use App\Models\User;
use App\Models\Admin;
use App\Models\Tarea;
use App\Models\Equipo;
use App\Models\Seguimiento;
use App\Models\Custom;

class PDFController extends Controller
{
    //
    public function proyectoPDF(Proyecto $proyecto)
    {

        $data = [
            'folio' => 'proyectoPDF',
            'dato' => $proyecto        ];
          
        $pdf = PDF::loadView('pdf', compact('data'));
    
        return $pdf->stream('proyecto.pdf');
    }
}
