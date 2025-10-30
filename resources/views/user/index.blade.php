@extends('layouts.admin')

@section('content')
<main>
    {{-- Boxicons para ícones --}}
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        :root {
            --primary-color: #c41e3a;
            --primary-dark: #8b0000;
            --background-color: #f5e6d3;
            --text-color: #2c1810;
            --hover-color: #d64d4d;
        }

        body {
            background-color: var(--background-color);
            font-family: Arial, sans-serif;
        }

        .page-title {
            text-align: center;
            color: var(--primary-color);
            font-size: 2rem;
            margin-bottom: 1.5rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }

        .card-custom {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .card-header-custom {
            background: var(--primary-color);
            color: white;
            padding: 1rem 1.5rem;
            font-size: 1.2rem;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-custom {
            border-radius: 8px;
            padding: 0.4rem 0.8rem;
            font-size: 0.9rem;
        }

        .btn-custom i {
            margin-right: 5px;
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .table-custom thead {
            background: var(--primary-dark);
            color: white;
        }

        .table-custom th, .table-custom td {
            padding: 12px 15px;
            text-align: center;
        }

        .table-custom tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table-custom tbody tr:hover {
            background-color: #f1d7cf;
            transition: 0.3s;
        }

        .search-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
        }
    </style>

    <h1 class="page-title">Gestão de Usuários</h1>

    {{-- Card Pesquisa --}}
    <div class="card-custom">
        <div class="card-header-custom">
            <span><i class='bx bx-search'></i> Pesquisar</span>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('user.index') }}" class="search-form">
                <div>
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" name="name" id="name" value="{{ request('name') }}"
                           class="form-control" placeholder="Nome do usuário">
                </div>
                <div>
                    <label for="email" class="form-label">E-mail</label>
                    <input type="text" name="email" id="email" value="{{ request('email') }}"
                           class="form-control" placeholder="E-mail do usuário">
                </div>
                <div class="d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-info btn-custom"><i class='bx bx-search-alt-2'></i> Pesquisar</button>
                    <a href="{{ route('user.index') }}" class="btn btn-warning btn-custom"><i class='bx bx-reset'></i> Limpar</a>
                    <a href="{{ url('generate-pdf-user?' . request()->getQueryString() ) }}" class="btn btn-danger btn-custom"><i class="fa-regular fa-file-pdf"></i> PDF</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Card Lista Usuários --}}
    <div class="card-custom">
        <div class="card-header-custom">
            <span><i class='bx bx-group'></i> Lista de Usuários</span>
            <span>
                <a href="{{ route('user.generate-pdf')}}" class="btn btn-warning btn-custom"><i class="fa-regular fa-file-pdf"></i> PDF</a>
                @can('edit-user')
                <a href="{{ route('user.create') }}" class="btn btn-success btn-custom"><i class='bx bx-plus'></i> Novo Usuário</a>
                @endcan
            </span>
        </div>

        <div class="card-body p-0">
            <x-alert />

            <table class="table-custom">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Perfil</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @forelse ($user->getRoleNames() as $role)
                                    <span class="badge bg-secondary">{{ $role }}</span>
                                @empty
                                    <span class="badge bg-light text-muted">Sem perfil</span>
                                @endforelse
                            </td>
                            <td>
                                @can('show-user')
                                <a href="{{ route('user.show', ['user' => $user->id]) }}" class="btn btn-primary btn-sm">Visualizar</a>
                                @endcan
                                @can('edit-user')
                                <a href="{{ route('user.edit', ['user' => $user->id]) }}" class="btn btn-warning btn-sm">Editar</a>
                                @endcan
                                @can('destroy-user')
                                    <form id="delete-form-{{ $user->id }}"
                                          action="{{ route('user.destroy', ['user' => $user->id]) }}"
                                          method="POST" style="display:inline;">
                                        @csrf
                                        @method('delete')
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete({{ $user->id }})">Apagar</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Nenhum usuário encontrado</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-3">
            {{ $users->links() }}
        </div>
    </div>
</main>
@endsection
