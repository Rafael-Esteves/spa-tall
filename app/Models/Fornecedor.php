<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;

    //N fornecedores podem fornecer N Produtos
    public function produtos()
    {
        return $this->belongsToMany(Produto::class);
    }

    //filliable
    protected $fillable = [
        'nome', 'cnpj', 'cpf', 'nome_fantasia'
    ];
}
