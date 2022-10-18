<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cat_docs extends Model
{
    use HasFactory;
    protected $table='cat_docs';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    public function categoria()
    {
        return $this->hasMany(Documento::class);
    }
}
