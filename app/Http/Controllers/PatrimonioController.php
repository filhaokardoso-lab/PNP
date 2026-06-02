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

        $filename = 'inventario_' . now()->format('Ymd_His') . '.xls';
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($patrimonios) {
            echo '<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo '<style>';
            echo '.title { font-size:18px; font-weight:bold; padding-bottom:10px; }';
            echo '.header { background-color:#4F81BD; color:#ffffff; font-weight:bold; text-align:left; }';
            echo '.cell { border:1px solid #d9d9d9; padding:6px; vertical-align:top; }';
            echo '.row-even { background-color:#f2f2f2; }';
            echo '</style></head><body>';
            echo '<table border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; width:100%;">';
            echo '<tr><td colspan="10" class="title">Inventário de Patrimônio</td></tr>';
            echo '<tr><td colspan="10" style="padding-bottom:12px;">Exportado em: ' . now()->format('d/m/Y H:i:s') . '</td></tr>';
            echo '</table>';
            echo '<table border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; width:100%;">';
            echo '<tr class="header">';
            echo '<th class="cell">Código</th>';
            echo '<th class="cell">Descrição</th>';
            echo '<th class="cell">Categoria</th>';
            echo '<th class="cell">Marca</th>';
            echo '<th class="cell">Modelo</th>';
            echo '<th class="cell">Número de Série</th>';
            echo '<th class="cell">Data de Aquisição</th>';
            echo '<th class="cell">Valor de Aquisição</th>';
            echo '<th class="cell">Setor / Localização</th>';
            echo '<th class="cell">Situação</th>';
            echo '</tr>';

            foreach ($patrimonios as $index => $patrimonio) {
                $rowClass = $index % 2 === 0 ? 'row-even' : '';
                echo '<tr class="' . $rowClass . '">';
                echo '<td class="cell">' . e($patrimonio->codigo) . '</td>';
                echo '<td class="cell">' . e($patrimonio->descricao) . '</td>';
                echo '<td class="cell">' . e($patrimonio->categoria) . '</td>';
                echo '<td class="cell">' . e($patrimonio->marca) . '</td>';
                echo '<td class="cell">' . e($patrimonio->modelo) . '</td>';
                echo '<td class="cell">' . e($patrimonio->numero_serie) . '</td>';
                echo '<td class="cell" style="mso-number-format:\'dd\/mm\/yyyy\';">' . optional($patrimonio->data_aquisicao)->format('d/m/Y') . '</td>';
                echo '<td class="cell" style="mso-number-format:\'R\$ #,##0.00\'; text-align:right;">' . number_format($patrimonio->valor_aquisicao, 2, ',', '.') . '</td>';
                echo '<td class="cell">' . e($patrimonio->setor_localizacao) . '</td>';
                echo '<td class="cell">' . e($patrimonio->situacao) . '</td>';
                echo '</tr>';
            }

            echo '</table></body></html>';
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
