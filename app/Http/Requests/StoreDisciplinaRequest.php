<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDisciplinaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'carga_horaria' => 'required|integer|min:1',
            'cursos' => 'required|array|min:2',
            'cursos.*' => 'required|integer|exists:cursos,id',
        ];
    }
}

