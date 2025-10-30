<?php

namespace App\Http\Controllers;

use App\Models\Foto; // Boa prática: usar o nome correto da classe (PascalCase)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // Importa o Facade para manipulação de arquivos

class FotoController extends Controller
{
    /**
     * Exibe a lista de todas as fotos.
     */
    public function index()
    {
        $fotos = Foto::latest()->get();
        return view('fotos.index', compact('fotos'));
    }

    /**
     * Armazena uma nova foto no sistema de arquivos e no banco de dados.
     */
    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Gera um nome de arquivo único
        $filename = time() . '.' . $request->foto->extension();
        
        // Move o arquivo para o diretório public/uploads/fotos
        $request->foto->move(public_path('uploads/fotos'), $filename);

        // Cria o registro no banco de dados
        Foto::create(['filename' => $filename]);

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