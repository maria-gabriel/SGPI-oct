<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtarea extends Model
{
    use HasFactory;
    protected $table = 'subtareas';

    public function tareas()
    {
        return $this->belongsTo(Tarea::class,'id_tarea','id');
    }
    public function usuarios()
    {
        return $this->belongsTo(User::class,'responsable','id');
    }
    public function tarea()
    {
        return $this->belongsTo(Tarea::class,'id_tarea','id');
    }
}
