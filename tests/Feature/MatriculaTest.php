<?php

namespace Tests\Feature;

use App\Events\MatriculaRealizada;
use App\Models\Aluno;
use App\Models\Curso;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class MatriculaTest extends TestCase
{
    use RefreshDatabase;

    public function test_realizar_matricula(): void
    {
        Event::fake();

        $aluno = Aluno::factory()->create();
        $curso = Curso::factory()->create();

        $data = [
            'aluno_id' => $aluno->id,
            'curso_id' => $curso->id,
        ];

        $response = $this->postJson('/api/matriculas', $data);

        $response->assertStatus(201);

        Event::assertDispatched(MatriculaRealizada::class);
    }

    public function test_trancar_matricula(): void
    {
        $aluno = Aluno::factory()->create();
        $curso = Curso::factory()->create();

        $matricula = $aluno->matriculas()->create([
            'curso_id' => $curso->id,
            'data_matricula' => now(),
            'status' => 'ativa',
        ]);

        $response = $this->putJson("/api/matriculas/{$matricula->id}/trancar");

        $response->assertStatus(200);
        $this->assertDatabaseHas('matriculas', [
            'id' => $matricula->id,
            'status' => 'trancada'
        ]);
    }
}

