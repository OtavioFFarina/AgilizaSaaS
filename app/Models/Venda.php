<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $guarded = [];

    // Uma venda tem vários Itens
    public function itens()
    {
        return $this->hasMany(VendaItem::class);
    }
}