<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'marca_id', 'preco', 'quantidade'];

    public function fornecedor()
    {
        return $this->belongsToMany(Fornecedor::class);
    }
    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }
}
