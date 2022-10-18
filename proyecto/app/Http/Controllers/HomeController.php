<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sede;
use App\Models\Custom;
use App\Models\Admin;
use App\Models\Proyecto;

class HomeController extends Controller
{
    protected $bg;
    public function __construct()
    {
        $this->middleware('auth');
        $this->bg = Custom::where('id_user', 1)->get()->last();
    }
    public function index()
    {  
        $bg = $this->bg;
        $type = Admin::where('id_user', Auth::user()->id)->get()->last();
        $proyectos = Proyecto::all();
       return view('home',compact('type', 'bg','proyectos'));
    }

    public function faqs()
    {  
        $bg = $this->bg;
       return view('layouts/faqs',compact('bg'));
    }
    
}
