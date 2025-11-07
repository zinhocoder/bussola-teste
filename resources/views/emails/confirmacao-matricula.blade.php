<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Confirmação de Matrícula</title>
</head>
<body>
    <h1>Confirmação de Matrícula</h1>
    
    <p>Olá, {{ $aluno->nome }}!</p>
    
    <p>Sua matrícula no curso <strong>{{ $curso->nome }}</strong> foi confirmada com sucesso.</p>
    
    <h2>Dados da Matrícula:</h2>
    <ul>
        <li><strong>Curso:</strong> {{ $curso->nome }}</li>
        <li><strong>Descrição:</strong> {{ $curso->descricao }}</li>
        <li><strong>Carga Horária:</strong> {{ $curso->carga_horaria }} horas</li>
        <li><strong>Data de Matrícula:</strong> {{ $matricula->data_matricula->format('d/m/Y') }}</li>
        <li><strong>Status:</strong> {{ ucfirst($matricula->status) }}</li>
    </ul>
    
    <p>Bem-vindo(a) ao nosso sistema!</p>
    
    <p>Atenciosamente,<br>Sistema de Gerenciamento Escolar</p>
</body>
</html>

