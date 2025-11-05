<?php

namespace App\Repositories;

use App\Models\Matricula;
use App\Repositories\Contracts\MatriculaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class MatriculaRepository implements MatriculaRepositoryInterface
{
    public function all(): Collection
    {
        return Matricula::with(['aluno', 'curso'])->get();
    }

    public function find(int $id): ?Matricula
    {
        return Matricula::with(['aluno', 'curso'])->find($id);
    }

    public function create(array $data): Matricula
    {
        return Matricula::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $matricula = $this->find($id);
        if (!$matricula) {
            return false;
        }
        return $matricula->update($data);
    }

    public function exists(int $alunoId, int $cursoId): bool
    {
        return Matricula::where('aluno_id', $alunoId)
            ->where('curso_id', $cursoId)
            ->where('status', 'ativa')
            ->exists();
    }

    public function trancar(int $id): bool
    {
        $matricula = $this->find($id);
        if (!$matricula) {
            return false;
        }
        return $matricula->update(['status' => 'trancada']);
    }
}

