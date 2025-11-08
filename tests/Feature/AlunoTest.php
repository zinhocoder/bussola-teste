<?php

namespace Tests\Feature;

use App\Models\Aluno;
use App\Models\Curso;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlunoTest extends TestCase
{
    use RefreshDatabase;

    public function test_cadastrar_aluno_com_curso(): void
    {
        $curso = Curso::factory()->create();

        $data = [
            'nome' => 'João Silva',
            'cpf' => '12345678901',
            'data_nascimento' => '1995-05-15',
            'cursos' => [$curso->id],
        ];

        $response = $this->postJson('/api/alunos', $data);

        $response->assertStatus(201)
            ->assertJsonFragment(['nome' => 'João Silva']);

        $this->assertDatabaseHas('alunos', ['cpf' => '12345678901']);
    }

    public function test_buscar_aluno_por_cpf(): void
    {
        $curso = Curso::factory()->create();
        $aluno = Aluno::factory()->create(['cpf' => '12345678901']);
        $aluno->cursos()->attach($curso->id, [
            'data_matricula' => now(),
            'status' => 'ativa'
        ]);

        $response = $this->getJson('/api/alunos/cpf/12345678901');

        $response->assertStatus(200)
            ->assertJsonFragment(['cpf' => '12345678901']);
    }
}

