<?php

namespace App\Repositories\Contracts;

use App\Models\Aluno;
use Illuminate\Database\Eloquent\Collection;

interface AlunoRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?Aluno;
    public function findByCpf(string $cpf): ?Aluno;
    public function create(array $data): Aluno;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function findByCurso(int $cursoId): Collection;
    public function syncCursos(int $id, array $cursoIds): void;
}

