<?php

namespace Tests\Feature;

use App\Models\Curso;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CursoTest extends TestCase
{
    use RefreshDatabase;

    public function test_listar_cursos(): void
    {
        Curso::factory()->count(3)->create();

        $response = $this->getJson('/api/cursos');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_cadastrar_curso(): void
    {
        $data = [
            'nome' => 'Novo Curso',
            'descricao' => 'Descrição do curso',
            'carga_horaria' => 3200,
        ];

        $response = $this->postJson('/api/cursos', $data);

        $response->assertStatus(201)
            ->assertJsonFragment(['nome' => 'Novo Curso']);

        $this->assertDatabaseHas('cursos', ['nome' => 'Novo Curso']);
    }

    public function test_editar_curso(): void
    {
        $curso = Curso::factory()->create();

        $data = [
            'nome' => 'Curso Atualizado',
        ];

        $response = $this->putJson("/api/cursos/{$curso->id}", $data);

        $response->assertStatus(200)
            ->assertJsonFragment(['nome' => 'Curso Atualizado']);

        $this->assertDatabaseHas('cursos', ['nome' => 'Curso Atualizado']);
    }

    public function test_excluir_curso_sem_matriculas(): void
    {
        $curso = Curso::factory()->create();

        $response = $this->deleteJson("/api/cursos/{$curso->id}");

        $response->assertStatus(200);
        $this->assertSoftDeleted('cursos', ['id' => $curso->id]);
    }
}

