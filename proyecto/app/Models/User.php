<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name','email','password',];

    protected $hidden = ['password','remember_token',];

    // protected $casts = ['email_verified_at' => 'datetime',];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];

    public function getnombrecompletoAttribute()
    {
       return ucfirst($this->nombre) . ' ' . ucfirst($this->apepa) . ' ' . ucfirst($this->apema);
    }
    public function cat_accesos()
    {
        return $this->belongsTo(cat_accesos::class,'iactivo','iactivo');
    }
    public function administrador(){
        return $this->hasMany(Admin::class);
    }
    public function admin(){
        return $this->belongsTo(Admin::class,'id','id_user');
    }
    public function usuario_pro(){
        return $this->hasMany(Proyecto::class);
    }
    public function usuario_tar(){
        return $this->hasMany(Tarea::class);
    }
    public function usuario_sub(){
        return $this->hasMany(Subtarea::class);
    }

}
