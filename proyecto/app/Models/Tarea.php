<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;
    protected $table = 'tareas';

    public function tarea()
    {
        return $this->hasMany(Subtarea::class);
    }
    public function usuarios()
    {
        return $this->belongsTo(User::class,'responsable','id');
    }
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class,'id_proyecto','id');
    }
    public function subtarea()
    {
        return $this->hasMany(Subtarea::class);
    }
}
