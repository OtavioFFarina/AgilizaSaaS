<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estabelecimento extends Model
{
    use HasUuids, SoftDeletes;

    protected $guarded = [];

    /**
     * Retorna todos os IDs de estabelecimentos vinculados (incluindo o próprio).
     */
    public function getVinculadosIds(): array
    {
        $vinculosComoOrigem = EstabelecimentoVinculo::where('estabelecimento_origem_id', $this->id)
            ->pluck('estabelecimento_destino_id')
            ->toArray();

        $vinculosComoDestino = EstabelecimentoVinculo::where('estabelecimento_destino_id', $this->id)
            ->pluck('estabelecimento_origem_id')
            ->toArray();

        // Merge all, add self, remove duplicates
        return array_unique(array_merge([$this->id], $vinculosComoOrigem, $vinculosComoDestino));
    }

    /**
     * Retorna apenas os IDs de estabelecimentos vinculados (SEM o próprio).
     */
    public function getOutrosVinculadosIds(): array
    {
        $todos = $this->getVinculadosIds();
        return array_values(array_filter($todos, fn($id) => $id !== $this->id));
    }
}