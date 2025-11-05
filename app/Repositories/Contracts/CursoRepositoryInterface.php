<?php

namespace App\Repositories\Contracts;

use App\Models\Curso;
use Illuminate\Database\Eloquent\Collection;

interface CursoRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?Curso;
    public function create(array $data): Curso;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function hasMatriculas(int $id): bool;
}

