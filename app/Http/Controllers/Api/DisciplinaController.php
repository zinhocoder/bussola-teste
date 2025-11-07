<?php

namespace App\Http\Controllers\Api;

use App\DTOs\DisciplinaDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDisciplinaRequest;
use App\Http\Requests\UpdateDisciplinaRequest;
use App\Services\DisciplinaService;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Disciplinas",
 *     description="Operações relacionadas a disciplinas"
 * )
 */
class DisciplinaController extends Controller
{
    public function __construct(
        private DisciplinaService $service
    ) {}

    /**
     * @OA\Get(
     *     path="/api/disciplinas",
     *     summary="Listar todas as disciplinas",
     *     tags={"Disciplinas"},
     *     @OA\Response(response=200, description="Lista de disciplinas")
     * )
     */
    public function index(): JsonResponse
    {
        $disciplinas = $this->service->listarTodas();
        return response()->json($disciplinas);
    }

    /**
     * @OA\Get(
     *     path="/api/disciplinas/curso/{cursoId}",
     *     summary="Listar disciplinas por curso",
     *     tags={"Disciplinas"},
     *     @OA\Parameter(
     *         name="cursoId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Lista de disciplinas do curso")
     * )
     */
    public function porCurso(int $cursoId): JsonResponse
    {
        $disciplinas = $this->service->listarPorCurso($cursoId);
        return response()->json($disciplinas);
    }

    /**
     * @OA\Get(
     *     path="/api/disciplinas/{id}",
     *     summary="Buscar disciplina por ID",
     *     tags={"Disciplinas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Dados da disciplina"),
     *     @OA\Response(response=404, description="Disciplina não encontrada")
     * )
     */
    public function show(int $id): JsonResponse
    {
        $disciplina = $this->service->buscarPorId($id);
        
        if (!$disciplina) {
            return response()->json(['message' => 'Disciplina não encontrada.'], 404);
        }

        return response()->json($disciplina);
    }

    /**
     * @OA\Post(
     *     path="/api/disciplinas",
     *     summary="Cadastrar disciplina em um curso",
     *     tags={"Disciplinas"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nome", "carga_horaria", "cursos"},
     *             @OA\Property(property="nome", type="string", example="Matemática"),
     *             @OA\Property(property="descricao", type="string", example="Disciplina de matemática básica"),
     *             @OA\Property(property="carga_horaria", type="integer", example=60),
     *             @OA\Property(property="cursos", type="array", @OA\Items(type="integer"), example={1, 2}, description="IDs dos cursos (mínimo 2)")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Disciplina criada com sucesso"),
     *     @OA\Response(response=400, description="Erro na validação")
     * )
     */
    public function store(StoreDisciplinaRequest $request): JsonResponse
    {
        try {
            $dto = DisciplinaDTO::fromArray($request->validated());
            $disciplina = $this->service->cadastrar($dto);
            
            return response()->json($disciplina, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/disciplinas/{id}",
     *     summary="Editar disciplina",
     *     tags={"Disciplinas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nome", type="string", example="Matemática"),
     *             @OA\Property(property="descricao", type="string", example="Disciplina de matemática básica"),
     *             @OA\Property(property="carga_horaria", type="integer", example=60),
     *             @OA\Property(property="cursos", type="array", @OA\Items(type="integer"), example={1, 2}, description="IDs dos cursos (mínimo 2)")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Disciplina atualizada com sucesso"),
     *     @OA\Response(response=404, description="Disciplina não encontrada"),
     *     @OA\Response(response=400, description="Erro na validação")
     * )
     */
    public function update(UpdateDisciplinaRequest $request, int $id): JsonResponse
    {
        try {
            $dto = DisciplinaDTO::fromArray($request->validated());
            $result = $this->service->editar($id, $dto);
            
            if (!$result) {
                return response()->json(['message' => 'Disciplina não encontrada.'], 404);
            }

            $disciplina = $this->service->buscarPorId($id);
            return response()->json($disciplina);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/disciplinas/{id}",
     *     summary="Excluir disciplina",
     *     tags={"Disciplinas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Disciplina excluída com sucesso"),
     *     @OA\Response(response=404, description="Disciplina não encontrada")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->service->excluir($id);
        
        if (!$result) {
            return response()->json(['message' => 'Disciplina não encontrada.'], 404);
        }

        return response()->json(['message' => 'Disciplina excluída com sucesso.']);
    }
}

