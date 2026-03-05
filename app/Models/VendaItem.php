<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendaItem extends Model
{
    protected $table = 'venda_itens';
    protected $guarded = [];

    // Um item pertence a um Produto
    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}