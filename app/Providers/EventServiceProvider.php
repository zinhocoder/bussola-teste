<?php

namespace App\Providers;

use App\Events\MatriculaRealizada;
use App\Listeners\EnviarEmailConfirmacaoMatricula;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        MatriculaRealizada::class => [
            EnviarEmailConfirmacaoMatricula::class,
        ],
    ];

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}

