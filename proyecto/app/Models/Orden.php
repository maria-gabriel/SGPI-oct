<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;
    protected $table = 'ordenes';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i',
        'updated_at' => 'datetime:Y-m-d',
    ];

    public function admin_orden(){
        return $this->belongsTo(Admin::class,'id_admin','id');
    }
    public function servicio_orden(){
        return $this->belongsTo(Servicio::class,'id_servicio','id');
    }
}
