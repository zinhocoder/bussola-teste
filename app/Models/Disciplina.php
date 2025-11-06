<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Disciplina extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'disciplinas';

    protected $fillable = [
        'nome',
        'descricao',
        'carga_horaria',
    ];

    protected $casts = [
        'carga_horaria' => 'integer',
    ];

    public function cursos(): BelongsToMany
    {
        return $this->belongsToMany(Curso::class, 'curso_disciplina')
            ->withTimestamps();
    }
}

