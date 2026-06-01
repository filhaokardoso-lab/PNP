@extends('layouts.admin')

@section('content')
<main>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        :root {
            --primary-color: #c41e3a;
            --primary-dark: #8b0000;
            --background-color: #f5e6d3;
            --text-color: #2c1810;
            --hover-color: #d64d4d;
            --surface: #ffffff;
        }

        body {
            background-color: var(--background-color);
            font-family: Arial, sans-serif;
        }

        .page-title {
            text-align: center;
            color: var(--primary-color);
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .page-subtitle {
            text-align: center;
            color: #4b5563;
            margin-bottom: 2rem;
        }

        .card-custom {
            background: var(--surface);
            border-radius: 15px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .card-header-custom {
            background: var(--primary-color);
            color: white;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .search-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
            align-items: end;
        }

        .search-form label {
            display: block;
            margin-bottom: 0.4rem;
            font-weight: 600;
            color: #374151;
        }

        .search-form input {
            width: 100%;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            padding: 0.8rem 1rem;
            background: #f8fafc;
            color: #111827;
        }

        .btn-custom {
            border-radius: 8px;
            padding: 0.6rem 1rem;
            font-size: 0.95rem;
            font-weight: 700;
        }

        .btn-search {
            background: #111827;
            color: #fff;
            border: none;
        }

        .btn-reset,
        .btn-new {
            border: none;
            color: #fff;
        }

        .btn-reset {
            background: #6b7280;
        }

        .btn-new {
            background: #10b981;
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .table-custom th,
        .table-custom td {
            padding: 14px 16px;
            text-align: center;
        }

        .table-custom thead {
            background: var(--primary-dark);
            color: white;
        }

        .table-custom tbody tr:nth-child(even) {
            background: #f8f1ef;
        }

        .table-custom tbody tr:hover {
            background: #f1d7cf;
        }

        .img-thumb {
            max-width: 90px;
            max-height: 70px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #d1d5db;
        }

        .badge {
            display: inline-block;
            padding: 0.35rem 0.7rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .badge-active {
            background: #10b981;
            color: #fff;
        }

        .badge-inactive {
            background: #ef4444;
            color: #fff;
        }

        .pagination-links {
            display: flex;
            justify-content: flex-end;
            padding: 1rem;
        }
    </style>

    <section class="card-custom">
        <div class="card-header-custom">
            <div>
                <h1 class="page-title">Consulta de Patrimônios</h1>
                <p class="page-subtitle">Filtre e visualize os ativos cadastrados no sistema.</p>
            </div>
            <div>
                @can('create-patrimonio')
                    <a href="{{ route('patrimonios.create') }}" class="btn btn-new btn-custom"><i class='bx bx-plus'></i> Novo</a>
                @endcan
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('patrimonios.index') }}" method="GET" class="search-form">
                <div>
                    <label for="codigo">Código</label>
                    <input type="text" name="codigo" id="codigo" value="{{ request('codigo') }}" placeholder="000123">
                </div>
                <div>
                    <label for="descricao">Descrição</label>
                    <input type="text" name="descricao" id="descricao" value="{{ request('descricao') }}" placeholder="Computador Desktop">
                </div>
                <div>
                    <label for="marca">Marca</label>
                    <input type="text" name="marca" id="marca" value="{{ request('marca') }}" placeholder="Dell">
                </div>
                <div class="d-flex" style="gap: 0.75rem; align-items: center;">
                    <button type="submit" class="btn btn-search btn-custom"><i class='bx bx-search-alt-2'></i> Pesquisar</button>
                    <a href="{{ route('patrimonios.index') }}" class="btn btn-reset btn-custom"><i class='bx bx-reset'></i> Limpar</a>
                </div>
            </form>

            <x-alert />

            <table class="table-custom">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Marca</th>
                        <th>Setor</th>
                        <th>Situação</th>
                        <th>Imagem</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($patrimonios as $patrimonio)
                        <tr>
                            <td>{{ $patrimonio->codigo }}</td>
                            <td>{{ $patrimonio->descricao }}</td>
                            <td>{{ $patrimonio->categoria }}</td>
                            <td>{{ $patrimonio->marca ?? '-' }}</td>
                            <td>{{ $patrimonio->setor_localizacao ?? '-' }}</td>
                            <td>
                                @if ($patrimonio->situacao === 'Ativo')
                                    <span class="badge badge-active">Ativo</span>
                                @else
                                    <span class="badge badge-inactive">Inativo</span>
                                @endif
                            </td>
                            <td>
                                @if ($patrimonio->imagem)
                                    <img src="{{ asset('uploads/patrimonios/' . $patrimonio->imagem) }}" alt="Imagem do patrimônio" class="img-thumb">
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; justify-content: center; gap: 0.35rem; flex-wrap: wrap;">
                                    @can('edit-patrimonio')
                                        <a href="{{ route('patrimonios.edit', ['patrimonio' => $patrimonio->id]) }}" class="btn btn-primary btn-sm">Editar</a>
                                    @endcan
                                    @can('destroy-patrimonio')
                                        <form action="{{ route('patrimonios.destroy', ['patrimonio' => $patrimonio->id]) }}" method="POST" onsubmit="return confirm('Deseja excluir este patrimônio?');" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">Nenhum patrimônio encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination-links">
                {{ $patrimonios->links() }}
            </div>
        </div>
    </section>
</main>
@endsection
