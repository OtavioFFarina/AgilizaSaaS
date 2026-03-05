<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstabelecimentoVinculo extends Model
{
    protected $table = 'estabelecimento_vinculos';

    protected $fillable = [
        'estabelecimento_origem_id',
        'estabelecimento_destino_id',
    ];

    public function origem()
    {
        return $this->belongsTo(Estabelecimento::class, 'estabelecimento_origem_id');
    }

    public function destino()
    {
        return $this->belongsTo(Estabelecimento::class, 'estabelecimento_destino_id');
    }
}
