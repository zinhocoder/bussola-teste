<?php

namespace App\Mail;

use App\Models\Matricula;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmacaoMatricula extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Matricula $matricula
    ) {}

    public function build()
    {
        return $this->subject('Confirmação de Matrícula - ' . $this->matricula->curso->nome)
            ->view('emails.confirmacao-matricula')
            ->with([
                'aluno' => $this->matricula->aluno,
                'curso' => $this->matricula->curso,
                'matricula' => $this->matricula,
            ]);
    }
}

