<?php

namespace App\Repositories\Contracts;

use App\Models\Matricula;
use Illuminate\Database\Eloquent\Collection;

interface MatriculaRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?Matricula;
    public function create(array $data): Matricula;
    public function update(int $id, array $data): bool;
    public function exists(int $alunoId, int $cursoId): bool;
    public function trancar(int $id): bool;
}

