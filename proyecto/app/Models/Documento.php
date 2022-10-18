<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;
    protected $table = 'documentos';

    public function categorias()
    {
        return $this->belongsTo(cat_docs::class,'cat_doc','id');
    }
    
}
