<?php

namespace App\DTOs;

class CursoDTO
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $nome,
        public readonly ?string $descricao,
        public readonly int $carga_horaria,
        public readonly ?string $data_cadastro = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            nome: $data['nome'],
            descricao: $data['descricao'] ?? null,
            carga_horaria: $data['carga_horaria'],
            data_cadastro: $data['data_cadastro'] ?? now()->format('Y-m-d'),
        );
    }

    public function toArray(): array
    {
        return [
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'carga_horaria' => $this->carga_horaria,
            'data_cadastro' => $this->data_cadastro ?? now()->format('Y-m-d'),
        ];
    }
}

