<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- ADICIONE ESTA LINHA AQUI NO TOPO!

class AppServiceProvider extends ServiceProvider
{
    // ... (pode ter uma função register aqui, ignore ela) ...

    public function boot(): void
    {
        // Se estivermos em produção, obriga o Laravel a usar HTTPS no CSS/JS
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
