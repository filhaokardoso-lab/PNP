<?php

namespace App\Http\Controllers;

use App\Models\Patrimonio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PatrimonioController extends Controller
{
    public function index(Request $request)
    {
        $patrimonios = Patrimonio::when($request->filled('codigo'), function ($query) use ($request) {
            $query->where('codigo', 'like', '%' . $request->codigo . '%');
        })
        ->when($request->filled('descricao'), function ($query) use ($request) {
            $query->where('descricao', 'like', '%' . $request->descricao . '%');
        })
        ->when($request->filled('marca'), function ($query) use ($request) {
            $query->where('marca', 'like', '%' . $request->marca . '%');
        })
        ->orderBy('id')
        ->paginate(10)
        ->withQueryString();

        return view('patrimonios.index', compact('patrimonios'));
    }

    public function inventory(Request $request)
    {
        $setores = Patrimonio::select('setor_localizacao')
            ->distinct()
            ->whereNotNull('setor_localizacao')
            ->where('setor_localizacao', '<>', '')
            ->orderBy('setor_localizacao')
            ->pluck('setor_localizacao');

        $patrimonios = Patrimonio::when($request->filled('setor_localizacao'), function ($query) use ($request) {
            $query->where('setor_localizacao', $request->setor_localizacao);
        })
        ->when($request->filled('situacao'), function ($query) use ($request) {
            $query->where('situacao', $request->situacao);
        })
        ->orderBy('id')
        ->paginate(15)
        ->withQueryString();

        return view('patrimonios.inventory', compact('patrimonios', 'setores'));
    }

    public function exportInventory(Request $request)
    {
        $patrimonios = Patrimonio::when($request->filled('setor_localizacao'), function ($query) use ($request) {
            $query->where('setor_localizacao', $request->setor_localizacao);
        })
        ->when($request->filled('situacao'), function ($query) use ($request) {
            $query->where('situacao', $request->situacao);
        })
        ->orderBy('id')
        ->get();

        $filename = 'inventario_' . now()->format('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $columns = ['Código', 'Descrição', 'Categoria', 'Marca', 'Modelo', 'Número de Série', 'Data de Aquisição', 'Valor de Aquisição', 'Setor / Localização', 'Situação'];

        $callback = function () use ($patrimonios, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($patrimonios as $patrimonio) {
                fputcsv($file, [
                    $patrimonio->codigo,
                    $patrimonio->descricao,
                    $patrimonio->categoria,
                    $patrimonio->marca,
                    $patrimonio->modelo,
                    $patrimonio->numero_serie,
                    optional($patrimonio->data_aquisicao)->format('Y-m-d'),
                    number_format($patrimonio->valor_aquisicao, 2, ',', '.'),
                    $patrimonio->setor_localizacao,
                    $patrimonio->situacao,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function finalizeInventory(Request $request)
    {
        return redirect()->route('patrimonios.inventory', $request->only('setor_localizacao', 'situacao'))
            ->with('success', 'Inventário finalizado com sucesso!');
    }

    public function create()
    {
        return view('patrimonios.create');
    }

    public function edit(Patrimonio $patrimonio)
    {
        return view('patrimonios.edit', compact('patrimonio'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:100',
            'descricao' => 'required|string|max:255',
            'categoria' => 'required|string|max:100',
            'marca' => 'nullable|string|max:100',
            'modelo' => 'nullable|string|max:100',
            'numero_serie' => 'nullable|string|max:150',
            'data_aquisicao' => 'required|date',
            'valor_aquisicao' => 'required|numeric|min:0',
            'setor_localizacao' => 'nullable|string|max:150',
            'situacao' => 'required|string|in:Ativo,Inativo',
            'imagem' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $filename = null;

        if ($request->hasFile('imagem')) {
            $uploadPath = public_path('uploads/patrimonios');
            if (! File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            $filename = time() . '-' . Str::slug($request->codigo ?? 'patrimonio') . '.' . $request->imagem->extension();
            $request->imagem->move($uploadPath, $filename);
        }

        Patrimonio::create([
            'codigo' => $request->codigo,
            'descricao' => $request->descricao,
            'categoria' => $request->categoria,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'numero_serie' => $request->numero_serie,
            'data_aquisicao' => $request->data_aquisicao,
            'valor_aquisicao' => $request->valor_aquisicao,
            'setor_localizacao' => $request->setor_localizacao,
            'situacao' => $request->situacao,
            'imagem' => $filename,
        ]);

        return redirect()->route('patrimonios.create')->with('success', 'Patrimônio cadastrado com sucesso!');
    }

    public function update(Request $request, Patrimonio $patrimonio)
    {
        $request->validate([
            'codigo' => 'required|string|max:100|unique:patrimonios,codigo,' . $patrimonio->id,
            'descricao' => 'required|string|max:255',
            'categoria' => 'required|string|max:100',
            'marca' => 'nullable|string|max:100',
            'modelo' => 'nullable|string|max:100',
            'numero_serie' => 'nullable|string|max:150',
            'data_aquisicao' => 'required|date',
            'valor_aquisicao' => 'required|numeric|min:0',
            'setor_localizacao' => 'nullable|string|max:150',
            'situacao' => 'required|string|in:Ativo,Inativo',
            'imagem' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('imagem')) {
            $uploadPath = public_path('uploads/patrimonios');
            if (! File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            if ($patrimonio->imagem && File::exists($uploadPath . '/' . $patrimonio->imagem)) {
                File::delete($uploadPath . '/' . $patrimonio->imagem);
            }

            $filename = time() . '-' . Str::slug($request->codigo ?? 'patrimonio') . '.' . $request->imagem->extension();
            $request->imagem->move($uploadPath, $filename);
        } else {
            $filename = $patrimonio->imagem;
        }

        $patrimonio->update([
            'codigo' => $request->codigo,
            'descricao' => $request->descricao,
            'categoria' => $request->categoria,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'numero_serie' => $request->numero_serie,
            'data_aquisicao' => $request->data_aquisicao,
            'valor_aquisicao' => $request->valor_aquisicao,
            'setor_localizacao' => $request->setor_localizacao,
            'situacao' => $request->situacao,
            'imagem' => $filename,
        ]);

        return redirect()->route('patrimonios.index')->with('success', 'Patrimônio atualizado com sucesso!');
    }

    public function destroy(Patrimonio $patrimonio)
    {
        $uploadPath = public_path('uploads/patrimonios');
        if ($patrimonio->imagem && File::exists($uploadPath . '/' . $patrimonio->imagem)) {
            File::delete($uploadPath . '/' . $patrimonio->imagem);
        }

        $patrimonio->delete();

        return redirect()->route('patrimonios.index')->with('success', 'Patrimônio excluído com sucesso!');
    }
}
