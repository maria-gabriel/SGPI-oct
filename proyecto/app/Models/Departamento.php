<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;
    protected $table = 'departamentos';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];
    
    public function subdirecciones()
    {
        return $this->belongsTo(Subdireccion::class,'id_sub','id');
    }
    public function proyecto()
    {
        return $this->hasMany(Proyecto::class);
    }
}
