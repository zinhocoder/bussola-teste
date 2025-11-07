<?php

namespace App\Http\Controllers\Api;

use App\DTOs\AlunoDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAlunoRequest;
use App\Http\Requests\UpdateAlunoRequest;
use App\Services\AlunoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Alunos",
 *     description="Operações relacionadas a alunos"
 * )
 */
class AlunoController extends Controller
{
    public function __construct(
        private AlunoService $service
    ) {}

    /**
     * @OA\Get(
     *     path="/api/alunos",
     *     summary="Listar todos os alunos",
     *     tags={"Alunos"},
     *     @OA\Response(response=200, description="Lista de alunos")
     * )
     */
    public function index(): JsonResponse
    {
        $alunos = $this->service->listarTodos();
        return response()->json($alunos);
    }

    /**
     * @OA\Get(
     *     path="/api/alunos/curso/{cursoId}",
     *     summary="Listar alunos matriculados em um curso",
     *     tags={"Alunos"},
     *     @OA\Parameter(
     *         name="cursoId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Lista de alunos do curso")
     * )
     */
    public function porCurso(int $cursoId): JsonResponse
    {
        $alunos = $this->service->listarPorCurso($cursoId);
        return response()->json($alunos);
    }

    /**
     * @OA\Get(
     *     path="/api/alunos/cpf/{cpf}",
     *     summary="Buscar aluno por CPF e retornar seus dados pessoais + curso(s) matriculado(s)",
     *     tags={"Alunos"},
     *     @OA\Parameter(
     *         name="cpf",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string", example="12345678901")
     *     ),
     *     @OA\Response(response=200, description="Dados do aluno com cursos"),
     *     @OA\Response(response=404, description="Aluno não encontrado")
     * )
     */
    public function porCpf(string $cpf): JsonResponse
    {
        $aluno = $this->service->buscarPorCpf($cpf);
        
        if (!$aluno) {
            return response()->json(['message' => 'Aluno não encontrado.'], 404);
        }

        return response()->json($aluno);
    }

    /**
     * @OA\Get(
     *     path="/api/alunos/{id}",
     *     summary="Buscar aluno por ID",
     *     tags={"Alunos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Dados do aluno"),
     *     @OA\Response(response=404, description="Aluno não encontrado")
     * )
     */
    public function show(int $id): JsonResponse
    {
        $aluno = $this->service->buscarPorId($id);
        
        if (!$aluno) {
            return response()->json(['message' => 'Aluno não encontrado.'], 404);
        }

        return response()->json($aluno);
    }

    /**
     * @OA\Post(
     *     path="/api/alunos",
     *     summary="Cadastrar aluno vinculando a pelo menos um curso",
     *     tags={"Alunos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nome", "cpf", "data_nascimento", "cursos"},
     *             @OA\Property(property="nome", type="string", example="João Silva"),
     *             @OA\Property(property="cpf", type="string", example="12345678901", description="CPF com 11 dígitos"),
     *             @OA\Property(property="data_nascimento", type="string", format="date", example="2000-01-15"),
     *             @OA\Property(property="cursos", type="array", @OA\Items(type="integer"), example={1}, description="IDs dos cursos (mínimo 1)")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Aluno criado com sucesso"),
     *     @OA\Response(response=400, description="Erro na validação")
     * )
     */
    public function store(StoreAlunoRequest $request): JsonResponse
    {
        try {
            $dto = AlunoDTO::fromArray($request->validated());
            $aluno = $this->service->cadastrar($dto);
            
            return response()->json($aluno, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/alunos/{id}",
     *     summary="Editar aluno",
     *     tags={"Alunos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nome", type="string", example="João Silva"),
     *             @OA\Property(property="cpf", type="string", example="12345678901", description="CPF com 11 dígitos"),
     *             @OA\Property(property="data_nascimento", type="string", format="date", example="2000-01-15")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Aluno atualizado com sucesso"),
     *     @OA\Response(response=404, description="Aluno não encontrado"),
     *     @OA\Response(response=400, description="Erro na validação")
     * )
     */
    public function update(UpdateAlunoRequest $request, int $id): JsonResponse
    {
        try {
            $dto = AlunoDTO::fromArray($request->validated());
            $result = $this->service->editar($id, $dto);
            
            if (!$result) {
                return response()->json(['message' => 'Aluno não encontrado.'], 404);
            }

            $aluno = $this->service->buscarPorId($id);
            return response()->json($aluno);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/alunos/{id}",
     *     summary="Excluir aluno",
     *     tags={"Alunos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Aluno excluído com sucesso"),
     *     @OA\Response(response=404, description="Aluno não encontrado")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->service->excluir($id);
        
        if (!$result) {
            return response()->json(['message' => 'Aluno não encontrado.'], 404);
        }

        return response()->json(['message' => 'Aluno excluído com sucesso.']);
    }

    /**
     * @OA\Post(
     *     path="/api/alunos/{id}/cursos",
     *     summary="Vincular aluno a outro(s) curso(s)",
     *     tags={"Alunos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"cursos"},
     *             @OA\Property(property="cursos", type="array", @OA\Items(type="integer"), example={1, 2}, description="IDs dos cursos (mínimo 1)")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Aluno vinculado aos cursos com sucesso"),
     *     @OA\Response(response=400, description="Erro na validação"),
     *     @OA\Response(response=404, description="Aluno não encontrado")
     * )
     */
    public function vincularCursos(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'cursos' => 'required|array|min:1',
            'cursos.*' => 'required|integer|exists:cursos,id',
        ]);

        try {
            $this->service->vincularCursos($id, $request->cursos);
            $aluno = $this->service->buscarPorId($id);
            
            return response()->json($aluno);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}

