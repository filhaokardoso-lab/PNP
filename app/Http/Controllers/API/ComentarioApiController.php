<?php

namespace App\Http\Controllers\Api;

use App\Models\Comentario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ComentarioApiController extends Controller
{
    /**
     * GET /api/comentarios
     * Retorna todos os comentários com paginação
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query('per_page', 15);
        $categoria = $request->query('categoria');

        $query = Comentario::active()->ordenado();

        if ($categoria) {
            $query->porCategoria($categoria);
        }

        $comentarios = $query->paginate($perPage);

        return response()->json($comentarios);
    }

    /**
     * GET /api/comentarios/{id}
     * Retorna um comentário específico
     */
    public function show(Comentario $comentario): JsonResponse
    {
        if ($comentario->deleted_at) {
            return response()->json(['message' => 'Comentário não encontrado'], 404);
        }

        return response()->json($comentario);
    }

    /**
     * GET /api/comentarios/categoria/{categoria}
     * Retorna comentários filtrados por categoria
     */
    public function porCategoria($categoria): JsonResponse
    {
        $categorias_validas = ['sugestao', 'elogio', 'critica', 'duvida', 'outro'];

        if (!in_array($categoria, $categorias_validas)) {
            return response()->json([
                'message' => 'Categoria inválida',
                'categorias_validas' => $categorias_validas
            ], 400);
        }

        $comentarios = Comentario::active()
                                 ->porCategoria($categoria)
                                 ->ordenado()
                                 ->get();

        return response()->json($comentarios);
    }

    /**
     * GET /api/comentarios/stats
     * Retorna estatísticas de comentários
     */
    public function estatisticas(): JsonResponse
    {
        $total = Comentario::active()->count();
        $por_categoria = Comentario::active()
                                  ->selectRaw('categoria, count(*) as total')
                                  ->groupBy('categoria')
                                  ->get()
                                  ->keyBy('categoria');

        $por_mes = Comentario::active()
                            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as mes, count(*) as total')
                            ->groupBy('mes')
                            ->orderBy('mes', 'desc')
                            ->limit(12)
                            ->get();

        return response()->json([
            'total' => $total,
            'por_categoria' => $por_categoria,
            'por_mes' => $por_mes,
            'anonimos' => Comentario::active()->where('anonimo', true)->count(),
        ]);
    }

    /**
     * GET /api/comentarios/recentes/{limit}
     * Retorna os comentários mais recentes
     */
    public function recentes($limit = 5): JsonResponse
    {
        $comentarios = Comentario::active()
                                ->ordenado()
                                ->limit($limit)
                                ->get();

        return response()->json($comentarios);
    }

    /**
     * POST /api/comentarios
     * Criar novo comentário via API
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'categoria' => 'required|in:sugestao,elogio,critica,duvida,outro',
            'comentario' => 'required|string|min:10|max:1000',
            'anonimo' => 'nullable|boolean',
        ]);

        $comentario = Comentario::create([
            'nome' => $validated['nome'],
            'email' => $validated['email'],
            'categoria' => $validated['categoria'],
            'comentario' => $validated['comentario'],
            'anonimo' => $validated['anonimo'] ?? false,
            'user_id' => $request->user()?->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'message' => 'Comentário criado com sucesso',
            'data' => $comentario,
        ], 201);
    }

    /**
     * DELETE /api/comentarios/{id}
     * Deletar um comentário
     */
    public function destroy(Comentario $comentario, Request $request): JsonResponse
    {
        if ($comentario->deleted_at) {
            return response()->json(['message' => 'Comentário já foi deletado'], 404);
        }

        // Verificar permissão
        if ($comentario->user_id !== $request->user()?->id && 
            !$request->user()?->hasPermissionTo('destroy-comentario')) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }

        $comentario->delete();

        return response()->json([
            'message' => 'Comentário deletado com sucesso',
        ]);
    }
}
