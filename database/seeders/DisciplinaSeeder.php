<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\Disciplina;
use Illuminate\Database\Seeder;

class DisciplinaSeeder extends Seeder
{
    public function run(): void
    {
        $cursos = Curso::all();
        
        $disciplinas = [
            [
                'nome' => 'Introdução a Administração',
                'descricao' => 'Fundamentos da administração',
                'carga_horaria' => 60,
                'cursos' => ['Direito', 'Sistemas de Informação', 'Administração'],
            ],
            [
                'nome' => 'Matemática Discreta',
                'descricao' => 'Fundamentos de matemática discreta',
                'carga_horaria' => 80,
                'cursos' => ['Sistemas de Informação', 'Engenharia de Software', 'Ciência da Computação'],
            ],
            [
                'nome' => 'Algoritmos e Estruturas de Dados',
                'descricao' => 'Estruturas de dados e algoritmos',
                'carga_horaria' => 100,
                'cursos' => ['Sistemas de Informação', 'Engenharia de Software', 'Ciência da Computação'],
            ],
            [
                'nome' => 'Direito Constitucional',
                'descricao' => 'Fundamentos do direito constitucional',
                'carga_horaria' => 80,
                'cursos' => ['Direito'],
            ],
            [
                'nome' => 'Banco de Dados',
                'descricao' => 'Projeto e implementação de bancos de dados',
                'carga_horaria' => 100,
                'cursos' => ['Sistemas de Informação', 'Engenharia de Software', 'Ciência da Computação'],
            ],
            [
                'nome' => 'Gestão de Projetos',
                'descricao' => 'Metodologias de gestão de projetos',
                'carga_horaria' => 60,
                'cursos' => ['Administração', 'Sistemas de Informação', 'Engenharia de Software'],
            ],
        ];

        foreach ($disciplinas as $disciplinaData) {
            $cursosIds = $cursos->whereIn('nome', $disciplinaData['cursos'])->pluck('id')->toArray();
            
            $disciplina = Disciplina::create([
                'nome' => $disciplinaData['nome'],
                'descricao' => $disciplinaData['descricao'],
                'carga_horaria' => $disciplinaData['carga_horaria'],
            ]);

            $disciplina->cursos()->sync($cursosIds);
        }
    }
}

