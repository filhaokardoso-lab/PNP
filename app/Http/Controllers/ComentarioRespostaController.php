<?php

namespace App\Http\Controllers;

use App\Models\ComentarioResposta;
use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioRespostaController extends Controller
{
    /**
     * Armazenar nova resposta
     */
    public function store(Request $request, Comentario $comentario)
    {
        // Validação
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'resposta' => 'required|string|min:5|max:500',
            'anonimo' => 'nullable|boolean',
        ], [
            'nome.required' => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ser válido.',
            'resposta.required' => 'A resposta é obrigatória.',
            'resposta.min' => 'A resposta deve ter no mínimo 5 caracteres.',
            'resposta.max' => 'A resposta não pode exceder 500 caracteres.',
        ]);

        // Criar resposta
        ComentarioResposta::create([
            'comentario_id' => $comentario->id,
            'nome' => $validated['nome'],
            'email' => $validated['email'],
            'resposta' => $validated['resposta'],
            'anonimo' => $validated['anonimo'] ?? false,
            'user_id' => auth()->id(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Se for AJAX, retornar JSON
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Resposta adicionada com sucesso!',
                'total_respostas' => $comentario->respostas()->count(),
            ], 201);
        }

        return redirect()->back()->with('success', 'Resposta enviada com sucesso! ✅');
    }

    /**
     * Listar respostas de um comentário
     */
    public function index(Comentario $comentario)
    {
        $respostas = $comentario->respostas()->get();

        return response()->json($respostas);
    }

    /**
     * Deletar resposta
     */
    public function destroy(ComentarioResposta $resposta)
    {
        // Verificar permissão
        if ($resposta->user_id !== auth()->id() && !auth()->user()?->hasPermissionTo('destroy-comentario')) {
            abort(403, 'Não autorizado.');
        }

        $comentarioId = $resposta->comentario_id;
        $resposta->delete();

        return redirect()->back()->with('success', 'Resposta deletada com sucesso! 🗑️');
    }
}
