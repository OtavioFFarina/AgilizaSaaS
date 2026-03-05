<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use SoftDeletes;

    // A nossa trava de segurança liberada
    protected $guarded = [];

    // Ensinando o Produto a achar a Categoria (Você já tinha feito esse)
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    // A MÁGICA QUE FALTOU: Ensinando o Produto a achar o Fornecedor! 👇
    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class);
    }
}