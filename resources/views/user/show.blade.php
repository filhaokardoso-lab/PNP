@extends('layouts.admin')

@section('content')
    <div class="card mt-4 mb-4 border-0 shadow-sm">

        <div class="card-header bg-white d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Detalhes do Usuário</h5>

            <div class="d-flex gap-2">
                <a href="{{ route('user.index') }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-list"></i> Listar
                </a>
                <a href="{{ route('user.edit', ['user' => $user->id]) }}" class="btn btn-outline-warning btn-sm">
                    <i class="bi bi-pencil-square"></i> Editar
                </a>
                <form id="delete-form-{{ $user->id }}" 
                      action="{{ route('user.destroy', ['user' => $user->id]) }}" 
                      method="POST" 
                      class="d-inline">
                    @csrf
                    @method('delete')
                    <button type="button" 
                            class="btn btn-outline-danger btn-sm" 
                            onclick="confirmDelete({{ $user->id }})">
                        <i class="bi bi-trash"></i> Apagar
                    </button>
                </form>
            </div>
        </div>

        <x-alert />

        <div class="row justify-content-center my-4">
            <div class="col-md-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <img src="{{ asset('img/' . $user->image) }}" 
                             alt="Foto de perfil" 
                             class="rounded-circle img-thumbnail mb-3" 
                             style="width: 180px; height: 180px; object-fit: cover;">
                        
                        <h4 class="mb-1">{{ $user->name }}</h4>
                        <span class="text-muted">ID: {{ $user->id }}</span>

                        <div class="mt-3">
                            <p class="mb-1"><strong>Email:</strong> {{ $user->email }}</p>
                            <p class="mb-1">
                                <strong>Cadastrado em:</strong> 
                                {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i:s') }}
                            </p>
                            <p class="mb-1">
                                <strong>Editado em:</strong> 
                                {{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i:s') }}
                            </p>
                            <p class="mb-0">
                                <strong>Perfil:</strong> 
                                @forelse($user->getRoleNames() as $role)
                                    <span class="badge bg-secondary">{{ $role }}</span>
                                @empty
                                    <span class="text-muted">Nenhum perfil</span>
                                @endforelse
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

