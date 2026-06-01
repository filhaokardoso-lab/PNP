<?php

namespace App\Http\Controllers;

use App\Models\Foto; // Boa prática: usar o nome correto da classe (PascalCase)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // Importa o Facade para manipulação de arquivos

class FotoController extends Controller
{
    /**
     * Exibe a página de upload para administradores.
     */
    public function create()
    {
        $fotos = Foto::latest()->get();
        return view('admin.fotos-upload', compact('fotos'));
    }

    /**
     * Exibe a lista de todas as fotos.
     */
    public function index(Request $request)
    {
        $category = $request->get('category', null);
        $search = $request->get('search', null);
        
        $fotos = Foto::when($category, function ($query) use ($category) {
            return $query->where('category', $category);
        })
        ->when($search, function ($query) use ($search) {
            return $query->where('description', 'like', '%' . $search . '%');
        })
        ->latest()
        ->get();
        
        $categories = Foto::$categories ?? [
            'geral' => 'Geral',
            'apresentacoes' => 'Apresentações',
            'danca' => 'Dança',
            'musica' => 'Música',
            'poesia' => 'Poesia',
            'artes-visuais' => 'Artes Visuais',
            'bastidores' => 'Bastidores',
            'publico' => 'Público',
        ];
        
        return view('user.galeria', compact('fotos', 'categories', 'category', 'search'));
    }

    /**
     * Armazena uma nova foto no sistema de arquivos e no banco de dados.
     */
    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $request->validate([
            'categoria' => 'required|in:' . implode(',', array_keys(Foto::$categories)),
            'descricao' => 'nullable|string|max:255',
        ], [
            'categoria.required' => 'Selecione uma categoria',
            'categoria.in' => 'Categoria inválida',
        ]);

        // Gera um nome de arquivo único
        $filename = time() . '.' . $request->foto->extension();
        
        // Move o arquivo para o diretório public/uploads/fotos
        $request->foto->move(public_path('uploads/fotos'), $filename);

        // Cria o registro no banco de dados
        Foto::create([
            'filename' => $filename,
            'category' => $request->categoria,
            'description' => $request->descricao,
        ]);

        return redirect()->back()->with('success', 'Foto adicionada com sucesso!');
    }

    
    public function destroy($id) 
{
    // 1. Encontra a foto no banco de dados
    $foto = \App\Models\Foto::findOrFail($id);
    
    $path = public_path('uploads/fotos/' . $foto->filename);
    
    // 2. Tenta deletar o arquivo, com uma verificação de segurança (is_file)
    if (File::exists($path) && is_file($path)) {
         File::delete($path);
    }
    
    // 3. Deleta o registro no banco de dados
    $foto->delete(); 
    
    return redirect()->back()->with('success', 'Foto excluída com sucesso!');

}
}