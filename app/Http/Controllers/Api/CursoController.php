<?php

namespace App\Http\Controllers\Api;

use App\DTOs\CursoDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCursoRequest;
use App\Http\Requests\UpdateCursoRequest;
use App\Services\CursoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Cursos",
 *     description="Operações relacionadas a cursos"
 * )
 */
class CursoController extends Controller
{
    public function __construct(
        private CursoService $service
    ) {}

    /**
     * @OA\Get(
     *     path="/api/cursos",
     *     summary="Listar todos os cursos",
     *     tags={"Cursos"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de cursos",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Curso"))
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $cursos = $this->service->listarTodos();
        return response()->json($cursos);
    }

    /**
     * @OA\Get(
     *     path="/api/cursos/{id}",
     *     summary="Buscar curso por ID",
     *     tags={"Cursos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dados do curso",
     *         @OA\JsonContent(ref="#/components/schemas/Curso")
     *     ),
     *     @OA\Response(response=404, description="Curso não encontrado")
     * )
     */
    public function show(int $id): JsonResponse
    {
        $curso = $this->service->buscarPorId($id);
        
        if (!$curso) {
            return response()->json(['message' => 'Curso não encontrado.'], 404);
        }

        return response()->json($curso);
    }

    /**
     * @OA\Post(
     *     path="/api/cursos",
     *     summary="Cadastrar novo curso",
     *     tags={"Cursos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nome", "carga_horaria"},
     *             @OA\Property(property="nome", type="string", example="Direito"),
     *             @OA\Property(property="descricao", type="string", example="Curso de Bacharelado em Direito"),
     *             @OA\Property(property="carga_horaria", type="integer", example=3600),
     *             @OA\Property(property="data_cadastro", type="string", format="date", example="2024-01-01")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Curso criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Curso")
     *     ),
     *     @OA\Response(response=400, description="Erro na validação")
     * )
     */
    public function store(StoreCursoRequest $request): JsonResponse
    {
        try {
            $dto = CursoDTO::fromArray($request->validated());
            $curso = $this->service->cadastrar($dto);
            
            return response()->json($curso, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/cursos/{id}",
     *     summary="Editar curso",
     *     tags={"Cursos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nome", type="string", example="Direito"),
     *             @OA\Property(property="descricao", type="string", example="Curso de Bacharelado em Direito"),
     *             @OA\Property(property="carga_horaria", type="integer", example=3600),
     *             @OA\Property(property="data_cadastro", type="string", format="date", example="2024-01-01")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Curso atualizado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Curso")
     *     ),
     *     @OA\Response(response=404, description="Curso não encontrado"),
     *     @OA\Response(response=400, description="Erro na validação")
     * )
     */
    public function update(UpdateCursoRequest $request, int $id): JsonResponse
    {
        try {
            $dto = CursoDTO::fromArray($request->validated());
            $result = $this->service->editar($id, $dto);
            
            if (!$result) {
                return response()->json(['message' => 'Curso não encontrado.'], 404);
            }

            $curso = $this->service->buscarPorId($id);
            return response()->json($curso);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/cursos/{id}",
     *     summary="Excluir curso",
     *     tags={"Cursos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Curso excluído com sucesso"
     *     ),
     *     @OA\Response(response=400, description="Não é possível excluir curso com alunos matriculados")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->service->excluir($id);
        
        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 400);
        }

        return response()->json(['message' => $result['message']]);
    }
}

