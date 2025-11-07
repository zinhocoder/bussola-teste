<?php

namespace App\Services;

use App\DTOs\AlunoDTO;
use App\Repositories\Contracts\AlunoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AlunoService
{
    public function __construct(
        private AlunoRepositoryInterface $repository
    ) {}

    public function listarTodos(): Collection
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

    public function buscarPorCpf(string $cpf)
    {
        return $this->repository->findByCpf($cpf);
    }

    public function cadastrar(AlunoDTO $dto)
    {
        if (empty($dto->cursos)) {
            throw new \Exception('O aluno deve ser vinculado a pelo menos um curso.');
        }

        $data = $dto->toArray();
        $data['cursos'] = $dto->cursos;
        
        return $this->repository->create($data);
    }

    public function editar(int $id, AlunoDTO $dto): bool
    {
        $data = $dto->toArray();
        
        if (!empty($dto->cursos)) {
            $data['cursos'] = $dto->cursos;
        }

        return $this->repository->update($id, $data);
    }

    public function vincularCursos(int $id, array $cursoIds): bool
    {
        $this->repository->syncCursos($id, $cursoIds);
        return true;
    }

    public function excluir(int $id): bool
    {
        return $this->repository->delete($id);
    }
}

