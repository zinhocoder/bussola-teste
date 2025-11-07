<?php

namespace App\Http\Controllers\Api;

use App\DTOs\MatriculaDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMatriculaRequest;
use App\Services\MatriculaService;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Matrículas",
 *     description="Operações relacionadas a matrículas"
 * )
 */
class MatriculaController extends Controller
{
    public function __construct(
        private MatriculaService $service
    ) {}

    /**
     * @OA\Get(
     *     path="/api/matriculas",
     *     summary="Listar todas as matrículas",
     *     tags={"Matrículas"},
     *     @OA\Response(response=200, description="Lista de matrículas")
     * )
     */
    public function index(): JsonResponse
    {
        $matriculas = $this->service->listarTodas();
        return response()->json($matriculas);
    }

    /**
     * @OA\Get(
     *     path="/api/matriculas/{id}",
     *     summary="Buscar matrícula por ID",
     *     tags={"Matrículas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Dados da matrícula"),
     *     @OA\Response(response=404, description="Matrícula não encontrada")
     * )
     */
    public function show(int $id): JsonResponse
    {
        $matricula = $this->service->buscarPorId($id);
        
        if (!$matricula) {
            return response()->json(['message' => 'Matrícula não encontrada.'], 404);
        }

        return response()->json($matricula);
    }

    /**
     * @OA\Post(
     *     path="/api/matriculas",
     *     summary="Realizar matrícula de um aluno em um curso",
     *     tags={"Matrículas"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"aluno_id", "curso_id"},
     *             @OA\Property(property="aluno_id", type="integer", example=1),
     *             @OA\Property(property="curso_id", type="integer", example=1),
     *             @OA\Property(property="data_matricula", type="string", format="date", example="2024-01-15", description="Data da matrícula (opcional, padrão: hoje)")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Matrícula realizada com sucesso. E-mail de confirmação enviado."),
     *     @OA\Response(response=400, description="Erro na validação")
     * )
     */
    public function store(StoreMatriculaRequest $request): JsonResponse
    {
        try {
            $dto = MatriculaDTO::fromArray($request->validated());
            $matricula = $this->service->realizarMatricula($dto);
            
            return response()->json($matricula, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/matriculas/{id}/trancar",
     *     summary="Trancar matrícula de um aluno em um curso",
     *     tags={"Matrículas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Matrícula trancada com sucesso"),
     *     @OA\Response(response=404, description="Matrícula não encontrada")
     * )
     */
    public function trancar(int $id): JsonResponse
    {
        $result = $this->service->trancarMatricula($id);
        
        if (!$result) {
            return response()->json(['message' => 'Matrícula não encontrada.'], 404);
        }

        return response()->json(['message' => 'Matrícula trancada com sucesso.']);
    }
}

