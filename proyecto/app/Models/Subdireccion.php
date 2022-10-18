<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subdireccion extends Model
{
    use HasFactory;
    protected $table = 'subdirecciones';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    public function direcciones()
    {
        return $this->belongsTo(Direccion::class,'id_dir','id');
    }
    public function departamento()
    {
        return $this->hasMany(Departamento::class);
    }
    public function proyecto()
    {
        return $this->hasMany(Proyecto::class);
    }
}
