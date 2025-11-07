<?php

namespace App\Listeners;

use App\Events\MatriculaRealizada;
use App\Mail\ConfirmacaoMatricula;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class EnviarEmailConfirmacaoMatricula implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(MatriculaRealizada $event): void
    {
        $matricula = $event->matricula->load(['aluno', 'curso']);
        
        // Em produção, usar o e-mail do aluno (adicionar campo email na tabela alunos)
        $email = 'aluno@exemplo.com'; // TODO: Adicionar campo email na tabela alunos
        
        Mail::to($email)->send(new ConfirmacaoMatricula($matricula));
    }
}

