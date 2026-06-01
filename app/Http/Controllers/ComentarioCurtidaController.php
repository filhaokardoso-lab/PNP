<?php

namespace App\Http\Controllers;

use App\Models\ComentarioCurtida;
use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioCurtidaController extends Controller
{
    /**
     * Alternar curtida em um comentário
     */
    public function toggle(Request $request, Comentario $comentario)
    {
        $user = $request->user();
        $ipAddress = $request->ip();

        // Verificar se já existe curtida do usuário ou IP
        $curtidaExistente = $comentario->curtidas()
            ->where(function ($query) use ($user, $ipAddress) {
                if ($user) {
                    $query->where('user_id', $user->id);
                } else {
                    $query->where('ip_address', $ipAddress);
                }
            })
            ->first();

        if ($curtidaExistente) {
            // Remover curtida
            $curtidaExistente->delete();
            $curtida = false;
        } else {
            // Adicionar curtida
            ComentarioCurtida::create([
                'comentario_id' => $comentario->id,
                'user_id' => $user?->id,
                'ip_address' => $ipAddress,
            ]);
            $curtida = true;
        }

        // Se for requisição AJAX, retornar JSON
        if ($request->expectsJson()) {
            return response()->json([
                'curtida' => $curtida,
                'total_curtidas' => $comentario->curtidas()->count(),
            ]);
        }

        return redirect()->back()->with('success', $curtida ? 'Curtido! ❤️' : 'Descurtido ✓');
    }

    /**
     * Obter total de curtidas de um comentário
     */
    public function totalCurtidas(Comentario $comentario)
    {
        return response()->json([
            'total' => $comentario->curtidas()->count(),
        ]);
    }

    /**
     * Verificar se usuário/IP curtiu
     */
    public function usuarioCurtiu(Request $request, Comentario $comentario)
    {
        $user = $request->user();
        $ipAddress = $request->ip();

        $curtiu = $comentario->curtidas()
            ->where(function ($query) use ($user, $ipAddress) {
                if ($user) {
                    $query->where('user_id', $user->id);
                } else {
                    $query->where('ip_address', $ipAddress);
                }
            })
            ->exists();

        return response()->json([
            'curtiu' => $curtiu,
        ]);
    }
}
