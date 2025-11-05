<?php

namespace App\Providers;

use App\Repositories\Contracts\AlunoRepositoryInterface;
use App\Repositories\Contracts\CursoRepositoryInterface;
use App\Repositories\Contracts\DisciplinaRepositoryInterface;
use App\Repositories\Contracts\MatriculaRepositoryInterface;
use App\Repositories\AlunoRepository;
use App\Repositories\CursoRepository;
use App\Repositories\DisciplinaRepository;
use App\Repositories\MatriculaRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Registrar bindings dos repositories
        $this->app->bind(CursoRepositoryInterface::class, CursoRepository::class);
        $this->app->bind(DisciplinaRepositoryInterface::class, DisciplinaRepository::class);
        $this->app->bind(AlunoRepositoryInterface::class, AlunoRepository::class);
        $this->app->bind(MatriculaRepositoryInterface::class, MatriculaRepository::class);
    }

    public function boot(): void
    {
        //
    }
}

