<?php

namespace App\Repositories\Contracts;

use App\Models\Disciplina;
use Illuminate\Database\Eloquent\Collection;

interface DisciplinaRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?Disciplina;
    public function create(array $data): Disciplina;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function findByCurso(int $cursoId): Collection;
    public function syncCursos(int $id, array $cursoIds): void;
}

