<?php

namespace App\Services;

use App\DTOs\DisciplinaDTO;
use App\Repositories\Contracts\DisciplinaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DisciplinaService
{
    public function __construct(
        private DisciplinaRepositoryInterface $repository
    ) {}

    public function listarTodas(): Collection
    {
        return $this->repository->all();
    }

    public function listarPorCurso(int $cursoId): Collection
    {
        return $this->repository->findByCurso($cursoId);
    }

    public function buscarPorId(int $id)
    {
        return $this->repository->find($id);
    }

    public function cadastrar(DisciplinaDTO $dto)
    {
        $data = $dto->toArray();
        
        if (count($dto->cursos) < 2) {
            throw new \Exception('Uma disciplina deve pertencer a pelo menos 2 cursos.');
        }

        $data['cursos'] = $dto->cursos;
        return $this->repository->create($data);
    }

    public function editar(int $id, DisciplinaDTO $dto): bool
    {
        $data = $dto->toArray();
        
        if (!empty($dto->cursos) && count($dto->cursos) < 2) {
            throw new \Exception('Uma disciplina deve pertencer a pelo menos 2 cursos.');
        }

        if (!empty($dto->cursos)) {
            $data['cursos'] = $dto->cursos;
        }

        return $this->repository->update($id, $data);
    }

    public function excluir(int $id): bool
    {
        return $this->repository->delete($id);
    }
}

