<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caixa extends Model
{
    protected $guarded = [];

    // Um caixa pertence a um Usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Um caixa tem várias Vendas
    public function vendas()
    {
        return $this->hasMany(Venda::class);
    }
}