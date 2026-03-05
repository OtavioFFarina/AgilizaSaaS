<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Fornecedor;
use App\Models\Estabelecimento;
use App\Models\User;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| TAREFA 5: Limpeza Automática da Lixeira (30 dias)
|--------------------------------------------------------------------------
| Este comando roda diariamente e exclui permanentemente todos os
| registros com deleted_at mais antigos que 30 dias.
|
| Para ativar no servidor, adicione ao crontab:
| * * * * * cd /caminho-do-projeto && php artisan schedule:run >> /dev/null 2>&1
|
*/
Artisan::command('lixeira:limpar', function () {
    $limite = now()->subDays(30);
    $totalExcluidos = 0;

    $models = [
        'Produtos' => Produto::class,
        'Categorias' => Categoria::class,
        'Fornecedores' => Fornecedor::class,
        'Estabelecimentos' => Estabelecimento::class,
        'Usuários' => User::class,
    ];

    foreach ($models as $nome => $model) {
        $itensExpirados = $model::onlyTrashed()
            ->where('deleted_at', '<', $limite)
            ->get();

        $count = 0;
        foreach ($itensExpirados as $item) {
            try {
                $item->forceDelete();
                $count++;
                $totalExcluidos++;
            } catch (\Illuminate\Database\QueryException $e) {
                // Item possui vínculo (ex: vendas passadas) e não pode ser excluído.
                // Será mantido na lixeira indefinidamente (soft deleted) para manter o histórico.
            }
        }

        if ($count > 0) {
            $this->info("✅ {$nome}: {$count} registro(s) excluído(s) permanentemente.");
        }
    }

    if ($totalExcluidos === 0) {
        $this->info('✅ Nenhum registro expirado (e sem vínculos) encontrado. Lixeira limpa!');
    } else {
        $this->info("🗑️ Total: {$totalExcluidos} registro(s) removidos permanentemente.");
    }
})->purpose('Excluir permanentemente registros na lixeira há mais de 30 dias');

// Agendar para rodar diariamente à meia-noite
Schedule::command('lixeira:limpar')->daily();
