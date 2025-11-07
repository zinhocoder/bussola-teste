<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDisciplinaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'sometimes|string|max:255',
            'descricao' => 'nullable|string',
            'carga_horaria' => 'sometimes|integer|min:1',
            'cursos' => 'sometimes|array|min:2',
            'cursos.*' => 'required|integer|exists:cursos,id',
        ];
    }
}

