<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMatriculaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'aluno_id' => 'required|integer|exists:alunos,id',
            'curso_id' => 'required|integer|exists:cursos,id',
            'data_matricula' => 'nullable|date',
        ];
    }
}

