<?php

namespace App\Repositories;

use App\Models\Curso;
use App\Repositories\Contracts\CursoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CursoRepository implements CursoRepositoryInterface
{
    public function all(): Collection
    {
        return Curso::with(['disciplinas', 'matriculas'])->get();
    }

    public function find(int $id): ?Curso
    {
        return Curso::with(['disciplinas', 'matriculas'])->find($id);
    }

    public function create(array $data): Curso
    {
        return Curso::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $curso = $this->find($id);
        if (!$curso) {
            return false;
        }
        return $curso->update($data);
    }

    public function delete(int $id): bool
    {
        $curso = $this->find($id);
        if (!$curso) {
            return false;
        }
        return $curso->delete();
    }

    public function hasMatriculas(int $id): bool
    {
        $curso = $this->find($id);
        if (!$curso) {
            return false;
        }
        return $curso->matriculas()->where('status', 'ativa')->exists();
    }
}

