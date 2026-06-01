<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    /**
     * Exibir página de comentários
     */
    public function index()
    {
        $comentarios = Comentario::active()->ordenado()->get();
        
        return view('user.comentarios', compact('comentarios'));
    }

    /**
     * Armazenar novo comentário
     */
    public function store(Request $request)
    {
        // Validação
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'categoria' => 'required|in:sugestao,elogio,critica,duvida,outro',
            'comentario' => 'required|string|min:10|max:1000',
            'anonimo' => 'nullable|boolean',
        ], [
            'nome.required' => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ser válido.',
            'categoria.required' => 'A categoria é obrigatória.',
            'categoria.in' => 'A categoria selecionada é inválida.',
            'comentario.required' => 'O comentário é obrigatório.',
            'comentario.min' => 'O comentário deve ter no mínimo 10 caracteres.',
            'comentario.max' => 'O comentário não pode exceder 1000 caracteres.',
        ]);

        // Criar comentário
        Comentario::create([
            'nome' => $validated['nome'],
            'email' => $validated['email'],
            'categoria' => $validated['categoria'],
            'comentario' => $validated['comentario'],
            'anonimo' => $validated['anonimo'] ?? false,
            'user_id' => auth()->id(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('user.comentarios')
                        ->with('success', 'Obrigado pelo seu comentário! ✅');
    }

    /**
     * Deletar comentário
     */
    public function destroy(Comentario $comentario)
    {
        // Verificar permissão
        if ($comentario->user_id !== auth()->id() && !auth()->user()->hasPermissionTo('destroy-comentario')) {
            abort(403, 'Não autorizado.');
        }

        $comentario->delete();

        return redirect()->back()
                        ->with('success', 'Comentário deletado com sucesso! 🗑️');
    }

    /**
     * Listar comentários por categoria (API)
     */
    public function porCategoria($categoria)
    {
        $comentarios = Comentario::active()
                                 ->porCategoria($categoria)
                                 ->ordenado()
                                 ->get();

        return response()->json($comentarios);
    }

    /**
     * Obter estatísticas de comentários
     */
    public function estatisticas()
    {
        $total = Comentario::active()->count();
        $porCategoria = Comentario::active()
                                  ->selectRaw('categoria, count(*) as total')
                                  ->groupBy('categoria')
                                  ->get();

        return response()->json([
            'total' => $total,
            'por_categoria' => $porCategoria,
        ]);
    }
}
