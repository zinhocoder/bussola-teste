<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aluno_id')->constrained('alunos')->onDelete('cascade');
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->date('data_matricula');
            $table->enum('status', ['ativa', 'trancada'])->default('ativa');
            $table->timestamps();
            $table->softDeletes();
            
            // Índice para melhor performance em consultas
            $table->index(['aluno_id', 'curso_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};

