<?php

namespace App\DTOs;

class DisciplinaDTO
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $nome,
        public readonly ?string $descricao,
        public readonly int $carga_horaria,
        public readonly array $cursos = [],
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            nome: $data['nome'],
            descricao: $data['descricao'] ?? null,
            carga_horaria: $data['carga_horaria'],
            cursos: $data['cursos'] ?? [],
        );
    }

    public function toArray(): array
    {
        return [
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'carga_horaria' => $this->carga_horaria,
        ];
    }
}

