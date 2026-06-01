@extends('layouts.admin')

@section('content')
<main>
    <style>
        :root {
            --primary: #c41e3a;
            --primary-dark: #8b0000;
            --background: #f4f4f4;
            --surface: #ffffff;
            --text: #1f2937;
            --border: #e5e7eb;
        }

        body {
            background: var(--background);
        }

        .inventory-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .inventory-title {
            margin: 0;
            color: var(--primary);
            font-size: 2rem;
            font-weight: 700;
        }

        .inventory-subtitle {
            color: #4b5563;
            margin: 0.25rem 0 0;
        }

        .inventory-card {
            background: var(--surface);
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            padding: 1.5rem;
            border: 1px solid rgba(156, 163, 175, 0.18);
        }

        .inventory-filter {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.25rem;
            align-items: end;
        }

        .inventory-filter label {
            display: block;
            margin-bottom: 0.4rem;
            font-size: 0.9rem;
            color: #374151;
            font-weight: 600;
        }

        .inventory-filter select {
            width: 100%;
            padding: 0.85rem 1rem;
            border-radius: 0.75rem;
            border: 1px solid var(--border);
            background: #fff;
            color: var(--text);
            font-size: 0.95rem;
        }

        .btn-inventory {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border: none;
            border-radius: 0.75rem;
            padding: 0.85rem 1.2rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
        }

        .btn-primary:hover {
            background: #a9192f;
        }

        .btn-secondary {
            background: #fff;
            color: var(--text);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: #f8fafc;
        }

        .inventory-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            justify-content: flex-end;
            margin-bottom: 1rem;
        }

        .inventory-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 100%;
        }

        .inventory-table th,
        .inventory-table td {
            padding: 1rem 0.85rem;
            text-align: left;
            border-bottom: 1px solid rgba(229, 231, 235, 0.9);
            vertical-align: middle;
            font-size: 0.95rem;
        }

        .inventory-table thead {
            background: var(--primary);
            color: #fff;
        }

        .inventory-table th {
            font-weight: 700;
        }

        .inventory-table tbody tr:hover {
            background: #f8fafc;
        }

        .inventory-table img {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 0.75rem;
            border: 1px solid var(--border);
        }

        .inventory-checkbox,
        .inventory-observation {
            width: 100%;
        }

        .inventory-observation {
            min-width: 180px;
            padding: 0.5rem 0.8rem;
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            resize: vertical;
            font-size: 0.95rem;
        }

        .table-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 1rem;
        }

        .inventory-pagination {
            display: flex;
            justify-content: flex-end;
            margin-top: 1rem;
        }
    </style>

    <section class="inventory-card">
        <div class="inventory-header">
            <div>
                <h1 class="inventory-title">Inventário de Patrimônios</h1>
                <p class="inventory-subtitle">Filtre por setor/localização e situação para gerar o inventário do dia.</p>
            </div>
            <div class="inventory-actions">
                <a href="{{ route('patrimonios.inventory.export', request()->query()) }}" class="btn-inventory btn-secondary">Exportar Excel</a>
                <form action="{{ route('patrimonios.inventory.finalize') }}" method="POST" style="display:inline;">
                    @csrf
                    <input type="hidden" name="setor_localizacao" value="{{ request('setor_localizacao') }}">
                    <input type="hidden" name="situacao" value="{{ request('situacao') }}">
                    <button type="submit" class="btn-inventory btn-primary">Finalizar inventário</button>
                </form>
            </div>
        </div>

        <form action="{{ route('patrimonios.inventory') }}" method="GET" class="inventory-filter">
            <div>
                <label for="setor_localizacao">Setor / Localização</label>
                <select name="setor_localizacao" id="setor_localizacao">
                    <option value="">Todos</option>
                    @foreach($setores as $setor)
                        <option value="{{ $setor }}" {{ request('setor_localizacao') === $setor ? 'selected' : '' }}>{{ $setor }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="situacao">Situação</label>
                <select name="situacao" id="situacao">
                    <option value="">Todas</option>
                    <option value="Ativo" {{ request('situacao') === 'Ativo' ? 'selected' : '' }}>Ativo</option>
                    <option value="Inativo" {{ request('situacao') === 'Inativo' ? 'selected' : '' }}>Inativo</option>
                </select>
            </div>

            <div style="display:flex; align-items:flex-end;">
                <button type="submit" class="btn-inventory btn-primary">Gerar Inventário</button>
            </div>
        </form>

        <x-alert />

        <div class="table-responsive">
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descrição</th>
                        <th>Setor</th>
                        <th>Situação</th>
                        <th>Imagem</th>
                        <th>Conferido</th>
                        <th>Observação</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patrimonios as $patrimonio)
                        <tr>
                            <td>{{ $patrimonio->codigo }}</td>
                            <td>{{ $patrimonio->descricao }}</td>
                            <td>{{ $patrimonio->setor_localizacao ?? '-' }}</td>
                            <td>{{ $patrimonio->situacao }}</td>
                            <td>
                                @if($patrimonio->imagem)
                                    <img src="{{ asset('uploads/patrimonios/' . $patrimonio->imagem) }}" alt="Imagem do patrimônio">
                                @else
                                    -
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <input type="checkbox" class="inventory-checkbox" name="conferido[{{ $patrimonio->id }}]" value="1">
                            </td>
                            <td>
                                <textarea class="inventory-observation" name="observacao[{{ $patrimonio->id }}]" rows="2" placeholder="Observação"></textarea>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 2rem 0;">Nenhum patrimônio encontrado para o inventário.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="inventory-pagination">
            {{ $patrimonios->links() }}
        </div>
    </section>
</main>
@endsection
