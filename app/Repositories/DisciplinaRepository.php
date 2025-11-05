<?php

namespace App\Repositories;

use App\Models\Disciplina;
use App\Repositories\Contracts\DisciplinaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DisciplinaRepository implements DisciplinaRepositoryInterface
{
    public function all(): Collection
    {
        return Disciplina::with('cursos')->get();
    }

    public function find(int $id): ?Disciplina
    {
        return Disciplina::with('cursos')->find($id);
    }

    public function create(array $data): Disciplina
    {
        $cursos = $data['cursos'] ?? [];
        unset($data['cursos']);
        
        $disciplina = Disciplina::create($data);
        
        if (!empty($cursos)) {
            $disciplina->cursos()->sync($cursos);
        }
        
        return $disciplina->load('cursos');
    }

    public function update(int $id, array $data): bool
    {
        $disciplina = $this->find($id);
        if (!$disciplina) {
            return false;
        }
        
        $cursos = $data['cursos'] ?? null;
        unset($data['cursos']);
        
        $disciplina->update($data);
        
        if ($cursos !== null) {
            $disciplina->cursos()->sync($cursos);
        }
        
        return true;
    }

    public function delete(int $id): bool
    {
        $disciplina = $this->find($id);
        if (!$disciplina) {
            return false;
        }
        return $disciplina->delete();
    }

    public function findByCurso(int $cursoId): Collection
    {
        return Disciplina::whereHas('cursos', function ($query) use ($cursoId) {
            $query->where('cursos.id', $cursoId);
        })->with('cursos')->get();
    }

    public function syncCursos(int $id, array $cursoIds): void
    {
        $disciplina = $this->find($id);
        if ($disciplina) {
            $disciplina->cursos()->sync($cursoIds);
        }
    }
}

