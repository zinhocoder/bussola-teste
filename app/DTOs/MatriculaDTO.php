<?php

namespace App\DTOs;

class MatriculaDTO
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $aluno_id,
        public readonly int $curso_id,
        public readonly ?string $data_matricula = null,
        public readonly string $status = 'ativa',
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            aluno_id: $data['aluno_id'],
            curso_id: $data['curso_id'],
            data_matricula: $data['data_matricula'] ?? now()->format('Y-m-d'),
            status: $data['status'] ?? 'ativa',
        );
    }

    public function toArray(): array
    {
        return [
            'aluno_id' => $this->aluno_id,
            'curso_id' => $this->curso_id,
            'data_matricula' => $this->data_matricula ?? now()->format('Y-m-d'),
            'status' => $this->status,
        ];
    }
}

