<?php

namespace Database\Factories;

use App\Models\Aluno;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlunoFactory extends Factory
{
    protected $model = Aluno::class;

    public function definition(): array
    {
        return [
            'nome' => $this->faker->name(),
            'cpf' => $this->faker->numerify('###########'),
            'data_nascimento' => $this->faker->dateTimeBetween('-30 years', '-18 years'),
        ];
    }
}

