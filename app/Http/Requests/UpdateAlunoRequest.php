<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAlunoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'sometimes|string|max:255',
            'cpf' => 'sometimes|string|size:11|unique:alunos,cpf,' . $this->route('id'),
            'data_nascimento' => 'sometimes|date|before:today',
        ];
    }
}

