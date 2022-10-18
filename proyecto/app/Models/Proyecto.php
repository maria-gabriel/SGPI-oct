<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    public function usuarios()
    {
        return $this->belongsTo(User::class,'id_user','id');
    }
    public function departamentos()
    {
        return $this->belongsTo(Departamento::class,'area','id');
    }
    public function subdirecciones()
    {
        return $this->belongsTo(Subdireccion::class,'area','id');
    }
    public function tarea()
    {
        return $this->hasMany(Tarea::class);
    }
}
