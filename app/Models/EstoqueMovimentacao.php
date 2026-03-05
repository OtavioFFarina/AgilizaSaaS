<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstoqueMovimentacao extends Model
{
    protected $table = 'estoque_movimentacoes';
    protected $guarded = [];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}