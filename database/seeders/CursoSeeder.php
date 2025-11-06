<?php

namespace Database\Seeders;

use App\Models\Curso;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        $cursos = [
            [
                'nome' => 'Direito',
                'descricao' => 'Curso de Bacharelado em Direito',
                'carga_horaria' => 3600,
                'data_cadastro' => now()->subMonths(12),
            ],
            [
                'nome' => 'Sistemas de Informação',
                'descricao' => 'Curso de Bacharelado em Sistemas de Informação',
                'carga_horaria' => 3200,
                'data_cadastro' => now()->subMonths(10),
            ],
            [
                'nome' => 'Administração',
                'descricao' => 'Curso de Bacharelado em Administração',
                'carga_horaria' => 3200,
                'data_cadastro' => now()->subMonths(8),
            ],
            [
                'nome' => 'Engenharia de Software',
                'descricao' => 'Curso de Bacharelado em Engenharia de Software',
                'carga_horaria' => 3600,
                'data_cadastro' => now()->subMonths(6),
            ],
            [
                'nome' => 'Ciência da Computação',
                'descricao' => 'Curso de Bacharelado em Ciência da Computação',
                'carga_horaria' => 3600,
                'data_cadastro' => now()->subMonths(4),
            ],
        ];

        foreach ($cursos as $curso) {
            Curso::create($curso);
        }
    }
}

