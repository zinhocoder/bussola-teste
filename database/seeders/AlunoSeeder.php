<?php

namespace Database\Seeders;

use App\Models\Aluno;
use App\Models\Curso;
use Illuminate\Database\Seeder;

class AlunoSeeder extends Seeder
{
    public function run(): void
    {
        $cursos = Curso::all();
        
        $alunos = [
            [
                'nome' => 'João Silva',
                'cpf' => '12345678901',
                'data_nascimento' => '1995-05-15',
                'cursos' => ['Direito', 'Administração'],
            ],
            [
                'nome' => 'Maria Santos',
                'cpf' => '23456789012',
                'data_nascimento' => '1998-08-20',
                'cursos' => ['Sistemas de Informação'],
            ],
            [
                'nome' => 'Pedro Oliveira',
                'cpf' => '34567890123',
                'data_nascimento' => '1997-03-10',
                'cursos' => ['Engenharia de Software', 'Ciência da Computação'],
            ],
            [
                'nome' => 'Ana Costa',
                'cpf' => '45678901234',
                'data_nascimento' => '1999-11-25',
                'cursos' => ['Administração'],
            ],
            [
                'nome' => 'Carlos Pereira',
                'cpf' => '56789012345',
                'data_nascimento' => '1996-07-30',
                'cursos' => ['Sistemas de Informação', 'Engenharia de Software'],
            ],
        ];

        foreach ($alunos as $alunoData) {
            $cursosIds = $cursos->whereIn('nome', $alunoData['cursos'])->pluck('id')->toArray();
            
            $aluno = Aluno::create([
                'nome' => $alunoData['nome'],
                'cpf' => $alunoData['cpf'],
                'data_nascimento' => $alunoData['data_nascimento'],
            ]);

            foreach ($cursosIds as $cursoId) {
                $aluno->cursos()->attach($cursoId, [
                    'data_matricula' => now()->subDays(rand(1, 90)),
                    'status' => 'ativa'
                ]);
            }
        }
    }
}

