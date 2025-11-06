<?php

namespace Database\Factories;

use App\Models\Curso;
use Illuminate\Database\Eloquent\Factories\Factory;

class CursoFactory extends Factory
{
    protected $model = Curso::class;

    public function definition(): array
    {
        return [
            'nome' => $this->faker->words(3, true),
            'descricao' => $this->faker->sentence(),
            'carga_horaria' => $this->faker->numberBetween(2000, 4000),
            'data_cadastro' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}

