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
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .description {
            text-align: center;
            color: var(--text-color);
            font-size: 1.1rem;
            margin-bottom: 2.5rem;
            opacity: 0.8;
        }

        .container {
            max-width: 900px;
            margin: 0 auto 3rem;
            padding: 0 1rem;
        }

        section {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        section h2 {
            color: var(--primary-color);
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-color);
        }

        .form-control,
        .form-select,
        .form-control-file {
            border-radius: 8px;
            border: 1px solid #ccc;
            transition: border-color 0.3s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 4px rgba(196, 30, 58, 0.3);
        }

        .btn-submit {
            background-color: var(--primary-color);
            border: none;
            padding: 0.6rem 1.5rem;
            color: white;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: var(--hover-color);
        }

        .input-group-text {
            background-color: #fff;
            cursor: pointer;
        }
    </style>

    {{-- Conteúdo --}}
    <h1 class="page-title">Cadastrar Usuário</h1>
    <p class="description">Preencha os dados abaixo para criar um novo usuário no sistema</p>

    <div class="container">
        <section>
            <h2>Formulário de Cadastro</h2>

            <x-alert />

            <form action="{{ route('user.store') }}" method="POST" class="row g-3" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="col-md-6">
                    <label for="image" class="form-label">Foto do usuário</label>
                    <input type="file" name="image" id="image" class="form-control-file @error('image') is-invalid @enderror">
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="roles" class="form-label">Perfil</label>
                    <select name="roles" class="form-select @error('roles') is-invalid @enderror" id="roles">
                        <option value="" disabled {{ old('roles', $userRoles ?? '') == '' ? 'selected' : '' }}>Selecione</option>
                        @forelse ($roles as $role)
                            @if ($role != 'Administrador' || Auth::user()->hasRole('Administrador'))
                                <option value="{{ $role }}" {{ old('roles', $userRoles ?? '') == $role ? 'selected' : '' }}>
                                    {{ $role }}
                                </option>
                            @endif
                        @empty
                            <option value="" disabled>Nenhum perfil encontrado</option>
                        @endforelse
                    </select>
                    @error('roles')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name"
                        placeholder="Nome completo" value="{{ old('name') }}">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        placeholder="Melhor e-mail do usuário" value="{{ old('email')}}">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label">Senha</label>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            placeholder="Senha com no mínimo 6 caracteres" value="{{ old('password') }}">
                        <span class="input-group-text" onclick="togglePassword('password', this)">
                            <i class="bx bx-lock"></i>
                        </span>
                    </div>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">Confirma senha</label>
                    <div class="input-group mb-3">
                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"
                            placeholder="Confirmar senha" value="{{ old('password_confirmation') }}">
                        <span class="input-group-text" onclick="togglePassword('password_confirmation', this)">
                            <i class="bx bx-lock"></i>
                        </span>
                    </div>
                </div>

                <div class="col-12 text-center">
                    <button type="submit" class="btn-submit">Salvar</button>
                </div>
            </form>
        </section>
    </div>

    <script>
        function togglePassword(fieldId, iconElement){
            const field = document.getElementById(fieldId);
            if(field.type === "password"){
                field.type = "text";
                iconElement.innerHTML = '<i class="bx bx-lock-open"></i>';
            } else {
                field.type = "password";
                iconElement.innerHTML = '<i class="bx bx-lock"></i>';
            }
        }
    </script>
</main>
@endsection
