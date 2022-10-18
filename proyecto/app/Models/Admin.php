<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];

    public function usuario(){
        return $this->belongsTo(User::class,'id_user','id');
    }
    public function user(){
        return $this->hasMany(User::class);
    }
    public function admin_orden(){
        return $this->hasMany(Admin::class);
    }
    public function historial(){
        return $this->hasMany(Historial::class);
    }

}

