<?php

namespace App\DTOs;

class AlunoDTO
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $nome,
        public readonly string $cpf,
        public readonly string $data_nascimento,
        public readonly array $cursos = [],
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            nome: $data['nome'],
            cpf: $data['cpf'],
            data_nascimento: $data['data_nascimento'],
            cursos: $data['cursos'] ?? [],
        );
    }

    public function toArray(): array
    {
        return [
            'nome' => $this->nome,
            'cpf' => $this->cpf,
            'data_nascimento' => $this->data_nascimento,
        ];
    }
}

