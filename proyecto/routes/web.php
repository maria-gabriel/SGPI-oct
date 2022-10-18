<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatAccesosController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\contraresController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\DireccionController;
use App\Http\Controllers\SubdireccionController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\SubtareaController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\CatDocsController;
use App\Http\Controllers\CatPerfilesController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\SedeController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\ConferenciaController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/contrares', [contraresController::class,'index'])->name('contrares');
Route::post('contrares', [contraresController::class,'actua'])->name('actua');

Auth::routes();
Route::group(['namespace'=>'admin', 'middleware' => 'val_acceso'],function(){

    Route::post('details/subdireccion', [SubdireccionController::class,'details'])->name('subdirecciones.details');
    Route::post('details/departamento', [DepartamentoController::class,'details'])->name('departamentos.details');
    Route::post('details/proyecto', [ProyectoController::class,'details'])->name('proyectos.details');

    Route::get('tareas',[TareaController::class,'index'])->name('tareas.index');
    Route::get('tareas/create/{proyecto}',[TareaController::class,'create'])->name('tareas.create');
    Route::get('tareas/home/{proyecto}',[TareaController::class,'home'])->name('tareas.home');
    Route::post('crud/tarea', [TareaController::class,'crud'])->name('tareas.crud');
    Route::post('mycrud/tarea', [TareaController::class,'mycrud'])->name('tareas.mycrud');
    Route::get('tareas/documentos/{tarea}', [TareaController::class,'documentos'])->name('tareas.documentos');
    Route::post('tareas/save/{tarea}', [TareaController::class,'store'])->name('tareas.store');
    Route::get('tareas/create/responsable/{tarea}',[TareaController::class,'create2'])->name('tareas.responsable');
    Route::post('tareas/save/responsable/{tarea}', [TareaController::class,'store2'])->name('tareas.store2');

    Route::get('subtareas',[SubtareaController::class,'index'])->name('subtareas.index');
    Route::get('subtareas/create/{tarea}',[SubtareaController::class,'create'])->name('subtareas.create');
    Route::post('crud/subtarea', [SubtareaController::class,'crud'])->name('subtareas.crud');
    Route::post('mycrud/subtarea', [SubtareaController::class,'mycrud'])->name('subtareas.mycrud');
    Route::get('subtareas/documentos/{subtarea}', [SubtareaController::class,'documentos'])->name('subtareas.documentos');
    Route::post('subtareas/save/{subtarea}', [SubtareaController::class,'store'])->name('subtareas.store');
    Route::get('subtareas/create/responsable/{subtarea}',[SubtareaController::class,'create2'])->name('subtareas.responsable');
    Route::post('subtareas/save/responsable/{subtarea}', [SubtareaController::class,'store2'])->name('subtareas.store2');

    Route::get('proyectos/proyecto',[ProyectoController::class,'index'])->name('proyectos.index');
    Route::post('crud/proyecto', [ProyectoController::class,'crud'])->name('proyectos.crud');
    Route::post('mycrud/proyecto', [ProyectoController::class,'mycrud'])->name('proyectos.mycrud');
    Route::get('proyectos/grafica/{proyecto}', [ProyectoController::class,'graphic'])->name('proyectos.grafica');
    Route::get('proyectos/documentos/{proyecto}', [ProyectoController::class,'documentos'])->name('proyectos.documentos');
    Route::post('proyectos/save/{proyecto}', [ProyectoController::class,'store'])->name('proyectos.store');
    Route::get('proyectos/create/responsable/{proyecto}',[ProyectoController::class,'create2'])->name('proyectos.responsable');
    Route::post('proyectos/save/responsable/{proyecto}', [ProyectoController::class,'store2'])->name('proyectos.store2');
    Route::get('proyectos/home', [ProyectoController::class, 'home'])->name('proyectos.home');

    Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('faqs', [App\Http\Controllers\HomeController::class, 'faqs'])->name('faqs');

    Route::get('home/orden', [OrdenController::class, 'home'])->name('ordenes.home');
    Route::get('ordenes',[OrdenController::class,'index'])->name('ordenes.index');
    Route::post('crud/ordenes', [OrdenController::class,'crud'])->name('ordenes.crud');

    Route::get('calendario',[ConferenciaController::class,'calendario'])->name('conferencias.calendario');

    Route::get('notas',[NotaController::class,'index'])->name('notas.index');
    Route::post('crud/notas', [NotaController::class,'crud'])->name('notas.crud');

    Route::get('perfiles',[CatPerfilesController::class,'index'])->name('perfiles.index');
    Route::post('crud/perfiles', [CatPerfilesController::class,'crud'])->name('perfiles.crud');

    Route::get('accesos',[CatAccesosController::class,'index'])->name('accesos.index');
    Route::post('crud/accesos', [CatAccesosController::class,'crud'])->name('accesos.crud');

    Route::get('documentos',[CatDocsController::class,'index'])->name('documentos.index');
    Route::post('crud/documentos', [CatDocsController::class,'crud'])->name('documentos.crud');

    Route::get('servicios',[ServicioController::class,'index'])->name('servicios.index');
    Route::post('crud/servicios', [ServicioController::class,'crud'])->name('servicios.crud');

    Route::get('equipos',[EquipoController::class,'index'])->name('equipos.index');
    Route::post('crud/equipos', [EquipoController::class,'crud'])->name('equipos.crud');

    Route::get('direcciones',[DireccionController::class,'index'])->name('direcciones.index');
    Route::post('crud/direcciones', [DireccionController::class,'crud'])->name('direcciones.crud');

    Route::get('subdirecciones',[SubdireccionController::class,'index'])->name('subdirecciones.index');
    Route::post('crud/subdirecciones', [SubdireccionController::class,'crud'])->name('subdirecciones.crud');

    Route::get('departamentos',[DepartamentoController::class,'index'])->name('departamentos.index');
    Route::post('crud/departamentos', [DepartamentoController::class,'crud'])->name('departamentos.crud');
    
    Route::get('sedes',[SedeController::class,'index'])->name('sedes.index');
    Route::post('crud/sedes', [SedeController::class,'crud'])->name('sedes.crud');

    Route::get('archivos',[DocumentoController::class,'index'])->name('archivos.index');
    Route::get('archivos/create',[DocumentoController::class,'create'])->name('archivos.create');
    Route::get('archivos/update/{documento}',[DocumentoController::class,'create'])->name('archivos.update');
    Route::post('archivos/save/{documento?}', [DocumentoController::class,'store'])->name('archivos.store');
    Route::get('archivos/destroy/{documento}', [DocumentoController::class,'destroy'])->name('archivos.destroy');

    Route::get('admins',[AdminController::class,'index'])->name('admins.index');
    Route::post('crud/admins', [AdminController::class,'crud'])->name('admins.crud');
    Route::get('admins/asignar/{admin}', [AdminController::class,'asignar'])->name('admins.asignar');

    Route::get('usuarios',[UserController::class,'index'])->name('usuarios.index');
    Route::post('crud/usuarios', [UserController::class,'crud'])->name('usuarios.crud');
    Route::get('usuarios/perfil',[UserController::class,'perfil'])->name('usuarios.perfil');
    Route::post('usuarios/custom', [UserController::class,'custom'])->name('usuarios.custom');
    Route::get('usuarios/area/usuario', [UserController::class,'area'])->name('usuarios.area');
    Route::post('usuarios/update/{usuario}', [UserController::class,'update'])->name('usuarios.update');
    Route::post('usuarios/update2/{usuario}', [UserController::class,'update_area'])->name('usuarios.update2');

    Route::get('proyectos/pdf/{proyecto}', [PDFController::class,'proyectoPDF'])->name('proyectos.pdf');

});