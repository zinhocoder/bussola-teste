<?php

namespace App\Services;

use App\DTOs\MatriculaDTO;
use App\Events\MatriculaRealizada;
use App\Repositories\Contracts\AlunoRepositoryInterface;
use App\Repositories\Contracts\CursoRepositoryInterface;
use App\Repositories\Contracts\MatriculaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class MatriculaService
{
    public function __construct(
        private MatriculaRepositoryInterface $matriculaRepository,
        private AlunoRepositoryInterface $alunoRepository,
        private CursoRepositoryInterface $cursoRepository
    ) {}

    public function listarTodas(): Collection
    {
        return $this->matriculaRepository->all();
    }

    public function buscarPorId(int $id)
    {
        return $this->matriculaRepository->find($id);
    }

    public function realizarMatricula(MatriculaDTO $dto)
    {
        // Verificar se aluno existe
        $aluno = $this->alunoRepository->find($dto->aluno_id);
        if (!$aluno) {
            throw new \Exception('Aluno não encontrado.');
        }

        // Verificar se curso existe
        $curso = $this->cursoRepository->find($dto->curso_id);
        if (!$curso) {
            throw new \Exception('Curso não encontrado.');
        }

        // Verificar se já existe matrícula ativa
        if ($this->matriculaRepository->exists($dto->aluno_id, $dto->curso_id)) {
            throw new \Exception('Aluno já está matriculado neste curso.');
        }

        // Criar matrícula
        $data = $dto->toArray();
        $matricula = $this->matriculaRepository->create($data);

        // Disparar evento para envio de e-mail
        event(new MatriculaRealizada($matricula));

        return $matricula->load(['aluno', 'curso']);
    }

    public function trancarMatricula(int $id): bool
    {
        return $this->matriculaRepository->trancar($id);
    }
}

