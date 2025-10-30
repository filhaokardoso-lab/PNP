@extends('layouts.admin')

@section('content')
<main>
    {{-- CSS direto --}}
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
        }

        .page-title {
            text-align: center;
            color: var(--primary-color);
            font-size: 2.3rem;
            margin-bottom: 0.5rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .description {
            text-align: center;
            color: var(--text-color);
            font-size: 1.1rem;
            margin-bottom: 2rem;
            opacity: 0.8;
        }

        .card-custom {
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            background: #fff;
            padding: 1.5rem;
        }

        .user-photo {
            width: 180px;
            height: 180px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid var(--primary-color);
        }

        .user-info h4 {
            color: var(--primary-color);
            font-weight: bold;
        }

        .badge-role {
            background-color: var(--primary-color) !important;
            font-size: 0.85rem;
        }

        .btn-action {
            border-radius: 8px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-action i {
            font-size: 1rem;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #fff;
        }

        .btn-outline-warning:hover {
            background-color: var(--hover-color);
            border-color: var(--hover-color);
            color: #fff;
        }

        .btn-outline-danger:hover {
            background-color: #b02a37;
            border-color: #b02a37;
            color: #fff;
        }
    </style>

    {{-- Conteúdo --}}
    <h1 class="page-title">Detalhes do Usuário</h1>
    <p class="description">Veja as informações cadastradas do usuário selecionado</p>

    <div class="container" style="max-width: 800px;">
        <div class="card-custom">

            {{-- Ações --}}
            <div class="d-flex justify-content-end gap-2 mb-3">
                <a href="{{ route('user.index') }}" class="btn btn-outline-primary btn-sm btn-action">
                    <i class="bx bx-list-ul"></i> Listar
                </a>
                <a href="{{ route('user.edit', ['user' => $user->id]) }}" class="btn btn-outline-warning btn-sm btn-action">
                    <i class="bx bx-edit-alt"></i> Editar
                </a>
                <form id="delete-form-{{ $user->id }}" 
                      action="{{ route('user.destroy', ['user' => $user->id]) }}" 
                      method="POST" 
                      class="d-inline">
                    @csrf
                    @method('delete')
                    <button type="button" 
                            class="btn btn-outline-danger btn-sm btn-action" 
                            onclick="confirmDelete({{ $user->id }})">
                        <i class="bx bx-trash"></i> Apagar
                    </button>
                </form>
            </div>

            <x-alert />

            {{-- Perfil do Usuário --}}
            <div class="text-center user-info">
                <img src="{{ asset('img/' . $user->image) }}" 
                     alt="Foto de perfil" 
                     class="user-photo mb-3">

                <h4 class="mb-1">{{ $user->name }}</h4>
                <span class="text-muted">ID: {{ $user->id }}</span>

                <div class="mt-3 text-start d-inline-block">
                    <p class="mb-2"><strong>Email:</strong> {{ $user->email }}</p>
                    <p class="mb-2">
                        <strong>Cadastrado em:</strong> 
                        {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i:s') }}
                    </p>
                    <p class="mb-2">
                        <strong>Editado em:</strong> 
                        {{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i:s') }}
                    </p>
                    <p class="mb-0">
                        <strong>Perfil:</strong> 
                        @forelse($user->getRoleNames() as $role)
                            <span class="badge badge-role">{{ $role }}</span>
                        @empty
                            <span class="text-muted">Nenhum perfil</span>
                        @endforelse
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
