<?php

namespace App\Services;

use App\DTOs\CursoDTO;
use App\Repositories\Contracts\CursoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CursoService
{
    public function __construct(
        private CursoRepositoryInterface $repository
    ) {}

    public function listarTodos(): Collection
    {
        return $this->repository->all();
    }

    public function buscarPorId(int $id)
    {
        return $this->repository->find($id);
    }

    public function cadastrar(CursoDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->create($data);
    }

    public function editar(int $id, CursoDTO $dto): bool
    {
        $data = $dto->toArray();
        return $this->repository->update($id, $data);
    }

    public function excluir(int $id): array
    {
        if ($this->repository->hasMatriculas($id)) {
            return [
                'success' => false,
                'message' => 'Não é possível excluir o curso pois existem alunos matriculados.'
            ];
        }

        $result = $this->repository->delete($id);
        
        return [
            'success' => $result,
            'message' => $result ? 'Curso excluído com sucesso.' : 'Curso não encontrado.'
        ];
    }
}

