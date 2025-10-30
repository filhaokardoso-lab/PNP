@extends('layouts.admin')

@section('content')
    <div class="card mb-4 border-light shadow">

        <div class="card-header hstack gap-2">
            <span>Listar dePermissões : {{ $role->name }} </span>

            <span class="ms-auto">
                @can('index-role')
                    <a href="{{ route('role.index') }}" class="btn btn-info btn-sm me-1"><i class="fa-solid fa-list"></i>
                        Perfil</a>
                @endcan
            </span>
        </div>

        <div class="card-body">

            <x-alert />

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="d-none d-sm-table-cell">ID</th>
                        <th>Nome</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>

                <tbody>

                    {{-- Imprimir os registros --}}
                    @forelse ($permissions as $permission)
                        <tr>
                            <td class="d-none d-sm-table-cell">{{ $permission->id }}</td>
                            <td class="d-none d-sm-table-cell">{{ $permission->name }}</td>
                            <td class="text-center">
                                @if (in_array($permission->id, $rolePermissions ?? []))
                                    @can('update-role-permission')
                                        <a
                                            href="{{ route('role-permission.update', ['role' => $role->id, 'permission' => $permission->id]) }}">
                                            <span class="badge text-bg-success">Liberado</span>
                                        </a>
                                    @else
                                        <span class="badge text-bg-success">Liberado</span>
                                    @endcan
                                @else
                                    @can('update-role-permission')
                                        <a
                                            href="{{ route('role-permission.update', ['role' => $role->id, 'permission' => $permission->id]) }}">
                                            <span class="badge text-bg-danger">Bloqueado</span>
                                        </a>
                                    @else
                                        <span class="badge text-bg-danger">Bloqueado</span>
                                    @endcan
                                @endif


                            </td>
                        </tr>
                    @empty
                        <div class="alert alert-danger" role="alert">
                            Nenhuma permissão para o perfil encontrado!
                        </div>
                    @endforelse



                </tbody>
            </table>
        </div>
    </div>
    </div>
@endsection
