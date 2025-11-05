<?php

namespace App\Repositories;

use App\Models\Aluno;
use App\Repositories\Contracts\AlunoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AlunoRepository implements AlunoRepositoryInterface
{
    public function all(): Collection
    {
        return Aluno::with('cursos')->get();
    }

    public function find(int $id): ?Aluno
    {
        return Aluno::with('cursos')->find($id);
    }

    public function findByCpf(string $cpf): ?Aluno
    {
        return Aluno::with('cursos')->where('cpf', $cpf)->first();
    }

    public function create(array $data): Aluno
    {
        $cursos = $data['cursos'] ?? [];
        unset($data['cursos']);
        
        $aluno = Aluno::create($data);
        
        if (!empty($cursos)) {
            foreach ($cursos as $cursoId) {
                $aluno->cursos()->attach($cursoId, [
                    'data_matricula' => now(),
                    'status' => 'ativa'
                ]);
            }
        }
        
        return $aluno->load('cursos');
    }

    public function update(int $id, array $data): bool
    {
        $aluno = $this->find($id);
        if (!$aluno) {
            return false;
        }
        
        $cursos = $data['cursos'] ?? null;
        unset($data['cursos']);
        
        $aluno->update($data);
        
        if ($cursos !== null) {
            // Não removemos cursos existentes, apenas adicionamos novos
            foreach ($cursos as $cursoId) {
                if (!$aluno->cursos()->where('curso_id', $cursoId)->exists()) {
                    $aluno->cursos()->attach($cursoId, [
                        'data_matricula' => now(),
                        'status' => 'ativa'
                    ]);
                }
            }
        }
        
        return true;
    }

    public function delete(int $id): bool
    {
        $aluno = $this->find($id);
        if (!$aluno) {
            return false;
        }
        return $aluno->delete();
    }

    public function findByCurso(int $cursoId): Collection
    {
        return Aluno::whereHas('cursos', function ($query) use ($cursoId) {
            $query->where('cursos.id', $cursoId);
        })->with('cursos')->get();
    }

    public function syncCursos(int $id, array $cursoIds): void
    {
        $aluno = $this->find($id);
        if ($aluno) {
            foreach ($cursoIds as $cursoId) {
                if (!$aluno->cursos()->where('curso_id', $cursoId)->exists()) {
                    $aluno->cursos()->attach($cursoId, [
                        'data_matricula' => now(),
                        'status' => 'ativa'
                    ]);
                }
            }
        }
    }
}

