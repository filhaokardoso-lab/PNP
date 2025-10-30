@extends('layouts.admin')

@section('content')

    <div class="card mt-4 mb-4 border-light shadow">

        <div class="card-header hstack gap-2">
            <span>Editar Usuário</span>

            <span class="ms-auto d-sm-flex flex-row">

                <a href="{{ route('user.index') }}" class="btn btn-info btn-sm me-1">Listar</a>
                <a href="{{ route('user.show', ['user' => $user->id]) }}" class="btn btn-primary btn-sm me-1">Visualizar</a>
            </span>
        </div>

        <div class="card-body">

            <x-alert />

            <form action="{{ route('user.update', ['user' => $user->id]) }}" method="POST" class="row g-3" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="col-md-6">
                    <label for="image" class="form-label">Foto do usuário</label>   
                    <input type="file" name="image" id="image" class="form-control-file">
                </div>

                <div class="col-6">
                    <label for="roles" class="form-label">Perfil: </label>
                        <select name="roles" class="form-select" id="roles">
                            <option value="">Selecione</option>
                            @forelse ($roles as $role)
                                @if ($role != 'Administrador')
                                    <option {{ old('roles', $userRoles) == $role ? 'selected' : '' }} value="{{ $role }}">{{ $role }}</option>
                                @else
                                    @if (Auth::user()->hasRole('Administrador'))
                                        <option {{ old('roles', $userRoles) == $role ? 'selected' : '' }} value="{{ $role }}">{{ $role }}</option>
                                    @endif
                                @endif
                            @empty
                            @endforelse
                        </select>
                </div>

                <div class="col-md-6">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Nome completo"
                        value="{{ old('name', $user->name) }}">
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control" id="email"
                        placeholder="Melhor e-mail do usuário" value="{{ old('email', $user->email)}}">
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label">Senha</label>
                    <div class="input-group mb-3">
                     
                    <input type="password" name="password" class="form-control" id="password"
                        placeholder="Senha com no mínimo 6 caracteres" value="{{ old('password') }}">
                        <span class="input-group-text" role="button" onclick="togglePassword('password', this)"><i class="bi bi-lock"></i></span>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">Confirma senha</label>
                    <div class="input-group mb-3">
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"
                        placeholder="Confirmar senha" value="{{ old('password_confirmation') }}">
                        <span class="input-group-text" role="button" onclick="togglePassword('password_confirmation', this)"><i class="bi bi-lock"></i></span>
                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-warning btn-sm">Salvar</button>
                </div>

            </form>
        </div>
    </div>
@endsection
