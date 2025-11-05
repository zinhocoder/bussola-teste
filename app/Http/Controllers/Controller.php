<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="Sistema de Gerenciamento Escolar API",
 *     version="1.0.0",
 *     description="API RESTful para gerenciamento de cursos, disciplinas, alunos e matrículas",
 *     )
 * )
 * 
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Servidor de Desenvolvimento"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
