<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlunoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|size:11|unique:alunos,cpf',
            'data_nascimento' => 'required|date|before:today',
            'cursos' => 'required|array|min:1',
            'cursos.*' => 'required|integer|exists:cursos,id',
        ];
    }
}

