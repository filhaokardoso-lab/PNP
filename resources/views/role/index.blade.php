@extends('layouts.admin')

@section('content')
    <main>
        {{-- CSS direto aqui dentro --}}
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <style>
            :root {
                --primary-color: #c41e3a;
                --primary-dark: #8b0000;
                --background-color: #f5e6d3;
                --text-color: #2c1810;
                --hover-color: #d64d4d;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: Arial, sans-serif;
            }

            body {
                background-color: var(--background-color);
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            .page-title {
                text-align: center;
                color: var(--primary-color);
                font-size: 2.2rem;
                margin-bottom: 1rem;
                text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
            }

            .description {
                text-align: center;
                color: var(--text-color);
                font-size: 1.1rem;
                margin-bottom: 2rem;
                opacity: 0.9;
            }

            .container {
                max-width: 1100px;
                margin: 0 auto;
                display: flex;
                flex-direction: column;
                gap: 2rem;
            }

            section {
                background: white;
                border-radius: 12px;
                padding: 1.5rem 2rem;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            }

            section h2 {
                color: var(--primary-color);
                font-size: 1.6rem;
                margin-bottom: 1.5rem;
                text-align: center;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            thead {
                background: var(--primary-color);
                color: white;
            }

            th,
            td {
                padding: 0.9rem;
                text-align: center;
                border-bottom: 1px solid #ddd;
            }

            tbody tr:hover {
                background: rgba(196, 30, 58, 0.08);
                transition: background 0.3s ease;
            }

            .actions {
                display: flex;
                justify-content: center;
                gap: 0.5rem;
                flex-wrap: wrap;
            }

            .btn-custom {
                display: inline-flex;
                align-items: center;
                gap: 0.4rem;
                border: none;
                border-radius: 6px;
                padding: 0.4rem 0.7rem;
                font-size: 0.9rem;
                cursor: pointer;
                transition: transform 0.2s;
            }

            .btn-custom:hover {
                transform: translateY(-2px);
            }

            .btn-info {
                background: #17a2b8;
                color: white;
            }

            .btn-warning {
                background: #ffc107;
                color: #2c1810;
            }

            .btn-danger {
                background: #dc3545;
                color: white;
            }

            .pagination {
                margin-top: 1rem;
                display: flex;
                justify-content: center;
            }

            @media (max-width: 768px) {

                th:nth-child(1),
                td:nth-child(1) {
                    display: none;
                }
            }
        </style>

        {{-- Conteúdo --}}
        <h1 class="page-title">📋 Gestão de Perfis</h1>
        <p class="description">Gerencie os perfis de acesso do sistema</p>

        <div class="container">
            <section>
                <h2>Lista de Perfis</h2>

                <x-alert />

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ ucfirst($role->name) }}</td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('role-permission.index', ['role' => $role->id]) }}"
                                            class="btn-custom btn-info">
                                            <i class='bx bx-list-ul'></i> Permissões
                                        </a>
                                        @can('edit-role')
                                            <a href="{{ route('role.edit', ['role' => $role->id]) }}"
                                                class="btn-custom btn-warning">
                                                <i class='bx bx-edit-alt'></i> Editar
                                            </a>
                                        @endcan

                                        @can('destroy-role')
                                            <form method="POST" action="{{ route('role.destroy', ['role' => $role->id]) }}"
                                                onsubmit="return confirm('Tem certeza que deseja apagar este perfil?')">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn-custom btn-danger">
                                                    <i class='bx bx-trash'></i> Apagar
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Nenhum perfil encontrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="pagination">
                    {{ $roles->links() }}
                </div>
            </section>
        </div>
    </main>
@endsection
