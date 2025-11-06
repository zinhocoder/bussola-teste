<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @OA\Schema(
 *     schema="Curso",
 *     type="object",
 *     title="Curso",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nome", type="string", example="Direito"),
 *     @OA\Property(property="descricao", type="string", example="Curso de Bacharelado em Direito"),
 *     @OA\Property(property="carga_horaria", type="integer", example=3600),
 *     @OA\Property(property="data_cadastro", type="string", format="date", example="2024-01-01"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Curso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cursos';

    protected $fillable = [
        'nome',
        'descricao',
        'carga_horaria',
        'data_cadastro',
    ];

    protected $casts = [
        'data_cadastro' => 'date',
        'carga_horaria' => 'integer',
    ];

    public function disciplinas(): BelongsToMany
    {
        return $this->belongsToMany(Disciplina::class, 'curso_disciplina')
            ->withTimestamps();
    }

    public function matriculas(): HasMany
    {
        return $this->hasMany(Matricula::class);
    }

    public function alunos(): BelongsToMany
    {
        return $this->belongsToMany(Aluno::class, 'matriculas')
            ->withPivot('data_matricula', 'status')
            ->withTimestamps();
    }
}
