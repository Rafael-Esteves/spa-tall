<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    //Marcas Possuem Produtos
    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }

    protected $fillable = ['nome'];
}
